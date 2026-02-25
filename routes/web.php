<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;

// Public Pages
Route::get('/', [WebController::class, 'home'])->name('home');
Route::get('/about', [WebController::class, 'about'])->name('about');
Route::get('/philosophy', [WebController::class, 'philosophy'])->name('philosophy');
Route::get('/ritual', [WebController::class, 'ritual'])->name('ritual');
Route::get('/contact', [WebController::class, 'contact'])->name('contact');

// Products
Route::get('/product', [WebController::class, 'product'])->name('product');
Route::get('/products', [WebController::class, 'products'])->name('products');

// Cart & Profile
Route::get('/cart', [WebController::class, 'cart'])->name('cart');
Route::get('/profile', [WebController::class, 'profile'])->name('profile');
Route::get('/orders', [WebController::class, 'orders'])->name('orders');
Route::get('/wishlist', [WebController::class, 'wishlist'])->name('wishlist');
Route::get('/addresses', [WebController::class, 'addresses'])->name('addresses');
Route::get('/payment', [WebController::class, 'payment'])->name('payment');
Route::get('/security', [WebController::class, 'security'])->name('security');

// Legal
Route::get('/terms', [WebController::class, 'terms'])->name('terms');

// Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [WebController::class, 'adminDashboard'])->name('dashboard');
    Route::get('/products', [WebController::class, 'adminProducts'])->name('products');
    Route::get('/orders', [WebController::class, 'adminOrders'])->name('orders');
    Route::get('/users', [WebController::class, 'adminUsers'])->name('users');
    Route::get('/inventory', [WebController::class, 'adminInventory'])->name('inventory');
    Route::get('/pricing', [WebController::class, 'adminPricing'])->name('pricing');
    Route::get('/banners', [WebController::class, 'adminBanners'])->name('banners');
    Route::get('/coupons', [WebController::class, 'adminCoupons'])->name('coupons');
    Route::get('/reviews', [WebController::class, 'adminReviews'])->name('reviews');
    Route::get('/categories', [WebController::class, 'adminCategories'])->name('categories');
    Route::get('/analytics', [WebController::class, 'adminAnalytics'])->name('analytics');
    Route::get('/login-history', [WebController::class, 'adminLoginHistory'])->name('login-history');
    Route::get('/activity-logs', [WebController::class, 'adminActivityLogs'])->name('activity-logs');
    Route::get('/management', [WebController::class, 'adminManagement'])->name('management');
    Route::get('/register', [WebController::class, 'adminRegister'])->name('register');
});
