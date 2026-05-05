@extends('layouts.app')

@section('title', 'Create Location')

@section('content')
<div class="mb-8">
    <h2 class="text-[28px] font-bold text-slate-800 tracking-tight leading-tight">Tambah Gudang / Lokasi</h2>
    <p class="text-slate-600 mt-1 text-base">Tambahkan data lokasi penyimpanan benih baru</p>
</div>

<div class="bg-white rounded-[16px] border border-slate-200 shadow-sm overflow-hidden max-w-3xl">
    <div class="p-6 border-b border-slate-200 flex items-center">
        <div class="text-[#10b981] mr-3 font-bold">
            <i class="bi bi-geo-alt text-[24px]"></i>
        </div>
        <h3 class="text-[20px] font-bold text-[#10b981]">Form Tambah Gudang</h3>
    </div>
    
    <div class="p-6">
        <form action="{{ route('locations.store') }}" method="POST">
            @csrf
            
            <div class="mb-5">
                <label for="name" class="block text-[14px] font-semibold text-slate-700 mb-2">Nama Lokasi/Gudang</label>
                <input type="text" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lokasi" required>
            </div>
            
            <div class="mb-5">
                <label for="address" class="block text-[14px] font-semibold text-slate-700 mb-2">Alamat Detail</label>
                <input type="text" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="address" name="address" value="{{ old('address') }}" placeholder="Masukkan alamat lengkap" required>
            </div>
            
            <div class="flex items-center justify-between mt-8 pt-6 border-t border-slate-100">
                <a href="{{ route('locations.index') }}" class="bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-bold rounded-lg text-[14px] px-5 py-2.5 transition-colors shadow-sm">Batal</a>
                <button type="submit" class="bg-[#16a34a] hover:bg-[#15803d] text-white font-bold rounded-lg text-[14px] px-6 py-2.5 transition-colors shadow-sm">Simpan Lokasi</button>
            </div>
        </form>
    </div>
</div>
@endsection
