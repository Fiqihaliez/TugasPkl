<?php

namespace App\Http\Controllers\Courses;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function landing()
{
    return view('landing');
}
    public function index($category_id)
{
    return view('courses.index', [
        'category_id' => $category_id,
    ]);
}

    public function create($category_id)
{
    $categories = Category::all();

    return view('courses.create', [
        'categories' => $categories, 
        'category_id' => $category_id 
    ]);
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

