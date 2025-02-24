@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Categories</h1>
        <a href="{{ route('categories.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow-md">+ Add New Category</a>
    </div>

    <div id="category-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"></div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(() => {
        const loadCategories = () => {
            $.ajax({
                url: "{{ route('categories.index') }}",
                type: "GET",
                dataType: "json",
                success: (response) => {
                    let categoryList = '';

                    if (response.data.length > 0) {
                        response.data.forEach((category) => {
                            let categoryImage = category.image_url ? `/${category.image_url}` : '{{ asset('storage/default.jpg') }}';

                            categoryList += `
                            <div id="category-card-${category.id}" class="bg-white p-6 rounded-lg shadow-lg transform transition-transform hover:scale-105">
                                <div class="mb-4">
                                    <img src="${categoryImage}" alt="Category Image" class="w-full h-32 object-cover rounded-md">
                                </div>
                                <h2 class="text-xl font-semibold mb-2 text-gray-800">${category.name}</h2>
                                <p class="text-gray-600 mb-4">${category.description || 'No description available.'}</p>
                                <div class="flex justify-between items-center">
                                    <a href="{{ url('categories') }}/${category.id}/edit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md shadow-md">Edit</a>
                                    <button type="button" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md shadow-md delete-button" data-id="${category.id}">Delete</button>
                                </div>
                            </div>`;
                        });
                    } else {
                        categoryList = `<p class="text-gray-600">No categories found.</p>`;
                    }

                    $('#category-list').html(categoryList);
                },
                error: () => {
                    $('#category-list').html('<p class="text-red-500">Failed to fetch categories.</p>');
                }
            });
        };

        loadCategories();

        $(document).on('click', '.delete-button', (e) => {
            const categoryId = $(e.currentTarget).data('id');

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
                        url: `{{ url('categories') }}/${categoryId}`,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: () => {
                            $(`#category-card-${categoryId}`).fadeOut(300, function() {
                                $(this).remove();
                            });

                            Swal.fire({
                                title: 'Deleted!',
                                text: 'Category has been deleted.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        },
                        error: () => {
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
