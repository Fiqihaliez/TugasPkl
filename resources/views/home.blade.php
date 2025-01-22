@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    @auth
        <h1 class="text-2xl font-bold mb-4">Welcome, {{ Auth::user()->name }}!</h1>
    @else
        <h1 class="text-2xl font-bold mb-4">Welcome to Our Learning Platform!</h1>
    @endauth

    <div class="categories mt-8">
        <h2 class="text-xl font-semibold mb-4">Categories</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($categories as $category)
                <div class="bg-white shadow rounded-lg p-4 hover:shadow-lg transition">
                    <h3 class="text-lg font-semibold mb-2">{{ $category->name }}</h3>
                    <p class="text-gray-600 mb-4">{{ $category->description }}</p>
                    <a href="{{ route('categories.show', $category->id) }}" class="text-blue-500 hover:underline">Explore</a>
                </div>
            @endforeach
        </div>
    </div>

    <div class="courses mt-12">
        <h2 class="text-xl font-semibold mb-4">Courses</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white shadow rounded-lg overflow-hidden hover:shadow-lg transition">
                    <img src="" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold mb-2"></h3>
                        <p class="text-gray-600 mb-4"></p>
                        <a href="" class="text-blue-500 hover:underline">Start Learning</a>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
