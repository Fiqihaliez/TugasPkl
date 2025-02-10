<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('components.navbar')
    <div class="container mx-auto p-8">
        @yield('content')
    </div>
    <footer class="w-full bg-black grid grid-cols-1 text-center justify-center p-10 gap-10 h-[600px] items-center">
        <div class="flex gap-10 mt-20 justify-center items-center">
            <i class="fa-brands fa-facebook text-white text-5xl"></i>
            <i class="fa-solid fa-phone text-white text-5xl"></i>
            <i class="fa-brands fa-google text-white text-5xl"></i>
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d126921.16447334258!2d106.93509119999999!3d-6.22592!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sid!4v1738846056178!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="w-fit h-fit"></iframe>
        </div>
        <div class="flex gap-10 justify-center mb-20">
            <h1 class="text-white font-bold text-xl">Home</h1>
            <h1 class="text-white font-bold text-xl">About us</h1>
            <h1 class="text-white font-bold text-xl">Contact us</h1>
            <h1 class="text-white font-bold text-xl">Location</h1>
        </div>
    </footer>
    @yield('scripts')
</body>
</html>
