<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::get('/login', fn () => view('auth.login'))->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');

Route::get('/dashboard', fn () => view('admin.dashboard'))
    ->middleware('auth');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth');


Route::get('/', function () {
    return view('landing');
});
