<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Benih Padi @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-800">
    <!-- Navbar -->
    <nav class="bg-[#16a34a] text-white sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/kementan.png') }}" alt="UPBS" class="h-12 w-auto">
                    <span class="font-bold text-xl tracking-tight hidden sm:block">UPBS BBRMP SumSel</span>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'font-bold' : 'text-green-100 hover:text-white transition' }}">Beranda</a>
                    <a href="{{ route('stok.index') }}" class="{{ request()->routeIs('stok.index') ? 'font-bold' : 'text-green-100 hover:text-white transition' }}">Cek Stok</a>
                    <a href="{{ route('login') }}" class="font-bold flex items-center gap-2 border border-green-400 hover:bg-green-600 rounded-lg px-4 py-2 transition">
                        <i class="bi bi-box-arrow-in-right"></i> Masuk Admin
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" class="text-white hover:text-green-200 focus:outline-none">
                        <i class="bi bi-list text-3xl"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-[#15803d]">
            <div class="px-4 pt-2 pb-4 space-y-1 shadow-inner">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md {{ request()->routeIs('home') ? 'bg-green-700 font-bold' : 'hover:bg-green-600' }}">Beranda</a>
                <a href="{{ route('stok.index') }}" class="block px-3 py-2 rounded-md {{ request()->routeIs('stok.index') ? 'bg-green-700 font-bold' : 'hover:bg-green-600' }}">Cek Stok</a>
                <a href="{{ route('login') }}" class="block px-3 py-2 mt-4 rounded-md font-bold flex items-center gap-2 bg-green-700">
                    <i class="bi bi-box-arrow-in-right"></i> Masuk Admin
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-[calc(100vh-80px)] flex flex-col">
        @yield('content')
    </main>

    <!-- Footer Area -->
    @yield('footer')

    <script>
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            var menu = document.getElementById('mobile-menu');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
            } else {
                menu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
