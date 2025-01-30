@extends('layouts.app')

@section('title', 'Login')

@section('content')
<h2 class="text-2xl font-bold text-center mb-6">Login</h2>
<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-4">
        <label for="email" class="block text-sm font-medium">Email</label>
        <input type="email" id="email" name="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
    </div>
    
    <div class="mb-4">
        <label for="password" class="block text-sm font-medium">Password</label>
        <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
    </div>
    
    <button type="submit" class="w-full py-2 text-white bg-blue-600 rounded-md">Login</button>
</form>


<p class="mt-4 text-center text-sm text-gray-600">
    Belum punya akun? 
    <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Daftar</a>
</p>
@endsection
