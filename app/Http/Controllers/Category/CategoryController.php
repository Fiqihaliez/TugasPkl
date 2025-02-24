<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            // Mengambil kategori
            $categories = Category::all();
    
            // Menambahkan status 'success' dan 'message' untuk membantu debugging di frontend
            return response()->json([
                'success' => true,
                'message' => 'Categories loaded successfully',
                'data' => $categories
            ]);
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
