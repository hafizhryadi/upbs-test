@extends('layouts.app')

@section('title', 'Edit Lokasi Gudang')

@section('content')
<div class="mb-8">
    <h2 class="text-[28px] font-bold text-slate-800 tracking-tight leading-tight">Edit Lokasi Gudang</h2>
    <p class="text-slate-600 mt-1 text-base">Ubah informasi lokasi atau gudang benih padi</p>
</div>

<div class="bg-white rounded-[16px] border border-slate-200 shadow-sm overflow-hidden max-w-2xl">
    <div class="p-6 border-b border-slate-200 flex items-center">
        <div class="text-[#10b981] mr-3 font-bold">
            <i class="bi bi-pencil-square text-[24px]"></i>
        </div>
        <h3 class="text-[20px] font-bold text-[#10b981]">Form Edit Lokasi</h3>
    </div>
    
    <div class="p-6">
        <form action="{{ route('locations.update', $location->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-5">
                <label for="name" class="block text-[14px] font-semibold text-slate-700 mb-2">Nama Lokasi</label>
                <input type="text" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium @error('name') border-rose-500 @enderror" id="name" name="name" value="{{ old('name', $location->name) }}" placeholder="Contoh: Gudang Benih Induk A" required>
                @error('name')
                    <p class="mt-1 text-[13px] text-rose-500">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-5">
                <label for="address" class="block text-[14px] font-semibold text-slate-700 mb-2">Alamat Lengkap</label>
                <textarea class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium min-h-[120px] @error('address') border-rose-500 @enderror" id="address" name="address" placeholder="Contoh: Jl. Pertanian No. 12, Kota Palembang" required>{{ old('address', $location->address) }}</textarea>
                @error('address')
                    <p class="mt-1 text-[13px] text-rose-500">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex items-center justify-between mt-8 pt-6 border-t border-slate-100">
                <a href="{{ route('locations.index') }}" class="bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-bold rounded-lg text-[14px] px-5 py-2.5 transition-colors shadow-sm">Batal</a>
                <button type="submit" class="bg-[#16a34a] hover:bg-[#15803d] text-white font-bold rounded-lg text-[14px] px-6 py-2.5 transition-colors shadow-sm">Update Lokasi</button>
            </div>
        </form>
    </div>
</div>
@endsection
