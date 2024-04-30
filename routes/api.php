<?php
// web.php or api.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\XPController;
use App\Http\Middleware\JwtMiddleware;

// Public routes for admin signup and login
Route::post('/admin/signup', [AdminController::class, 'register']);
Route::post('/admin/login', [AdminController::class, 'login']);

// Protected routes for authenticated admin actions
Route::middleware([JwtMiddleware::class])->group(function () {
    Route::post('/user/add', [UserController::class, 'register']);
    Route::post('/tenant/add', [TenantController::class, 'add']);
    Route::post('/points/add', [XPController::class, 'award']);
});

