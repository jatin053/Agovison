import io
from pathlib import Path
from typing import Any

import numpy as np
import tensorflow as tf
from fastapi import FastAPI, File, HTTPException, UploadFile
from PIL import Image, ImageStat, UnidentifiedImageError

BASE_DIR = Path(__file__).resolve().parent
MODEL_PATH = BASE_DIR / "soil-model" / "soil_type_model.h5"
MAX_IMAGE_BYTES = 5 * 1024 * 1024
ALLOWED_TYPES = {"image/jpeg", "image/png", "image/webp"}
LABELS = [
    "Alluvial Soil",
    "Black Soil",
    "Cinder Soil",
    "Clayey Soil",
    "Laterite Soil",
    "Loamy Soil",
    "Peat Soil",
    "Sandy Loam",
    "Sandy Soil",
    "Yellow Soil",
]

app = FastAPI(title="AgroVision Soil Image API", version="1.0.0")
model = None
load_error = None

try:
    model = tf.keras.models.load_model(MODEL_PATH, compile=False)
    if int(model.output_shape[-1]) != len(LABELS):
        raise RuntimeError("Soil model output count does not match its labels.")
except Exception as exc:
    model = None
    load_error = str(exc)


@app.get("/health")
def health() -> dict[str, Any]:
    return {
        "status": "ok" if model is not None else "not_ready",
        "model_loaded": model is not None,
        "classes": len(LABELS),
        "error": load_error,
    }


@app.post("/predict-soil")
async def predict_soil(image: UploadFile = File(...)) -> dict[str, Any]:
    if model is None:
        raise HTTPException(status_code=503, detail=f"Soil model is not ready: {load_error}")
    if (image.content_type or "") not in ALLOWED_TYPES:
        raise HTTPException(status_code=422, detail="Upload a JPG, PNG, or WEBP soil image.")

    raw = await image.read(MAX_IMAGE_BYTES + 1)
    if len(raw) > MAX_IMAGE_BYTES:
        raise HTTPException(status_code=413, detail="Soil image must be 5 MB or smaller.")

    try:
        source = Image.open(io.BytesIO(raw))
        source.verify()
        source = Image.open(io.BytesIO(raw)).convert("RGB")
    except (UnidentifiedImageError, OSError):
        raise HTTPException(status_code=422, detail="The uploaded file is not a valid image.")

    if min(source.size) < 160:
        raise HTTPException(status_code=422, detail="Upload a clearer soil photo at least 160×160 pixels.")
    if sum(ImageStat.Stat(source.resize((64, 64))).var) / 3 < 20:
        raise HTTPException(status_code=422, detail="The image has too little detail. Photograph exposed soil in clear daylight.")

    resized = source.resize((224, 224), Image.Resampling.LANCZOS)
    batch = np.expand_dims(np.asarray(resized, dtype=np.float32) / 255.0, axis=0)
    scores = np.asarray(model.predict(batch, verbose=0)[0], dtype=np.float64)
    ranked = np.argsort(scores)[::-1]
    best = int(ranked[0])
    confidence = round(float(scores[best]) * 100, 2)

    if confidence < 25:
        raise HTTPException(
            status_code=422,
            detail="The soil type cannot be identified reliably. Upload a close, well-lit photo without plants or tools.",
        )

    return {
        "soil_type": LABELS[best],
        "confidence": confidence,
        "alternatives": [
            {"soil_type": LABELS[int(index)], "confidence": round(float(scores[int(index)]) * 100, 2)}
            for index in ranked[1:4]
        ],
        "response_source": "ben041_soil_type_cnn",
        "image_filename": image.filename,
    }
