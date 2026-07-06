# AgroVision

AgroVision is a Laravel/PHP smart farming platform with crop recommendation, yield prediction, fertilizer recommendation, weather forecasting, and crop disease detection.

## Setup

1. Install PHP dependencies with `composer install`.
2. Copy `.env.example` to `.env` if needed and fill in your local settings.
3. Run `php artisan key:generate`.
4. Create the database and run `php artisan migrate`.
5. Create the storage link with `php artisan storage:link`.
6. Start Laravel with `php artisan serve`.

## Disease Detection

The disease module sends uploaded images and crop details to a Python API.

Laravel expects:

```env
DISEASE_API_URL=http://127.0.0.1:5000
```

The Python starter lives in `ml-disease-api/`.

## Required Environment Variables

```env
GOOGLE_MAPS_API_KEY=
GOOGLE_WEATHER_API_KEY=
GOOGLE_AIR_QUALITY_API_KEY=
DISEASE_API_URL=http://127.0.0.1:5000
```

## Start Laravel

```bash
php artisan serve
```

If you use a queue worker or cache/session database features, make sure MySQL is running first.

## Start the Python API

From `ml-disease-api/`:

```bash
python -m venv .venv
.venv\Scripts\activate
pip install -r requirements.txt
uvicorn app:app --reload --host 127.0.0.1 --port 5000
```

## Test Disease Detection

1. Open the AgroVision dashboard.
2. Go to `Disease Detection`.
3. Select a crop, symptom, location, crop age, and upload a clear JPG, JPEG, PNG, or WEBP image.
4. Click `Detect Crop Disease`.
5. Check the result page, history page, and admin disease page.

## Useful Commands

```bash
php artisan migrate
php artisan route:list
php artisan view:cache
php artisan view:clear
php artisan config:clear
```

