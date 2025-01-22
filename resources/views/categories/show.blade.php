@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-2xl font-semibold text-blue-500 mb-4">{{ $category->name }}</h1>
            <p class="text-gray-700 mb-6">{{ $category->description }}</p>
            <h2 class="text-xl font-semibold text-blue-500 mb-4">Courses in {{ $category->name }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="mt-6">
                    <a href="{{ url('home') }}" class="text-blue-500 hover:underline">
                        &larr; Back to Home
                    </a>
                </div>
                

            </div>
        </div>
    </div>
@endsection
