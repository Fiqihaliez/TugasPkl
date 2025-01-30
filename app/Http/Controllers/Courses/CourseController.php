<?php

namespace App\Http\Controllers\Courses;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{

    public function index($category_id)
{
    $courses = Course::where('category_id', $category_id)->get();

    return view('courses.index', [
        'courses' => $courses,
        'category_id' => $category_id, 
    ]);;
}

public function create($category_id)
{
    return view('courses.create', ['category_id' => $category_id]);
}

    public function edit($id)
    {
        $data['course'] = Course::findOrFail($id);
        return view('courses.edit', $data);
    }

    public function show($id)
    {
        $data['course'] = Course::findOrFail($id);
        return view('courses.show', $data);
    }
}

