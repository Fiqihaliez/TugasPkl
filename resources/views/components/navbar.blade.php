<nav class="bg-white shadow-md">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <div class="text-xl font-semibold text-blue-500">
            <a href="/" class="text-gray-700 hover:text-blue-500">
                <i class="fa-solid fa-book"></i> My App
            </a>
        </div>

        <div class="flex items-center justify-center flex-1">
            <form id="search-form" action="{{ route('search') }}" method="GET" class="flex items-center space-x-2 w-full max-w-md">
                <input 
                    type="text" 
                    id="search-input"
                    name="query" 
                    class="border rounded-full py-2 px-4 text-gray-700 w-full" 
                    placeholder="Search..." 
                    aria-label="Search"
                    autocomplete="off"
                >
                <button type="submit" class="hidden">Search</button>
            </form>
        </div>
        
        <div class="hidden md:flex space-x-6 flex-1 justify-center font-bold">
            <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-500">Home</a>
            <a href="{{ route('categories.index') }}" class="text-gray-700 hover:text-blue-500">Categories</a>
            <a href="{{ route('admin.courses.index') }}" class="text-gray-700 hover:text-blue-500">Courses</a>
        </div>

        <div class="flex items-center space-x-4 cursor-pointer" id="profile-menu-button">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('img/prestasi.jpg') }}" alt="Profile Picture" class="w-8 h-8 rounded-full">
            </div>
            <button id="logout-button" class="bg-red-500 text-white px-3 py-1 rounded text-sm">Logout</button>
        </div>

        <button class="md:hidden text-gray-700 focus:outline-none" id="mobile-menu-button" aria-label="Toggle Sidebar">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
    </div>
</nav>

<!-- Sidebar -->
<div id="sidebar" class="fixed top-0 left-0 w-64 h-full bg-white shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out z-50">
    <div class="px-4 py-6">
        <div class="text-lg font-semibold text-blue-500 mb-6">
            <a href="/">MyApp</a>
        </div>

        <div class="space-y-4">
            <a href="/home" class="block text-gray-700 hover:text-blue-500">Home</a>
            <a href="/categories" class="block text-gray-700 hover:text-blue-500">Categories</a>
            <a href="/courses" class="block text-gray-700 hover:text-blue-500">Courses</a>
            <button id="logout-button-sidebar" class="w-full text-left text-red-500 hover:text-red-700 block">Logout</button>
        </div>
    </div>
</div>

<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40" aria-hidden="true"></div>
<div id="search-results" class="absolute top-20 left-1/2 transform -translate-x-1/2 w-full max-w-md bg-white shadow-lg rounded-lg hidden z-50">
    <ul id="search-list" class="max-h-60 overflow-y-auto"></ul>
</div>

<script>
    const searchInput = document.getElementById('search-input');
    const searchResultsContainer = document.getElementById('search-results');
    const searchList = document.getElementById('search-list');
    const searchForm = document.getElementById('search-form');

    searchInput.addEventListener('input', async function () {
        const query = searchInput.value;

        if (query.length < 3) {
            searchResultsContainer.classList.add('hidden');
            return;
        }

        try {
            const response = await fetch(`/search?query=${query}`);
            const data = await response.json();
            
            if (data && data.categories.length > 0) {
                searchList.innerHTML = '';
                data.categories.forEach(category => {
                    const listItem = document.createElement('li');
                    listItem.classList.add('px-4', 'py-2', 'hover:bg-gray-200');
                    listItem.innerText = `${category.name} - ${category.description}`;
                    searchList.appendChild(listItem);
                });
                searchResultsContainer.classList.remove('hidden');
            } else {
                searchResultsContainer.classList.add('hidden');
            }
        } catch (error) {
            console.error('Error fetching search results:', error);
        }
    });

    document.addEventListener('click', (e) => {
        if (!searchForm.contains(e.target)) {
            searchResultsContainer.classList.add('hidden');
        }
    });

    document.getElementById("mobile-menu-button").addEventListener("click", function () {
        document.getElementById("sidebar").classList.toggle("-translate-x-full");
        document.getElementById("overlay").classList.toggle("hidden");
    });

    document.getElementById("overlay").addEventListener("click", function () {
        document.getElementById("sidebar").classList.add("-translate-x-full");
        document.getElementById("overlay").classList.add("hidden");
    });

    async function logout() {
        try {
            const token = localStorage.getItem('authToken');

            const response = await fetch("{{ route('logout') }}", {
                method: "POST",
                headers: {
                    "Authorization": "Bearer " + token,
                    "X-CSRF-TOKEN": document.querySelector("meta[name='csrf-token']").getAttribute('content')
                },
                data: {
                    _token: "{{ csrf_token() }}"
                },

            });

            if (response.ok) {
                localStorage.removeItem('authToken'); 
                window.location.href = "{{ route('login') }}";
            } else {
                alert("Logout gagal, coba lagi.");
            }
        } catch (error) {
            console.error("Error saat logout:", error);
        }
    }

    document.getElementById("logout-button").addEventListener("click", logout);
    document.getElementById("logout-button-sidebar").addEventListener("click", logout);
</script>
