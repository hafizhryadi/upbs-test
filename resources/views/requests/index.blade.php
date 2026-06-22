@extends('layouts.app')

@section('title', 'Daftar Permohonan Benih')

@section('content')
    <div class="mb-8">
        <h2 class="text-[28px] font-bold text-slate-800 tracking-tight leading-tight">Daftar Permohonan Benih</h2>
        <p class="text-slate-600 mt-1 text-base">Kelola dan pantau permohonan layanan benih dari masyarakat</p>
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

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <!-- Card Header -->
        <div class="p-6 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center">
                <div class="text-[#10b981] mr-3 font-bold">
                    <i class="bi bi-clipboard-data text-[24px]"></i>
                </div>
                <h3 class="text-[20px] font-bold text-[#10b981]">Daftar Permohonan Terbaru</h3>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                <div class="relative w-full sm:w-[320px]">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="bi bi-search text-slate-400"></i>
                    </div>
                    <input type="text"
                        class="bg-slate-100 border-none text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] w-full pl-10 px-4 py-2.5 transition-all outline-none font-medium placeholder-slate-400"
                        placeholder="Cari nama pemohon atau instansi">
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-slate-700 whitespace-nowrap min-w-[800px]">
                <thead class="text-[13px] text-slate-800 bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-bold text-left">Tanggal</th>
                        <th scope="col" class="px-6 py-4 font-bold text-left">Nama Lengkap</th>
                        <th scope="col" class="px-6 py-4 font-bold text-left">Kontak</th>
                        <th scope="col" class="px-6 py-4 font-bold text-left">Alamat</th>
                        <th scope="col" class="px-6 py-4 font-bold text-left">Jenis Permohonan</th>
                        <th scope="col" class="px-6 py-4 font-bold text-left">Permintaan Benih</th>
                        <th scope="col" class="px-6 py-4 font-bold text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($requests as $request)
                        <tr class="bg-white border-b border-slate-100 hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-slate-600 text-[13px] font-medium">
                                {{ $request->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800 text-[13px]">{{ $request->nama }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-800 text-[13px]">{{ $request->phone }}</div>
                                <div class="text-[12px] text-slate-500 mt-0.5">{{ $request->email ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-[13px] text-slate-600 max-w-50 line-clamp-2"
                                    title="{{ $request->alamat }}">{{ $request->alamat }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-block px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wide {{ $request->jenis == 'pembelian' ? 'bg-blue-50 text-blue-600 border border-blue-200' : 'bg-purple-50 text-purple-600 border border-purple-200' }}">
                                    {{ $request->jenis }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-block px-2.5 py-1 rounded-md text-[11px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                    {{ $request->variety->name ?? '-' }}
                                </span>
                                <div class="text-[13px] font-bold text-slate-700 mt-1.5">
                                    {{ number_format($request->jumlah) }} kg</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex flex-col gap-2">
                                    <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wide {{ $requestStatusClasses[$request->status] ?? 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                                        {{ $requestStatusLabels[$request->status] ?? ucfirst($request->status) }}
                                    </span>
                                    <a href="{{ route('request.show', $request->id) }}"
                                        class="inline-flex items-center justify-center gap-2 py-2 px-3 rounded-lg bg-slate-800 hover:bg-slate-700 shadow-sm font-bold text-[12px] transition-colors tooltip w-full"
                                        title="Lihat Detail Permohonan">
                                        <i class="bi bi-eye text-[14px]"></i> Lihat Detail
                                    </a>

                                    @if ($request->surat_permohonan)
                                        <a href="{{ route('request.download', $request->id) }}"
                                            class="inline-flex items-center justify-center gap-2 py-2 px-3 rounded-lg bg-[#16a34a] hover:bg-[#15803d] shadow-sm font-bold text-[12px] transition-colors tooltip w-full"
                                            title="Unduh Surat Permohonan">
                                            <i class="bi bi-file-earmark-pdf text-[14px]"></i> Surat Permohonan
                                        </a>
                                    @else
                                        <span
                                            class="hidden items-center justify-center gap-2 py-2 px-3 rounded-lg bg-slate-100 text-slate-400 font-bold text-[12px] w-full cursor-not-allowed"
                                            title="Tidak ada file surat">
                                            <i class="bi bi-dash-circle text-[14px]"></i> Tidak Ada
                                        </span>
                                    @endif

                                    @if ($request->surat_persetujuan)
                                        <a href="{{ asset($request->surat_persetujuan) }}" target="_blank"
                                            class="inline-flex items-center justify-center gap-2 py-2 px-3 rounded-lg bg-[#3b82f6] hover:bg-[#2563eb] shadow-sm font-bold text-[12px] transition-colors tooltip w-full"
                                            title="Unduh Surat Persetujuan">
                                            <i class="bi bi-file-earmark-check text-[14px]"></i> Surat Persetujuan
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-slate-500 text-[14px]">
                                Belum ada data permohonan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($requests->hasPages())
            <div class="p-6 border-t border-slate-200">
                {{ $requests->links() }}
            </div>
        @endif
    </div>
@endsection
