@extends('layouts.public')

@section('title', '- Permohonan Berhasil')

@section('content')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 mt-10 min-h-[70vh] flex items-center justify-center">
        <div class="w-full max-w-2xl text-center">
            <div data-aos="zoom-in">
                <i class="bi bi-check-circle-fill text-[#16a34a] mb-6 inline-block text-[4rem] md:text-[5rem]"></i>
            </div>
            <h2 class="font-bold mb-4 text-slate-800 text-2xl md:text-3xl" data-aos="fade-up" data-aos-delay="100">Permohonan Berhasil Dikirim!</h2>
            <p class="text-slate-500 mb-8 text-base md:text-lg" data-aos="fade-up" data-aos-delay="200">
                Terima kasih atas permohonan layanan benih Anda. Tim kami di UPBS BBRMP SumSel akan segera meninjau
                permohonan Anda dan menghubungi Anda kembali.
            </p>
            <div data-aos="fade-up" data-aos-delay="300">
                <a href="{{ route('home') }}" class="inline-block bg-[#16a34a] hover:bg-[#15803d] text-white px-8 py-3 rounded-lg font-semibold transition-all shadow-md hover:-translate-y-0.5 hover:shadow-lg">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, duration: 800 });
    </script>
@endsection
