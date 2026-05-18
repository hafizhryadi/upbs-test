@extends('layouts.app')

@section('title', 'Create Inventory')

@section('content')
<div class="mb-8">
    <h2 class="text-[28px] font-bold text-slate-800 tracking-tight leading-tight">Tambah Stok Awal</h2>
    <p class="text-slate-600 mt-1 text-base">Masukkan batch stok benih padi yang baru</p>
</div>

<div class="bg-white rounded-[16px] border border-slate-200 shadow-sm overflow-hidden max-w-3xl">
    <div class="p-6 border-b border-slate-200 flex items-center">
        <div class="text-[#10b981] mr-3 font-bold">
            <i class="bi bi-box-seam text-[24px]"></i>
        </div>
        <h3 class="text-[20px] font-bold text-[#10b981]">Form Stok Awal</h3>
    </div>
    
    <div class="p-6">
        <form action="{{ route('inventories.store') }}" method="POST">
            @csrf
            
            <div class="mb-5">
                <label for="variety_id" class="block text-[14px] font-semibold text-slate-700 mb-2">Varietas</label>
                <select class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="variety_id" name="variety_id" required>
                    <option value="" selected disabled>-- Pilih Varietas --</option>
                    @foreach ($varieties as $variety)
                        <option value="{{ $variety->id }}" {{ old('variety_id') == $variety->id ? 'selected' : '' }}>{{ $variety->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label for="location_id" class="block text-[14px] font-semibold text-slate-700 mb-2">Lokasi Gudang</label>
                    <select class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="location_id" name="location_id" required>
                        <option value="" selected disabled>-- Pilih Gudang --</option>
                        @foreach ($locations as $location)
                            <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label for="expiry_date" class="block text-[14px] font-semibold text-slate-700 mb-2">Masa Edar</label>
                    <input type="date" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="expiry_date" name="expiry_date" value="{{ old('expiry_date') }}" required>
                </div>
                <div>
                    <label for="status" class="block text-[14px] font-semibold text-slate-700 mb-2">Status</label>
                    <select class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="status" name="status" required>
                        <option value="ready" {{ old('status') == 'ready' ? 'selected' : '' }}>Ready (Siap Jual)</option>
                        <option value="packing" {{ old('status') == 'packing' ? 'selected' : '' }}>Packing (Dalam Kemasan)</option>
                        <option value="hold" {{ old('status') == 'hold' ? 'selected' : '' }}>Hold (Tertahan)</option>
                        <option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>Expired (Kadaluarsa)</option>
                    </select>
                </div>
            </div>

            <div class="mb-5">
                <label for="quantity" class="block text-[14px] font-semibold text-slate-700 mb-2">Jumlah Awal (kg)</label>
                <input type="number" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="quantity" name="quantity" value="{{ old('quantity') }}" min="0" placeholder="0" required>
            </div>

            <div class="flex items-center justify-between mt-8 pt-6 border-t border-slate-100">
                <a href="{{ route('inventories.index') }}" class="bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-bold rounded-lg text-[14px] px-5 py-2.5 transition-colors shadow-sm">Batal</a>
                <button type="submit" class="bg-[#16a34a] hover:bg-[#15803d] text-white font-bold rounded-lg text-[14px] px-6 py-2.5 transition-colors shadow-sm">Simpan Stok</button>
            </div>
        </form>
    </div>
</div>
@endsection
