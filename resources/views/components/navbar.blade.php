<nav class="bg-white shadow-md">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <div class="text-xl font-semibold text-blue-500">
            <img src="{{ asset('img/logoles.png') }}" alt="Logo" class="h-12">
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

        <!-- Search Bar (Center aligned) -->

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

<!-- Live Search Results -->
<div id="search-results" class="absolute top-20 left-1/2 transform -translate-x-1/2 w-full max-w-md bg-white shadow-lg rounded-lg hidden z-50">
    <ul id="search-list" class="max-h-60 overflow-y-auto">
        <!-- Live search results will appear here -->
    </ul>
</div>

<script>
    const searchInput = document.getElementById('search-input');
    const searchResultsContainer = document.getElementById('search-results');
    const searchList = document.getElementById('search-list');
    const searchForm = document.getElementById('search-form');

    // Handle search input and display results
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

    // Optional: Hide search results when clicking outside of search input
    document.addEventListener('click', (e) => {
        if (!searchForm.contains(e.target)) {
            searchResultsContainer.classList.add('hidden');
        }
    });
</script>
