<?php

namespace App\Http\Controllers\Courses;

use Exception;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ApiCourseController extends Controller
{
    public function index($category_id = null)
{
    try {
        $search = request()->query('search', '');
        if ($category_id) {
            $courses = Course::where('category_id', $category_id)
                             ->where('title', 'like', '%' . $search . '%')
                             ->get();
            if ($courses->isEmpty()) {
                return response()->json(['message' => 'Tidak ada kursus untuk kategori ini.'], 404);
            }
        } else{
                $courses = Course::where('title', 'like', '%' . $search . '%')
                                 ->orderBy('title')
                                 ->get(); 
            }
        return response()->json($courses);
    } catch (Exception $e) {
        return response()->json([
            'message' => 'Terjadi kesalahan saat mengambil data kursus.',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function landing($limit = 3)
{
    try {
        $search = request()->query('search', '');
        $courses = Course::where('title', 'like', '%' . $search . '%')
                    ->orderBy('title')
                    ->limit($limit)    
                    ->get();   
            
        return response()->json($courses);
    } catch (Exception $e) {
        return response()->json([
            'message' => 'Terjadi kesalahan saat mengambil data kursus.',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
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

    public function destroy($courseId)
{
    $course = Course::find($courseId);

    if ($course) {
        $course->delete();
        return response()->json(['message' => 'Course deleted successfully.']);
    }

    return response()->json(['message' => 'Course not found.'], 404);
}
}
