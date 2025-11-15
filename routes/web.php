<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StudentController;

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
Route::get('/projects/public', [ProjectController::class, 'publicProjects'])->name('projects.public');

// Admin View
Route::get('/admin/approved-projects', [ProjectController::class, 'adminApprovedProjects'])->name('admin.approved.projects');



// Student signup
Route::get('/student/register', [StudentController::class, 'showRegisterForm'])->name('student.register.form');
Route::post('/student/register', [StudentController::class, 'register'])->name('student.register');


//Student login/logout
Route::get('/student/login', [StudentController::class, 'showLoginForm'])->name('student.login');
Route::post('/student/login', [StudentController::class, 'login'])->name('student.login.post');
Route::post('/student/logout', [StudentController::class, 'logout'])->name('student.logout');


// Dashboard
Route::get('/student/dashboard', function () {
    return view('student.dashboard'); })->name('student.dashboard');