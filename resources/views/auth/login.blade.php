@extends('layouts.public')

@section('title', '- Masuk Admin')

@section('content')
    <!-- Add Google Fonts and AOS -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8fafc;
        }

        .text-green {
            color: #16a34a;
        }

        .bg-green {
            background-color: #16a34a;
        }

        .btn-green {
            background: #16a34a;
            color: white;
            border: none;
            padding: 12px 20px;
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

        .login-card {
            border-radius: 16px;
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .login-sidebar {
            background: url('{{ asset('images/hero_bg.png') }}') center/cover no-repeat;
            position: relative;
        }

        .login-sidebar-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(22, 163, 74, 0.8);
            /* green tint */
            z-index: 1;
        }

        .form-control {
            padding: 12px 16px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .form-control:focus {
            border-color: #16a34a;
            box-shadow: 0 0 0 0.25rem rgba(22, 163, 74, 0.25);
        }
    </style>

    <div class="container py-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12">
                <div class="card login-card">
                    <div class="row g-0">
                        <div class="col-lg-6 d-none d-lg-block login-sidebar min-vh-50">
                            <div class="login-sidebar-overlay d-flex flex-column justify-content-center p-5 text-white">
                                <div style="z-index: 2">
                                    <h2 class="fw-bold mb-4 fs-1">Sistem Manajemen Benih Padi</h2>
                                    <p class="fs-5 opacity-75">Unit Pengelola Benih Sumber (UPBS) Balai Penerapan
                                        Modernisasi Pertanian Sumatera Selatan.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 p-5 d-flex flex-column justify-content-center bg-white">
                            <div class="text-center mb-4">
                                <i class="bi bi-flower1 text-green" style="font-size: 3rem;"></i>
                                <h3 class="fw-bold text-dark mt-2">Masuk Admin</h3>
                                <p class="text-muted">Silakan masukkan kredensial Anda untuk melanjutkan</p>
                            </div>

                            @if ($errors->any())
                                <div
                                    class="alert alert-danger rounded-3 border-0 bg-danger bg-opacity-10 text-danger p-3 mb-4">
                                    <ul class="mb-0 ps-3">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="email" class="form-label fw-semibold text-dark">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 text-muted"><i
                                                class="bi bi-envelope"></i></span>
                                        <input type="email" class="form-control border-start-0 ps-0" id="email"
                                            name="email" value="{{ old('email') }}" required autofocus
                                            placeholder="admin@brmp.sumsel">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="form-label fw-semibold text-dark">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 text-muted"><i
                                                class="bi bi-lock"></i></span>
                                        <input type="password" class="form-control border-start-0 ps-0" id="password"
                                            name="password" required placeholder="••••••••">
                                    </div>
                                </div>

                                <div class="mb-4 form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                    <label class="form-check-label text-muted" for="remember">Ingat Saya</label>
                                </div>

                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-green btn-lg py-3 fs-6">
                                        Masuk ke Dashboard <i class="bi bi-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </form>

                            <div class="text-center mt-5">
                                <a href="{{ route('home') }}"
                                    class="text-decoration-none text-muted transition hover-green"><i
                                        class="bi bi-arrow-left me-1"></i> Kembali ke Beranda</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
