<nav class="bg-white shadow-md">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <div class="text-xl font-semibold text-blue-500">
            <a href="/">My App</a>
        </div>

        <div class="hidden md:flex space-x-6">
            <a href="home" class="text-gray-700 hover:text-blue-500">Home</a>
            <a href="categories" class="text-gray-700 hover:text-blue-500">Categories</a>
            <a href="courses" class="text-gray-700 hover:text-blue-500">Courses</a>
        </div>

        <div class="hidden md:flex items-center space-x-4">
            @auth
                <span class="text-gray-700">Welcome, {{ Auth::user()->name }}</span>
            @else
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-500">Login</a>
                <a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-500">Register</a>
            @endauth
        </div>
        <button class="md:hidden text-gray-700 focus:outline-none" id="mobile-menu-button" aria-label="Toggle Sidebar">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
    </div>
</nav>

<div
    id="sidebar"
    class="fixed top-0 left-0 w-64 h-full bg-white shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out z-50"
>
    <div class="px-4 py-6">
        <div class="text-lg font-semibold text-blue-500 mb-6">
            <a href="/">MyApp</a>
        </div>

        <div class="space-y-4">
            <a href="home" class="block text-gray-700 hover:text-blue-500">Home</a>
            <a href="categories" class="block text-gray-700 hover:text-blue-500">Categories</a>
            <a href="courses" class="block text-gray-700 hover:text-blue-500">Courses</a>
        </div>

        <div class="mt-6 border-t pt-4">
            <button class="block bg-yellow-500 hover:text-yellow-700 mt-2" id="editButton" onclick="editItem()">Edit Item</button>
            <button class="block bg-red-500 hover:text-red-700 mt-2" id="deleteButton" onclick="deleteItem()">Delete Item</button>
        </div>

        <div class="mt-6 border-t pt-4">
            @auth
                <span class="block text-gray-700">Welcome, {{ Auth::user()->name }}</span>
            @else
                <a href="{{ route('login') }}" class="block text-gray-700 hover:text-blue-500">Login</a>
                <a href="{{ route('register') }}" class="block text-gray-700 hover:text-blue-500 mt-2">Register</a>
            @endauth
        </div>
    </div>
</div>

<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40" aria-hidden="true"></div>

<script>
    const menuButton = document.getElementById('mobile-menu-button');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    menuButton.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });

    function editItem() {
        Swal.fire({
            title: 'Edit Item',
            text: 'You can now edit the item!',
            icon: 'info',
            confirmButtonText: 'Okay, got it!',
        });
    }

    function deleteItem() {
        Swal.fire({
            title: 'Are you sure?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Deleted!',
                    'The item has been deleted.',
                    'success'
                );
            }
        });
    }
</script>
