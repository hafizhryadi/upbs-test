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
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#f8f9fc] text-slate-800 font-sans antialiased min-h-screen flex selection:bg-emerald-200 selection:text-emerald-900">
    
    <!-- Sidebar -->
    <aside class="w-64 bg-[#0a5c36] text-white flex flex-col justify-between fixed h-full z-20 shadow-xl">
        <div>
            <!-- Logo area -->
            <div class="p-6 border-b border-white/10">
                <h1 class="text-2xl font-bold tracking-tight">UPBS BRMP</h1>
                <p class="text-xs text-white/70 mt-1 font-medium">Panel Admin</p>
            </div>
            
            <!-- Navigation -->
            <nav class="mt-6 px-4 space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-[#0f7a49] text-white font-medium shadow-sm' : 'text-emerald-100/80 hover:bg-white/5 hover:text-white' }}">
                    <i class="bi bi-house mr-3 text-lg {{ request()->routeIs('dashboard') ? 'text-emerald-300' : '' }}"></i>
                    Dashboard
                </a>
                <a href="{{ route('locations.index') }}" class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('locations.*') ? 'bg-[#0f7a49] text-white font-medium shadow-sm' : 'text-emerald-100/80 hover:bg-white/5 hover:text-white' }}">
                    <i class="bi bi-geo-alt mr-3 text-lg {{ request()->routeIs('locations.*') ? 'text-emerald-300' : '' }}"></i>
                    Locations
                </a>
                <a href="{{ route('inventories.index') }}" class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('inventories.*') ? 'bg-[#0f7a49] text-white font-medium shadow-sm' : 'text-emerald-100/80 hover:bg-white/5 hover:text-white' }}">
                    <i class="bi bi-box-seam mr-3 text-lg {{ request()->routeIs('inventories.*') ? 'text-emerald-300' : '' }}"></i>
                    Inventory
                </a>
                <a href="{{ route('varieties.index') }}" class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('varieties.*') ? 'bg-[#0f7a49] text-white font-medium shadow-sm' : 'text-emerald-100/80 hover:bg-white/5 hover:text-white' }}">
                    <i class="bi bi-tags mr-3 text-lg {{ request()->routeIs('varieties.*') ? 'text-emerald-300' : '' }}"></i>
                    Varietas
                </a>
                <a href="{{ route('transactions.index') }}" class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('transactions.*') ? 'bg-[#0f7a49] text-white font-medium shadow-sm' : 'text-emerald-100/80 hover:bg-white/5 hover:text-white' }}">
                    <i class="bi bi-credit-card mr-3 text-lg {{ request()->routeIs('transactions.*') ? 'text-emerald-300' : '' }}"></i>
                    Transaksi
                </a>
                <a href="#" class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 text-emerald-100/80 hover:bg-white/5 hover:text-white">
                    <i class="bi bi-clipboard-data mr-3 text-lg"></i>
                    Permohonan Benih
                </a>
                <a href="{{ route('report.index') }}" class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('report.*') ? 'bg-[#0f7a49] text-white font-medium shadow-sm' : 'text-emerald-100/80 hover:bg-white/5 hover:text-white' }}">
                    <i class="bi bi-file-earmark-text mr-3 text-lg {{ request()->routeIs('report.*') ? 'text-emerald-300' : '' }}"></i>
                    Laporan
                </a>
            </nav>
        </div>

        <div class="p-5">
            <div class="border-t border-white/10 pt-5 pb-3 flex items-center">
                <div class="bg-white/10 rounded-full w-10 h-10 flex items-center justify-center mr-3">
                    <i class="bi bi-people-fill text-white"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-white">Admin UPBS</p>
                    <p class="text-xs text-emerald-200/80">Administrator</p>
                </div>
            </div>
            <a href="#" class="flex items-center justify-center w-full px-4 py-2 mt-2 border border-emerald-600/50 rounded-lg text-sm transition-all hover:bg-white/10 text-emerald-50 hover:border-emerald-500">
                <i class="bi bi-box-arrow-left mr-2"></i> Keluar
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 ml-64 min-h-screen flex flex-col bg-[#f8f9fc]">
        @if(session('success'))
            <div class="m-8 mb-0 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm">
                <div class="flex items-center">
                    <div class="bg-emerald-100 rounded-full p-1.5 mr-3 flex items-center justify-center">
                        <i class="bi bi-check2 text-emerald-600 font-bold"></i>
                    </div>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.style.display='none'" class="text-emerald-500 hover:text-emerald-700 transition-colors p-1">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        @endif
        
        <div class="p-8 flex-1">
            @yield('content')
        </div>
        
    </main>

</body>
</html>
