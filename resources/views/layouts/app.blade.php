<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('components.navbar')
    <div class="">
        @yield('content')
    </div>
    <footer class="w-full bg-black grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 text-center justify-center p-10 gap-10 h-fit items-center">

        <div class="flex gap-10 justify-center items-center mb-4 md:mb-0">
            <i class="fa-brands fa-facebook text-white text-3xl md:text-5xl"></i>
            <i class="fa-solid fa-phone text-white text-3xl md:text-5xl"></i>
            <i class="fa-brands fa-google text-white text-3xl md:text-5xl"></i>
        </div>

        <div class="w-full h-64 md:h-72 lg:h-80 lg:pt-8">
            <iframe src="https://www.google.com/maps/embed?pb=..." width="100%" height="100%" style="border:0;" loading="lazy"></iframe>
        </div>
    
        <div class="flex flex-wrap justify-center gap-10 mb-4 md:mb-0">
            <h1 class="text-white font-bold text-sm md:text-lg">Home</h1>
            <h1 class="text-white font-bold text-sm md:text-lg">About us</h1>
            <h1 class="text-white font-bold text-sm md:text-lg">Contact us</h1>
            <h1 class="text-white font-bold text-sm md:text-lg">Location</h1>
        </div>
    </footer>
    @yield('scripts')
</body>
</html>
