@extends('layouts.public')

@section('title', '- Permohonan Berhasil')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    body { font-family: 'Outfit', sans-serif; }
    .text-green { color: #16a34a; }
    .bg-green { background-color: #16a34a; }
    .btn-green {
        background: #16a34a; color: white; border: none; padding: 12px 30px;
        border-radius: 8px; font-weight: 600; transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(22, 163, 74, 0.4);
    }
    .btn-green:hover { background: #15803d; color: white; transform: translateY(-2px); }
</style>

<div class="container py-5 mt-5" style="min-height: 70vh; display: flex; align-items: center; justify-content: center;">
    <div class="row w-100 justify-content-center">
        <div class="col-md-6 text-center">
            <div data-aos="zoom-in">
                <i class="bi bi-check-circle-fill text-green mb-4" style="font-size: 5rem;"></i>
            </div>
            <h2 class="fw-bold mb-3 text-dark" data-aos="fade-up" data-aos-delay="100">Permohonan Berhasil Dikirim!</h2>
            <p class="text-muted mb-4 fs-5" data-aos="fade-up" data-aos-delay="200">
                Terima kasih atas permohonan layanan benih Anda. Tim kami di UPBS BBRMP SumSel akan segera meninjau permohonan Anda dan menghubungi Anda kembali.
            </p>
            <div data-aos="fade-up" data-aos-delay="300">
                <a href="{{ route('home') }}" class="btn-green text-decoration-none d-inline-block">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        once: true,
        duration: 800
    });
</script>
@endsection
