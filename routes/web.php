<?php

use App\Http\Controllers\Admin\CropController as AdminCropController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\Buyer\CartController;
use App\Http\Controllers\Buyer\CheckoutController;
use App\Http\Controllers\Buyer\FavoriteController;
use App\Http\Controllers\Buyer\MarketplaceController;
use App\Http\Controllers\Buyer\OrderController as BuyerOrderController;
use App\Http\Controllers\Buyer\ReviewController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Expert\DashboardController as ExpertDashboardController;
use App\Http\Controllers\Expert\QuestionController as ExpertQuestionController;
use App\Http\Controllers\Farmer\CropController as FarmerCropController;
use App\Http\Controllers\Farmer\DashboardController as FarmerDashboardController;
use App\Http\Controllers\Farmer\DiseaseReportController;
use App\Http\Controllers\Farmer\IntelligenceController;
use App\Http\Controllers\Farmer\OrderController as FarmerOrderController;
use App\Http\Controllers\Farmer\QuestionController as FarmerQuestionController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'landing'])->name('home');
Route::get('/about', [PublicPageController::class, 'about'])->name('about');
Route::get('/contact', [PublicPageController::class, 'contact'])->name('contact');
Route::post('/contact', [PublicPageController::class, 'storeContact'])->name('contact.store');
Route::get('/weather-intelligence', [PublicPageController::class, 'weather'])->name('weather.index');
Route::get('/community', [CommunityController::class, 'index'])->name('community.index');
Route::get('/auctions', [AuctionController::class, 'index'])->name('auctions.index');
Route::get('/auctions/{auction}', [AuctionController::class, 'show'])->name('auctions.show');
Route::get('/marketplace', [MarketplaceController::class, 'index'])->name('buyer.marketplace.index');
Route::get('/marketplace/{crop:slug}', [MarketplaceController::class, 'show'])->name('buyer.marketplace.show');
Route::post('/locale', [LocaleController::class, 'update'])->name('locale.update');

Route::get('/dashboard', [DashboardController::class, 'redirect'])
    ->middleware(['auth', 'verified', 'active'])
    ->name('dashboard');

Route::middleware(['auth', 'verified', 'active'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/notifications/latest', [NotificationController::class, 'latest'])->name('notifications.latest');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');
    Route::post('/community', [CommunityController::class, 'store'])->name('community.store');
    Route::post('/community/posts/{post}/comments', [CommunityController::class, 'comment'])->name('community.comments.store');
    Route::post('/community/posts/{post}/like', [CommunityController::class, 'togglePostLike'])->name('community.posts.like');
    Route::post('/community/comments/{comment}/like', [CommunityController::class, 'toggleCommentLike'])->name('community.comments.like');
    Route::post('/auctions', [AuctionController::class, 'store'])->middleware('role:Farmer')->name('auctions.store');
    Route::post('/auctions/{auction}/bids', [AuctionController::class, 'bid'])->middleware('role:Buyer')->name('auctions.bid');
});

Route::prefix('admin')
    ->as('admin.')
    ->middleware(['auth', 'verified', 'active', 'role:Admin'])
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::patch('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
        Route::patch('/users/{user}/toggle-block', [AdminUserController::class, 'toggleBlock'])->name('users.toggle-block');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        Route::get('/crops', [AdminCropController::class, 'index'])->name('crops.index');
        Route::patch('/crops/{crop}/approve', [AdminCropController::class, 'approve'])->name('crops.approve');
        Route::patch('/crops/{crop}/reject', [AdminCropController::class, 'reject'])->name('crops.reject');
        Route::delete('/crops/{crop}', [AdminCropController::class, 'destroy'])->name('crops.destroy');

        Route::get('/orders/export/excel', [AdminOrderController::class, 'export'])->name('orders.export');
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::patch('/orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');

        Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');

        Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [AdminSettingController::class, 'store'])->name('settings.store');
        Route::patch('/settings/{setting}', [AdminSettingController::class, 'update'])->name('settings.update');
    });

Route::prefix('farmer')
    ->as('farmer.')
    ->middleware(['auth', 'verified', 'active', 'role:Farmer'])
    ->group(function () {
        Route::get('/dashboard', [FarmerDashboardController::class, 'index'])->name('dashboard');

        Route::get('/crops', [FarmerCropController::class, 'index'])->name('crops.index');
        Route::get('/crops/create', [FarmerCropController::class, 'create'])->name('crops.create');
        Route::post('/crops', [FarmerCropController::class, 'store'])->name('crops.store');
        Route::get('/crops/{crop}/edit', [FarmerCropController::class, 'edit'])->name('crops.edit');
        Route::put('/crops/{crop}', [FarmerCropController::class, 'update'])->name('crops.update');
        Route::delete('/crops/{crop}', [FarmerCropController::class, 'destroy'])->name('crops.destroy');

        Route::get('/orders', [FarmerOrderController::class, 'index'])->name('orders.index');

        Route::get('/disease-reports', [DiseaseReportController::class, 'index'])->name('disease-reports.index');
        Route::post('/disease-reports', [DiseaseReportController::class, 'store'])->name('disease-reports.store');
        Route::get('/intelligence', [IntelligenceController::class, 'index'])->name('intelligence.index');
        Route::post('/intelligence/recommend', [IntelligenceController::class, 'recommend'])->name('intelligence.recommend');
        Route::post('/soil-reports', [IntelligenceController::class, 'storeSoilReport'])->name('soil-reports.store');

        Route::get('/questions', [FarmerQuestionController::class, 'index'])->name('questions.index');
        Route::post('/questions', [FarmerQuestionController::class, 'store'])->name('questions.store');
    });

Route::prefix('buyer')
    ->as('buyer.')
    ->middleware(['auth', 'verified', 'active', 'role:Buyer'])
    ->group(function () {
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
        Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

        Route::get('/orders', [BuyerOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [BuyerOrderController::class, 'show'])->name('orders.show');
        Route::get('/orders/{order}/invoice', [BuyerOrderController::class, 'invoice'])->name('orders.invoice');
        Route::get('/orders/{order}/invoice/pdf', [BuyerOrderController::class, 'downloadPdf'])->name('orders.invoice.pdf');

        Route::post('/favorites/{crop}', [FavoriteController::class, 'store'])->name('favorites.store');
        Route::delete('/favorites/{crop}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

        Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    });

Route::prefix('expert')
    ->as('expert.')
    ->middleware(['auth', 'verified', 'active', 'role:Expert'])
    ->group(function () {
        Route::get('/dashboard', [ExpertDashboardController::class, 'index'])->name('dashboard');
        Route::get('/questions', [ExpertQuestionController::class, 'index'])->name('questions.index');
        Route::post('/questions/{question}/answer', [ExpertQuestionController::class, 'answer'])->name('questions.answer');
    });

require __DIR__.'/auth.php';
