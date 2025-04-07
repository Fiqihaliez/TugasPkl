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
            })->limit($limit)->get();
        } catch (Exception $e) {
            logger()->error('Error fetching courses: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getCourseDetail(int $id): Course
    {
        try {
            $course = Course::findOrFail($id);
            $course->image_url = asset('storage/' . $course->image_url); 
            return $course;
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
                'image_url' => $data['image_url'] ?? null,
                'category_id' => $data['category_id'] ?? null,
            ]);
        } catch (Exception $e) {
            logger()->error('Error creating course: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateCourse(Course $course, array $data): Course
    {
        try {
            if (isset($data['image_url']) && $data['image_url'] instanceof \Illuminate\Http\UploadedFile) {
                if ($course->image_url) {
                    Storage::disk('public')->delete($course->image_url);
                }
                $filename = uniqid() . '.' . $data['image_url']->getClientOriginalExtension();
                $data['image_url']->move(public_path('uploads/courses'), $filename);
                $imagePath = 'uploads/courses/' . $filename;
            }
            
    
            $course->update([
                'title' => $data['title'],         
                'description' => $data['description'] ?? null,
                'category_id' => $data['category_id'],
                'image_url' => $imagePath ?? $course->image_url,
            ]);
    
            return $course;
        } catch (Exception $e) {
            logger()->error('Error updating course: ' . $e->getMessage());
            throw $e;
        }
    }
    

    public function deleteCourse(Course $course): bool
    {
        try {
            if ($course->image_url) {
                Storage::disk('public')->delete($course->image_url);
            }

            return $course->delete();
        } catch (Exception $e) {
            logger()->error('Error deleting course: ' . $e->getMessage());
            throw $e;
        }
    }
}
