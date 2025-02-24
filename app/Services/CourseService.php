<?php

namespace App\Services;

use App\Models\Course;
use Exception;
use Illuminate\Support\Facades\Storage;

class CourseService
{
    public function getAllCourses(?string $search = null, int $limit = 10)
    {
        try {
            return Course::when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                             ->orWhere('description', 'like', "%{$search}%");
            })->with('category')->limit($limit)->get();
        } catch (Exception $e) {
            logger()->error('Error fetching courses: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getCourseDetail(int $id): Course
    {
        try {
            return Course::with('category')->findOrFail($id);
        } catch (Exception $e) {
            logger()->error('Course not found: ' . $e->getMessage());
            throw $e;
        }
    }

    public function createCourse(array $data): Course
    {
        try {
            return Course::create([
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'category_id' => $data['category_id'],
                'image_url' => $data['image_url'] ?? null,
            ]);
        } catch (Exception $e) {
            logger()->error('Error creating course: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateCourse(Course $course, array $data): Course
    {
        try {
            if (isset($data['image_url']) && $data['image_url'] !== $course->image_url) {
                if ($course->image_url) {
                    Storage::disk('public')->delete($course->image_url);
                }
                $course->image_url = $data['image_url'];
            }

            $course->update([
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'category_id' => $data['category_id'],
                'image_url' => $course->image_url,
            ]);

            return $course;
        } catch (Exception $e) {
            logger()->error('Error updating course: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deleteCourse(Course $course): Course
    {
        try {
            if ($course->image_url) {
                Storage::disk('public')->delete($course->image_url);
            }

            $course->delete();

            return $course;
        } catch (Exception $e) {
            logger()->error('Error deleting course: ' . $e->getMessage());
            throw $e;
        }
    }
}
