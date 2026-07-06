# AgroVision Disease API

Local FastAPI image-classification service used by the Laravel disease form.

## Installed model

The runtime uses the Apache-2.0 `Arko007/agromind-plant-disease-nfnet` NFNet-F1
model from Hugging Face. It contains 88 crop/disease classes. AgroVision currently
exposes the model-supported crops Tomato, Potato, Rice, Wheat, and Maize (mapped to
the model's Corn classes).

Required files:

- `model/model.safetensors`
- `model/config.json`
- `model/remedies.json`

The 519 MB weights file is ignored by Git and must be downloaded on each deployment.

## Run

```powershell
.venv\Scripts\python.exe -m uvicorn app:app --host 127.0.0.1 --port 5000
```

Check `http://127.0.0.1:5000/health`. `model_loaded` must be `true`, and Laravel's
`.env` should contain `DISEASE_API_URL=http://127.0.0.1:5000`.

## Behavior and safeguards

- Accepts verified JPG, PNG, and WEBP images up to 5 MB.
- Rejects very small, invalid, low-detail, and low-confidence images.
- Ranks only disease classes belonging to the crop selected by the farmer.
- Returns the top result, confidence, severity, remedies, prevention, and alternatives.
- Never falls back to a fabricated/demo diagnosis.

This is a preliminary classifier, not a laboratory diagnosis. The source model was
trained on curated datasets, so accuracy can decrease for cluttered field photos,
unusual lighting, early-stage symptoms, or diseases outside its 88 classes.

## Optional custom training

`train.py` remains available for training a custom TensorFlow MobileNetV2 model on
your own verified folder-per-class dataset. The current production API uses the
downloaded NFNet-F1 weights described above.
