<?php

namespace App\Http\Controllers\Courses;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{

    public function create()
    {
        return view('courses.create');
    }

    public function edit($id)
    {
        $data['course'] = Course::findOrFail($id);
        return view('courses.edit', $data);
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);
        return view('courses.show', compact('course'));
    }
}

