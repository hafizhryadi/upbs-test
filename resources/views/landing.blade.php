@extends('layouts.public')

@section('title', '- Unit Pengelola Benih Sumber')

@section('content')
    <!-- Add Google Fonts and AOS -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        .text-green {
            color: #16a34a;
        }

        .bg-green {
            background-color: #16a34a;
        }

        /* Hero section */
        .hero {
            position: relative;
            min-height: 90vh;
            background: url('{{ asset('images/hero_bg.jpeg') }}') center/cover no-repeat;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            /* semi-transparent black for readablity */
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            padding-top: 100px;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            color: #fff;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        }

        /* Buttons */
        .btn-green {
            background: #16a34a;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(22, 163, 74, 0.4);
        }

        .btn-green:hover {
            background: #15803d;
            color: white;
            transform: translateY(-2px);
        }

        .btn-outline-green {
            background: transparent;
            color: #16a34a;
            border: 2px solid #16a34a;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
            background: rgba(255, 255, 255, 0.9);
        }

        .btn-outline-green:hover {
            background: #16a34a;
            color: white;
            transform: translateY(-2px);
        }

        /* Polaroids */
        .polaroid {
            background: #fff;
            padding: 15px 15px 50px 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            position: relative;
            border-radius: 2px;
            display: inline-block;
            transition: transform 0.3s;
        }

        .polaroid:hover {
            transform: scale(1.05) rotate(0deg) !important;
            z-index: 10 !important;
        }

        .polaroid img {
            width: 100%;
            max-width: 300px;
            height: auto;
            display: block;
        }

        .tape {
            width: 120px;
            height: 35px;
            background: rgba(255, 255, 255, 0.5);
            position: absolute;
            top: -15px;
            left: 50%;
            backdrop-filter: blur(5px);
            transform: translateX(-50%) rotate(-3deg);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .polaroid-1 {
            transform: rotate(-5deg);
            top: 20px;
            z-index: 3;
        }

        .polaroid-2 {
            transform: rotate(3deg);
            margin-top: -30px;
            z-index: 2;
        }

        .polaroid-3 {
            transform: rotate(7deg);
            top: 30px;
            z-index: 4;
        }

        /* Sections */
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

        .about-text {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #4b5563;
        }

        /* Process cards */
        .step-circle {
            width: 80px;
            height: 80px;
            background: #dcfce7;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: bold;
            color: #16a34a;
            margin: 0 auto 1.5rem auto;
            box-shadow: 0 4px 10px rgba(22, 163, 74, 0.2);
        }

        .variety-card {
            padding: 30px 20px;
            border-radius: 12px;
            transition: all 0.3s;
            border: 1px solid #f3f4f6;
            background: #fff;
        }

        .variety-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.05);
            border-color: #dcfce7;
        }

        .requirements-list li {
            margin-bottom: 12px;
            font-size: 1.1rem;
            color: #4b5563;
            position: relative;
            padding-left: 30px;
        }

        .requirements-list li::before {
            content: '\F633';
            /* Bootstrap check-circle */
            font-family: 'bootstrap-icons';
            position: absolute;
            left: 0;
            top: 2px;
            color: #16a34a;
        }

        .hover-white {
            transition: color 0.3s;
        }

        .hover-white:hover {
            color: #ffffff !important;
        }

        /* Popup Modal */
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(5px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .popup-overlay.show {
            opacity: 1;
        }

        .popup-content {
            background: #fff;
            border-radius: 16px;
            width: 90%;
            max-width: 500px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            transform: translateY(20px);
            transition: transform 0.4s ease;
        }

        .popup-overlay.show .popup-content {
            transform: translateY(0);
        }

        .popup-close {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transition: background 0.3s;
        }

        .popup-close:hover {
            background: rgba(220, 38, 38, 0.8);
        }

        .popup-img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .popup-body {
            padding: 30px;
            text-align: center;
        }

        .popup-title {
            font-weight: 800;
            color: #111827;
            margin-bottom: 10px;
            font-size: 1.5rem;
        }

        .popup-text {
            color: #4b5563;
            margin-bottom: 20px;
            line-height: 1.6;
        }
    </style>

    <!-- Initial Popup Overlay -->
    <div id="welcomePopup" class="popup-overlay" style="display: none;">
        <div class="popup-content">
            <button class="popup-close" id="closePopupBtn">&times;</button>
            <img src="{{ asset('images/hero_bg.jpeg') }}" alt="Survey Image" class="popup-img">
            <div class="popup-body">
                <h3 class="popup-title">Survei Kepuasan Layanan</h3>
                <p class="popup-text">Bantu kami meningkatkan kualitas layanan dengan mengisi survei kepuasan pelanggan.
                    Penilaian Anda sangat berarti bagi kami.</p>
                <a href="https://docs.google.com/forms/d/e/1FAIpQLScPKtQAlCjo1NYUh1YVqcx7J_sZi6XELs3lFCHb7TCQH0r6ag/viewform"
                    class="btn-green d-inline-block mt-2 text-decoration-none" target="_blank">Isi Survei Sekarang</a>
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <div class="row align-items-center">
                <div class="col-lg-12 text-center" data-aos="fade-up" data-aos-duration="1000">
                    <h1 class="hero-title mb-4">Unit Pengelola Benih Sumber<br>(UPBS) BBRMP SumSel</h1>
                    <div class="d-flex justify-content-center gap-3 mt-4 mb-5 position-relative" style="z-index: 20;">
                        <a href="{{ route('request.create') }}" class="btn-green text-decoration-none">Pengajuan Layanan</a>
                        <a href="{{ route('stok.index') }}" class="btn-outline-green text-decoration-none">Cek Stok</a>
                    </div>

                    <!-- Polaroids -->
                    <div class="row justify-content-center mt-5 pt-4" style="perspective: 1000px;">
                        <div class="col-md-3 d-none d-md-block" data-aos="fade-up" data-aos-delay="200">
                            <div class="polaroid polaroid-1">
                                <div class="tape"></div>
                                <img src="{{ asset('images/office.jpeg') }}" alt="Seed Storage">
                            </div>
                        </div>
                        <div class="col-md-3 d-none d-md-block" data-aos="fade-down" data-aos-delay="300">
                            <div class="polaroid polaroid-2">
                                <div class="tape"></div>
                                <img src="{{ asset('images/seed_storage2.jpeg') }}" alt="Seed Preparation">
                            </div>
                        </div>
                        <div class="col-md-3 d-none d-md-block" data-aos="fade-up" data-aos-delay="400">
                            <div class="polaroid polaroid-3">
                                <div class="tape"></div>
                                <img src="{{ asset('images/seed_storage.jpeg') }}" alt="Rice Field">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang Kami Section -->
    <section class="py-5 bg-white">
        <div class="container py-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Tentang Kami</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center" data-aos="fade-up" data-aos-delay="100">
                    <p class="about-text mb-5">
                        BBRMP Sumatera Selatan melayani Pengelolaan Produk Instrumen Hasil Standardisasi yang dikelola oleh
                        Unit Pengelola Benih Sumber (UPBS) BBRMP Sumsel. Produk yang tersedia pada saat ini adalah benih
                        padi. Layanan Benih/Bibit Sumber Spesifik Lokasi yang dikelola oleh Unit Pengelola Benih Sumber
                        (UPBS) BBRMP Sumsel dapat melalui dua cara yakni melalui bantuan dan melalui pembelian.
                    </p>

                    <div class="row g-2 mt-4" data-aos="zoom-in" data-aos-delay="200">
                        <div class="col-4">
                            <img src="{{ asset('images/beras_3.jpeg') }}" alt="Drying Rice 1"
                                class="img-fluid rounded shadow-sm" style="height: 250px; object-fit: cover; width: 100%;">
                        </div>
                        <div class="col-4">
                            <img src="{{ asset('images/beras_4.jpeg') }}" alt="Drying Rice 2"
                                class="img-fluid rounded shadow-sm" style="height: 250px; object-fit: cover; width: 100%;">
                        </div>
                        <div class="col-4">
                            <img src="{{ asset('images/seed_storage2.jpeg') }}" alt="Drying Rice 3"
                                class="img-fluid rounded shadow-sm" style="height: 250px; object-fit: cover; width: 100%;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Persyaratan Layanan Section -->
    <section class="py-5 bg-white">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-12" data-aos="fade-up">
                    <h2 class="fw-bold fs-2 mb-4" style="color: #111827;">Persyaratan Layanan</h2>
                    <ul class="list-unstyled requirements-list ps-3">
                        <li>Mengisi identitas sesuai kartu identitas yang dimiliki dan maksud kedatangan melalui form</li>
                        <li>Mengisi form permohonan layanan dengan melampirkan KTP/Kartu Anggota dan lainnya yang masih
                            berlaku</li>
                        <li>Mengisi Survei Kepuasan Pelanggan setelah mendapatkan layanan</li>
                        <li>Permintaan bantuan benih sumber VUB dapat diberikan dengan ketentuan sebagai berikut:
                            <ol class="mt-2 text-muted" type="a">
                                <li>Apabila target PNBP sudah dipenuhi,</li>
                                <li>Benih digunakan untuk kegiatan display atau sosialisasi yang dilakukan oleh dinas,</li>
                                <li>Bantuan diberikan pada kondisi tertentu, diantaranya terjadi bencana alam, kekeringan,
                                    kebanjiran atau hal-hal lain perlu untuk diberikan bantuan benih,</li>
                                <li>Pemberian bantuan benih di atas dengan tetap mempertimbangkan ketersediaan stok benih di
                                    gudang UPBS.</li>
                            </ol>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Varietas Benih Padi Section -->
    <section class="py-5" style="background-color: #f8fafc;">
        <div class="container py-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Varietas Benih Padi</h2>
                <p class="lead text-muted mx-auto" style="max-width: 800px;">
                    Varietas benih padi unggul yang tersedia di UPBS Sumatera Selatan untuk mendukung peningkatan produksi
                    dan kualitas pertanian
                </p>
            </div>

            <div class="row g-4 text-center">
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="variety-card h-100">
                        <div class="step-circle">1</div>
                        <h4 class="fw-bold mb-3 fs-5">Inpari 32 HDB</h4>
                        <p class="text-muted small">Varietas padi unggul sawah irigasi yang memiliki produktivitas tinggi
                            dan tahan terhadap penyakit Hawar Daun Bakteri (HDB) serta beberapa biotipe wereng batang
                            coklat.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="variety-card h-100">
                        <div class="step-circle">2</div>
                        <h4 class="fw-bold mb-3 fs-5">Inpari 42 Agritan GSR</h4>
                        <p class="text-muted small">Varietas padi berdaya hasil tinggi dengan konsep Green Super Rice
                            (GSR), hemat input, ramah lingkungan, dan adaptif pada berbagai kondisi lahan.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="variety-card h-100">
                        <div class="step-circle">3</div>
                        <h4 class="fw-bold mb-3 fs-5">Inpari 50 Marem</h4>
                        <p class="text-muted small">Varietas padi unggul dengan potensi hasil tinggi, tahan terhadap wereng
                            batang coklat, HDB, dan blas, serta memiliki karakter nasi pera.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="variety-card h-100">
                        <div class="step-circle">4</div>
                        <h4 class="fw-bold mb-3 fs-5">Padjajaran Agritan</h4>
                        <p class="text-muted small">Varietas padi unggul yang adaptif di lahan sawah irigasi dengan hasil
                            produksi yang baik dan kualitas beras yang cukup disukai.</p>
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

        document.addEventListener('DOMContentLoaded', function() {
            const popup = document.getElementById('welcomePopup');
            const closeBtn = document.getElementById('closePopupBtn');

            // Show popup with a slight delay
            setTimeout(() => {
                popup.style.display = 'flex';
                // Trigger reflow
                void popup.offsetWidth;
                popup.classList.add('show');
            }, 500);

            // Close popup function
            const closePopup = () => {
                popup.classList.remove('show');
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
    <footer class="bg-dark text-white py-5 mt-auto" style="background-color: #111827 !important;">
        <div class="container py-4">
            <div class="row g-4">
                <div class="col-lg-5 mb-4 mb-lg-0" data-aos="fade-up">
                    <h5 class="text-green fw-bold mb-3 fs-4"><i class="bi bi-flower1"></i> UPBS Beras BBRMP SumSel</h5>
                    <p class="text-secondary small pe-lg-4" style="line-height: 1.8;">
                        Unit Pengelola Benih Sumber (UPBS) di bawah naungan Balai Penerapan Modernisasi Pertanian (BBRMP)
                        Sumatera Selatan. Berkomitmen dalam menyediakan layanan benih padi varietas unggul demi meningkatkan
                        produktivitas pertanian nasional.
                    </p>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="100">
                    <h5 class="text-white mb-4 fw-semibold fs-6">Tautan Cepat</h5>
                    <ul class="list-unstyled text-secondary small">
                        <li class="mb-3"><a href="{{ route('home') }}"
                                class="text-secondary text-decoration-none hover-white transition">Beranda</a></li>
                        <li class="mb-3"><a href="{{ route('dashboard') }}"
                                class="text-secondary text-decoration-none hover-white transition">Dashboard</a></li>
                        <li class="mb-3"><a href="{{ route('stok.index') }}"
                                class="text-secondary text-decoration-none hover-white transition">Stok Benih</a></li>
                        <li class="mb-3"><a href="{{ route('transactions.create') }}"
                                class="text-secondary text-decoration-none hover-white transition">Pengajuan Layanan</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <h5 class="text-white mb-4 fw-semibold fs-6">Hubungi Kami</h5>
                    <ul class="list-unstyled text-secondary small">
                        <li class="mb-3 d-flex">
                            <i class="bi bi-geo-alt-fill text-green me-3 fs-5"></i>
                            <span>Jl. Kol. H. Barlian No.KM. 6, Srijaya, Kec. Alang-Alang Lebar, Kota Palembang, Sumatera
                                Selatan 30153</span>
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
                    &copy; {{ date('Y') }} Sistem Informasi Manajemen Benih Padi
                </div>
                <div
                    class="col-md-6 text-center text-md-end mt-3 mt-md-0 d-flex justify-content-center justify-content-md-end gap-3">
                    <a href="#" class="text-secondary transition hover-white"><i
                            class="bi bi-facebook fs-4"></i></a>
                    <a href="#" class="text-secondary transition hover-white"><i
                            class="bi bi-twitter fs-4"></i></a>
                    <a href="#" class="text-secondary transition hover-white"><i
                            class="bi bi-instagram fs-4"></i></a>
                    <a href="#" class="text-secondary transition hover-white"><i
                            class="bi bi-youtube fs-4"></i></a>
                </div>
            </div>
        </div>
    </footer>
@endsection
