@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 flex justify-center">
    <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4 text-center">Edit Course</h1>

        <form id="edit-course-form" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="title" class="block text-gray-700">Title</label>
                <input type="text" id="title" name="title" value="{{ $course->title }}" class="w-full border-gray-300 rounded-lg shadow-sm p-2">
                <p id="title-error" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700">Description</label>
                <textarea id="description" name="description" class="w-full border-gray-300 rounded-lg shadow-sm p-2 line-clamp-3">{{ $course->description }}</textarea>
                <p id="description-error" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>
            <div class="mb-4">
                <label for="category_id" class="block text-gray-700">Category</label>
                <select id="category_id" name="category_id" class="w-full border-gray-300 rounded-lg shadow-sm p-2">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $course->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                <p id="category-error" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>
            <div class="mb-4 text-center">
                <label class="block text-gray-700">Course Image</label>
                <input type="file" id="image" name="image_url" class="w-full border-gray-300 rounded-lg shadow-sm p-2">
                <p id="image-error" class="text-red-500 text-sm mt-1 hidden"></p>
                <div id="image-preview">
                    @if ($course->image_url)
                        <img src="{{ asset('storage/' . $course->image_url) }}" alt="Course Image" class="mt-4 mx-auto max-h-32 object-cover">
                    @endif
                </div>
            </div>
            <button type="submit" id="update-course" class="w-full bg-blue-500 text-white px-4 py-2 rounded flex items-center justify-center">
                Update
            </button>
        </form>
        <a href="{{ route('admin.courses.index') }}" class="block text-center mt-4 text-blue-500">Back to Courses</a>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    $('#image').on('change', function () {
        let file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function (e) {
                $('#image-preview').html(`<img src="${e.target.result}" alt="Preview Image" class="mt-4 mx-auto max-h-32 object-cover">`);
            };
            reader.readAsDataURL(file);
        }
    });

    $('#edit-course-form').on('submit', function (e) {
        e.preventDefault();

        let form = new FormData(document.getElementById('edit-course-form'));
        let button = $('#update-course');

        let valid = true;
        if ($('#title').val().trim() === '') {
            $('#title-error').text('Title is required').removeClass('hidden');
            valid = false;
        } else {
            $('#title-error').addClass('hidden');
        }

        if (!valid) return;

        button.prop('disabled', true).html('<span class="loader"></span> Updating...');

        $.ajax({
            url: "{{ route('admin.courses.update', $course->id) }}",
            type: "POST",
            data: form,
            processData: false,
            contentType: false,
            success: function () {
                Swal.fire({
                    title: 'Updated!',
                    text: 'Course has been updated successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = "{{ route('admin.courses.index') }}";
                });
            },
            error: function (xhr) {
                let errors = xhr.responseJSON.errors;
                if (errors) {
                    if (errors.title) {
                        $('#title-error').text(errors.title[0]).removeClass('hidden');
                    }
                    if (errors.description) {
                        $('#description-error').text(errors.description[0]).removeClass('hidden');
                    }
                    if (errors.category_id) {
                        $('#category-error').text(errors.category_id[0]).removeClass('hidden');
                    }
                    if (errors.image) {
                        $('#image-error').text(errors.image[0]).removeClass('hidden');
                    }
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to update course. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            complete: function () {
                setTimeout(() => {
                    button.prop('disabled', false).html('Update');
                }, 1000);
            }
        });
    });
});
</script>
@endsection
