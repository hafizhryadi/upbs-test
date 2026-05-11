@extends('layouts.app')

@section('title', 'Create Variety')

@section('content')
<div class="mb-8">
    <h2 class="text-[28px] font-bold text-slate-800 tracking-tight leading-tight">Tambah Varietas</h2>
    <p class="text-slate-600 mt-1 text-base">Tambahkan data varietas benih padi baru</p>
</div>

<div class="bg-white rounded-[16px] border border-slate-200 shadow-sm overflow-hidden max-w-3xl">
    <div class="p-6 border-b border-slate-200 flex items-center">
        <div class="text-[#10b981] mr-3 font-bold">
            <i class="bi bi-plus-circle text-[24px]"></i>
        </div>
        <h3 class="text-[20px] font-bold text-[#10b981]">Form Tambah Varietas</h3>
    </div>
    
    <div class="p-6">
        <form action="{{ route('varieties.store') }}" method="POST">
            @csrf
            
            <div class="mb-5">
                <label for="name" class="block text-[14px] font-semibold text-slate-700 mb-2">Nama Varietas</label>
                <input type="text" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama varietas" required>
            </div>
            <div class="mb-5">
                <label for="type" class="block text-[14px] font-semibold text-slate-700 mb-2">Tipe Varietas</label>
                <select class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="type" name="type" required>
                    <option value="" disabled selected>Pilih Tipe Varietas</option>
                    <option value="FS" {{ old('type') == 'FS' ? 'selected' : '' }}>FS</option>
                    <option value="SS" {{ old('type') == 'SS' ? 'selected' : '' }}>SS</option>
                    <option value="ES" {{ old('type') == 'ES' ? 'selected' : '' }}>ES</option>
                </select>
            </div>
            
            <div class="mb-5">
                <label for="description" class="block text-[14px] font-semibold text-slate-700 mb-2">Deskripsi</label>
                <textarea class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="description" name="description" rows="4" placeholder="Masukkan deskripsi varietas (opsional)">{{ old('description') }}</textarea>
            </div>
            
            <div class="flex items-center justify-between mt-8 pt-6 border-t border-slate-100">
                <a href="{{ route('varieties.index') }}" class="bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-bold rounded-lg text-[14px] px-5 py-2.5 transition-colors shadow-sm">Batal</a>
                <button type="submit" class="bg-[#16a34a] hover:bg-[#15803d] text-white font-bold rounded-lg text-[14px] px-6 py-2.5 transition-colors shadow-sm">Simpan Varietas</button>
            </div>
        </form>
    </div>
</div>
@endsection
