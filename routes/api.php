<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\AdminRegisterController;
use App\Http\Controllers\InventoryController;

// Public banner routes
Route::get('/banners', [BannerController::class, 'index']);

// Public auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/admin/register', [AdminRegisterController::class, 'register']);

// Public product routes
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/products/{id}/reviews', [ReviewController::class, 'getProductReviews']);
Route::post('/reviews', [ReviewController::class, 'store']);

// Public category routes
Route::get('/categories', [CategoryController::class, 'index']);

// Protected routes (require auth:sanctum)
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Cart routes
    Route::get('/cart', [CartController::class, 'show']);
    Route::post('/cart/add', [CartController::class, 'addItem']);
    Route::put('/cart/items/{itemId}', [CartController::class, 'updateItem']);
    Route::delete('/cart/items/{itemId}', [CartController::class, 'removeItem']);
    Route::delete('/cart/clear', [CartController::class, 'clear']);
    Route::get('/cart/count', [CartController::class, 'count']);

    // Order routes
    Route::post('/checkout', [OrderController::class, 'checkout']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::put('/orders/{id}/cancel', [OrderController::class, 'cancel']);
    Route::post('/orders/{id}/pay', [OrderController::class, 'pay']);
});

// Protected admin routes (require auth:sanctum + admin role)
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/users', [AdminController::class, 'users']);
    Route::apiResource('products', ProductController::class)->except(['index', 'show']);
    Route::get('/orders', [AdminController::class, 'orders']);
    Route::get('/orders/export', [AdminController::class, 'exportOrders']);
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']);
    
    // Coupon management
    Route::apiResource('coupons', CouponController::class);
    Route::put('/coupons/{id}/toggle', [CouponController::class, 'toggle']);
    
    // Review management
    Route::get('/reviews', [AdminController::class, 'reviews']);
    Route::put('/reviews/{id}/toggle', [AdminController::class, 'toggleReview']);
    Route::delete('/reviews/{id}', [AdminController::class, 'deleteReview']);
    
    // Login history
    Route::get('/login-history', [AdminController::class, 'loginHistory']);
    
    // Category management
    Route::apiResource('categories', CategoryController::class)->except(['show']);
    
    // Admin Management (Super Admin only)
    
    // User management
    Route::get('/users', [AdminController::class, 'users']);
    Route::get('/users/{id}', [AdminController::class, 'getUser']);
    Route::put('/users/{id}', [AdminController::class, 'updateUser']);
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);
    
    // Banner management
    Route::get('/banners', [BannerController::class, 'index']);
    Route::post('/banners', [BannerController::class, 'store']);
    Route::put('/banners/{id}', [BannerController::class, 'update']);
    Route::delete('/banners/{id}', [BannerController::class, 'destroy']);
    Route::post('/banners/upload', [BannerController::class, 'upload']);
    Route::post('/banners/delete', [BannerController::class, 'delete']);
    
    // Review management
    Route::get('/reviews', [AdminController::class, 'reviews']);
    Route::put('/reviews/{id}/toggle', [AdminController::class, 'toggleReview']);
    Route::delete('/reviews/{id}', [AdminController::class, 'deleteReview']);
    Route::prefix('admins')->group(function () {
        Route::get('/', [AdminManagementController::class, 'index']);
        Route::post('/', [AdminManagementController::class, 'store']);
        Route::put('/{id}', [AdminManagementController::class, 'update']);
        Route::post('/{id}/reset-password', [AdminManagementController::class, 'resetPassword']);
        Route::put('/{id}/toggle-status', [AdminManagementController::class, 'toggleStatus']);
        Route::delete('/{id}', [AdminManagementController::class, 'destroy']);
    });
    
    // Activity Logs
    Route::get('/activity-logs', [AdminManagementController::class, 'activityLogs']);
    
    // Change Own Password
    Route::post('/change-password', [AdminManagementController::class, 'changeOwnPassword']);
    
    // Analytics & Reports
    Route::get('/analytics/top-products', [AnalyticsController::class, 'topProducts']);
    Route::get('/analytics/top-customers', [AnalyticsController::class, 'topCustomers']);
    Route::get('/analytics/sales-report', [AnalyticsController::class, 'salesReport']);
    
    // Export System
    Route::get('/export/orders', [AnalyticsController::class, 'exportOrders']);
    Route::get('/export/users', [AnalyticsController::class, 'exportUsers']);
    Route::get('/export/products', [AnalyticsController::class, 'exportProducts']);
    
    // Inventory Management
    Route::post('/inventory/{productId}/adjust', [InventoryController::class, 'adjustStock']);
    Route::get('/inventory/low-stock', [InventoryController::class, 'getLowStock']);
    Route::get('/inventory/{productId}/history', [InventoryController::class, 'getStockHistory']);
    Route::post('/inventory/bulk-update', [InventoryController::class, 'bulkUpdateStock']);
    Route::get('/inventory/stats', [InventoryController::class, 'getInventoryStats']);
});

// Public coupon validation (no auth required)
Route::post('/coupons/validate', [CouponController::class, 'validate']);

// Payment verification
Route::post('/payment/verify', [PaymentController::class, 'verifyPayment']);
Route::post('/payment/webhook', [PaymentController::class, 'webhook']);
