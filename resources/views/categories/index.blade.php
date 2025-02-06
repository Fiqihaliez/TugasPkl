@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">Categories</h1>

    <a href="{{ route('categories.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add New Category</a>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full bg-white shadow rounded-lg">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Description</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $category->id }}</td>
                    <td class="px-4 py-2">{{ $category->name }}</td>
                    <td class="px-4 py-2">{{ $category->description }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('categories.edit', $category->id) }}" class="text-white bg-blue-500 px-2 py-1 rounded-sm">Edit</a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline-block" id="delete-form-{{ $category->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="text-white bg-red-500 px-2 py-1 rounded-sm" onclick="confirmDelete({{ $category->id }})">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(categoryId) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + categoryId).submit();
            }
        });
    }

    @if (session('success'))
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    @endif
</script>
@endsection
