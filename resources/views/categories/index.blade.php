@extends('layouts.app')
@section('content')
@if (auth()->user())
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

@else
    <div class="flex justify-between items-center">
        <div>
            <h3 class="text-2xl pl-5 pt-2">Categories</h3>
            <br>
        </div>
    </div>
    <br>

    <div id="course-list" class="pl-5 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
        @foreach($categories as $category)
            <div class="category-item p-3 bg-white shadow rounded-lg overflow-hidden hover:shadow-lg transition">
                <h3 class="text-lg font-semibold mb-2">{{ $category->name }}</h3>
                <p class="text-gray-600 mb-4">{{ $category->description }}</p>
                <a href="{{ route('courses.index', $category->id) }}" class="btn btn-info text-white bg-blue-500 hover:bg-blue-700 py-1 px-3 rounded-md">Start Learning</a>
            </div>
        @endforeach
    </div>
@endif

@endsection