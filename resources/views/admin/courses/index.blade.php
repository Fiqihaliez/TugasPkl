@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Courses</h1>
        <a href="{{ route('admin.courses.create' , ['category_id' => 1]) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow-md">+ Add New Course</a>
    </div>

    <div id="course-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <p class="text-gray-600">Loading courses...</p>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(() => {
        const loadCourses = () => {
            $.ajax({
                url: "{{ route('admin.courses.index') }}",
                type: "GET",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: (response) => {
                    let courseList = '';

                    if (response.courses.data === 0) {
                        courseList = `<p class="text-gray-600">No courses found.</p>`;
                    } else {
                        response.courses.forEach ((course) => {
                            let courseImage = course.image_url ? `/${course.image_url}` : '{{ asset('storage/default.jpg') }}';

                            courseList += `
                            <div id="course-card-${course.id}" class="bg-white p-6 rounded-lg shadow-lg transform transition-transform hover:scale-105">
                                <div class="mb-4">
                                    <img src="${courseImage}" alt="Course Image" class="w-full h-32 object-cover rounded-md">
                                </div>
                                <h2 class="text-xl font-semibold mb-2 text-gray-800">${course.title}</h2>
                                <p class="text-gray-600 mb-4">${course.description || 'No description available.'}</p>
                                <p class="text-sm text-gray-500">Category: ${course.category.name}</p>
                                <div class="flex justify-between items-center mt-4">
                                    <a href="{{ url('courses') }}/${course.id}/edit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md shadow-md">Edit</a>
                                    <button type="button" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md shadow-md delete-button" data-id="${course.id}">Delete</button>
                                </div>
                            </div>`;
                        });
                    }

                    $('#course-list').html(courseList);
                },
                error: () => {
                    $('#course-list').html('<p class="text-red-500">Failed to fetch courses.</p>');
                }
            });
        };

        loadCourses();

        $(document).on('click', '.delete-button', (e) => {
            const courseId = $(e.currentTarget).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ url('admin/courses') }}/${courseId}`,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: () => {
                            $(`#course-card-${courseId}`).fadeOut(300, () => {
                                $(this).remove();
                            });

                            Swal.fire({
                                title: 'Deleted!',
                                text: 'Course has been deleted.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        },
                        error: () => {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to delete course.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
