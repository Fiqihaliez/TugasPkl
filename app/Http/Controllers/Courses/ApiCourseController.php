<?php

namespace App\Http\Controllers\Courses;

use Exception;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Services\CourseService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ApiCourseController extends Controller
{
    protected $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    public function index(Request $request, $category_id = null)
    {
         $search = request()->query('search', '');
        $limit = isset($request->limit)? $request->limit : null; 
        $courses = $this->courseService->getCourses($search, $category_id, $limit);

        if ($courses->isEmpty()) {
            return response()->json(['message' => 'Tidak ada kursus untuk kategori ini.'], 404);
        }

        return response()->json($courses);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        try {
            $course = $this->courseService->createCourse($request->all());
            return response()->json([
                'message' => 'Course created successfully.',
                'data' => $course,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat membuat kursus.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
        ]);

        try {
            $course = $this->courseService->updateCourse($id, $request->all());
            return response()->json([
                'message' => 'Course updated successfully.',
                'data' => $course,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui kursus.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($courseId)
    {
        try {
            $deleted = $this->courseService->deleteCourse($courseId);
            if ($deleted) {
                return response()->json(['message' => 'Course deleted successfully.']);
            }
            return response()->json(['message' => 'Course not found.'], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus kursus.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}       