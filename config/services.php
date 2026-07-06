<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'google' => [
        'maps_key' => env('GOOGLE_MAPS_API_KEY'),
        'weather_key' => env('GOOGLE_WEATHER_API_KEY', env('GOOGLE_MAPS_API_KEY')),
        'air_quality_key' => env('GOOGLE_AIR_QUALITY_API_KEY', env('GOOGLE_MAPS_API_KEY')),
    ],

    'openweather' => [
        'key' => env('OPENWEATHER_API_KEY'),
    ],

    'disease_api' => [
        'url' => env('DISEASE_API_URL', 'http://127.0.0.1:5000'),
    ],

    'soil_api' => [
        'url' => env('SOIL_API_URL'),
        'key' => env('SOIL_API_KEY'),
    ],

    'soil_image_api' => [
        'url' => env('SOIL_IMAGE_API_URL', 'http://127.0.0.1:5001'),
    ],

    'fertilizer_ml' => [
        'url' => env('FERTILIZER_ML_API_URL'),
    ],

];
