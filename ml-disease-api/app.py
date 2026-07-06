import io
import json
import os
from pathlib import Path
from typing import Any, Optional

import torch
import timm
from fastapi import FastAPI, File, Form, HTTPException, UploadFile
from PIL import Image, ImageStat, UnidentifiedImageError
from safetensors.torch import load_file
from torchvision import transforms

BASE_DIR = Path(__file__).resolve().parent
MODEL_DIR = Path(os.getenv("DISEASE_MODEL_DIR", BASE_DIR / "model"))
MODEL_PATH = MODEL_DIR / "model.safetensors"
CONFIG_PATH = MODEL_DIR / "config.json"
REMEDIES_PATH = MODEL_DIR / "remedies.json"
MAX_IMAGE_BYTES = 5 * 1024 * 1024
ALLOWED_TYPES = {"image/jpeg", "image/png", "image/webp"}
CROP_ALIASES = {"maize": "corn"}

app = FastAPI(title="AgroVision Disease API", version="2.0.0")
model: Optional[torch.nn.Module] = None
labels: list[str] = []
remedies: dict[str, dict[str, str]] = {}
preprocess = None
load_error: Optional[str] = None


def normalized(value: str) -> str:
    return " ".join(value.replace("___", " ").replace("__", " ").replace("_", " ").lower().split())


def split_label(label: str) -> tuple[str, str]:
    parts = label.replace("___", "__").split("__", 1)
    if len(parts) == 2:
        return parts[0].replace("_", " ").strip(), parts[1].replace("_", " ").strip()
    return "", label.replace("_", " ").strip()


def load_assets() -> None:
    global model, labels, remedies, preprocess, load_error
    try:
        if not MODEL_PATH.is_file() or not CONFIG_PATH.is_file():
            raise RuntimeError("model.safetensors or config.json is missing")

        config = json.loads(CONFIG_PATH.read_text(encoding="utf-8"))
        labels = config["class_names"]
        image_size = int(config.get("input_size", 512))
        mean = config.get("normalization", {}).get("mean", [0.5, 0.5, 0.5])
        std = config.get("normalization", {}).get("std", [0.5, 0.5, 0.5])

        classifier = timm.create_model(
            config.get("architecture", "nfnet_f1"),
            pretrained=False,
            num_classes=len(labels),
        )
        classifier.load_state_dict(load_file(str(MODEL_PATH)), strict=True)
        classifier.eval()
        model = classifier
        preprocess = transforms.Compose([
            transforms.Resize((image_size, image_size)),
            transforms.ToTensor(),
            transforms.Normalize(mean=mean, std=std),
        ])
        remedies = json.loads(REMEDIES_PATH.read_text(encoding="utf-8")) if REMEDIES_PATH.is_file() else {}
        load_error = None
    except Exception as exc:
        model = None
        load_error = str(exc)


load_assets()


def remedy_for(label: str) -> dict[str, str]:
    wanted = normalized(label)
    for remedy_label, detail in remedies.items():
        if normalized(remedy_label) == wanted:
            return detail
    return {}


def severity_for(disease: str, confidence: float) -> str:
    if "healthy" in disease.lower():
        return "Healthy"
    if confidence >= 85:
        return "High confidence"
    if confidence >= 60:
        return "Moderate confidence"
    return "Low confidence"


@app.get("/health")
def health() -> dict[str, Any]:
    crops = sorted({split_label(label)[0] for label in labels})
    return {
        "status": "ok" if model is not None else "not_ready",
        "model_loaded": model is not None,
        "classes": len(labels),
        "supported_crops": crops,
        "error": load_error,
    }


@app.post("/predict")
async def predict(
    image: UploadFile = File(...),
    crop_name: str = Form(...),
    affected_part: str = Form(...),
    symptoms: str = Form(...),
    location: str = Form(...),
    crop_age: str = Form(...),
    symptom_started: str = Form(...),
    field_affected: str = Form(...),
    fertilizer_used: Optional[str] = Form(None),
    pesticide_used: Optional[str] = Form(None),
) -> dict[str, Any]:
    if model is None or preprocess is None:
        raise HTTPException(status_code=503, detail=f"Prediction model is not ready: {load_error}")
    if (image.content_type or "") not in ALLOWED_TYPES:
        raise HTTPException(status_code=422, detail="Upload a JPG, PNG, or WEBP image.")

    raw = await image.read(MAX_IMAGE_BYTES + 1)
    if len(raw) > MAX_IMAGE_BYTES:
        raise HTTPException(status_code=413, detail="Image must be 5 MB or smaller.")

    try:
        source = Image.open(io.BytesIO(raw))
        source.verify()
        source = Image.open(io.BytesIO(raw)).convert("RGB")
    except (UnidentifiedImageError, OSError):
        raise HTTPException(status_code=422, detail="The uploaded file is not a valid image.")

    if min(source.size) < 160:
        raise HTTPException(status_code=422, detail="Image is too small. Upload a clear photo at least 160×160 pixels.")
    if sum(ImageStat.Stat(source.resize((64, 64))).var) / 3 < 35:
        raise HTTPException(status_code=422, detail="Image has too little visual detail. Upload a clear, focused leaf photo.")

    requested_crop = CROP_ALIASES.get(crop_name.casefold(), crop_name.casefold())
    crop_indices = [
        index for index, label in enumerate(labels)
        if split_label(label)[0].casefold() == requested_crop
    ]
    if not crop_indices:
        raise HTTPException(status_code=422, detail=f"The installed model does not support {crop_name}.")

    tensor = preprocess(source).unsqueeze(0)
    with torch.inference_mode():
        probabilities = torch.softmax(model(tensor)[0], dim=0)

    # The farmer already selects the crop, so rank only diseases trained for that crop.
    crop_scores = probabilities[crop_indices]
    crop_scores = crop_scores / crop_scores.sum()
    order = torch.argsort(crop_scores, descending=True)
    ranked_indices = [crop_indices[int(position)] for position in order]
    best_index = ranked_indices[0]
    confidence = round(float((crop_scores[order[0]] * 100).item()), 2)
    predicted_crop, disease = split_label(labels[best_index])

    if confidence < 35:
        raise HTTPException(
            status_code=422,
            detail="The model cannot identify this image reliably. Upload a closer, well-lit photo of one affected leaf.",
        )

    detail = remedy_for(labels[best_index])
    alternatives = []
    for position, index in enumerate(ranked_indices[1:4], start=1):
        _, alternative = split_label(labels[index])
        alternatives.append({
            "crop": predicted_crop,
            "disease": alternative,
            "confidence": round(float((crop_scores[order[position]] * 100).item()), 2),
        })

    healthy = "healthy" in disease.casefold()
    return {
        "crop": crop_name,
        "disease": disease.title(),
        "confidence": confidence,
        "severity": severity_for(disease, confidence),
        "possible_cause": (
            "No trained disease pattern was detected in this image."
            if healthy else f"The leaf pattern most closely matches {disease.replace('_', ' ')}."
        ),
        "treatment": detail.get(
            "organic",
            "No treatment is indicated." if healthy
            else "Isolate affected plants and confirm the diagnosis with a local agricultural expert before treatment.",
        ),
        "prevention": detail.get(
            "prevention",
            "Continue regular crop inspection, field hygiene, suitable spacing, and balanced irrigation.",
        ),
        "alternatives": alternatives,
        "response_source": "agromind_nfnet_f1_88_class",
        "model_label": labels[best_index],
        "affected_part": affected_part,
        "symptoms": symptoms,
        "location": location,
        "crop_age": crop_age,
        "symptom_started": symptom_started,
        "field_affected": field_affected,
        "fertilizer_used": fertilizer_used,
        "pesticide_used": pesticide_used,
        "image_filename": image.filename,
    }
