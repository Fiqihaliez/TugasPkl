@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">Edit Category</h1>

    <form id="edit-category-form">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-gray-700">Name</label>
            <input type="text" id="name" name="name" value="{{ $category->name }}" class="w-full border-gray-300 rounded-lg shadow-sm" required>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700">Description</label>
            <textarea id="description" name="description" class="w-full border-gray-300 rounded-lg shadow-sm">{{ $category->description }}</textarea>
        </div>
        <button type="submit" id="update-category" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    $('#update-category').on('click', function () {
        let button = $(this);
        let categoryId = "{{ $category->id }}";
        let name = $('#name').val();
        let description = $('#description').val();

        button.prop('disabled', true).text('Updating...');

        $.ajax({
            url: "{{ route('categories.update', $category->id) }}",
            type: "POST",
            timeout: 2000,
            data: {
                _token: "{{ csrf_token() }}",
                _method: "PUT",
                name: name,
                description: description
            },
            success: function (response) {
                Swal.fire({
                    title: 'Updated!',
                    text: 'Category has been updated successfully.',
                    icon: 'success',
                    timer: 2000, 
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Update tampilan di index tanpa reload halaman
                    let updatedCategory = response.data;

                    // Menemukan kategori yang baru diperbarui dan mengubah kontennya
                    let row = $('#category-row-' + updatedCategory.id);
                    row.find('.category-name').text(updatedCategory.name);
                    row.find('.category-description').text(updatedCategory.description);
                    
                    window.location.href = "{{ route('categories.index') }}";  // Optional: Redirect ke halaman index setelah update
                });
            },
            error: function () {
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to update category. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            },
            complete: function () {
                setTimeout(() => {
                    button.prop('disabled', false).text('Update');
                }, 2000);
            }
        });
    });
});

</script>
@endsection
