<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('adminpage');
});

// Admin Signup & Login Routes
Route::get('/admin/register', [AdminController::class, 'showRegisterForm']);
Route::post('/admin/register', [AdminController::class, 'register']);

Route::get('/admin/login', [AdminController::class, 'showLoginForm']);
Route::post('/admin/login', [AdminController::class, 'login']);
Route::post('/admin/logout', [AdminController::class, 'logout']);

