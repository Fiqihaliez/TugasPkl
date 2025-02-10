<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $categories = Category::all();
            return response()->json(['categories' => $categories]);
        }
    
        return view('categories.index');
    }
    

    public function create()
    {
        return view('categories.create');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', ['category' => $category]);
    }

    public function show(Category $category)
    {
        return view('categories.show', ['category' => $category]);
    }
}
