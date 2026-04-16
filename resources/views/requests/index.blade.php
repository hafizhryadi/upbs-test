@extends('layouts.app')

@section('title', '- Daftar Permohonan Benih')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Daftar Permohonan Benih</h1>
    </div>

    <!-- DataTables Example -->
    <div class="card shadow mb-4 border-0 rounded-lg">
        <div class="card-header py-3 bg-white border-bottom-0">
            <h6 class="m-0 font-weight-bold text-success">Daftar Permohonan Terbaru</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle w-full bg-white text-sm" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="py-3 px-4 font-semibold text-left">Tanggal</th>
                            <th class="py-3 px-4 font-semibold text-left">Nama / Instansi</th>
                            <th class="py-3 px-4 font-semibold text-left">Kontak</th>
                            <th class="py-3 px-4 font-semibold text-left">Permintaan (Benih / kg)</th>
                            <th class="py-3 px-4 font-semibold text-left">Lokasi & Luas Lahan</th>
                            <th class="py-3 px-4 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($requests as $request)
                            <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition-colors">
                                <td class="py-3 px-4 text-gray-600">{{ $request->created_at->format('d M Y') }}</td>
                                <td class="py-3 px-4">
                                    <div class="font-medium text-gray-900">{{ $request->nama }}</div>
                                    <div class="text-xs text-gray-500">{{ $request->kelompok_tani }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="text-gray-900">{{ $request->phone }}</div>
                                    <div class="text-xs text-gray-500">{{ $request->email ?? '-' }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        {{ $request->benih }}
                                    </span>
                                    <br>
                                    <span class="text-sm font-semibold text-gray-700 mt-1 inline-block">{{ $request->jumlah }} kg</span>
                                </td>
                                <td class="py-3 px-4 text-gray-600 text-sm">
                                    <div class="truncate max-w-[150px]" title="{{ $request->lokasi_lahan }}">{{ $request->lokasi_lahan }}</div>
                                    <div class="font-medium mt-1">{{ $request->luas_lahan }} Ha</div>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <a href="{{ route('request.show', $request->id) }}" class="inline-flex items-center justify-center gap-2 py-2 px-3 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm font-semibold text-[13px] transition-colors tooltip" title="Unduh Surat PDF">
                                        <i class="bi bi-file-earmark-pdf text-[15px]"></i> Unduh PDF
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-gray-500">Belum ada data permohonan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $requests->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
