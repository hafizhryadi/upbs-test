@extends('layouts.public')

@section('title', '- Buat Permohonan')

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

<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-4 mt-5">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4 fw-bold" style="color: #111827;">Form Pengajuan Layanan Benih</h2>
                    <p class="text-center text-muted mb-4">Silakan isi formulir di bawah ini dengan data yang valid.</p>

                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('request.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nama" class="form-label fw-bold">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-bold">Nomor Telepon/WA</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-bold">Email (Opsional)</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="kelompok_tani" class="form-label fw-bold">Kelompok Tani / Instansi</label>
                                <input type="text" class="form-control" id="kelompok_tani" name="kelompok_tani" value="{{ old('kelompok_tani') }}" required>
                            </div>
                            <div class="col-12">
                                <label for="alamat" class="form-label fw-bold">Alamat Lengkap</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="benih" class="form-label fw-bold">Varietas Benih yang Diminta</label>
                                <input type="text" class="form-control" id="benih" name="benih" value="{{ old('benih') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="jumlah" class="form-label fw-bold">Jumlah (kg)</label>
                                <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" min="1" required>
                            </div>
                            <div class="col-12">
                                <label for="rencana_tanam" class="form-label fw-bold">Rencana Waktu Tanam</label>
                                <input type="text" class="form-control" id="rencana_tanam" name="rencana_tanam" value="{{ old('rencana_tanam') }}" placeholder="Contoh: Awal Musim Hujan 2026" required>
                            </div>
                            <div class="col-md-6">
                                <label for="lokasi_lahan" class="form-label fw-bold">Lokasi Lahan Tanam</label>
                                <input type="text" class="form-control" id="lokasi_lahan" name="lokasi_lahan" value="{{ old('lokasi_lahan') }}" placeholder="Desa/Kecamatan/Kabupaten" required>
                            </div>
                            <div class="col-md-6">
                                <label for="luas_lahan" class="form-label fw-bold">Luas Lahan (Hektar)</label>
                                <input type="number" step="0.01" class="form-control" id="luas_lahan" name="luas_lahan" value="{{ old('luas_lahan') }}" min="0.1" required>
                            </div>
                            <div class="col-12">
                                <label for="surat_permohonan" class="form-label fw-bold">Unggah Surat Permohonan (PDF/JPG/PNG, Max 5MB)</label>
                                <input class="form-control" type="file" id="surat_permohonan" name="surat_permohonan" accept=".pdf,.jpg,.jpeg,.png" required>
                            </div>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn-green">Kirim Permohonan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
