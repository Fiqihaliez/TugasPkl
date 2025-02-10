@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">Add New Category</h1>

    <form id="category-form">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700">Name</label>
            <input type="text" id="name" name="name" class="w-full border-gray-300 rounded-lg shadow-sm">
            <p id="name-error" class="text-red-500 text-sm mt-1 hidden"></p>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700">Description</label>
            <textarea id="description" name="description" class="w-full border-gray-300 rounded-lg shadow-sm"></textarea>
            <p id="description-error" class="text-red-500 text-sm mt-1 hidden"></p>
        </div>
        <button type="submit" id="submit-category" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#category-form').on('submit', function (e) {
            e.preventDefault();

            let name = $('#name').val().trim();
            let description = $('#description').val().trim();
            let form = $(this);
            let button = $('#submit-category');

            $('#name-error, #description-error').text('').addClass('hidden');

            if (name === '') {
                $('#name-error').text('Name is required').removeClass('hidden');
                return;
            }

            button.prop('disabled', true).text('Saving...');

            $.ajax({
                url: "{{ route('categories.store') }}",
                type: "POST",
                data: form.serialize(),
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
