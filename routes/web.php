<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CustomerController;
Route::get('/login', fn () => view('auth.login'))->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');

Route::get('/dashboard', fn () => view('admin.dashboard'))
    ->middleware('auth');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth');

Route::get('/', function () {
    return view('landing');
});

Route::get('/overview',function(){
   return view('users.overview');
});

Route::get('/landing/products', function () {
    return response()->json(App\Models\Product::with('categories')->where('status', 'active')->latest()->take(6)->get());
});

Route::get('/products', function () {
    return view('users.product');
});



Route::get('/api/products/all', function () {
    return response()->json(App\Models\Product::with('categories')->where('status', 'active')->latest()->get());
});


Route::prefix('admin')->middleware('auth')->group(function () {
    // Categories
    Route::get('/categories', fn () => view('admin.categories'));
    Route::get('/categories/data', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

    // Products
    Route::get('/products', fn () => view('admin.product')); // Kept view name as 'product' since the file is product.blade.php
    Route::get('/products/data', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);

    // Customers
    Route::get('/customers', fn () => view('admin.customers'));
    Route::get('/customers/data', [CustomerController::class, 'index']);
    Route::post('/customers', [CustomerController::class, 'store']);
    Route::put('/customers/{id}', [CustomerController::class, 'update']);
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy']);
});


// Public route for customer sign-up
Route::post('/customers', [CustomerController::class, 'store']);
Route::post('/customers/login', [CustomerController::class, 'login']);

// Order Routes
Route::get('/orders/{product}', function ($product) {
    return view('users.order', ['productId' => $product]);
});
Route::post('/orders', [\App\Http\Controllers\OrderController::class, 'store']);
