<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Benih Padi @yield('title')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Note: Tailwind CSS via Vite is intentionally omitted here to preserve the original Bootstrap design -->
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="bi bi-flower1"></i> UPBS BRMP SumSel
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active fw-bold' : '' }}" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#cek-stok">Cek Stok</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link fw-bold btn btn-outline-light border-0 px-3 py-2 ms-lg-2" href="{{ route('dashboard') }}">
                            <i class="bi bi-box-arrow-in-right"></i> Masuk Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main style="min-height: calc(100vh - 76px); display: flex; flex-direction: column;">
        @yield('content')
    </main>

    <!-- Footer Area -->
    @yield('footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
