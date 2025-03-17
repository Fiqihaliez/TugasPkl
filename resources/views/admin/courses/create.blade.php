@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 flex justify-center">
    <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4 text-center">Add New Course</h1>

        <form id="course-form" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-gray-700">Title</label>
                <input type="text" id="title" name="title" class="w-full border-gray-300 rounded-lg shadow-sm p-2">
                <p id="title-error" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700">Description</label>
                <textarea id="description" name="description" class="w-full border-gray-300 rounded-lg shadow-sm p-2 line-clamp-3"></textarea>
                <p id="description-error" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>
            <div class="mb-4">
                <label for="category_id" class="block text-gray-700">Category</label>
                <select id="category_id" name="category_id" class="w-full border-gray-300 rounded-lg shadow-sm p-2">
                    <option value="">-- Select Category --</option>
                </select>
                <p id="category-error" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>
            <div class="mb-4">
                <label for="image" class="block text-gray-700">Image</label>
                <input type="file" id="image" name="image_url" accept="image/*" class="w-full border-gray-300 rounded-lg shadow-sm p-2">
                <p id="image-error" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>
            <button type="submit" id="submit-course" class="w-full bg-blue-500 text-white px-4 py-2 rounded">Save</button>
        </form>
        <a href="{{ route('admin.courses.index') }}" class="block text-center mt-4 text-blue-500">Back to Courses</a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        loadCategories();

        function loadCategories() {
            $.ajax({
                url: "{{ route('categories.index') }}",
                type: "GET",
                dataType: "json",
                success: function (response) {
                    let categorySelect = $('#category_id');
                    categorySelect.empty().append('<option value="">-- Select Category --</option>');
                    
                    if (response.success && response.data.length > 0) {
                        response.data.forEach(category => {
                            categorySelect.append(`<option value="${category.id}">${category.name}</option>`);
                        });
                    } else {
                        categorySelect.append('<option disabled>No categories available</option>');
                    }
                },
                error: function () {
                    console.error("Failed to load categories.");
                }
            });
        }

        $('#course-form').on('submit', function (e) {
            e.preventDefault();
            let form = new FormData(this);
            let button = $('#submit-course');
            $('.text-red-500').text('').addClass('hidden');
            button.prop('disabled', true).text('Saving...');

            $.ajax({
                url: "{{ route('admin.courses.store') }}",
                type: "POST",
                data: form,
                processData: false,
                contentType: false,
                success: function (response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Course added successfully!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = "{{ route('admin.courses.index') }}";
                    });
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON?.errors;
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
                        if (errors.image_url) {
                            $('#image-error').text(errors.image_url[0]).removeClass('hidden');
                        }
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Something went wrong. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                complete: function () {
                    button.prop('disabled', false).text('Save');
                }
            });
        });
    });
</script>
@endsection
