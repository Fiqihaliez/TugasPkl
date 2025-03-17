@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 flex justify-center">
    <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4 text-center">Add New Category</h1>

        <form id="category-form" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" id="name" name="name" class="w-full border-gray-300 rounded-lg shadow-sm p-2">
                <p id="name-error" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700">Description</label>
                <textarea id="description" name="description" class="w-full border-gray-300 rounded-lg shadow-sm p-2 line-clamp-3"></textarea>
                <p id="description-error" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>
            <div class="mb-4">
                <label for="image" class="block text-gray-700">Image</label>
                <input type="file" id="image" name="image_url" accept="image/*" class="w-full border-gray-300 rounded-lg shadow-sm p-2">
                <p id="image-error" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>
            <button type="submit" id="submit-category" class="w-full bg-blue-500 text-white px-4 py-2 rounded">Save</button>
        </form>
        <a href="{{ route('categories.index') }}" class="block text-center mt-4 text-blue-500">Back to Categories</a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#category-form').on('submit', function (e) {
            e.preventDefault();

            let form = new FormData(this);
            let button = $('#submit-category');

            $('#name-error, #description-error, #image-error').text('').addClass('hidden');

            button.prop('disabled', true).text('Saving...');

            $.ajax({
                url: "{{ route('categories.store') }}",
                type: "POST",
                headers: {"Authorization": "Bearer " + localStorage.getItem('authToken')},
                data: form,
                processData: false,
                contentType: false,
                success: function (response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Category added successfully!',
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
                        if (errors.image) {
                            $('#image-error').text(errors.image[0]).removeClass('hidden');
                        }
                    }

                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to add category. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                },
                complete: function () {
                    setTimeout(() => {
                        button.prop('disabled', false).text('Save');
                    }, 2000);
                }
            });
        });
    });
</script>
@endsection
