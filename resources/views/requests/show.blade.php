@extends('layouts.app')

@section('title', 'Detail Permohonan Benih')

@section('content')
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-[28px] font-bold text-slate-800 tracking-tight leading-tight">Detail Permohonan</h2>
            <p class="text-slate-600 mt-1 text-base">Informasi lengkap tentang permohonan benih</p>
        </div>
        <a href="{{ route('request.index') }}" class="inline-flex items-center gap-2 py-2 px-4 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[14px] transition-colors">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    @php
        $requestStatusClasses = [
            'pending' => 'bg-amber-50 text-amber-700 border border-amber-200',
            'disetujui' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
            'ditolak' => 'bg-red-50 text-red-700 border border-red-200',
        ];

        $requestStatusLabels = [
            'pending' => 'Pending',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
        ];
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="text-[18px] font-bold text-slate-800">Informasi Pemohon</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8">
                        <div>
                            <div class="text-[13px] font-bold text-slate-500 mb-1">Nama Lengkap</div>
                            <div class="text-[15px] font-medium text-slate-800">{{ $request->nama }}</div>
                        </div>
                        <div>
                            <div class="text-[13px] font-bold text-slate-500 mb-1">Kontak</div>
                            <div class="text-[15px] font-medium text-slate-800">{{ $request->phone }}</div>
                            <div class="text-[14px] text-slate-500">{{ $request->email ?? '-' }}</div>
                        </div>
                        <div class="sm:col-span-2">
                            <div class="text-[13px] font-bold text-slate-500 mb-1">Alamat</div>
                            <div class="text-[15px] font-medium text-slate-800">{{ $request->alamat }}</div>
                        </div>
                        <div>
                            <div class="text-[13px] font-bold text-slate-500 mb-1">Tanggal Permohonan</div>
                            <div class="text-[15px] font-medium text-slate-800">{{ $request->created_at->format('d M Y H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="text-[18px] font-bold text-slate-800">Detail Permintaan</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8">
                        <div>
                            <div class="text-[13px] font-bold text-slate-500 mb-1">Jenis Permohonan</div>
                            <span class="inline-block px-3 py-1 rounded-full text-[12px] font-bold uppercase tracking-wide {{ $request->jenis == 'pembelian' ? 'bg-blue-50 text-blue-600 border border-blue-200' : 'bg-purple-50 text-purple-600 border border-purple-200' }}">
                                {{ $request->jenis }}
                            </span>
                        </div>
                        <div>
                            <div class="text-[13px] font-bold text-slate-500 mb-1">Permintaan Benih</div>
                            <div class="text-[15px] font-bold text-slate-800">{{ $request->variety->name ?? '-' }}</div>
                            <div class="text-[14px] text-slate-600 mt-0.5">{{ number_format($request->jumlah) }} kg</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="text-[18px] font-bold text-slate-800">Dokumen Lampiran</h3>
                </div>
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row gap-4">
                        @if ($request->surat_permohonan)
                            <a href="{{ route('request.download', $request->id) }}"
                                class="inline-flex items-center justify-center gap-2 py-2.5 px-4 rounded-lg bg-[#16a34a] hover:bg-[#15803d] text-white shadow-sm font-bold text-[13px] transition-colors tooltip"
                                title="Unduh Surat Permohonan">
                                <i class="bi bi-file-earmark-pdf text-[16px]"></i> Unduh Surat Permohonan
                            </a>
                        @else
                            <span
                                class="inline-flex items-center justify-center gap-2 py-2.5 px-4 rounded-lg bg-slate-100 text-slate-400 font-bold text-[13px] cursor-not-allowed">
                                <i class="bi bi-dash-circle text-[16px]"></i> Tidak Ada Surat Permohonan
                            </span>
                        @endif

                        @if ($request->surat_persetujuan)
                            <a href="{{ asset($request->surat_persetujuan) }}" target="_blank"
                                class="inline-flex items-center justify-center gap-2 py-2.5 px-4 rounded-lg bg-[#3b82f6] hover:bg-[#2563eb] text-white shadow-sm font-bold text-[13px] transition-colors tooltip"
                                title="Unduh Surat Persetujuan">
                                <i class="bi bi-file-earmark-check text-[16px]"></i> Lihat Surat Persetujuan
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="md:col-span-1">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden sticky top-6">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="text-[18px] font-bold text-slate-800">Status Permohonan</h3>
                </div>
                <div class="p-6">
                    <div class="mb-6">
                        <div class="text-[13px] font-bold text-slate-500 mb-2">Status Saat Ini</div>
                        <span class="inline-flex items-center justify-center px-4 py-2 rounded-full text-[13px] font-bold uppercase tracking-wide {{ $requestStatusClasses[$request->status] ?? 'bg-slate-100 text-slate-600 border border-slate-200' }} w-full">
                            {{ $requestStatusLabels[$request->status] ?? ucfirst($request->status) }}
                        </span>
                    </div>

                    @if (auth()->check() && auth()->user()->role === 'pimpinan')
                        <div class="pt-4 border-t border-slate-100">
                            <div class="text-[13px] font-bold text-slate-500 mb-3">Ubah Status</div>
                            <form action="{{ route('request.status', $request->id) }}" method="POST" class="w-full flex flex-col gap-3">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg px-4 py-3 transition-all outline-none font-medium focus:ring-2 focus:ring-[#10b981] focus:border-transparent">
                                    <option value="pending" {{ $request->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="disetujui" {{ $request->status === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                    <option value="ditolak" {{ $request->status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                                
                                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 rounded-lg bg-[#10b981] hover:bg-[#059669] shadow-sm font-bold text-[14px] transition-colors mt-2">
                                    <i class="bi bi-save"></i> Simpan Status
                                </button>
                            </form>
                            @if ($request->status === 'pending')
                                <p class="text-[12px] text-slate-500 mt-4 leading-relaxed">
                                    <i class="bi bi-info-circle text-blue-500 mr-1"></i> Jika disetujui, sistem akan secara otomatis memotong stok benih dan menerbitkan surat persetujuan.
                                </p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
