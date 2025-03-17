@extends('layouts.app')

@section('content')

<!-- Hero Section -->
<section class="relative w-full h-screen bg-cover bg-center" style="background-image: url('{{ asset('img/prestasi.jpg') }}');">
    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
        <div class="text-center text-white px-4 md:px-8">
            <h1 class="text-5xl font-extrabold mb-4">Selamat Datang di Excellent</h1>
            <p class="text-lg md:text-2xl mb-6">Platform terbaik untuk belajar berbagai kategori kursus yang menginspirasi.</p>
            <a href="#courses" class="bg-blue-600 text-white px-6 py-3 rounded-lg text-xl hover:bg-blue-700 transition duration-300">Mulai Belajar Sekarang</a>
        </div>
    </div>
</section>

<!-- Kategori Kursus -->
<div class="container mx-auto p-6">
    <h2 class="text-4xl font-bold text-center mb-10">Kategori Kursus</h2>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($categories as $category)
        <div class="relative group">
            <img src="{{ asset($category->image ?? 'img/default-category.jpg') }}" class="w-full h-64 object-cover rounded-lg shadow-lg">
            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                <h2 class="text-white text-2xl font-semibold">{{ $category->name }}</h2>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Daftar Kursus -->
<div class="container mx-auto p-6">
    <h2 class="text-4xl font-bold text-center mb-10">Kursus Populer</h2>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($courses as $course)
        <div class="course-item bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition">
            <img src="{{ asset($course->image ?? 'img/default-course.jpg') }}" class="w-full h-48 object-cover">
            <div class="p-4">
                <h3 class="text-lg font-semibold mb-2">{{ $course->title }}</h3>
                <p class="text-gray-600 mb-4">{{ Str::limit($course->description, 100) }}</p>
                <a href="{{ route('courses.show', $course->id) }}" class="text-blue-500 hover:underline">Mulai Belajar</a>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Pencarian Kursus -->
<div class="px-4 mt-10">
    <label for="category-search" class="font-semibold"><i class="fa-solid fa-magnifying-glass"></i> Cari Kursus:</label>
    <input type="text" id="category-search" class="border border-gray-300 rounded-md w-full p-2 mt-3" placeholder="Cari kursus..." />
    <div id="course-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 mt-6"></div>
</div>

<script>
    $(document).ready(function() {
        let debounceTimer;

        function fetchCourses(query = '') {
            $.ajax({
                url: '/api/courses',
                type: 'GET',
                data: { search: query, limit: 6 }, 
                success: function(response) {
                    var courseList = $('#course-list');
                    courseList.empty();
                    if (response.length === 0) {
                        courseList.append('<p class="text-gray-500 text-center">Tidak ada kursus yang ditemukan.</p>');
                    } else {
                        $.each(response, function(index, course) {
                            var courseHtml = `
                                <div class="course-item bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition">
                                    <img src="${course.image || '/img/default-course.jpg'}" class="w-full h-48 object-cover">
                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold mb-2">${course.title}</h3>
                                        <p class="text-gray-600 mb-4">${course.description.substring(0, 100)}...</p>
                                        <a href="/courses/${course.id}/show" class="text-blue-500 hover:underline">Mulai Belajar</a>
                                    </div>
                                </div>
                            `;
                            courseList.append(courseHtml);
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan',
                        text: 'Tidak dapat mengambil data kursus. Coba lagi nanti.',
                    });
                }
            });
        }

        $('#category-search').on('input', function() {
            clearTimeout(debounceTimer);
            let query = $(this).val();  
            debounceTimer = setTimeout(function() {
                fetchCourses(query);
            }, 500);
        });

        fetchCourses();
    });
</script>

@endsection
