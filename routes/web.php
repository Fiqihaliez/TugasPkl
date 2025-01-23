<?php

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Courses\CourseController;
use PhpParser\Node\Stmt\TryCatch;

Route::get('/', function () {
    return jsonResponse(true, 'Response  Success', null, 200);
});

Route::get('/courses/create', [CourseController::class, 'create']);
Route::get('/courses/{id}/edit', [CourseController::class, 'edit']);
Route::get('/courses/{id}', [CourseController::class, 'show']); 

// Route::get('/courses', function () {
//     $courses = Course::all();

//     if (Auth::check()) {
//         if (Auth::user()->role == 'admin' || Auth::user()->role == 'student') {
//             $courses = Course::all();
//         } else {
//             $courses = Course::where('user_id', Auth::id())->get();
//         }
//     }

//     return response()->json([
//         'message' => 'Courses fetched successfully.',
//         'data' => $courses,
//     ]);
// });

// Route::post('/courses', function (Request $request) {
//     $request->validate([
//         'title' => 'required|string|max:255',
//         'category_id' => 'required|exists:categories,id',
//         'description' => 'nullable|string',
//     ]);
                       
//     $course = new Course;
//     $course->title = $request->title;
//     $course->category_id = $request->category_id;
//     $course->description = $request->description;
//     $course->save();

//     return response()->json([
//         'message' => 'Course created successfully.',
//         'data' => $course,
//     ], 201);
// });

// Route::get('/courses/{id}', function ($id) {
//     try {
//         $course = Course::findOrFail($id);
        
//         return response()->json([
//             'message' => 'Course details fetched successfully',
//             'data' => $course,
//         ]);
//     } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
//         return response()->json([
//             'message' => 'Course not found',
//         ], 404);
//     }
// });

// Route::put('/courses/{id}', function (Request $request, $id) {
//     try {
//         $request->validate([
//             'title' => 'required|string|max:255',
//             'category_id' => 'required|exists:categories,id',
//             'description' => 'nullable|string',
//         ]);
    
//         $course = Course::findOrFail($id);
//         $course->title = $request->title;
//         $course->category_id = $request->category_id;
//         $course->description = $request->description;
//         $course->save();
    
//         return response()->json([
//             'message' => 'Course updated successfully.',
//             'data' => $course,
//         ]);
//     } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
//         return response()->json([
//             'message' => 'There is no Course to be updated',
//         ], 404);
//     }
// });

// Route::delete('/courses/{id}', function ($id) {
//     try {
//         $course = Course::findOrFail($id);
//         $course->delete();

//         return response()->json([
//             'message' => 'Course deleted successfully.',
//         ]);
//     } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
//         return response()->json([
//             'message' => 'There is no Course to be deleted',
//         ], 404);
//     }
// });

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