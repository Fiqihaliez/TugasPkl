<div class="flex flex-col">

    <div class="flex-1">
        <nav class="bg-gray-100 shadow-sm p-4">
            <div class="container mx-auto flex justify-between items-center">
                <button id="menu-toggle" class="text-whitefocus:outline-none md:hidden px-4 py-2 rounded">
                    ☰
                </button>
                <div class="hidden md:flex items-center">
                    <img src="{{ asset('img/logoles.png') }}" alt="Logo" class="h-12">
                </div>
                <ul id="nav-menu" class="hidden md:flex justify-center space-x-6 flex-1">
                    <li><a href="#about" class="font-bold">Tentang Kami</a></li>
                    <li><a href="#blog" class="font-bold" >Blog</a></li>
                    <li><a href="#courses" class="font-bold">Program</a></li>
                </ul>
                <div class="hidden md:flex space-x-4">
                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700 focus:outline-none">
                        Masuk/Daftar
                    </a>

                </div>
                <!-- Mobile menu (hidden by default) -->
                <ul id="mobile-menu" class="md:hidden absolute left-0 top-0 bg-gray-100 shadow-md w-64 p-4 space-y-4 mt-10 -translate-x-full transition-all duration-300">
                    <li><a href="#about">Tentang Kami</a></li>
                    <li><a href="#blog">Blog</a></li>
                    <li><a href="#program">Program</a></li>
                </ul>
            </div>
        </nav>
    </div>
</div>

<script>
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    

    menuToggle.addEventListener('click', function() {

        mobileMenu.classList.toggle('hidden'); 
        mobileMenu.classList.toggle('-translate-x-full'); 
        mobileMenu.classList.toggle('translate-x-0');
    });
</script>
