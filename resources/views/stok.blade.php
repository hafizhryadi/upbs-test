@extends('layouts.public')

@section('title', 'Cek Stok Benih - Unit Pengelola Benih Sumber')

@section('content')
<!-- Add Google Fonts and AOS -->
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    body {
        font-family: 'Outfit', sans-serif;
    }
    .text-green { color: #16a34a; }
    .bg-green { background-color: #16a34a; }
    
    .section-title {
        font-weight: 800;
        font-size: 2.5rem;
        margin-bottom: 2rem;
        color: #111827;
        position: relative;
        display: inline-block;
    }
    .section-title::after {
        content: '';
        position: absolute;
        width: 50%;
        height: 4px;
        background: #16a34a;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        border-radius: 2px;
    }
    .hover-white { transition: color 0.3s; }
    .hover-white:hover { color: #ffffff !important; }
</style>

<!-- Cek Stok Section -->
<section id="cek-stok" class="py-5 bg-white" style="min-height: 80vh; padding-top: 100px !important;">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">Informasi Stok Benih</h2>
            <p class="lead text-muted mx-auto" style="max-width: 800px;">
                Total ketersediaan benih padi berdasarkan varietas saat ini di Gudang UPBS BBRMP Sumsel.
            </p>
        </div>

        <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="100">
            <div class="col-lg-10">
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-4 px-4 border-0">#</th>
                                    <th class="py-4 px-4 border-0">Varietas</th>
                                    <th class="py-4 px-4 border-0">Tgl Kadaluarsa</th>
                                    <th class="py-4 px-4 text-end border-0">Total Stok (kg)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stocks as $index => $stock)
                                <tr>
                                    <td class="py-3 px-4">{{ $index + 1 }}</td>
                                    <td class="py-3 px-4">
                                        <div class="fw-bold text-dark">{{ $stock->variety->name ?? 'Unknown' }}</div>
                                    </td>
                                    <td class="py-3 px-4">
                                        {{ \Carbon\Carbon::parse($stock->expiry_date)->format('d M Y') }}
                                        @php
                                            $statusData = \App\Models\Inventory::getStatusData($stock->expiry_date);
                                        @endphp
                                        @if($statusData['status'] != 'safe')
                                            <span class="badge bg-{{ $statusData['badge'] }} {{ $statusData['badge'] == 'warning' ? 'text-dark' : '' }} ms-2">
                                                {{ $statusData['label'] }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-end text-success fw-bold fs-5">
                                        {{ number_format($stock->total_quantity) }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">Belum ada data stok benih.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary px-4 py-2" style="border-radius: 8px;">
                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Scripts -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        once: true,
        duration: 800
    });
</script>
@endsection

@section('footer')
<footer class="bg-dark text-white py-5 mt-auto" style="background-color: #111827 !important;">
    <div class="container py-4">
        <div class="row g-4">
            <div class="col-lg-5 mb-4 mb-lg-0" data-aos="fade-up">
                <h5 class="text-green fw-bold mb-3 fs-4"><i class="bi bi-flower1"></i> UPBS BBRMP SumSel</h5>
                <p class="text-secondary small pe-lg-4" style="line-height: 1.8;">
                    Unit Pengelola Benih Sumber (UPBS) di bawah naungan Balai Penerapan Modernisasi Pertanian (BBRMP) Sumatera Selatan. Berkomitmen dalam menyediakan layanan benih padi varietas unggul demi meningkatkan produktivitas pertanian nasional.
                </p>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="100">
                <h5 class="text-white mb-4 fw-semibold fs-6">Tautan Cepat</h5>
                <ul class="list-unstyled text-secondary small">
                    <li class="mb-3"><a href="{{ route('home') }}" class="text-secondary text-decoration-none hover-white transition">Beranda</a></li>
                    <li class="mb-3"><a href="{{ route('dashboard') }}" class="text-secondary text-decoration-none hover-white transition">Dashboard</a></li>
                    <li class="mb-3"><a href="{{ route('stok.index') }}" class="text-secondary text-decoration-none hover-white transition">Stok Benih</a></li>
                    <li class="mb-3"><a href="{{ route('transactions.create') }}" class="text-secondary text-decoration-none hover-white transition">Pengajuan Layanan</a></li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <h5 class="text-white mb-4 fw-semibold fs-6">Hubungi Kami</h5>
                <ul class="list-unstyled text-secondary small">
                    <li class="mb-3 d-flex">
                        <i class="bi bi-geo-alt-fill text-green me-3 fs-5"></i> 
                        <span>Jl. Kol. H. Barlian No.KM. 6, Srijaya, Kec. Alang-Alang Lebar, Kota Palembang, Sumatera Selatan 30153</span>
                    </li>
                    <li class="mb-3 d-flex">
                        <i class="bi bi-telephone-fill text-green me-3 fs-5"></i> 
                        <span>(0711) 411317</span>
                    </li>
                    <li class="mb-3 d-flex">
                        <i class="bi bi-envelope-fill text-green me-3 fs-5"></i> 
                        <span>BBRMP.sumsel@pertanian.go.id</span>
                    </li>
                </ul>
            </div>
        </div>
        <hr class="border-secondary my-4" style="opacity: 0.2;">
        <div class="row align-items-center" data-aos="fade-up" data-aos-delay="300">
            <div class="col-md-6 text-center text-md-start text-secondary small">
                 &copy; {{ date('Y') }} Sistem Informasi Manajemen Benih Padi<br>UPBS BBRMP SumSel. All Rights Reserved.
            </div>
            <div class="col-md-6 text-center text-md-end mt-3 mt-md-0 d-flex justify-content-center justify-content-md-end gap-3">
                <a href="#" class="text-secondary transition hover-white"><i class="bi bi-facebook fs-4"></i></a>
                <a href="#" class="text-secondary transition hover-white"><i class="bi bi-twitter fs-4"></i></a>
                <a href="#" class="text-secondary transition hover-white"><i class="bi bi-instagram fs-4"></i></a>
                <a href="#" class="text-secondary transition hover-white"><i class="bi bi-youtube fs-4"></i></a>
            </div>
        </div>
    </div>
</footer>
@endsection
