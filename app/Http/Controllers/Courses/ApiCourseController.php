<?php

namespace App\Http\Controllers\Courses;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ApiCourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();

        if (Auth::check()) {
            if (Auth::user()->role == 'admin' || Auth::user()->role == 'student') {
                $courses = Course::all();
            } else {
                $courses = Course::where('user_id', Auth::id())->get();
            }
        }

        return response()->json([
            'message' => 'Courses fetched successfully.',
            'data' => $courses,
        ]);
    }

    public function show($id)
    {
        try {
            $course = Course::findOrFail($id);
            return response()->json([
                'message' => 'Course details fetched successfully',
                'data' => $course,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Course not found',
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
        ]);

        $course = new Course;
        $course->title = $request->title;
        $course->category_id = $request->category_id;
        $course->description = $request->description;
        $course->save();

        return response()->json([
            'message' => 'Course created successfully.',
            'data' => $course,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'description' => 'nullable|string',
            ]);

            $course = Course::findOrFail($id);
            $course->title = $request->title;
            $course->category_id = $request->category_id;
            $course->description = $request->description;
            $course->save();

            return response()->json([
                'message' => 'Course updated successfully.',
                'data' => $course,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'There is no Course to be updated',
            ], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $course = Course::findOrFail($id);
            $course->delete();

            return response()->json([
                'message' => 'Course deleted successfully.',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'There is no Course to be deleted',
            ], 404);
        }
    }
}
