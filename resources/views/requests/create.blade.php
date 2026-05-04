@extends('layouts.public')

@section('title', 'Permohonan Benih - UPBS BBRMP SumSel')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    body { 
        font-family: 'Outfit', sans-serif; 
        background-color: #f8fafc;
    }
    .text-green { color: #16a34a; }
    .bg-green { background-color: #16a34a; }
    
    .form-control {
        padding: 0.75rem 1.25rem;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        background-color: #f9fafb;
        transition: all 0.3s;
    }
    .form-control:focus {
        border-color: #16a34a;
        box-shadow: 0 0 0 0.25rem rgba(22, 163, 74, 0.25);
        background-color: #fff;
    }
    .form-label {
        font-weight: 600;
        color: #4b5563;
        margin-bottom: 0.5rem;
    }
    
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
        box-shadow: 0 6px 20px rgba(22, 163, 74, 0.5);
    }
    .btn-outline-secondary {
        border-radius: 8px;
        font-weight: 600;
        padding: 12px 30px;
    }

    .card-header-custom {
        background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
        color: white;
        padding: 30px;
        text-align: center;
        border-radius: 16px 16px 0 0 !important;
    }
</style>

<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 rounded-4 mt-4" data-aos="fade-up" data-aos-duration="800">
                <div class="card-header-custom">
                    <i class="bi bi-file-earmark-text fs-1 mb-2 d-block"></i>
                    <h2 class="fw-bold mb-1">Form Pengajuan Layanan Benih</h2>
                    <p class="mb-0 opacity-75">Silakan isi formulir di bawah ini dengan data yang valid dan lengkap.</p>
                </div>
                
                <div class="card-body p-5 bg-white rounded-bottom-4">
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3 border-0 bg-danger bg-opacity-10 text-danger p-4 mb-4">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
                                <strong class="fs-5">Terdapat kesalahan!</strong>
                            </div>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('request.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4">
                            <!-- Data Pemohon -->
                            <div class="col-12">
                                <h5 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-person-fill text-green me-2"></i>Data Pemohon</h5>
                            </div>
                            <div class="col-md-6">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Nomor Telepon/WA</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Contoh: 081234567890" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email (Opsional)</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com">
                            </div>
                            <div class="col-md-6">
                                <label for="kelompok_tani" class="form-label">Kelompok Tani / Instansi</label>
                                <input type="text" class="form-control" id="kelompok_tani" name="kelompok_tani" value="{{ old('kelompok_tani') }}" placeholder="Nama Kelompok Tani/Instansi" required>
                            </div>
                            <div class="col-12">
                                <label for="alamat" class="form-label">Alamat Lengkap</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap pengiriman" required>{{ old('alamat') }}</textarea>
                            </div>

                            <!-- Detail Permohonan -->
                            <div class="col-12 mt-5">
                                <h5 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-box-seam-fill text-green me-2"></i>Detail Permohonan</h5>
                            </div>
                            <div class="col-md-6">
                                <label for="benih" class="form-label">Varietas Benih yang Diminta</label>
                                <input type="text" class="form-control" id="benih" name="benih" value="{{ old('benih') }}" placeholder="Contoh: Inpari 32" required>
                            </div>
                            <div class="col-md-6">
                                <label for="jumlah" class="form-label">Jumlah (kg)</label>
                                <div class="input-group">
                                    <input type="number" class="form-control border-end-0" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" min="1" placeholder="0" required>
                                    <span class="input-group-text bg-light border-start-0 text-muted">kg</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="rencana_tanam" class="form-label">Rencana Waktu Tanam</label>
                                <input type="text" class="form-control" id="rencana_tanam" name="rencana_tanam" value="{{ old('rencana_tanam') }}" placeholder="Contoh: Awal Musim Hujan 2026 / November 2026" required>
                            </div>
                            <div class="col-md-6">
                                <label for="lokasi_lahan" class="form-label">Lokasi Lahan Tanam</label>
                                <input type="text" class="form-control" id="lokasi_lahan" name="lokasi_lahan" value="{{ old('lokasi_lahan') }}" placeholder="Desa/Kecamatan/Kabupaten" required>
                            </div>
                            <div class="col-md-6">
                                <label for="luas_lahan" class="form-label">Luas Lahan (Hektar)</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" class="form-control border-end-0" id="luas_lahan" name="luas_lahan" value="{{ old('luas_lahan') }}" min="0.1" placeholder="0.00" required>
                                    <span class="input-group-text bg-light border-start-0 text-muted">ha</span>
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <label for="surat_permohonan" class="form-label">Unggah Surat Permohonan</label>
                                <input class="form-control" type="file" id="surat_permohonan" name="surat_permohonan" accept=".pdf,.jpg,.jpeg,.png" required>
                                <div class="form-text text-muted small mt-1"><i class="bi bi-info-circle me-1"></i>Format yang didukung: PDF, JPG, PNG. Maksimal ukuran 5MB.</div>
                            </div>
                        </div>
                        
                        <div class="d-flex flex-column flex-md-row gap-3 mt-5 pt-3 border-top">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
                            <button type="submit" class="btn-green w-100"><i class="bi bi-send-fill me-2"></i>Kirim Permohonan</button>
                        </div>
                    </form>
                </div>
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
