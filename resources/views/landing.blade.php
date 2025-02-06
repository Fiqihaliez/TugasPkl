@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    @auth
        <h1 class="text-2xl font-bold mb-4">Welcome, {{ Auth::user()->name }}!</h1>
    @else
        <div class="w-full flex gap-35">
            <div class="mt-12">
                <h1 class="text-3xl font-bold mb-4"><i class="fa-solid fa-book"></i> Book is a window to<br>
                <span class="text-3xl font-bold text-blue-500">the world</span>
                </h1>
                <h1 class="text-lg font-bold">Education is the passport to the future,<br>
                <span>for tomorrow belongs to those who prepare for it today</span>
                </h1>
                <br>
                <div class="text-center flex gap-4 w-full">
                <a href="{{ route('login') }}" class="bg-red-400 text-white w-[175px] font-bold rounded-xl transform transition duration-300 hover:scale-105 p-3 hover:text-blue-500">Login</a>
                <a href="{{ route('register') }}" class="bg-blue-200 w-[200px] text-gray-700 font-bold transform transition duration-300 hover:scale-105 hover:text-blue-500 p-3  rounded-xl">Register</a>
                </div>
            </div>
            <div class="bg-gray-300 w-[500px] h-[350px]">
                <div class=""></div>
            </div>
        </div>
    @endauth
    <label for="category-search" class="font-semibold"><i class="fa-solid fa-magnifying-glass"></i> Search Courses:</label>
    <input type="text" id="category-search" class="border border-gray-300 rounded-md w-full p-2" placeholder="Search for courses..." />
    <div id="course-list" class="grid grid-cols-3 gap-5"></div>
</div>
<footer class="w-full bg-black grid grid-cols-1 text-center justify-center p-10 gap-10">
    <div class="flex gap-10 justify-center items-center">
        <i class="fa-brands fa-facebook text-white text-5xl"></i>
        <i class="fa-solid fa-phone text-white text-5xl"></i>
        <i class="fa-brands fa-google text-white text-5xl"></i>
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d126921.16447334258!2d106.93509119999999!3d-6.22592!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sid!4v1738846056178!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="w-fit h-fit"></iframe>
    </div>
    <div class="flex gap-10 justify-center">
        <h1 class="text-white font-bold">Home</h1>
        <h1 class="text-white font-bold">About us</h1>
        <h1 class="text-white font-bold">Contact us</h1>
        <h1 class="text-white font-bold">Location</h1>
    </div>
    
</footer>
<script>
    $(document).ready(function() {
    let debounceTimer;
    function fetchCourses(query = '') {
        $.ajax({
            url: '/api/courses',
            type: 'GET',
            data: { search: query }, 
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
                                    <a href="/courses/${course.id}" class="text-blue-500 hover:underline">Start Learning</a>
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
