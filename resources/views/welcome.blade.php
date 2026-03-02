@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h2 class="text-[28px] font-bold text-slate-800 tracking-tight leading-tight">Dashboard</h2>
    <p class="text-slate-600 mt-1 text-base">Sistem Informasi Manajemen UPBS</p>
</div>

<!-- Metric Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <div class="bg-white rounded-2xl p-6 border-[3px] border-[#0B6638] shadow-sm flex flex-col items-center justify-center relative overflow-hidden h-36">
        <div class="w-12 h-12 bg-emerald-50 rounded-lg flex items-center justify-center mb-2">
            <i class="bi bi-box-seam text-2xl text-[#0B6638]"></i>
        </div>
        <h3 class="text-[32px] font-bold text-[#0B6638] leading-none mb-1">{{ number_format($total_stock) }}</h3>
        <p class="text-[13px] font-bold text-slate-800">Total benih</p>
    </div>

    <div class="bg-white rounded-2xl p-6 border-[3px] border-[#0B6638] shadow-sm flex flex-col items-center justify-center relative overflow-hidden h-36">
        <div class="w-12 h-12 bg-emerald-50 rounded-lg flex items-center justify-center mb-2">
            <i class="bi bi-box-arrow-in-down text-2xl text-[#0B6638]"></i>
        </div>
        <h3 class="text-[32px] font-bold text-[#0B6638] leading-none mb-1">{{ number_format($trx_in) }}</h3>
        <p class="text-[13px] font-bold text-slate-800">Stok Masuk</p>
    </div>

    <div class="bg-white rounded-2xl p-6 border-[3px] border-[#0B6638] shadow-sm flex flex-col items-center justify-center relative overflow-hidden h-36">
        <div class="w-12 h-12 bg-amber-50 rounded-lg flex items-center justify-center mb-2">
            <i class="bi bi-exclamation-triangle text-2xl text-amber-500"></i>
        </div>
        <h3 class="text-[32px] font-bold text-amber-500 leading-none mb-1">{{ $low_stock_count }}</h3>
        <p class="text-[13px] font-bold text-slate-800">Stok menipis / Kadaluarsa</p>
    </div>

    <div class="bg-white rounded-2xl p-6 border-[3px] border-[#0B6638] shadow-sm flex flex-col items-center justify-center relative overflow-hidden h-36">
        <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center mb-2">
            <i class="bi bi-box-arrow-up text-2xl text-purple-600"></i>
        </div>
        <h3 class="text-[32px] font-bold text-[#0B6638] leading-none mb-1">{{ number_format($trx_out) }}</h3>
        <p class="text-[13px] font-bold text-slate-800">Stok Keluar</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-x-12 gap-y-8 mb-8">
    <!-- Left Column: Permohonan Terbaru -->
    <div class="lg:col-span-2">
        <div class="mb-5">
            <h3 class="text-[17px] font-bold text-slate-800">Transaksi Terbaru</h3>
            <p class="text-[13px] text-slate-600">Daftar transaksi masuk dan keluar</p>
        </div>
        
        <div class="space-y-4">
            @forelse($recent_transactions as $trx)
            <div class="bg-slate-100/80 hover:bg-slate-100 transition-colors rounded-[14px] p-5 flex flex-col sm:flex-row sm:justify-between sm:items-center">
                <div>
                    <h4 class="font-bold text-slate-800 text-[15px]">TRX-{{ str_pad($trx->id, 5, '0', STR_PAD_LEFT) }} • <span class="text-[13px] text-slate-500 capitalize">{{ $trx->category }}</span></h4>
                    <p class="text-[13px] text-slate-700 mt-1">{{ $trx->note ?: ($trx->trx_type == 'masuk' ? 'Tambahan Stok' : 'Pengeluaran Stok') }}</p>
                    <p class="text-[13px] {{ $trx->trx_type == 'masuk' ? 'text-emerald-600' : 'text-rose-600' }} font-semibold mt-0.5">
                        {{ $trx->trx_type == 'masuk' ? '+' : '-' }}{{ number_format($trx->quantity) }} kg ({{ optional($trx->inventory->variety)->name ?? 'Unknown' }})
                    </p>
                </div>
                <div class="mt-3 sm:mt-0 sm:text-right">
                    <span class="text-[13px] font-bold text-slate-800">{{ \Carbon\Carbon::parse($trx->trx_date)->format('d M Y H:i') }}</span>
                </div>
            </div>
            @empty
            <div class="bg-slate-100/80 rounded-[14px] p-5 text-center">
                <p class="text-slate-500 text-[14px]">Belum ada transaksi</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Right Column: Stok Menipis & Pergerakan -->
    <div>
        <div class="mb-10">
            <div class="flex items-start">
                <div class="bg-amber-50 text-amber-500 w-10 h-10 rounded-lg flex items-center justify-center mr-3 shrink-0">
                    <i class="bi bi-exclamation-triangle-fill text-xl"></i>
                </div>
                <div class="pt-0.5">
                    <h3 class="text-[15px] font-bold text-slate-800 leading-tight">Stok Menipis</h3>
                    <p class="text-[13px] text-slate-600 mt-0.5">Benih yang perlu diisi ulang</p>
                </div>
            </div>
        </div>

        <div class="mb-5">
            <h3 class="text-[15px] font-bold text-slate-800 leading-tight">Pergerakan Stok Terbaru</h3>
            <p class="text-[13px] text-slate-600 mt-0.5">Aktivitas stok masuk dan keluar hari ini</p>
        </div>

        <div class="space-y-3">
            @forelse($recent_transactions as $trx)
            <div class="bg-slate-100/80 rounded-[12px] p-4">
                <h4 class="font-bold text-slate-800 text-[14px]">{{ optional($trx->inventory->variety)->name ?? '-' }}</h4>
                <p class="text-[13px] text-slate-700 mt-1">{{ number_format($trx->quantity) }} kg • {{ $trx->category }}</p>
                <p class="text-[12px] text-slate-500 mt-0.5">{{ \Carbon\Carbon::parse($trx->trx_date)->format('d M H:i') }}</p>
            </div>
            @empty
            <div class="bg-slate-100/80 rounded-[12px] p-5 text-center text-slate-500 text-[13px]">
                Belum ada pergerakan stok
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection