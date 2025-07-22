<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProjectController;

Route::get('/', function () {
    return view('admin.register');
    
});


// Admin Signup & Login Routes
Route::get('/admin/register', [AdminController::class, 'showRegisterForm']);
Route::post('/admin/register', [AdminController::class, 'register']);

Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);
Route::post('/admin/logout', [AdminController::class, 'logout']);

//handles admin dashboard
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

//handles everthing about the uploading of finalists
Route::get('/admin/upload-finalists', [AdminController::class, 'showUploadForm']);
Route::post('/admin/upload-finalists', [AdminController::class, 'uploadFinalists']);




// Admin Project Review Routes
Route::get('/admin/pending-projects', [AdminController::class, 'pendingProjects'])->name('admin.pending');
Route::post('/admin/approve-project/{id}', [AdminController::class, 'approveProject'])->name('admin.approve');
Route::post('/admin/reject-project/{id}', [AdminController::class, 'rejectProject'])->name('admin.reject');


//Approved project
// Public View
Route::get('/projects', [ProjectController::class, 'publicProjects'])->name('projects.public');

// Admin View
Route::get('/admin/approved-projects', [ProjectController::class, 'adminApprovedProjects'])->name('admin.approved.projects');


