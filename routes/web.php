<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
Route::get('/login', fn () => view('auth.login'))->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');

Route::get('/dashboard', fn () => view('admin.dashboard'))
    ->middleware('auth');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth');
Route::get('/', function () {
    return view('landing');
});

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/categories', fn () => view('admin.categories')); // View route
    Route::get('/categories/data', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
});

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/product', fn () => view('admin.product')); // View route
    Route::get('/product/data', [ProductController::class, 'index']);
    Route::post('/product', [ProductController::class, 'store']);
    Route::put('/product/{id}', [ProductController::class, 'update']);
    Route::delete('/product/{id}', [ProductController::class, 'destroy']);
});

