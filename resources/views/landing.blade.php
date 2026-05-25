@extends('layouts.public')

@section('title', '- Unit Pengelola Benih Sumber')

@section('content')
    <!-- Add AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        /* Polaroids animations */
        .polaroid-1 { transform: rotate(-5deg); top: 20px; z-index: 3; }
        .polaroid-2 { transform: rotate(3deg); margin-top: -30px; z-index: 2; }
        .polaroid-3 { transform: rotate(7deg); top: 30px; z-index: 4; }
        .polaroid:hover { transform: scale(1.05) rotate(0deg) !important; z-index: 10 !important; }
    </style>

    <!-- Initial Popup Overlay -->
    <div id="welcomePopup" class="fixed inset-0 bg-black/75 backdrop-blur-sm z-[9999] flex items-center justify-center opacity-0 transition-opacity duration-400 ease-out" style="display: none;">
        <div class="bg-white rounded-2xl w-[90%] max-w-[500px] overflow-hidden relative shadow-2xl translate-y-5 transition-transform duration-400 ease-out popup-content">
            <button id="closePopupBtn" class="absolute top-4 right-4 bg-black/50 hover:bg-red-600/80 text-white border-none w-8 h-8 rounded-full flex items-center justify-center cursor-pointer z-10 transition-colors">
                <i class="bi bi-x text-xl"></i>
            </button>
            <img src="{{ asset('images/hero_bg.jpeg') }}" alt="Survey Image" class="w-full h-[250px] object-cover">
            <div class="p-8 text-center">
                <h3 class="font-extrabold text-slate-900 mb-2 text-2xl">Survei Kepuasan Layanan</h3>
                <p class="text-slate-600 mb-6 leading-relaxed">Bantu kami meningkatkan kualitas layanan dengan mengisi survei kepuasan pelanggan. Penilaian Anda sangat berarti bagi kami.</p>
                <a href="https://docs.google.com/forms/d/e/1FAIpQLScPKtQAlCjo1NYUh1YVqcx7J_sZi6XELs3lFCHb7TCQH0r6ag/viewform" target="_blank" class="inline-block bg-[#16a34a] hover:bg-[#15803d] text-white px-6 py-3 rounded-lg font-semibold transition-all shadow-md hover:-translate-y-0.5">Isi Survei Sekarang</a>
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="relative min-h-[90vh] flex items-center overflow-hidden bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/hero_bg.jpeg') }}')">
        <div class="absolute inset-0 bg-black/50 z-0"></div>
        <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20">
            <div class="text-center" data-aos="fade-up" data-aos-duration="1000">
                <h1 class="text-white font-extrabold text-4xl md:text-5xl lg:text-6xl mb-6 drop-shadow-lg">
                    Unit Pengelola Benih Sumber<br>(UPBS) BBRMP Sumatera Selatan
                </h1>
                
                <div class="flex flex-col sm:flex-row justify-center gap-4 mt-8 mb-16 relative z-20 px-4 sm:px-0">
                    <a href="{{ route('request.create') }}" class="bg-[#16a34a] hover:bg-[#15803d] text-white px-8 py-3.5 rounded-lg font-bold transition-all shadow-lg shadow-green-600/40 hover:-translate-y-1 w-full sm:w-auto">
                        Pengajuan Layanan
                    </a>
                    <a href="{{ route('stok.index') }}" class="bg-white/90 hover:bg-[#16a34a] hover:text-white text-[#16a34a] border-2 border-[#16a34a] px-8 py-3.5 rounded-lg font-bold transition-all shadow-lg hover:-translate-y-1 w-full sm:w-auto">
                        Cek Stok
                    </a>
                </div>

                <!-- Polaroids -->
                <div class="hidden md:flex justify-center mt-12 pt-10" style="perspective: 1000px;">
                    <div class="w-1/4 px-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="polaroid polaroid-1 bg-white p-4 pb-12 shadow-2xl relative inline-block transition-transform duration-300">
                            <div class="absolute -top-4 left-1/2 -translate-x-1/2 -rotate-3 w-32 h-9 bg-white/50 backdrop-blur-[5px] border border-white/30 shadow-sm"></div>
                            <img src="{{ asset('images/office.jpeg') }}" alt="Seed Storage" class="w-full max-w-[300px] h-auto block">
                        </div>
                    </div>
                    <div class="w-1/4 px-4" data-aos="fade-down" data-aos-delay="300">
                        <div class="polaroid polaroid-2 bg-white p-4 pb-12 shadow-2xl relative inline-block transition-transform duration-300">
                            <div class="absolute -top-4 left-1/2 -translate-x-1/2 -rotate-3 w-32 h-9 bg-white/50 backdrop-blur-[5px] border border-white/30 shadow-sm"></div>
                            <img src="{{ asset('images/seed_storage2.jpeg') }}" alt="Seed Preparation" class="w-full max-w-[300px] h-auto block">
                        </div>
                    </div>
                    <div class="w-1/4 px-4" data-aos="fade-up" data-aos-delay="400">
                        <div class="polaroid polaroid-3 bg-white p-4 pb-12 shadow-2xl relative inline-block transition-transform duration-300">
                            <div class="absolute -top-4 left-1/2 -translate-x-1/2 -rotate-3 w-32 h-9 bg-white/50 backdrop-blur-[5px] border border-white/30 shadow-sm"></div>
                            <img src="{{ asset('images/seed_storage.jpeg') }}" alt="Rice Field" class="w-full max-w-[300px] h-auto block">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang Kami Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 relative inline-block">
                    Tentang Kami
                    <span class="absolute bottom-[-10px] left-1/2 -translate-x-1/2 w-1/2 h-1 bg-[#16a34a] rounded-sm"></span>
                </h2>
            </div>
            
            <div class="max-w-5xl mx-auto text-center" data-aos="fade-up" data-aos-delay="100">
                <p class="text-lg text-slate-600 leading-relaxed mb-12">
                    BBRMP Sumatera Selatan melayani Pengelolaan Produk Instrumen Hasil Standardisasi yang dikelola oleh
                    Unit Pengelola Benih Sumber (UPBS) BBRMP Sumatera Selatan. Produk yang tersedia pada saat ini adalah benih
                    padi. Layanan Benih/Bibit Sumber Spesifik Lokasi yang dikelola oleh Unit Pengelola Benih Sumber
                    (UPBS) BBRMP Sumatera Selatan dapat melalui dua cara yakni melalui bantuan dan melalui pembelian.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8" data-aos="zoom-in" data-aos-delay="200">
                    <div>
                        <img src="{{ asset('images/beras_3.jpeg') }}" alt="Drying Rice 1" class="w-full h-[250px] object-cover rounded-xl shadow-md">
                    </div>
                    <div>
                        <img src="{{ asset('images/beras_4.jpeg') }}" alt="Drying Rice 2" class="w-full h-[250px] object-cover rounded-xl shadow-md">
                    </div>
                    <div>
                        <img src="{{ asset('images/seed_storage2.jpeg') }}" alt="Drying Rice 3" class="w-full h-[250px] object-cover rounded-xl shadow-md">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Persyaratan Layanan Section -->
    <section class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl p-8 md:p-12 shadow-sm border border-slate-100" data-aos="fade-up">
                <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mb-8 flex items-center">
                    <i class="bi bi-card-checklist text-[#16a34a] mr-4 text-3xl"></i> Persyaratan Layanan
                </h2>
                <ul class="space-y-4 text-lg text-slate-600 pl-2 md:pl-4">
                    <li class="flex items-start">
                        <i class="bi bi-check-circle-fill text-[#16a34a] mt-1 mr-4 shrink-0"></i>
                        <span>Mengisi identitas sesuai kartu identitas yang dimiliki dan maksud kedatangan melalui form</span>
                    </li>
                    <li class="flex items-start">
                        <i class="bi bi-check-circle-fill text-[#16a34a] mt-1 mr-4 shrink-0"></i>
                        <span>Mengisi form permohonan layanan dengan melampirkan KTP/Kartu Anggota dan lainnya yang masih berlaku</span>
                    </li>
                    <li class="flex items-start">
                        <i class="bi bi-check-circle-fill text-[#16a34a] mt-1 mr-4 shrink-0"></i>
                        <span>Mengisi Survei Kepuasan Pelanggan setelah mendapatkan layanan</span>
                    </li>
                    <li class="flex items-start">
                        <i class="bi bi-check-circle-fill text-[#16a34a] mt-1 mr-4 shrink-0"></i>
                        <div>
                            <span>Permintaan bantuan benih sumber VUB dapat diberikan dengan ketentuan sebagai berikut:</span>
                            <ol class="list-[lower-alpha] pl-6 mt-3 space-y-2 text-slate-500">
                                <li>Apabila target PNBP sudah dipenuhi,</li>
                                <li>Benih digunakan untuk kegiatan display atau sosialisasi yang dilakukan oleh dinas,</li>
                                <li>Bantuan diberikan pada kondisi tertentu, diantaranya terjadi bencana alam, kekeringan, kebanjiran atau hal-hal lain perlu untuk diberikan bantuan benih,</li>
                                <li>Pemberian bantuan benih di atas dengan tetap mempertimbangkan ketersediaan stok benih di gudang UPBS.</li>
                            </ol>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Varietas Benih Padi Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 relative inline-block">
                    Varietas Benih Padi
                    <span class="absolute bottom-[-10px] left-1/2 -translate-x-1/2 w-1/2 h-1 bg-[#16a34a] rounded-sm"></span>
                </h2>
                <p class="text-lg text-slate-500 max-w-3xl mx-auto mt-6">
                    Varietas benih padi unggul yang tersedia di UPBS Sumatera Selatan untuk mendukung peningkatan produksi
                    dan kualitas pertanian
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 text-center">
                @foreach ($varieties as $variety)
                <div data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                    <div class="bg-white border border-slate-100 rounded-2xl p-8 h-full transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_15px_30px_rgba(0,0,0,0.05)] hover:border-green-200 group">
                        <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center text-3xl font-bold text-[#16a34a] mx-auto mb-6 shadow-sm group-hover:bg-green-100 transition-colors">
                            {{ $loop->iteration }}
                        </div>
                        <h4 class="font-bold text-xl mb-3 text-slate-800">{{ $variety->name }}</h4>
                        <p class="text-sm text-slate-500">{{ $variety->description }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, duration: 800 });

        document.addEventListener('DOMContentLoaded', function() {
            const popup = document.getElementById('welcomePopup');
            const popupContent = popup.querySelector('.popup-content');
            const closeBtn = document.getElementById('closePopupBtn');

            // Show popup with a slight delay
            setTimeout(() => {
                popup.style.display = 'flex';
                // Trigger reflow
                void popup.offsetWidth;
                popup.classList.remove('opacity-0');
                popupContent.classList.remove('translate-y-5');
            }, 500);

            // Close popup function
            const closePopup = () => {
                popup.classList.add('opacity-0');
                popupContent.classList.add('translate-y-5');
                setTimeout(() => {
                    popup.style.display = 'none';
                }, 400); // match transition duration
            };

            closeBtn.addEventListener('click', closePopup);

            // Close when clicking outside
            popup.addEventListener('click', function(e) {
                if (e.target === popup) {
                    closePopup();
                }
            });
        });
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
                    <a href="https://www.facebook.com/people/BBRMP-Sumatera-Selatan/100064902301689/" class="text-slate-500 hover:text-white transition-colors"><i class="bi bi-facebook text-xl"></i></a>
                    <a href="https://x.com/BSIP_SUMSEL2109" class="text-slate-500 hover:text-white transition-colors"><i class="bi bi-twitter-x text-xl"></i></a>
                    <a href="https://www.instagram.com/brmpsumsel/" class="text-slate-500 hover:text-white transition-colors"><i class="bi bi-instagram text-xl"></i></a>
                    <a href="https://www.youtube.com/@BBRMPSumsel" class="text-slate-500 hover:text-white transition-colors"><i class="bi bi-youtube text-xl"></i></a>
                </div>
            </div>
        </div>
    </footer>
@endsection
