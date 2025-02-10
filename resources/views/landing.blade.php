@extends('layouts.app1')

@section('content')
<!-- Hero Section -->
<section class="relative w-full h-screen bg-cover bg-center" style="background-image: url('{{ asset('img/prestasi.jpg') }}');">
    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
        <div class="text-center text-white px-4 md:px-8">
            <h1 class="text-5xl font-extrabold mb-4">Selamat Datang di Excellent</h1>
            <p class="text-lg md:text-2xl mb-6">Platform terbaik untuk belajar berbagai kategori kursus yang menginspirasi.</p>
            <a href="#courses" class="bg-blue-600 text-white px-6 py-3 rounded-lg text-xl hover:bg-blue-700 transition duration-300">Mulai Belajar Sekarang</a>
        </div>
    </div>
</section>

<div class="container mx-auto p-6">
    <h2 class="text-4xl font-bold text-center mb-10">Kategori Kursus</h2>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($categories as $category)
        <div class="relative group">
            <img src="{{ asset('img/logoles.png') }}" class="w-full h-64 object-cover rounded-lg shadow-lg">
            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                <h2 class="text-white text-2xl font-semibold">{{ $category->name }}</h2>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="mt-12 text-center">
        <a href="#courses" class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">Lihat Semua Kursus</a>
    </div>
</div>
@endsection
