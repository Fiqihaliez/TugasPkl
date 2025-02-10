<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function createCategory($data)
    {
        return Category::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
        ]);
    }

    public function updateCategory(Category $category, $data)
    {
        $category->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
        ]);

        return $category;
    }

    public function deleteCategory(Category $category)
    {
        return $category->delete();
    }
}
