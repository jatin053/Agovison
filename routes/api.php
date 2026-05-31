<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CropController;
use App\Http\Controllers\Api\DiseaseReportController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\WeatherController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::get('/crops', [CropController::class, 'index']);
Route::get('/crops/{crop}', [CropController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::post('/crops', [CropController::class, 'store']);
    Route::put('/crops/{crop}', [CropController::class, 'update']);
    Route::delete('/crops/{crop}', [CropController::class, 'destroy']);

    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);

    Route::get('/weather', [WeatherController::class, 'index']);
    Route::post('/weather', [WeatherController::class, 'store']);

    Route::get('/disease-reports', [DiseaseReportController::class, 'index']);
    Route::post('/disease-reports', [DiseaseReportController::class, 'store']);
    Route::get('/disease-reports/{diseaseReport}', [DiseaseReportController::class, 'show']);
});
