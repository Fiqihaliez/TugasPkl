<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;

class CourseController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $courses = Course::with('category')->get();
            return response()->json([
                'success' => true,
                'courses' => $courses
            ]);
        }
    
        return view('admin.courses.index');
    }
    
    public function create()
    {
        $categories = Category::all();
        return view('admin.courses.create', [
        
            'categories' => $categories 
        ]);
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $categories = Category::all();
    
        return view('admin.courses.edit', compact('course', 'categories'));
    }
    
    
    public function show(Course $course)
    {
        return view('admin.courses.show', ['course' => $course]);
    }
}
