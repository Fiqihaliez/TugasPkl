@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">Categories</h1>

    <a href="{{ route('categories.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add New Category</a>

    <table class="w-full bg-white shadow rounded-lg">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Description</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody id="category-table">
            <tr>
                <td colspan="4" class="text-center py-4">Loading categories...</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    function loadCategories() {
        $.ajax({
            url: "{{ route('categories.index') }}",
            type: "GET",
            dataType: "json",
            success: function (response) {
                let categoryRows = '';

                if (response.categories.length === 0) {
                    categoryRows = `<tr><td colspan="4" class="text-center py-4">No categories found.</td></tr>`;
                } else {
                    response.categories.forEach(function (category) {
                        categoryRows += `
                        <tr id="category-row-${category.id}" class="border-t">
                            <td class="px-4 py-2">${category.id}</td>
                            <td class="px-4 py-2 category-name">${category.name}</td>
                            <td class="px-4 py-2 category-description">${category.description}</td>
                            <td class="px-4 py-2">
                                <a href="{{ url('categories') }}/${category.id}/edit" class="text-white bg-blue-500 px-2 py-1 rounded-sm id="edit-button">Edit</a>
                                <button type="button" class="text-white bg-red-500 px-2 py-1 rounded-sm delete-button" data-id="${category.id}">Delete</button>
                            </td>
                        </tr>
                        `;
                    });
                }

                $('#category-table').html(categoryRows);
            },
            error: function () {
                $('#category-table').html('<tr><td colspan="4" class="text-center py-4 text-red-500">Failed to fetch categories.</td></tr>');
            }
        });
    }

    loadCategories();

    $(document).on('click', '.edit-button', function () {
    let categoryId = $(this).data('id');
    
    $.ajax({
        url: "/categories/" + categoryId + "/edit",
        type: "GET",
        success: function (response) {
            $('#categoryName').val(response.data.name);
            $('#categoryDescription').val(response.data.description);
            $('#categoryId').val(response.data.id); 
        }
    });
});

    $(document).on('click', '.delete-button', function () {
        let categoryId = $(this).data('id');

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
                    url: "{{ url('categories') }}/" + categoryId,
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function () {
                        $(`#category-row-${categoryId}`).fadeOut(300, function () {
                            $(this).remove();
                        });

                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Category has been deleted.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    },
                    error: function () {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to delete category.',
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
