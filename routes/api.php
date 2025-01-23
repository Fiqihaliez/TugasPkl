<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Courses\ApiCourseController;

Route::get('/courses', [ApiCourseController::class, 'index']); 
Route::get('/courses/{id}', [ApiCourseController::class, 'show']); 
Route::post('/courses', [ApiCourseController::class, 'store']);  
Route::put('/courses/{id}', [ApiCourseController::class, 'update']);  
Route::delete('/courses/{id}', [ApiCourseController::class, 'destroy']); 
