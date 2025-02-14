<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Category;
use Exception;

class CourseService
{
    public function getCourses($search = '', $category_id = null, $limit = null)
    {
        try {
            $query = Course::query();

            if ($category_id) {
                $query->where('category_id', $category_id);
            }

            if ($search) {
                $query->where('title', 'like', '%' . $search . '%');
            }

            if ($limit) {
                $query->limit($limit);
            }

            return $query->orderBy('title')->get();
        } catch (Exception $e) {
            throw new Exception('Terjadi kesalahan saat mengambil kursus: ' . $e->getMessage());
        }
    }

    public function createCourse($data)
    {
        try {
            $course = new Course;
            $course->title = $data['title'];
            $course->category_id = $data['category_id'];
            $course->description = $data['description'];
            $course->save();

            return $course;
        } catch (Exception $e) {
            throw new Exception('Terjadi kesalahan saat membuat kursus: ' . $e->getMessage());
        }
    }

    public function updateCourse($id, $data)
    {
        try {
            $course = Course::findOrFail($id);
            $course->title = $data['title'];
            $course->category_id = $data['category_id'];
            $course->description = $data['description'];
            $course->save();

            return $course;
        } catch (Exception $e) {
            throw new Exception('Terjadi kesalahan saat memperbarui kursus: ' . $e->getMessage());
        }
    }
       
    public function deleteCourse($id)
    {
        try {
            $course = Course::find($id);
            if ($course) {
                $course->delete();
                return true;
            }

            return false;
        } catch (Exception $e) {
            throw new Exception('Terjadi kesalahan saat menghapus kursus: ' . $e->getMessage());
        }
    }
}