<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Benih Padi @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body
    class="bg-[#f8f9fc] text-slate-800 font-sans antialiased min-h-screen flex flex-col md:flex-row selection:bg-emerald-200 selection:text-emerald-900">

    <!-- Sidebar -->
    <aside class="w-full md:w-64 bg-[#0a5c36] text-white flex flex-col justify-between md:fixed h-auto md:h-full z-20 shadow-xl relative">
        <div>
            <!-- Logo area -->
            <div class="p-4 md:p-6 border-b border-white/10 flex justify-between items-center md:block">
                <div>
                    <a class="text-xl md:text-2xl font-bold tracking-tight" href="{{ route('home') }}">UPBS BBRMP</a>
                    <p class="text-xs text-white/70 mt-1 font-medium hidden md:block">Panel Admin</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="md:hidden">
                    @csrf
                    <button type="submit" class="flex items-center text-sm font-medium text-white/90 hover:text-white bg-white/10 hover:bg-red-500/80 px-3 py-1.5 rounded-md transition-all">
                        <i class="bi bi-box-arrow-right mr-1.5"></i> Keluar
                    </button>
                </form>
            </div>

            <!-- Navigation -->
            <nav class="mt-4 md:mt-6 px-4 space-y-0 md:space-y-1 flex flex-row md:flex-col overflow-x-auto gap-2 md:gap-0 pb-2 md:pb-0">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 whitespace-nowrap {{ request()->routeIs('dashboard') ? 'bg-[#0f7a49] text-white font-medium shadow-sm' : 'text-emerald-100/80 hover:bg-white/5 hover:text-white' }}">
                    <i class="bi bi-house mr-3 text-lg {{ request()->routeIs('dashboard') ? 'text-emerald-300' : '' }}"></i>
                    Beranda
                </a>
                
                @if(auth()->user()->role === 'staff')

                <a href="{{ route('locations.index') }}"
                    class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 whitespace-nowrap {{ request()->routeIs('locations.*') ? 'bg-[#0f7a49] text-white font-medium shadow-sm' : 'text-emerald-100/80 hover:bg-white/5 hover:text-white' }}">
                    <i class="bi bi-geo-alt mr-3 text-lg {{ request()->routeIs('locations.*') ? 'text-emerald-300' : '' }}"></i>
                    Lokasi Gudang
                </a>
                <a href="{{ route('varieties.index') }}"
                    class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 whitespace-nowrap {{ request()->routeIs('varieties.*') ? 'bg-[#0f7a49] text-white font-medium shadow-sm' : 'text-emerald-100/80 hover:bg-white/5 hover:text-white' }}">
                    <i class="bi bi-tags mr-3 text-lg {{ request()->routeIs('varieties.*') ? 'text-emerald-300' : '' }}"></i>
                    Varietas
                </a>
                <a href="{{ route('inventories.index') }}"
                    class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 whitespace-nowrap {{ request()->routeIs('inventories.*') ? 'bg-[#0f7a49] text-white font-medium shadow-sm' : 'text-emerald-100/80 hover:bg-white/5 hover:text-white' }}">
                    <i class="bi bi-box-seam mr-3 text-lg {{ request()->routeIs('inventories.*') ? 'text-emerald-300' : '' }}"></i>
                    Ketersediaan
                </a>
                <a href="{{ route('transactions.index') }}"
                    class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 whitespace-nowrap {{ request()->routeIs('transactions.*') ? 'bg-[#0f7a49] text-white font-medium shadow-sm' : 'text-emerald-100/80 hover:bg-white/5 hover:text-white' }}">
                    <i class="bi bi-credit-card mr-3 text-lg {{ request()->routeIs('transactions.*') ? 'text-emerald-300' : '' }}"></i>
                    Input Stok
                </a>
                @endif

                <a href="{{ route('request.index') }}"
                    class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 whitespace-nowrap {{ request()->routeIs('request.*') ? 'bg-[#0f7a49] text-white font-medium shadow-sm' : 'text-emerald-100/80 hover:bg-white/5 hover:text-white' }}">
                    <i class="bi bi-clipboard-data mr-3 text-lg {{ request()->routeIs('request.*') ? 'text-emerald-300' : '' }}"></i>
                    Permohonan Benih
                </a>
                @if(auth()->user()->role === 'staff')
                <a href="{{ route('report.index') }}"
                    class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 whitespace-nowrap {{ request()->routeIs('report.index', 'report.show') ? 'bg-[#0f7a49] text-white font-medium shadow-sm' : 'text-emerald-100/80 hover:bg-white/5 hover:text-white' }}">
                    <i class="bi bi-file-earmark-text mr-3 text-lg {{ request()->routeIs('report.index', 'report.show') ? 'text-emerald-300' : '' }}"></i>
                    Laporan Transaksi
                </a>
                <a href="{{ route('report.requests') }}"
                    class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 whitespace-nowrap {{ request()->routeIs('report.requests') ? 'bg-[#0f7a49] text-white font-medium shadow-sm' : 'text-emerald-100/80 hover:bg-white/5 hover:text-white' }}">
                    <i class="bi bi-file-earmark-bar-graph mr-3 text-lg {{ request()->routeIs('report.requests') ? 'text-emerald-300' : '' }}"></i>
                    Laporan Permohonan
                </a>
                @endif
            </nav>
        </div>

        <div class="p-4 md:p-5 hidden md:block">
            <div class="border-t border-white/10 pt-5 pb-3 flex items-center">
                <div class="bg-white/10 rounded-full w-10 h-10 flex items-center justify-center mr-3">
                    <i class="bi bi-people-fill text-white"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-white">{{ auth()->user()->name ?? 'Admin UPBS' }}</p>
                    <p class="text-xs text-emerald-200/80">{{ auth()->check() ? ucfirst(auth()->user()->role) : 'Guest' }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="w-full mt-2">
                @csrf
                <button type="submit" class="flex items-center justify-center w-full px-4 py-2 border border-emerald-600/50 rounded-lg text-sm transition-all hover:bg-white/10 text-emerald-50 hover:border-emerald-500">
                    <i class="bi bi-box-arrow-left mr-2"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 md:ml-64 min-h-screen flex flex-col bg-[#f8f9fc]">
        @if (session('success'))
            <div
                class="m-8 mb-0 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm">
                <div class="flex items-center">
                    <div class="bg-emerald-100 rounded-full p-1.5 mr-3 flex items-center justify-center">
                        <i class="bi bi-check2 text-emerald-600 font-bold"></i>
                    </div>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.style.display='none'"
                    class="text-emerald-500 hover:text-emerald-700 transition-colors p-1">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div
                class="m-8 mb-0 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 flex items-center justify-between shadow-sm">
                <div class="flex items-center">
                    <div class="bg-red-100 rounded-full p-1.5 mr-3 flex items-center justify-center">
                        <i class="bi bi-exclamation-triangle text-red-600 font-bold"></i>
                    </div>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.style.display='none'"
                    class="text-red-500 hover:text-red-700 transition-colors p-1">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        @endif

        <div class="p-4 md:p-8 flex-1">
            @yield('content')
        </div>

    </main>

</body>

</html>
