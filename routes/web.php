<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\DiseaseDetectionController as AdminDiseaseDetectionController;
use App\Http\Controllers\Admin\FertilizerAdminController;
use App\Http\Controllers\Admin\SoilReportController as AdminSoilReportController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\DashboardFeatureController;
use App\Http\Controllers\DiseaseDetectionController;
use App\Http\Controllers\FarmReportController;
use App\Http\Controllers\FertilizerRecommendationController;
use App\Http\Controllers\SoilProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('/about', 'about')->name('about');
Route::view('/features', 'features')->name('features');
Route::view('/services', 'services')->name('services');
Route::view('/contact', 'contact')->name('contact');
Route::post('/contact', [ContactMessageController::class, 'store'])->name('contact.store');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');

Route::middleware('auth')->group(function () {
    Route::view('/dashboard', 'dashboard_ui.index')->name('dashboard');
    Route::get('/dashboard/crop-recommendation', [DashboardFeatureController::class, 'crop'])->name('dashboard.crop');
    Route::post('/dashboard/crop-recommendation', [DashboardFeatureController::class, 'storeCrop'])->name('dashboard.crop.store');
    Route::get('/dashboard/yield-prediction', [DashboardFeatureController::class, 'yield'])->name('dashboard.yield');
    Route::post('/dashboard/yield-prediction', [DashboardFeatureController::class, 'storeYield'])->name('dashboard.yield.store');
    Route::get('/dashboard/disease-detection', [DiseaseDetectionController::class, 'index'])->name('dashboard.disease');
    Route::post('/dashboard/disease-detection', [DiseaseDetectionController::class, 'store'])->name('dashboard.disease.store');
    Route::get('/dashboard/disease-detection/history', [DiseaseDetectionController::class, 'history'])->name('dashboard.disease.history');
    Route::get('/dashboard/disease-detection/result/{diseaseDetection}', [DiseaseDetectionController::class, 'result'])->name('dashboard.disease.result');
    Route::get('/dashboard/disease-detection/{diseaseDetection}', [DiseaseDetectionController::class, 'show'])->name('dashboard.disease.show');
    Route::delete('/dashboard/disease-detection/{diseaseDetection}', [DiseaseDetectionController::class, 'destroy'])->name('dashboard.disease.destroy');
    Route::get('/dashboard/fertilizer-recommendation', [FertilizerRecommendationController::class, 'index'])->name('dashboard.fertilizer');
    Route::post('/dashboard/fertilizer-recommendation', [FertilizerRecommendationController::class, 'store'])->name('dashboard.fertilizer.store');
    Route::post('/api/fertilizer-recommendation', [FertilizerRecommendationController::class, 'api'])->middleware('throttle:30,1')->name('api.fertilizer.recommendation');
    Route::get('/dashboard/fertilizer-recommendation/history', [FertilizerRecommendationController::class, 'history'])->name('dashboard.fertilizer.history');
    Route::get('/dashboard/fertilizer-recommendation/result/{fertilizerRecommendation}', [FertilizerRecommendationController::class, 'result'])->name('dashboard.fertilizer.result');
    Route::get('/dashboard/fertilizer-recommendation/{fertilizerRecommendation}', [FertilizerRecommendationController::class, 'show'])->name('dashboard.fertilizer.show');
    Route::delete('/dashboard/fertilizer-recommendation/{fertilizerRecommendation}', [FertilizerRecommendationController::class, 'destroy'])->name('dashboard.fertilizer.destroy');
    Route::get('/dashboard/weather-forecast', [DashboardFeatureController::class, 'weather'])->name('dashboard.weather');
    Route::post('/dashboard/weather-forecast', [DashboardFeatureController::class, 'storeWeather'])->name('dashboard.weather.store');
    Route::post('/dashboard/location/weather', [DashboardFeatureController::class, 'lookupWeather'])->name('dashboard.location.weather');
    Route::post('/dashboard/location/reverse', [DashboardFeatureController::class, 'reverseLocation'])->name('dashboard.location.reverse');
    Route::get('/dashboard/soil', [SoilProfileController::class, 'index'])->name('dashboard.soil');
    Route::get('/dashboard/soil/create', [SoilProfileController::class, 'create'])->name('dashboard.soil.create');
    Route::post('/dashboard/soil', [SoilProfileController::class, 'store'])->name('dashboard.soil.store');
    Route::post('/dashboard/soil/estimate', [SoilProfileController::class, 'estimate'])->name('dashboard.soil.estimate');
    Route::get('/dashboard/soil/history', [SoilProfileController::class, 'history'])->name('dashboard.soil.history');
    Route::get('/dashboard/soil/{soilProfile}', [SoilProfileController::class, 'show'])->name('dashboard.soil.show');
    Route::get('/dashboard/soil/{soilProfile}/edit', [SoilProfileController::class, 'edit'])->name('dashboard.soil.edit');
    Route::put('/dashboard/soil/{soilProfile}', [SoilProfileController::class, 'update'])->name('dashboard.soil.update');
    Route::delete('/dashboard/soil/{soilProfile}', [SoilProfileController::class, 'destroy'])->name('dashboard.soil.destroy');
    Route::view('/dashboard/history', 'dashboard_ui.history')->name('dashboard.history');
    Route::get('/dashboard/reports', [FarmReportController::class, 'index'])->name('dashboard.reports');
    Route::get('/dashboard/reports/export/csv', [FarmReportController::class, 'csv'])->name('dashboard.reports.csv');
    Route::get('/dashboard/reports/export/pdf', [FarmReportController::class, 'pdf'])->name('dashboard.reports.pdf');
    Route::view('/dashboard/saved-results', 'dashboard_ui.saved')->name('dashboard.saved');
    Route::view('/dashboard/profile', 'dashboard_ui.profile')->name('dashboard.profile');
    Route::view('/dashboard/settings', 'dashboard_ui.settings')->name('dashboard.settings');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminDashboardController::class, 'users'])->name('users');
    Route::get('/contact-messages', [AdminDashboardController::class, 'contactMessages'])->name('contact-messages');
    Route::get('/reports', [AdminDashboardController::class, 'reports'])->name('reports');
    Route::get('/reports/{type}/{id}', [AdminDashboardController::class, 'reportShow'])->name('reports.show');
    Route::get('/disease-detections', [AdminDiseaseDetectionController::class, 'index'])->name('disease.index');
    Route::get('/disease-detections/export/csv', [AdminDiseaseDetectionController::class, 'csv'])->name('disease.csv');
    Route::get('/disease-detections/{diseaseDetection}', [AdminDiseaseDetectionController::class, 'show'])->name('disease.show');
    Route::delete('/disease-detections/{diseaseDetection}', [AdminDiseaseDetectionController::class, 'destroy'])->name('disease.destroy');
    Route::get('/soil-reports', [AdminSoilReportController::class, 'index'])->name('soil.index');
    Route::get('/soil-reports/export/csv', [AdminSoilReportController::class, 'csv'])->name('soil.csv');
    Route::get('/soil-reports/{soilProfile}', [AdminSoilReportController::class, 'show'])->name('soil.show');
    Route::patch('/soil-reports/{soilProfile}', [AdminSoilReportController::class, 'update'])->name('soil.update');
    Route::delete('/soil-reports/{soilProfile}', [AdminSoilReportController::class, 'destroy'])->name('soil.destroy');
    Route::get('/fertilizers', [FertilizerAdminController::class, 'fertilizers'])->name('fertilizer.master');
    Route::post('/fertilizers', [FertilizerAdminController::class, 'storeFertilizer'])->name('fertilizer.master.store');
    Route::put('/fertilizers/{fertilizer}', [FertilizerAdminController::class, 'updateFertilizer'])->name('fertilizer.master.update');
    Route::patch('/fertilizers/{fertilizer}/status', [FertilizerAdminController::class, 'deactivateFertilizer'])->name('fertilizer.master.status');
    Route::get('/fertilizer-rules', [FertilizerAdminController::class, 'rules'])->name('fertilizer.rules');
    Route::post('/fertilizer-rules', [FertilizerAdminController::class, 'storeRule'])->name('fertilizer.rules.store');
    Route::put('/fertilizer-rules/{fertilizerRule}', [FertilizerAdminController::class, 'updateRule'])->name('fertilizer.rules.update');
    Route::get('/fertilizer-recommendations', [FertilizerAdminController::class, 'reports'])->name('fertilizer.reports');
    Route::get('/fertilizer-recommendations/export/csv', [FertilizerAdminController::class, 'csv'])->name('fertilizer.reports.csv');
    Route::get('/fertilizer-recommendations/{fertilizerRecommendation}', [FertilizerAdminController::class, 'showReport'])->name('fertilizer.reports.show');
    Route::patch('/fertilizer-recommendations/{fertilizerRecommendation}', [FertilizerAdminController::class, 'reviewReport'])->name('fertilizer.reports.review');
    Route::delete('/fertilizer-recommendations/{fertilizerRecommendation}', [FertilizerAdminController::class, 'destroyReport'])->name('fertilizer.reports.destroy');
    Route::get('/settings', [AdminDashboardController::class, 'settings'])->name('settings');
});
