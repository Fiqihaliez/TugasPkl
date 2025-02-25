@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center">
    <div>
        <h3 class="text-2xl pl-5 pt-2">Courses</h3>
        <br>
        @if (auth()->user())
        @isset($category_id)
        <a href="{{ route('home') }}" class="text-blue-500 pl-5 text-lg"><= Back</a>
        @endisset
        @else
        <a href="/categories" class="text-blue-500 pl-5 text-lg"><= Back</a>        
        @endif
    </div>
    <div class="text-right w-full pr-5">
        @if (auth()->user())
        @isset($category_id)
            <a href="{{ route('courses.create', ['category_id' => $category_id]) }}" class="btn btn-primary text-xl rounded-md bg-blue-300 p-1">Create Course</a>
        @endisset
        @else
            
        @endif
    </div>
</div>
<br>
<div id="course-list" class="pl-5 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10"></div>

<script>
    var categoryId = {{ $category_id ?? 'null' }};
    var url = '/api/courses'; 
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    if (categoryId) {
        url = '/api/courses/' + categoryId; 
    }

    $.ajax({
        url: url, 
        type: 'GET',
        success: function(response) {
            var courseList = $('#course-list');
            courseList.empty(); 
            if (response.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Data Found',
                    text: 'No courses found for this category.',
                });
            }
            $.each(response, function(index, course) {
                var courseHtml = `
                    <div class="course-item bg-white shadow rounded-lg overflow-hidden hover:shadow-lg transition">
                        <img src="${course.image}" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold mb-2">${course.title}</h3>
                            <p class="text-gray-600 mb-4">${course.description}</p>
                            @if (auth()->user())
                                @isset($category_id)
                                <a href="/courses/${course.id}/show" class="btn btn-info text-white bg-blue-500 hover:bg-blue-700 py-1 px-3 rounded-md">Show</a>
                                <a href="/courses/${course.id}/edit" class="btn btn-warning text-white bg-yellow-500 hover:bg-yellow-700 py-1 px-3 rounded-md">Edit</a>
                                <button class="btn btn-danger text-white bg-red-500 hover:bg-red-700 py-1 px-3 rounded-md" onclick="deleteCourse(${course.id})">Delete</button>
                                @endisset
                            @else 
                                <a href="/courses/${course.id}/show" class="btn btn-info text-white bg-blue-500 hover:bg-blue-700 py-1 px-3 rounded-md">Show</a> 
                            @endif
                        </div>
                    </div>
                `;
                courseList.append(courseHtml); 
            });
        },
        error: function(xhr, status, error) {
            if (xhr.status === 500) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to fetch courses, try again later.',
                });
            } else if (xhr.status === 404) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Data Found',
                    text: 'No courses found.',
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error fetching courses: ' + error,
                });
            }
        }
    });

    function deleteCourse(courseId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This course will be deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/api/courses/' + courseId, 
                    type: 'DELETE',
                    success: function(response) {
                        if (response.message === 'Course deleted successfully.') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Course has been deleted.'
                            });
                            $('#course-' + courseId).remove();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed',
                                text: 'Failed to delete the course.'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'There was an error while deleting the course.'
                        });
                    }
                });
            }
        });
    }
</script>
@endsection
