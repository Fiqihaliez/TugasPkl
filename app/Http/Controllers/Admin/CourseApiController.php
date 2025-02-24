<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Services\CourseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseApiController extends Controller
{
    protected $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'image_url' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:3000',
        ]);

        $data = $request->only(['title', 'description', 'category_id']);

        $imagePath = null;
        if ($request->hasFile('image_url')) {
            $filename = uniqid() . '.' . $request->image_url->getClientOriginalExtension();
            $request->image_url->move(public_path('uploads/courses'), $filename);
            $imagePath = 'uploads/courses/' . $filename;
        }

        $data['image_url'] = $imagePath;
        $course = $this->courseService->createCourse($data);

        return response()->json([
            'success' => true,
            'message' => 'Course created successfully.',
            'data' => $course,
            'image_url' => $course->image_url ? Storage::url($course->image_url) : url('/default-course-image.jpg'),
        ], 201);
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'image_url' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:3000',
        ]);

        $data = $request->only(['title', 'description', 'category_id']);

        if ($request->hasFile('image_url')) {
            $filename = uniqid() . '.' . $request->image_url->getClientOriginalExtension();
            $request->image_url->move(public_path('uploads/courses'), $filename);
            $imagePath = 'uploads/courses/' . $filename;
            $data['image_url'] = $imagePath;
        }

        $updatedCourse = $this->courseService->updateCourse($course, $data);

        return response()->json([
            'success' => true,
            'message' => 'Course updated successfully.',
            'data' => $updatedCourse,
            'image_url' => $updatedCourse->image_url ? Storage::url($updatedCourse->image_url) : url('/default-course-image.jpg'),
        ]);
    }

    public function destroy(Course $course)
    {
        if ($course->image_url) {
            Storage::delete('public/' . $course->image_url);
        }

        $this->courseService->deleteCourse($course);

        return response()->json([
            'success' => true,
            'message' => 'Course deleted successfully.',
        ]);
    }
}
