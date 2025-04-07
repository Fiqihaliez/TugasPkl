@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 flex justify-center">
    <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4 text-center">Edit Category</h1>

        <form id="edit-category-form" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" id="name" name="name" value="{{ $category->name }}" class="w-full border-gray-300 rounded-lg shadow-sm p-2">
                <p id="name-error" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700">Description</label>
                <textarea id="description" name="description" class="w-full border-gray-300 rounded-lg shadow-sm p-2 line-clamp-3">{{ $category->description }}</textarea>
                <p id="description-error" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>
            <div class="mb-4 text-center">
                <label class="block text-gray-700">Category Image</label>
                <input type="file" id="image" name="image_url" class="w-full border-gray-300 rounded-lg shadow-sm p-2">
                <p id="image-error" class="text-red-500 text-sm mt-1 hidden"></p>
                <div id="image-preview">
                    @if ($category->image_url)
                        <img src="{{ asset('storage/' . $category->image_url) }}" alt="Category Image" class="mt-4 mx-auto max-h-32 object-cover">
                    @endif
                </div>
            </div>
            <button type="submit" id="update-category" class="w-full bg-blue-500 text-white px-4 py-2 rounded flex items-center justify-center">
                Update
            </button>
        </form>
        <a href="{{ route('categories.index') }}" class="block text-center mt-4 text-blue-500">Back to Categories</a>
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

    $('#edit-category-form').on('submit', function (e) {
        e.preventDefault();

        let form = new FormData(document.getElementById('edit-category-form'));
        let button = $('#update-category');

        let valid = true;
        if ($('#name').val().trim() === '') {
            $('#name-error').text('Name is required').removeClass('hidden');
            valid = false;
        } else {
            $('#name-error').addClass('hidden');
        }

        if (!valid) return;

        button.prop('disabled', true).html('<span class="loader"></span> Updating...');

        $.ajax({
            url: "{{ route('categories.update', $category->id) }}",
            type: "POST",
            headers: {"Authorization": "Bearer " + localStorage.getItem('authToken')},
            data: form,
            processData: false,
            contentType: false,
            success: function () {
                Swal.fire({
                    title: 'Updated!',
                    text: 'Category has been updated successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = "{{ route('categories.index') }}";
                });
            },
            error: function (xhr) {
                let errors = xhr.responseJSON.errors;
                if (errors) {
                    if (errors.name) {
                        $('#name-error').text(errors.name[0]).removeClass('hidden');
                    }
                    if (errors.description) {
                        $('#description-error').text(errors.description[0]).removeClass('hidden');
                    }
                    if (errors.image_url) {
                        $('#image-error').text(errors.image_url[0]).removeClass('hidden');
                    }
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to update category. Please try again.',
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
