@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">Search Results</h1>

        @if($categories->isEmpty())
            <p class="text-gray-500">No categories found for your search.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($categories as $category)
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold text-blue-500">{{ $category->name }}</h3>
                        <p class="text-gray-700">{{ $category->description ?? 'No description available' }}</p>
                        <a href="{{ route('categories.show', $category->id) }}" class="text-blue-500 hover:underline">Jelajahi</a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
