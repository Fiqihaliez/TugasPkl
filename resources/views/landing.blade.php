@extends('layouts.app')

@section('content')
<div class="">
    @auth
        <h1 class="text-2xl font-bold mb-4">Welcome, {{ Auth::user()->name }}!</h1>
    @else
        <div class="w-full h-[500px] flex flex-col md:flex-row gap-5 justify-between items-center" 
            style="background-image: url('{{ asset('images/banner.jpg') }}'); background-size: cover; background-position: center;">
            <div class=" ml-5 text-center md:text-left">
                <h1 class="text-4xl text-gray-300 font-bold mb-4"><i class="fa-solid fa-book"></i> Book is a window to<br>
                    <span class="text-3xl font-bold text-blue-500">the world</span>
                </h1>
                <h1 class="text-xl font-bold text-gray-300">Education is the passport to the future,<br>
                    <span>for tomorrow belongs to those who prepare for it today</span>
                </h1>
                <br>
                <div class="text-center flex flex-col md:flex-row gap-4 w-full justify-center md:justify-start">
                    <a href="{{ route('login') }}" class="bg-red-400 text-white w-full md:w-[175px] font-bold rounded-xl transform transition duration-300 hover:scale-105 p-3 hover:text-blue-500">Login</a>
                    <a href="{{ route('register') }}" class="bg-blue-200 w-full md:w-[200px] text-gray-700 font-bold transform transition duration-300 hover:scale-105 hover:text-blue-500 p-3 rounded-xl">Register</a>
                </div>
            </div>
        </div>
    @endauth
        <br>
        <div class="px-4">
            <label for="category-search" class="font-semibold "><i class="fa-solid fa-magnifying-glass"></i> Search Courses:</label>
            <input type="text" id="category-search" class="border border-gray-300 rounded-md w-full p-2 mt-3" placeholder="Search for courses..." />
            <div id="course-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 mt-6"></div>
        </div>
</div>

<script>
    $(document).ready(function() {
        let debounceTimer;
        function fetchCourses(query = '') {
            $.ajax({
                url: '/api/courses',
                type: 'GET',
                data: { search: query , limit : 3}, 
                success: function(response) {
                    var courseList = $('#course-list');
                    courseList.empty(); 
                    $.each(response, function(index, course) {
                        var courseHtml = `
                            <div class="course-item bg-white shadow rounded-lg overflow-hidden hover:shadow-lg transition">
                                <img src="${course.image}" class="w-full h-48 object-cover">
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold mb-2">${course.title}</h3>
                                    <p class="text-gray-600 mb-4">${course.description}</p>
                                    <a href="/courses/${course.id}/show" class="text-blue-500 hover:underline">Start Learning</a>
                                </div>
                            </div>
                        `;
                        courseList.append(courseHtml);
                    });
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