@extends('layouts.app')

@section('title', 'Manajemen Transaksi')

@section('content')
@php
    $total_penjualan = $transactions->where('category', 'penjualan')->sum('quantity');
    $total_diseminasi = $transactions->where('category', 'diseminasi')->sum('quantity');
    $total_masuk = $transactions->where('trx_type', 'masuk')->sum('quantity');
@endphp

<div class="mb-8">
    <h2 class="text-[28px] font-bold text-slate-800 tracking-tight leading-tight">Manajemen Transaksi</h2>
    <p class="text-slate-600 mt-1 text-base">Kelola riwayat keluar masuk stok benih (Masuk / Penjualan / Diseminasi)</p>
</div>

<!-- Top Cards -->
<div class="flex flex-nowrap overflow-x-auto gap-6 mb-8 pb-2" style="scrollbar-width: thin;">
    <div class="bg-white rounded-[16px] p-6 border border-slate-200 shadow-sm flex items-center justify-between min-w-[240px] flex-1">
        <div>
            <p class="text-[14px] text-slate-600 font-medium mb-1">Total Transaksi</p>
            <h3 class="text-[28px] font-bold text-[#1e88e5]">{{ $transactions->count() }}</h3>
        </div>
        <div class="text-slate-800 text-[28px]">
            <i class="bi bi-credit-card"></i>
        </div>
    </div>

    <div class="bg-white rounded-[16px] p-6 border border-slate-200 shadow-sm flex items-center justify-between min-w-[240px] flex-1">
        <div>
            <p class="text-[14px] text-slate-600 font-medium mb-1">Total Masuk</p>
            <h3 class="text-[28px] font-bold text-[#a855f7]">{{ number_format($total_masuk, 0) }} Kg</h3>
        </div>
        <div class="text-[#a855f7] text-[32px]">
            <i class="bi bi-box-arrow-in-down"></i>
        </div>
    </div>

    <div class="bg-white rounded-[16px] p-6 border border-slate-200 shadow-sm flex items-center justify-between min-w-[240px] flex-1">
        <div>
            <p class="text-[14px] text-slate-600 font-medium mb-1">Total Penjualan</p>
            <h3 class="text-[28px] font-bold text-[#16a34a]">{{ number_format($total_penjualan, 0) }} Kg</h3>
        </div>
        <div class="text-[#16a34a] text-[32px]">
            <i class="bi bi-cart-check"></i>
        </div>
    </div>

    <div class="bg-white rounded-[16px] p-6 border border-slate-200 shadow-sm flex items-center justify-between min-w-[240px] flex-1">
        <div>
            <p class="text-[14px] text-slate-600 font-medium mb-1">Total Diseminasi</p>
            <h3 class="text-[28px] font-bold text-[#ef4444]">{{ number_format($total_diseminasi, 0) }} Kg</h3>
        </div>
        <div class="text-[#ef4444] text-[32px]">
            <i class="bi bi-share"></i>
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
            <form method="GET" action="{{ route('transactions.index') }}" class="flex flex-col sm:flex-row items-center gap-4 w-full">
                <div class="flex items-center gap-2 w-full sm:w-auto bg-slate-100 rounded-lg px-3 focus-within:ring-2 focus-within:ring-[#10b981]">
                    <span class="text-[13px] font-bold text-slate-700 whitespace-nowrap">Dari:</span>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" onchange="this.form.submit()" class="bg-transparent border-none text-slate-800 text-[13px] w-full sm:w-[130px] py-2 transition-all outline-none font-medium">
                </div>
                <div class="flex items-center gap-2 w-full sm:w-auto bg-slate-100 rounded-lg px-3 focus-within:ring-2 focus-within:ring-[#10b981]">
                    <span class="text-[13px] font-bold text-slate-700 whitespace-nowrap">Sampai:</span>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" onchange="this.form.submit()" class="bg-transparent border-none text-slate-800 text-[13px] w-full sm:w-[130px] py-2 transition-all outline-none font-medium">
                </div>
                @if(request('start_date') || request('end_date'))
                    <a href="{{ route('transactions.index') }}" class="text-[12px] font-bold text-red-500 hover:text-red-700 whitespace-nowrap ml-2">
                        <i class="bi bi-x-circle mr-1"></i>Reset
                    </a>
                @endif
            </form>
            <a href="{{ route('transactions.create') }}" class="w-full sm:w-auto bg-[#16a34a] hover:bg-[#15803d] text-white font-bold rounded-lg text-[13px] px-4 py-2.5 text-center transition-colors shadow-sm flex items-center justify-center whitespace-nowrap">
                <i class="bi bi-plus text-lg mr-1"></i> Tambah Transaksi
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-slate-700 whitespace-nowrap min-w-[800px]">
            <thead class="text-[13px] text-slate-800 bg-white border-b border-slate-200">
                <tr>
                    <th scope="col" class="px-6 py-4 font-bold w-16">No</th>
                    <th scope="col" class="px-6 py-4 font-bold">Varietas</th>
                    <th scope="col" class="px-6 py-4 font-bold text-center">Kode Batch</th>
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
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-[13px] text-slate-800">{{ $trx->variety->name ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($trx->inventory && $trx->inventory->batch_code)
                                <span class="font-mono text-[11px] bg-slate-100 px-2 py-1 rounded text-slate-600 border border-slate-200">{{ $trx->inventory->batch_code }}</span>
                            @else
                                <span class="text-[12px] text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="font-bold text-[14px] {{ $trx->trx_type == 'masuk' ? 'text-[#a855f7]' : 'text-slate-700' }}">
                                {{ $trx->trx_type == 'masuk' ? '+' : '-' }}{{ $trx->quantity }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center text-slate-600 text-[12px]">
                            {{ \Carbon\Carbon::parse($trx->trx_date)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $kat_lower = strtolower($trx->category);
                                $badge_class = 'bg-slate-100 text-slate-700 border-slate-200';
                                $kat_text = ucfirst($trx->category);
                                
                                if($trx->trx_type == 'masuk') {
                                    $badge_class = 'bg-purple-100 text-purple-700 border-purple-200';
                                    $kat_text = 'Stok Masuk';
                                } elseif($kat_lower == 'penjualan') {
                                    $badge_class = 'bg-[#22c55e] text-white border-green-500 shadow-sm shadow-green-200';
                                } elseif($kat_lower == 'diseminasi') {
                                    $badge_class = 'bg-[#60a5fa] text-white border-blue-400 shadow-sm shadow-blue-200';
                                }
                            @endphp
                            <span class="inline-block px-3 py-1 rounded-[6px] text-[11px] font-bold {{ $badge_class }}">
                                {{ $kat_text }}
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
