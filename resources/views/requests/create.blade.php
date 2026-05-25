@extends('layouts.public')

@section('title', 'Permohonan Benih - UPBS BBRMP SumSel')

@section('content')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <div class="py-12 mt-10 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden mt-8" data-aos="fade-up" data-aos-duration="800">
                <div class="bg-gradient-to-br from-green-600 to-green-800 text-white p-8 text-center">
                    <i class="bi bi-file-earmark-text text-5xl mb-4 block"></i>
                    <h2 class="text-2xl md:text-3xl font-bold mb-2">Form Pengajuan Layanan Benih</h2>
                    <p class="opacity-80 text-sm md:text-base">Silakan isi formulir di bawah ini dengan data yang valid dan lengkap.</p>
                </div>

                <div class="p-6 md:p-10">
                    @if ($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg mb-6">
                            <div class="flex items-center mb-2">
                                <i class="bi bi-exclamation-triangle-fill text-xl mr-2"></i>
                                <strong class="text-lg">Terdapat kesalahan!</strong>
                            </div>
                            <ul class="list-disc list-inside ml-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('request.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Data Pemohon -->
                            <div class="col-span-1 md:col-span-2">
                                <h5 class="font-bold text-slate-800 border-b border-slate-200 pb-2 mb-4 mt-2">
                                    <i class="bi bi-person-fill text-green-600 mr-2"></i>Data Pemohon
                                </h5>
                            </div>
                            <div>
                                <label for="nama" class="block font-semibold text-slate-600 mb-2">Nama Lengkap</label>
                                <input type="text" class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-slate-50 focus:bg-white focus:border-green-600 focus:ring-2 focus:ring-green-200 transition-all outline-none" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap" required>
                            </div>
                            <div>
                                <label for="phone" class="block font-semibold text-slate-600 mb-2">Nomor Telepon/WA</label>
                                <input type="text" class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-slate-50 focus:bg-white focus:border-green-600 focus:ring-2 focus:ring-green-200 transition-all outline-none" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Contoh: 081234567890" required>
                            </div>
                            <div>
                                <label for="email" class="block font-semibold text-slate-600 mb-2">Email (Opsional)</label>
                                <input type="email" class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-slate-50 focus:bg-white focus:border-green-600 focus:ring-2 focus:ring-green-200 transition-all outline-none" id="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com">
                            </div>
                            <div class="col-span-1 md:col-span-2">
                                <label for="alamat" class="block font-semibold text-slate-600 mb-2">Alamat Lengkap</label>
                                <textarea class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-slate-50 focus:bg-white focus:border-green-600 focus:ring-2 focus:ring-green-200 transition-all outline-none" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap pengiriman" required>{{ old('alamat') }}</textarea>
                            </div>

                            <!-- Detail Permohonan -->
                            <div class="col-span-1 md:col-span-2 mt-6">
                                <h5 class="font-bold text-slate-800 border-b border-slate-200 pb-2 mb-4">
                                    <i class="bi bi-box-seam-fill text-green-600 mr-2"></i>Detail Permohonan
                                </h5>
                            </div>
                            <div>
                                <label for="benih" class="block font-semibold text-slate-600 mb-2">Varietas Benih yang Diminta</label>
                                <select class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-slate-50 focus:bg-white focus:border-green-600 focus:ring-2 focus:ring-green-200 transition-all outline-none" id="benih" name="benih" required>
                                    <option value="" disabled selected>Pilih Varietas Benih</option>
                                    @foreach ($varieties as $variety)
                                        <option value="{{ $variety->name }}" {{ old('benih') == $variety->name ? 'selected' : '' }}>{{ $variety->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="jumlah" class="block font-semibold text-slate-600 mb-2">Jumlah (kg)</label>
                                <div class="flex">
                                    <input type="number" class="w-full px-4 py-3 rounded-l-lg border border-r-0 border-slate-200 bg-slate-50 focus:bg-white focus:border-green-600 focus:ring-2 focus:ring-green-200 transition-all outline-none" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" min="1" placeholder="0" required>
                                    <span class="inline-flex items-center px-4 py-3 rounded-r-lg border border-l-0 border-slate-200 bg-slate-100 text-slate-500 font-medium">kg</span>
                                </div>
                            </div>
                            <div class="col-span-1 md:col-span-2">
                                <label for="jenis" class="block font-semibold text-slate-600 mb-2">Jenis Permohonan</label>
                                <select class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-slate-50 focus:bg-white focus:border-green-600 focus:ring-2 focus:ring-green-200 transition-all outline-none" id="jenis" name="jenis" required>
                                    <option value="" disabled selected>Pilih Jenis Permohonan</option>
                                    <option value="pembelian" {{ old('jenis') == 'pembelian' ? 'selected' : '' }}>Pembelian</option>
                                    <option value="diseminasi" {{ old('jenis') == 'diseminasi' ? 'selected' : '' }}>Diseminasi</option>
                                </select>
                            </div>
                            <div class="col-span-1 md:col-span-2" id="surat_permohonan_container" style="display: none;">
                                <label for="surat_permohonan" class="block font-semibold text-slate-600 mb-2">Unggah Surat Permohonan</label>
                                <input class="w-full px-4 py-2.5 rounded-lg border border-slate-200 bg-slate-50 focus:bg-white focus:border-green-600 transition-all outline-none file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100" type="file" id="surat_permohonan" name="surat_permohonan" accept=".pdf,.jpg,.jpeg,.png">
                                <p class="text-slate-500 text-sm mt-2">
                                    <i class="bi bi-info-circle mr-1"></i>Format yang didukung: PDF, JPG, PNG. Maksimal ukuran 5MB.
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row gap-4 mt-10 pt-6 border-t border-slate-200">
                            <a href="{{ route('home') }}" class="w-full md:w-1/2 flex justify-center items-center px-6 py-3 border-2 border-slate-300 text-slate-700 font-semibold rounded-lg hover:bg-slate-50 hover:text-slate-900 transition-colors">
                                <i class="bi bi-arrow-left mr-2"></i>Kembali
                            </a>
                            <button type="submit" class="w-full md:w-1/2 flex justify-center items-center px-6 py-3 bg-[#16a34a] hover:bg-[#15803d] text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all hover:-translate-y-0.5">
                                <i class="bi bi-send-fill mr-2"></i>Kirim Permohonan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, duration: 800 });

        document.addEventListener('DOMContentLoaded', function() {
            const jenisSelect = document.getElementById('jenis');
            const suratContainer = document.getElementById('surat_permohonan_container');
            const suratInput = document.getElementById('surat_permohonan');

            function toggleSurat() {
                if (jenisSelect.value === 'diseminasi') {
                    suratContainer.style.display = 'block';
                    suratInput.setAttribute('required', 'required');
                } else {
                    suratContainer.style.display = 'none';
                    suratInput.removeAttribute('required');
                }
            }

            toggleSurat();
            jenisSelect.addEventListener('change', toggleSurat);
        });
    </script>
@endsection
