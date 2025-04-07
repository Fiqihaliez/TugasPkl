<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Course;


class LandingController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $courses = Course::all();
        return view('landing', compact('categories' , 'courses'));
    }
}
