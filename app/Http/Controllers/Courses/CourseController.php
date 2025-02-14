<?php

namespace App\Http\Controllers\Courses;
use App\Models\Course;
use App\Models\Category;
use App\Services\CourseService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    protected $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    public function landing()
    {
        return view('landing');
    }

    public function allCourses()
    {
        return view('courses.index');
    }

    public function index($category_id = null)
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
        $course = $this->courseService->getCourses(null, null, null)->find($id);
        return view('courses.edit', [
            'course' => $course
        ]);
    }

    public function show($id)
    {
        $course = $this->courseService->getCourses(null, null, null)->find($id);
        return view('courses.show', [
            'course' => $course
        ]);
    }
}