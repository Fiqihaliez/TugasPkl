<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Category\CategoryApiController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\CourseApiController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\SearchController;

Route::view('register', 'auth.register')->name('register.form');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::view('register', 'auth.register')->name('register.form'); 

Route::get('home', [HomeController::class, 'index'])->name('home');
Route::get('', [LandingController::class, 'index'])->name('landing');

Route::get('search', [SearchController::class, 'index'])->name('search');

Route::view('login', 'auth.login')->name('login.form'); 
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('categories/create', [CategoryController::class,'create'])->name('categories.create');
Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

Route::prefix('api')->middleware('jwt.auth')->group(function () {
    Route::post('categories', [CategoryApiController::class, 'store'])->name('categories.store');
    Route::put('categories/{category}', [CategoryApiController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [CategoryApiController::class, 'destroy'])->name('categories.destroy');
}); 

Route::prefix('api')->middleware('jwt.auth')->group(function () {
    Route::post('/courses', [CourseApiController::class, 'store'])->name('admin.courses.store');  
    Route::put('/courses/{courseId}', [CourseApiController::class, 'update'])->name('admin.courses.update');  
    Route::delete('/courses/{courseId}', [CourseApiController::class, 'destroy'])->name('admin.courses.destroy');
    Route::get('/courses/{category_id?}', [CourseApiController::class, 'index'])->name('admin.courses.index');
});

    Route::get('/courses/{category_id?}', [CourseController::class, 'index'])->name('admin.courses.index');
    Route::get('/courses/create/{category_id}', [CourseController::class, 'create'])->name('admin.courses.create');
    Route::get('/courses/{id}/show', [CourseController::class, 'show'])->name('admin.courses.show');
    Route::get('/courses/{id}/edit', [CourseController::class, 'edit'])->name('admin.courses.edit');

    Route::middleware('auth:api')->post('logout', [AuthController::class, 'logout'])->name('logout');



// code 200 
// ret       urn response()->json([
//     'success' => true,
//     'message' => 'Response  Success',
//     'data' => null
// ]);

// code 400
// {
//     "success": false,
//     "message": "Bad Response",
//     "errors": {
//         "field": "This field is required"
//     }
// }

// code 404
// return response()->json([
//     'success' => false,
//     'message' => 'Data Not Found',
//     'data'    => null
// ], 404); 