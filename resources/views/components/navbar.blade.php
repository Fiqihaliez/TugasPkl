<nav class="bg-white shadow-md">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <div class="text-xl font-semibold text-blue-500">
            <a href="/" class="text-gray-700 hover:text-blue-500 
            {{ request()->is('/') ? 'text-blue-500' : '' }}" ><i class="fa-solid fa-book"></i> My App</a>
        </div>

        <div class="lg:pr-[450px] hidden md:flex space-x-6">
            <a href="/home" class="text-gray-700 hover:text-blue-500 
                {{ request()->is('home') ? 'text-blue-500' : '' }}"><i class="fa-solid fa-house"></i> Home</a>
            <a href="/categories" class="text-gray-700 hover:text-blue-500 
                {{ request()->is('categories') ? 'text-blue-500' : '' }}"><i class="fa-solid fa-bars"></i> Categories</a>
            <a href="/courses" class="text-gray-700 hover:text-blue-500 
                {{ request()->is('courses') ? 'text-blue-500' : '' }}"><i class="fa-solid fa-file"></i> Courses</a>
        </div>

        <button class="md:hidden text-gray-700 focus:outline-none" id="mobile-menu-button" aria-label="Toggle Sidebar">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
    </div>
</nav>

<div id="sidebar" class="fixed top-0 left-0 w-64 h-full bg-white shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out z-50">
    <div class="px-4 py-6">
        <div class="text-lg font-semibold text-blue-500 mb-6">
            <a href="/">MyApp</a>
        </div>

        <div class="space-y-4">
            <a href="/home" class="block text-gray-700 hover:text-blue-500 {{ request()->is('home') ? 'text-blue-500' : '' }}">Home</a>
            <a href="/categories" class="block text-gray-700 hover:text-blue-500 {{ request()->is('categories') ? 'text-blue-500' : '' }}">Categories</a>
            <a href="/courses" class="block text-gray-700 hover:text-blue-500 {{ request()->is('courses') ? 'text-blue-500' : '' }}">Courses</a>
        </div>
    </div>
</div>

<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40" aria-hidden="true"></div>

<script>
    document.getElementById("mobile-menu-button").addEventListener("click", function () {
        document.getElementById("sidebar").classList.toggle("-translate-x-full");
        document.getElementById("overlay").classList.toggle("hidden");
    });

    document.getElementById("overlay").addEventListener("click", function () {
        document.getElementById("sidebar").classList.add("-translate-x-full");
        document.getElementById("overlay").classList.add("hidden");
    });
</script>