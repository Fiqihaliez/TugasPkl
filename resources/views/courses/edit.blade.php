@extends('layouts.app')
@section('content')
<h1>Edit Course</h1>
    <form id="edit-course-form">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" value="{{ $course->title }}" required><br><br>
        <label for="category_id">Category:</label><br>
        <input type="number" id="category_id" name="category_id" value="{{ $course->category_id }}" required><br><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description">{{ $course->description }}</textarea><br><br>
        <button type="submit">Update Course</button>
    </form>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#edit-course-form').on('submit', function(e) {
            e.preventDefault();
            var formData = {
                title: $('#title').val(),
                category_id: $('#category_id').val(),
                description: $('#description').val()
            };

            var courseId = "{{ $course->id }}";

            $.ajax({
                url: '{{ route('api.courses.update', ['courseId' => $course->id]) }}',
                type: 'PUT',
                data: formData,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,  
                    });
                    console.log(response.data);
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update the course: ' + error, 
                    });
                }
            });
        });
    </script>
@endsection