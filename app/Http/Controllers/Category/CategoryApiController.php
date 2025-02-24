<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryApiController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image_url' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:3000', 
        ]);


        $data = $request->only(['name', 'description']);


        $imagePath = null;

        if ($request->hasFile('image_url')) {
            $filename = uniqid() . '.' . $request->image_url->getClientOriginalExtension();
            $request->image_url->move(public_path('uploads/categories'), $filename);

            $imagePath = 'uploads/categories/' . $filename;
        }


        $data['image_url'] = $imagePath;

        $category = $this->categoryService->createCategory($data);

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully.',
            'data' => $category,
            'image_url' => $category->image_url ? Storage::url($category->image_url) : url('/default-category-image.jpg'),
        ], 201);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image_url' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:3000', 
        ]);

        $data = $request->only(['name', 'description']);

        if ($request->hasFile('image_url')) {
            $filename = uniqid() . '.' . $request->image_url->getClientOriginalExtension();
            $request->image_url->move(public_path('uploads/categories'), $filename);

            $imagePath = 'uploads/categories/' . $filename;
        }

        $data['image_url'] = $imagePath;

        $updatedCategory = $this->categoryService->updateCategory($category, $data);

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully.',
            'data' => $updatedCategory,
            'image_url' => $updatedCategory->image_url ? Storage::url($updatedCategory->image_url) : url('/default-category-image.jpg'),
        ]);
    }

    public function destroy(Category $category)
    {
        if ($category->image_url) {
            Storage::delete('public/' . $category->image_url);
        }

        $this->categoryService->deleteCategory($category);

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully.'
        ]);
    }
}
