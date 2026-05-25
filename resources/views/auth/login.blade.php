@extends('layouts.public')

@section('title', '- Masuk Admin')

@section('content')
    <div class="min-h-[calc(100vh-80px)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-slate-50">
        <div class="max-w-4xl w-full bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col md:flex-row">
            
            <!-- Left Side: Image/Banner -->
            <div class="hidden md:block w-1/2 relative bg-cover bg-center" style="background-image: url('{{ asset('images/hero_bg.jpeg') }}');">
                <!-- Fallback background color if image is missing -->
                <div class="absolute inset-0 bg-green-700/80"></div>
                <div class="relative z-10 h-full flex flex-col justify-center p-10 text-white">
                    <h2 class="text-3xl font-extrabold mb-4 leading-tight">Sistem Manajemen Benih Padi</h2>
                    <p class="text-green-50 text-lg">Unit Pengelola Benih Sumber (UPBS) Balai Besar Penerapan Modernisasi Pertanian Sumatera Selatan.</p>
                </div>
            </div>

            <!-- Right Side: Login Form -->
            <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
                <div class="text-center mb-8">
                    <img src="{{ asset('images/kementan.png') }}" alt="UPBS" class="w-20 mx-auto mb-4">
                    <h3 class="text-2xl font-bold text-slate-800">Masuk Admin</h3>
                    <p class="text-slate-500 mt-2 text-sm">Silakan masukkan kredensial Anda untuk melanjutkan</p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg mb-6">
                        <ul class="list-disc list-inside ml-1 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="email" class="block font-semibold text-slate-700 mb-2 text-sm">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@brmp.sumsel" class="w-full pl-10 pr-4 py-3 rounded-lg border border-slate-200 bg-slate-50 focus:bg-white focus:border-green-600 focus:ring-2 focus:ring-green-200 transition-all outline-none">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block font-semibold text-slate-700 mb-2 text-sm">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <i class="bi bi-lock"></i>
                            </div>
                            <input type="password" id="password" name="password" required placeholder="••••••••" class="w-full pl-10 pr-4 py-3 rounded-lg border border-slate-200 bg-slate-50 focus:bg-white focus:border-green-600 focus:ring-2 focus:ring-green-200 transition-all outline-none">
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded cursor-pointer">
                        <label for="remember" class="ml-2 block text-sm text-slate-600 cursor-pointer">Ingat Saya</label>
                    </div>

                    <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-base font-bold text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                        Masuk ke Dashboard <i class="bi bi-arrow-right ml-2"></i>
                    </button>
                </form>

                <div class="mt-8 text-center">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-slate-500 hover:text-green-600 transition-colors flex items-center justify-center">
                        <i class="bi bi-arrow-left mr-2"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
