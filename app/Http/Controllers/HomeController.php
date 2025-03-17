<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all(); 
        $courses = Course::all(); 

        return view('home', [
            'categories' => $categories,
            'courses' => $courses
        ]);
    }
}
