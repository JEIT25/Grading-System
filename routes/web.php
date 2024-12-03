<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FacilitatorController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Dashboard
Route::get('/admin', [AdminController::class, 'index'])
    ->name('admin.dashboard');

//user(student or facilitator) delete
Route::delete('/admin/delete-user/{id}/{role}', [AdminController::class, 'deleteUser'])->name('admin.delete-user');

//delete subject
Route::delete('/admin/subjects/{subject}', [AdminController::class, 'deleteSubject'])->name('admin.delete-subject');

//Delete grade
Route::delete('/facilitator/grades/{id}', [FacilitatorController::class, 'deleteGrade'])->name('facilitator.delete-grade');

// Create Student
Route::get('/admin/create-student', [AdminController::class, 'createStudent'])
    ->name('admin.create-student');
Route::post('/admin/store-student', [AdminController::class, 'storeStudent'])
    ->name('admin.store-student');

// Create Facilitator
Route::get('/admin/create-facilitator', [AdminController::class, 'createFacilitator'])
    ->name('admin.create-facilitator');
Route::post('/admin/store-facilitator', [AdminController::class, 'storeFacilitator'])
    ->name('admin.store-facilitator');

// Create Subject
Route::get('/admin/create-subject', [AdminController::class, 'createSubject'])
    ->name('admin.create-subject');
Route::post('/admin/store-subject', [AdminController::class, 'storeSubject'])
    ->name('admin.store-subject');

//facilitato route
Route::middleware(['auth'])->group(function () {
    Route::get('/facilitator/dashboard', [FacilitatorController::class, 'index'])->name('facilitator.dashboard');
    Route::get('/facilitator/subjects', [FacilitatorController::class, 'showSubjects'])->name('facilitator.subjects');
    Route::get('/facilitator/faculty-menu', [FacilitatorController::class, 'facultyMenu'])->name('facilitator.faculty-menu');
    Route::post('/facilitator/add-grade', [FacilitatorController::class, 'addGrade'])->name('facilitator.add-grade');
    Route::get('/facilitator/general-grade', [FacilitatorController::class, 'showStudentGrades'])->name('facilitator.calculate-grade');
});

//student routes
Route::middleware('auth')->get('/student/my-info', [StudentController::class, 'showMyInfo'])->name('student.my-info');
Route::get('/student/grades', [StudentController::class, 'showStudentGrades'])->name('student.grades')->middleware('auth');



