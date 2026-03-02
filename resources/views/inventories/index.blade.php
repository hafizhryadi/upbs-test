@extends('layouts.app')

@section('title', 'Manajemen Inventori')

@section('content')
<div class="mb-8">
    <h2 class="text-[28px] font-bold text-slate-800 tracking-tight leading-tight">Manajemen Inventori</h2>
    <p class="text-slate-600 mt-1 text-base">Kelola stok benih dan kode batch</p>
</div>

<div class="bg-white rounded-[16px] border border-slate-200 shadow-sm overflow-hidden">
    <!-- Card Header -->
    <div class="p-6 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center">
            <div class="text-[#10b981] mr-3 font-bold">
                <i class="bi bi-box-seam text-[24px]"></i>
            </div>
            <h3 class="text-[20px] font-bold text-[#10b981]">Stok Benih Padi</h3>
        </div>
        
        <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
            <div class="relative w-full sm:w-[320px]">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <i class="bi bi-search text-slate-400"></i>
                </div>
                <input type="text" class="bg-slate-100 border-none text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] w-full pl-10 px-4 py-2.5 transition-all outline-none font-medium placeholder-slate-400" placeholder="Cari varietas atau kode batch">
            </div>
            <a href="{{ route('inventories.create') }}" class="w-full sm:w-auto bg-[#16a34a] hover:bg-[#15803d] text-white font-bold rounded-lg text-[14px] px-5 py-2.5 text-center transition-colors shadow-sm flex items-center justify-center whitespace-nowrap">
                <i class="bi bi-plus text-lg mr-1"></i> Tambah Stok Awal
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-slate-700">
            <thead class="text-[13px] text-slate-800 bg-white border-b border-slate-200">
                <tr>
                    <th scope="col" class="px-6 py-4 font-bold w-12">#</th>
                    <th scope="col" class="px-6 py-4 font-bold">Varietas</th>
                    <th scope="col" class="px-6 py-4 font-bold">Lokasi Gudang</th>
                    <th scope="col" class="px-6 py-4 font-bold text-center">Kode Batch</th>
                    <th scope="col" class="px-6 py-4 font-bold text-center">Tgl Kadaluarsa</th>
                    <th scope="col" class="px-6 py-4 font-bold text-center">Status</th>
                    <th scope="col" class="px-6 py-4 font-bold text-center">Jumlah (kg)</th>
                    <th scope="col" class="px-6 py-4 font-bold text-center w-24">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inventories as $inventory)
                    <tr class="bg-white border-b border-slate-100 hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-800 text-[13px]">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 font-medium text-[13px] text-slate-800">
                            {{ $inventory->variety->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-slate-600 text-[13px]">
                            {{ $inventory->location->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-mono text-[12px] bg-slate-100 px-2 py-1 rounded text-slate-600 border border-slate-200">{{ $inventory->batch_code }}</span>
                        </td>
                        <td class="px-6 py-4 text-center text-[12px]">
                            <div class="text-slate-800 font-medium mb-1">{{ \Carbon\Carbon::parse($inventory->expiry_date)->format('d/m/Y') }}</div>
                            @php
                                $expiry_badge_class = 'bg-slate-100 text-slate-600';
                                if($inventory->expiry_status_badge == 'danger') $expiry_badge_class = 'bg-red-50 text-red-600 border border-red-200';
                                elseif($inventory->expiry_status_badge == 'warning') $expiry_badge_class = 'bg-amber-50 text-amber-600 border border-amber-200';
                                elseif($inventory->expiry_status_badge == 'success') $expiry_badge_class = 'bg-green-50 text-green-600 border border-green-200';
                            @endphp
                            <span class="inline-block px-2 py-0.5 rounded text-[11px] font-bold {{ $expiry_badge_class }}">
                                {{ $inventory->expiry_status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $status_badge_class = 'bg-slate-100 text-slate-600 border-slate-200';
                                if($inventory->status == 'ready') $status_badge_class = 'bg-[#22c55e] text-white border-green-500 shadow-sm shadow-green-200';
                                elseif($inventory->status == 'packing') $status_badge_class = 'bg-[#60a5fa] text-white border-blue-400 shadow-sm shadow-blue-200';
                                elseif($inventory->status == 'hold') $status_badge_class = 'bg-amber-500 text-white border-amber-500 shadow-sm shadow-amber-200';
                                elseif($inventory->status == 'expired') $status_badge_class = 'bg-red-500 text-white border-red-600 shadow-sm shadow-red-200';
                            @endphp
                            <span class="inline-block px-3 py-1 rounded-[6px] text-[11px] font-bold {{ $status_badge_class }}">
                                {{ ucfirst($inventory->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center font-bold text-[14px]">
                            {{ number_format($inventory->quantity) }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-3">
                                <a href="{{ route('inventories.edit', $inventory->id) }}" class="font-medium text-slate-600 hover:text-slate-900 transition-colors tooltip" title="Edit">
                                    <i class="bi bi-pencil-square text-[16px]"></i>
                                </a>
                                <form action="{{ route('inventories.destroy', $inventory->id) }}" method="POST" class="inline-block m-0" onsubmit="return confirm('Yakin ingin menghapus stok ini? Transaksi terkait mungkin akan error.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-red-500 hover:text-red-700 transition-colors tooltip flex items-center" title="Hapus">
                                        <i class="bi bi-trash text-[16px]"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-10 text-center text-slate-500 text-[14px]">
                            Belum ada data stok.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
