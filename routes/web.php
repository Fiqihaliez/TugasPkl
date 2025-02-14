<?php

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Courses\CourseController;
use PhpParser\Node\Stmt\TryCatch;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Category\CategoryApiController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Courses\ApiCourseController;

Route::post('register', [AuthController::class, 'register'])->name('register');
Route::view('register', 'auth.register')->name('register.form'); 

Route::get('home', [HomeController::class, 'index'])->name('home');
Route::view('login', 'auth.login')->name('login.form'); 
Route::post('login', [AuthController::class, 'login'])->name('login'); 
Route::resource('categories', CategoryController::class);

Route::prefix('api')->group(function () {
    Route::resource('categories', CategoryApiController::class);
});

Route::prefix('api')->as('api.')->group(function () {
    Route::post('/courses', [ApiCourseController::class, 'store'])->name('courses.store');  
    Route::put('/courses/{courseId}', [ApiCourseController::class, 'update'])->name('courses.update');  
    Route::delete('/courses/{courseId}', [ApiCourseController::class, 'destroy'])->name('courses.destroy');
    Route::get('/courses/{category_id?}', [ApiCourseController::class, 'index'])->name('courses.index');
    Route::get('/', [ApiCourseController::class, 'landing'])->name('landing.index');
});

Route::group([], function () {
    Route::get('/', [CourseController::class, 'landing']);
    Route::get('/courses/{category_id}', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/create/{category_id}', [CourseController::class, 'create'])->name('courses.create');
    Route::get('/courses/{id}', [CourseController::class, 'show'])->name('courses.show');
    Route::get('/courses/{id}/edit', [CourseController::class, 'edit'])->name('courses.edit');
    Route::get('/courses', [CourseController::class, 'allCourses'])->name('courses.all');
});


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