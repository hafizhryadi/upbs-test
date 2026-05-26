@extends('layouts.app')

@section('title', 'Edit Inventory')

@section('content')
<div class="mb-8">
    <h2 class="text-[28px] font-bold text-slate-800 tracking-tight leading-tight">Edit Data Stok</h2>
    <p class="text-slate-600 mt-1 text-base">Perbarui data stok fisik benih</p>
</div>

<div class="bg-white rounded-[16px] border border-slate-200 shadow-sm overflow-hidden max-w-3xl">
    <div class="p-6 border-b border-slate-200 flex items-center">
        <div class="text-amber-500 mr-3 font-bold">
            <i class="bi bi-pencil-square text-[24px]"></i>
        </div>
        <h3 class="text-[20px] font-bold text-amber-500">Form Koreksi Stok</h3>
    </div>
    
    <div class="p-6">
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700">
                <div class="flex items-center mb-2">
                    <i class="bi bi-exclamation-triangle-fill mr-2 text-rose-500"></i>
                    <span class="font-bold">Terjadi Kesalahan:</span>
                </div>
                <ul class="list-disc pl-5 text-[13px] space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('inventories.update', $inventory->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-5">
                <label for="variety_id" class="block text-[14px] font-semibold text-slate-700 mb-2">Varietas</label>
                <select class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 px-4 py-2.5 transition-all outline-none font-medium" id="variety_id" name="variety_id" required>
                    <option value="">-- Pilih Varietas --</option>
                    @foreach ($varieties as $variety)
                        <option value="{{ $variety->id }}" {{ old('variety_id', $inventory->variety_id) == $variety->id ? 'selected' : '' }}>
                            {{ $variety->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-5">
                <label for="location_id" class="block text-[14px] font-semibold text-slate-700 mb-2">Lokasi Gudang</label>
                <select class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 px-4 py-2.5 transition-all outline-none font-medium" id="location_id" name="location_id" required>
                    <option value="">-- Pilih Gudang --</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}" {{ old('location_id', $inventory->location_id) == $location->id ? 'selected' : '' }}>
                            {{ $location->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-5">
                <label for="batch_code" class="block text-[14px] font-semibold text-slate-700 mb-2">Kode Batch</label>
                <input type="text" class="w-full bg-slate-100 border border-slate-200 text-slate-500 text-[14px] rounded-lg px-4 py-2.5 outline-none font-medium cursor-not-allowed" id="batch_code" name="batch_code" value="{{ old('batch_code', $inventory->batch_code) }}" readonly>
            </div>

            <div class="mb-5">
                <label for="expiry_date" class="block text-[14px] font-semibold text-slate-700 mb-2">Tanggal Kadaluarsa / ED</label>
                <input type="date" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 px-4 py-2.5 transition-all outline-none font-medium" id="expiry_date" name="expiry_date" value="{{ old('expiry_date', $inventory->expiry_date) }}" required>
            </div>

            <div class="mb-6 p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800">
                <div class="flex items-start">
                    <i class="bi bi-info-circle-fill mt-0.5 mr-3 text-amber-500"></i>
                    <div class="text-[13px] leading-relaxed">
                        <strong class="block mb-1">Penting: Histori Mutasi (Traceability)</strong>
                        Jumlah stok fisik <strong>dikunci</strong>. Jika terdapat selisih jumlah stok karena rusak, hilang, atau opname, dilarang mengubah langsung. Silakan sesuaikan dengan menu <a href="{{ route('transactions.create') }}" class="font-bold underline text-amber-700 hover:text-amber-900">Catat Transaksi Keluar &rarr; Kategori: Penyesuaian</a>.
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <label for="quantity" class="block text-[14px] font-semibold text-slate-700 mb-2">Jumlah (kg)</label>
                <input type="number" class="w-full bg-slate-100 border border-slate-200 text-slate-500 text-[14px] rounded-lg px-4 py-2.5 outline-none font-bold cursor-not-allowed" id="quantity" name="quantity" value="{{ old('quantity', $inventory->quantity) }}" min="0" readonly>
            </div>

            <div class="flex items-center justify-between mt-8 pt-6 border-t border-slate-100">
                <a href="{{ route('inventories.index') }}" class="bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-bold rounded-lg text-[14px] px-5 py-2.5 transition-colors shadow-sm">Batal</a>
                <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-lg text-[14px] px-6 py-2.5 transition-colors shadow-sm">Update Data Stok</button>
            </div>
        </form>
    </div>
</div>
@endsection
