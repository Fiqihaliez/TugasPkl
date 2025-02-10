<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Exception;

class CourseService
{
    public function getAllCourses($category_id = null, $search = '', $limit)
    {
        try {
            if ($category_id) {
                $courses = Course::where('category_id', $category_id)
                                 ->where('title', 'like', '%' . $search . '%')
                                 ->get();
            } elseif (is_null($category_id) && $limit) {
                $courses = Course::where('title', 'like', '%' . $search . '%')
                                 ->orderBy('title')
                                 ->limit($limit)
                                 ->get();
            } else {
                $courses = Course::where('title', 'like', '%' . $search . '%')
                                 ->orderBy('title')
                                 ->get();
            }
            
            return ['status' => true, 'data' => $courses];
        } catch (Exception $e) {
            return ['status' => false, 'message' => 'Terjadi kesalahan saat mengambil data kursus.', 'error' => $e->getMessage()];
        }
    }

    public function createCourse($data)
    {
        try {
            $course = Course::create([
                'title' => $data['title'],
                'category_id' => $data['category_id'],
                'description' => $data['description'],
            ]);

            return ['status' => true, 'message' => 'Course created successfully.', 'data' => $course];
        } catch (Exception $e) {
            return ['status' => false, 'message' => 'Terjadi kesalahan saat membuat kursus.', 'error' => $e->getMessage()];
        }
    }

    public function updateCourse($id, $data)
    {
        $course = Course::find($id);
        try {
            $course = Course::findOrFail($id);
            $course->update([
                'title' => $data['title'],
                'category_id' => $data['category_id'],
                'description' => $data['description'],
            ]);

            return ['status' => true, 'message' => 'Course updated successfully.', 'data' => $course];
        } catch (Exception $e) {
            return ['status' => false, 'message' => 'Terjadi kesalahan saat mengupdate kursus.', 'error' => $e->getMessage()];
        }
    }

    public function deleteCourse($courseId)
    {
        try {
            $course = Course::find($courseId);

            if ($course) {
                $course->delete();
                return ['status' => true, 'message' => 'Course deleted successfully.'];
            }

            return ['status' => false, 'message' => 'Course not found.'];
        } catch (Exception $e) {
            return ['status' => false, 'message' => 'Terjadi kesalahan saat menghapus kursus.', 'error' => $e->getMessage()];
        }
    }
}
