@extends('layouts.app')

@section('title', 'Manajemen Inventori')

@php
function sortIcon($column) {
    $sortBy = request('sort_by');
    $order = request('order', 'asc');
    if ($sortBy === $column) {
        return $order === 'asc' ? '<i class="bi bi-chevron-up text-[10px] ml-1"></i>' : '<i class="bi bi-chevron-down text-[10px] ml-1"></i>';
    }
    return '<i class="bi bi-chevron-expand text-[10px] ml-1 text-slate-400"></i>';
}

function sortUrl($column) {
    $sortBy = request('sort_by');
    $order = request('order', 'asc');
    $newOrder = ($sortBy === $column && $order === 'asc') ? 'desc' : 'asc';
    return request()->fullUrlWithQuery(['sort_by' => $column, 'order' => $newOrder]);
}
@endphp

@section('content')
    <div class="mb-8">
        <h2 class="text-[28px] font-bold text-slate-800 tracking-tight leading-tight">Manajemen Inventori</h2>
        <p class="text-slate-600 mt-1 text-base">Pantau ketersediaan stok benih</p>
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

            <form method="GET" action="{{ route('inventories.index') }}" class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                @if(request('sort_by'))
                    <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                @endif
                @if(request('order'))
                    <input type="hidden" name="order" value="{{ request('order') }}">
                @endif
                
                <select name="status" onchange="this.form.submit()" class="bg-slate-100 border-none text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] px-4 py-2.5 outline-none font-medium transition-all cursor-pointer">
                    <option value="">Stok Tersedia</option>
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua</option>
                    <option value="safe" {{ request('status') == 'safe' ? 'selected' : '' }}>Aman</option>
                    <option value="warning" {{ request('status') == 'warning' ? 'selected' : '' }}>Mendekati Kadaluarsa</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Kadaluarsa</option>
                    <option value="empty" {{ request('status') == 'empty' ? 'selected' : '' }}>Stok Habis</option>
                </select>

                <div class="relative w-full sm:w-[320px]">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="bi bi-search text-slate-400"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="bg-slate-100 border-none text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] w-full pl-10 px-4 py-2.5 transition-all outline-none font-medium placeholder-slate-400"
                        placeholder="Cari varietas atau kode batch">
                </div>
                <!-- Optional submit button for search if user presses enter it will submit anyway, but good for mobile -->
                <button type="submit" class="hidden">Cari</button>
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-slate-700 whitespace-nowrap min-w-[800px]">
                <thead class="text-[13px] text-slate-800 bg-white border-b border-slate-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-bold w-12">No</th>
                        <th scope="col" class="px-6 py-4 font-bold">
                            <a href="{{ sortUrl('variety') }}" class="inline-flex items-center hover:text-[#10b981] transition-colors">Varietas {!! sortIcon('variety') !!}</a>
                        </th>
                        <th scope="col" class="px-6 py-4 font-bold">
                            <a href="{{ sortUrl('location') }}" class="inline-flex items-center hover:text-[#10b981] transition-colors">Lokasi Gudang {!! sortIcon('location') !!}</a>
                        </th>
                        <th scope="col" class="px-6 py-4 font-bold text-center">
                            <a href="{{ sortUrl('batch_code') }}" class="inline-flex items-center justify-center w-full hover:text-[#10b981] transition-colors">Kode Batch {!! sortIcon('batch_code') !!}</a>
                        </th>
                        <th scope="col" class="px-6 py-4 font-bold text-center">
                            <a href="{{ sortUrl('expiry_date') }}" class="inline-flex items-center justify-center w-full hover:text-[#10b981] transition-colors">Masa Edar {!! sortIcon('expiry_date') !!}</a>
                        </th>
                        <th scope="col" class="px-6 py-4 font-bold text-center">Status</th>
                        <th scope="col" class="px-6 py-4 font-bold text-center">
                            <a href="{{ sortUrl('quantity') }}" class="inline-flex items-center justify-center w-full hover:text-[#10b981] transition-colors">Jumlah (kg) {!! sortIcon('quantity') !!}</a>
                        </th>
                        <th scope="col" class="px-6 py-4 font-bold text-center">Aksi</th>
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
                                @if($inventory->batch_code)
                                    <span class="font-mono text-[12px] bg-slate-100 px-2 py-1 rounded text-slate-600 border border-slate-200">{{ $inventory->batch_code }}</span>
                                @else
                                    <span class="text-[12px] text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center text-[12px]">
                                <div class="text-slate-800 font-medium mb-1">
                                    {{ \Carbon\Carbon::parse($inventory->expiry_date)->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                 @php
                                    $expiry_badge_class = 'bg-slate-100 text-slate-600';
                                    if ($inventory->expiry_status_badge == 'danger') {
                                        $expiry_badge_class = 'bg-red-50 text-red-600 border border-red-200';
                                    } elseif ($inventory->expiry_status_badge == 'warning') {
                                        $expiry_badge_class = 'bg-amber-50 text-amber-600 border border-amber-200';
                                    } elseif ($inventory->expiry_status_badge == 'success') {
                                        $expiry_badge_class = 'bg-green-50 text-green-600 border border-green-200';
                                    }
                                @endphp
                                <span
                                    class="inline-block px-2 py-0.5 rounded text-[11px] font-bold {{ $expiry_badge_class }}">
                                    {{ $inventory->expiry_status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-[14px]">
                                {{ number_format($inventory->quantity) }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('inventories.edit', $inventory->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 transition-colors" title="Edit Data">
                                    <i class="bi bi-pencil-square text-[14px]"></i>
                                </a>
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
