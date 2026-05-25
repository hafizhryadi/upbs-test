@extends('layouts.public')

@section('title', 'Cek Stok Benih - Unit Pengelola Benih Sumber')

@section('content')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <div class="pt-24 pb-16 bg-white min-h-[80vh]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 relative inline-block">
                    Informasi Stok Benih
                    <span class="absolute bottom-[-10px] left-1/2 -translate-x-1/2 w-1/2 h-1 bg-[#16a34a] rounded-sm"></span>
                </h2>
                <p class="text-slate-500 text-lg md:text-xl max-w-3xl mx-auto mt-6">
                    Total ketersediaan benih padi berdasarkan varietas saat ini di Gudang UPBS Beras BBRMP SumSel.
                </p>
            </div>

            <div class="max-w-5xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200">
                                    <th class="py-4 px-6 font-semibold text-slate-700 text-sm">#</th>
                                    <th class="py-4 px-6 font-semibold text-slate-700 text-sm">Varietas</th>
                                    <th class="py-4 px-6 font-semibold text-slate-700 text-sm">Tgl Kadaluarsa</th>
                                    <th class="py-4 px-6 font-semibold text-slate-700 text-sm text-right">Total Stok (kg)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($stocks as $index => $stock)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="py-4 px-6 text-sm text-slate-600">{{ $index + 1 }}</td>
                                        <td class="py-4 px-6">
                                            <div class="font-bold text-slate-800">{{ $stock->variety->name ?? 'Unknown' }}</div>
                                        </td>
                                        <td class="py-4 px-6 text-sm text-slate-600">
                                            {{ \Carbon\Carbon::parse($stock->expiry_date)->format('d M Y') }}
                                            @php
                                                $statusData = \App\Models\Inventory::getStatusData($stock->expiry_date);
                                            @endphp
                                            @if ($statusData['status'] != 'safe')
                                                @php
                                                    $badgeColors = [
                                                        'danger' => 'bg-red-100 text-red-700',
                                                        'warning' => 'bg-amber-100 text-amber-700',
                                                        'success' => 'bg-emerald-100 text-emerald-700',
                                                    ];
                                                    $colorClass = $badgeColors[$statusData['badge']] ?? 'bg-slate-100 text-slate-700';
                                                @endphp
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $colorClass }} ml-2">
                                                    {{ $statusData['label'] }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-right">
                                            <span class="text-emerald-600 font-bold text-lg">{{ number_format($stock->total_quantity) }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-12 text-slate-500">
                                            Belum ada data stok benih.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="text-center mt-12" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 border border-slate-300 shadow-sm text-base font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        <i class="bi bi-arrow-left mr-2"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, duration: 800 });
    </script>
@endsection

@section('footer')
    <footer class="bg-slate-900 text-white pt-16 pb-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-12">
                <div class="lg:col-span-5" data-aos="fade-up">
                    <h5 class="text-[#16a34a] font-bold text-xl mb-4 flex items-center">
                        <i class="bi bi-flower1 mr-2"></i> UPBS BBRMP SumSel
                    </h5>
                    <p class="text-slate-400 text-sm leading-relaxed pr-4">
                        Unit Pengelola Benih Sumber (UPBS) di bawah naungan Balai Penerapan Modernisasi Pertanian (BBRMP) Sumatera Selatan. Berkomitmen dalam menyediakan layanan benih padi varietas unggul demi meningkatkan produktivitas pertanian nasional.
                    </p>
                </div>
                <div class="lg:col-span-3 md:col-span-1" data-aos="fade-up" data-aos-delay="100">
                    <h5 class="text-white font-semibold text-lg mb-6">Tautan Cepat</h5>
                    <ul class="space-y-4 text-sm">
                        <li><a href="{{ route('home') }}" class="text-slate-400 hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="{{ route('dashboard') }}" class="text-slate-400 hover:text-white transition-colors">Dashboard</a></li>
                        <li><a href="{{ route('stok.index') }}" class="text-slate-400 hover:text-white transition-colors">Stok Benih</a></li>
                        <li><a href="{{ route('transactions.create') }}" class="text-slate-400 hover:text-white transition-colors">Pengajuan Layanan</a></li>
                    </ul>
                </div>
                <div class="lg:col-span-4 md:col-span-1" data-aos="fade-up" data-aos-delay="200">
                    <h5 class="text-white font-semibold text-lg mb-6">Hubungi Kami</h5>
                    <ul class="space-y-4 text-sm text-slate-400">
                        <li class="flex items-start">
                            <i class="bi bi-geo-alt-fill text-[#16a34a] mr-3 mt-1 text-lg"></i>
                            <span>Jl. Kol. H. Barlian No.KM. 6, Srijaya, Kec. Alang-Alang Lebar, Kota Palembang, Sumatera Selatan 30153</span>
                        </li>
                        <li class="flex items-center">
                            <i class="bi bi-telephone-fill text-[#16a34a] mr-3 text-lg"></i>
                            <span>(0711) 411317</span>
                        </li>
                        <li class="flex items-center">
                            <i class="bi bi-envelope-fill text-[#16a34a] mr-3 text-lg"></i>
                            <span>BBRMP.sumsel@pertanian.go.id</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-slate-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center" data-aos="fade-up" data-aos-delay="300">
                <div class="text-slate-500 text-sm text-center md:text-left mb-4 md:mb-0">
                    &copy; {{ date('Y') }} Sistem Informasi Manajemen Benih Padi<br class="md:hidden"> UPBS BBRMP SumSel. All Rights Reserved.
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-slate-500 hover:text-white transition-colors"><i class="bi bi-facebook text-xl"></i></a>
                    <a href="#" class="text-slate-500 hover:text-white transition-colors"><i class="bi bi-twitter text-xl"></i></a>
                    <a href="#" class="text-slate-500 hover:text-white transition-colors"><i class="bi bi-instagram text-xl"></i></a>
                    <a href="#" class="text-slate-500 hover:text-white transition-colors"><i class="bi bi-youtube text-xl"></i></a>
                </div>
            </div>
        </div>
    </footer>
@endsection
