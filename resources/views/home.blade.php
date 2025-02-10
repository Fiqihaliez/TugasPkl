@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    @auth
        <h1 class="text-3xl font-bold mb-6">Selamat datang, {{ Auth::user()->name }}!</h1>
    @else
        <h1 class="text-3xl font-bold mb-6">Selamat datang di Excellent</h1>
    @endauth

    <div class="categories mt-8">
        <h2 class="text-2xl font-semibold mb-6">Kategori Kursus</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($categories as $category)
                <div class="bg-white shadow-lg rounded-lg p-6 hover:shadow-xl transition">
                    <h3 class="text-lg font-semibold mb-3">{{ $category->name }}</h3>
                    <p class="text-gray-600 mb-4">{{ $category->description }}</p>
                    <a href="{{ route('categories.show', $category->id) }}" class="text-blue-500 hover:underline">Jelajahi</a>
                </div>
            @endforeach
        </div>
    </div>

    <div class="courses mt-12">
        <h2 class="text-2xl font-semibold mb-6">Kursus Kami</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
 
                <div class="bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition">
                    <img src="" alt="" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold mb-2"></h3>
                        <p class="text-gray-600 mb-4"></p>
                        <a href="" class="text-blue-500 hover:underline">Mulai Belajar</a>
                    </div>
                </div>

        </div>
    </div>
</div>
@endsection
