<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Category\CategoryApiController;
use App\Http\Controllers\Auth\AuthController;

Route::get('/', function () {
    return jsonResponse(true, 'Response  Success', null, 200);
});

Route::post('register', [AuthController::class, 'register'])->name('register');
Route::view('register', 'auth.register')->name('register.form'); 

Route::get('home', [HomeController::class, 'index'])->name('home');
Route::view('login', 'auth.login')->name('login.form'); 
Route::post('login', [AuthController::class, 'login'])->name('login'); 
Route::resource('categories', CategoryController::class);

Route::prefix('api')->group(function () {
    Route::resource('categories', CategoryApiController::class);
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