<?php

namespace App\Services;

use App\Models\Category;
use Exception;
use Illuminate\Support\Facades\Storage;

class CategoryService
{
    public function getAllCategories(?string $search = null, int $limit = 10)
    {
        try {
            return Category::when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('description', 'like', "%{$search}%");
            })->limit($limit)->get();
        } catch (Exception $e) {
            logger()->error('Error fetching categories: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getCategoryDetail(int $id): Category
    {
        try {
            return Category::findOrFail($id);
        } catch (Exception $e) {
            logger()->error('Category not found: ' . $e->getMessage());
            throw $e;
        }
    }

    public function createCategory(array $data): Category
    {
        try {
            return Category::create([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'image_url' => $data['image_url'] ?? null,
            ]);
        } catch (Exception $e) {
            logger()->error('Error creating category: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateCategory(Category $category, array $data): Category
    {
        try {
            if (isset($data['image_url']) && $data['image_url'] !== $category->image_url) {
                if ($category->image_url) {
                    Storage::disk('public')->delete($category->image_url);
                }
                $category->image_url = $data['image_url'];
            }

            $category->update([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'image_url' => $category->image_url,
            ]);

            return $category;
        } catch (Exception $e) {
            logger()->error('Error updating category: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deleteCategory(Category $category): Category
    {
        try {
            if ($category->image_url) {
                Storage::disk('public')->delete($category->image_url);
            }

            $category->delete();

            return $category;
        } catch (Exception $e) {
            logger()->error('Error deleting category: ' . $e->getMessage());
            throw $e;
        }
    }
}
