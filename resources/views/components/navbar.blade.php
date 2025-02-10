<nav class="bg-white shadow-md">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <div class="text-xl font-semibold text-blue-500">
            <img src="{{ asset('img/logoles.png') }}" alt="Logo" class="h-12">
        </div>

        <div class="hidden md:flex space-x-6 flex-1 justify-center font-bold">
            <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-500">Home</a>
            <a href="{{ route('categories.index') }}" class="text-gray-700 hover:text-blue-500">Categories</a>
            <a href="courses" class="text-gray-700 hover:text-blue-500">Courses</a>
        </div>

        <div class="flex items-center space-x-4 cursor-pointer" id="profile-menu-button">
            <div class="flex items-center space-x-2">
                <span class="text-gray-700"></span>
                <img src="{{ asset('img/prestasi.jpg') }}" alt="Profile Picture" class="w-8 h-8 rounded-full">
            </div>
        </div>

        <button class="md:hidden text-gray-700 focus:outline-none" id="mobile-menu-button" aria-label="Toggle Sidebar">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
    </div>
</nav>



<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40" aria-hidden="true"></div>

<script>
    const menuButton = document.getElementById('mobile-menu-button');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const profileMenuButton = document.getElementById('profile-menu-button');
    const profileSidebar = document.getElementById('profile-sidebar');

    menuButton.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
        profileSidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });

    profileMenuButton.addEventListener('click', () => {
        profileSidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    });
</script>
