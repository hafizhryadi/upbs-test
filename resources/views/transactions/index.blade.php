@extends('layouts.app')

@section('title', 'Manajemen Transaksi')

@section('content')
@php
    $total_masuk = $transactions->where('trx_type', 'masuk')->sum('quantity');
    $total_keluar = $transactions->where('trx_type', 'keluar')->sum('quantity');
@endphp

<div class="mb-8">
    <h2 class="text-[28px] font-bold text-slate-800 tracking-tight leading-tight">Manajemen Transaksi</h2>
    <p class="text-slate-600 mt-1 text-base">Kelola riwayat transaksi masuk dan keluar benih</p>
</div>

<!-- Top Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-[16px] p-6 border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-[14px] text-slate-600 font-medium mb-1">Total Transaksi</p>
            <h3 class="text-[28px] font-bold text-[#1e88e5]">{{ $transactions->count() }}</h3>
        </div>
        <div class="text-slate-800 text-[28px]">
            <i class="bi bi-credit-card"></i>
        </div>
    </div>

    <div class="bg-white rounded-[16px] p-6 border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-[14px] text-slate-600 font-medium mb-1">Total masuk</p>
            <h3 class="text-[28px] font-bold text-[#16a34a]">{{ number_format($total_masuk, 2) }} Kg</h3>
        </div>
        <div class="text-[#16a34a] text-[32px]">
            <i class="bi bi-arrow-down-circle"></i>
        </div>
    </div>

    <div class="bg-white rounded-[16px] p-6 border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-[14px] text-slate-600 font-medium mb-1">Total keluar</p>
            <h3 class="text-[28px] font-bold text-[#ef4444]">{{ number_format($total_keluar, 2) }} Kg</h3>
        </div>
        <div class="text-[#ef4444] text-[32px]">
            <i class="bi bi-arrow-up-circle"></i>
        </div>
    </div>
</div>

<div class="bg-white rounded-[16px] border border-slate-200 shadow-sm overflow-hidden">
    <!-- Card Header -->
    <div class="p-6 border-b border-slate-200 flex flex-col xl:flex-row xl:items-center justify-between gap-4">
        <div class="flex items-center">
            <div class="text-slate-800 mr-3 font-bold">
                <i class="bi bi-wallet2 text-[20px]"></i>
            </div>
            <h3 class="text-[18px] font-bold text-slate-800">Riwayat Transaksi</h3>
        </div>
        
        <div class="flex flex-col sm:flex-row items-center gap-4 w-full xl:w-auto">
            <div class="flex items-center gap-2 w-full sm:w-auto bg-slate-100 rounded-lg px-3 focus-within:ring-2 focus-within:ring-[#10b981]">
                <span class="text-[13px] font-bold text-slate-700 whitespace-nowrap">Dari:</span>
                <input type="text" class="bg-transparent border-none text-slate-800 text-[13px] w-full sm:w-[100px] py-2 transition-all outline-none font-medium placeholder-slate-400" placeholder="hh/bb/tttt">
            </div>
            <div class="flex items-center gap-2 w-full sm:w-auto bg-slate-100 rounded-lg px-3 focus-within:ring-2 focus-within:ring-[#10b981]">
                <span class="text-[13px] font-bold text-slate-700 whitespace-nowrap">Sampai:</span>
                <input type="text" class="bg-transparent border-none text-slate-800 text-[13px] w-full sm:w-[100px] py-2 transition-all outline-none font-medium placeholder-slate-400" placeholder="hh/bb/tttt">
            </div>
            <a href="{{ route('transactions.create') }}" class="w-full sm:w-auto bg-[#16a34a] hover:bg-[#15803d] text-white font-bold rounded-lg text-[13px] px-4 py-2.5 text-center transition-colors shadow-sm flex items-center justify-center whitespace-nowrap">
                <i class="bi bi-plus text-lg mr-1"></i> Tambah Transaksi
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-slate-700">
            <thead class="text-[13px] text-slate-800 bg-white border-b border-slate-200">
                <tr>
                    <th scope="col" class="px-6 py-4 font-bold w-16">ID</th>
                    <th scope="col" class="px-6 py-4 font-bold">Inventory</th>
                    <th scope="col" class="px-6 py-4 font-bold text-center">Tipe</th>
                    <th scope="col" class="px-6 py-4 font-bold text-center">Jumlah (kg)</th>
                    <th scope="col" class="px-6 py-4 font-bold text-center">Tanggal</th>
                    <th scope="col" class="px-6 py-4 font-bold text-center">Kategori</th>
                    <th scope="col" class="px-6 py-4 font-bold">Keterangan</th>
                    <th scope="col" class="px-6 py-4 font-bold text-center w-24">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $index => $trx)
                    <tr class="bg-white border-b border-slate-100 hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-800 text-[13px]">
                            {{ str_pad($loop->iteration, 3, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-6 py-4 text-[13px] font-medium text-slate-700">
                            {{ $trx->inventory->variety->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($trx->trx_type == 'masuk')
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-green-50 text-green-600 border border-green-200">
                                    <i class="bi bi-arrow-down-circle-fill mr-1 text-[10px]"></i> Masuk
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-red-50 text-red-500 border border-red-200">
                                    <i class="bi bi-arrow-down-circle-fill mr-1 text-[10px] transform rotate-180"></i> Keluar
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center font-bold text-[14px]">
                            {{ number_format($trx->quantity, 3) }}
                        </td>
                        <td class="px-6 py-4 text-center text-slate-600 text-[12px]">
                            {{ \Carbon\Carbon::parse($trx->trx_date)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $kat_lower = strtolower($trx->category);
                                $badge_class = 'bg-blue-100 text-blue-700 border-blue-200';
                                if($kat_lower == 'adjust' || str_contains($kat_lower, 'tambah')) {
                                    $badge_class = 'bg-[#22c55e] text-white border-green-500 shadow-sm shadow-green-200';
                                } elseif(str_contains($kat_lower, 'rusak') || str_contains($kat_lower, 'hilang')) {
                                    $badge_class = 'bg-red-500 text-white border-red-600 shadow-sm shadow-red-200';
                                } elseif($kat_lower == 'jual' || str_contains($kat_lower, 'dinas')) {
                                    $badge_class = 'bg-[#60a5fa] text-white border-blue-400 shadow-sm shadow-blue-200';
                                }
                            @endphp
                            <span class="inline-block px-3 py-1 rounded-[6px] text-[11px] font-bold {{ $badge_class }}">
                                {{ ucfirst($trx->category) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-600 text-[12px]">
                            {{ $trx->note ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('transactions.destroy', $trx->id) }}" method="POST" class="inline-block m-0" onsubmit="return confirm('Hapus transaksi? Stok akan dikembalikan (reversed).');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-medium text-red-400 hover:text-red-600 transition-colors tooltip flex justify-center items-center w-full" title="Hapus">
                                    <i class="bi bi-trash text-[15px]"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-10 text-center text-slate-500 text-[14px]">
                            Belum ada riwayat transaksi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
