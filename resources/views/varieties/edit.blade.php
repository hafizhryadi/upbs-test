@extends('layouts.app')

@section('title', 'Edit Varietas')

@section('content')
<div class="mb-8">
    <h2 class="text-[28px] font-bold text-slate-800 tracking-tight leading-tight">Edit Varietas</h2>
    <p class="text-slate-600 mt-1 text-base">Ubah data varietas benih padi</p>
</div>

<div class="bg-white rounded-[16px] border border-slate-200 shadow-sm overflow-hidden max-w-2xl">
    <div class="p-6 border-b border-slate-200 flex items-center">
        <div class="text-[#10b981] mr-3 font-bold">
            <i class="bi bi-pencil-square text-[24px]"></i>
        </div>
        <h3 class="text-[20px] font-bold text-[#10b981]">Form Edit Varietas</h3>
    </div>
    
    <div class="p-6">
        <form action="{{ route('varieties.update', $variety->id) }}" method="POST" id="varietyForm">
            @csrf
            @method('PUT')
            
            @php
                $oldName = old('name', $variety->name);
                $defaultInputName = $oldName;
                $defaultInputType = '';
                
                if ($oldName) {
                    $parts = explode(' ', $oldName);
                    $lastWord = end($parts);
                    if (in_array($lastWord, ['FS', 'SS', 'ES'])) {
                        $defaultInputType = $lastWord;
                        array_pop($parts);
                        $defaultInputName = implode(' ', $parts);
                    }
                }
            @endphp

            <div class="mb-5">
                <label for="input_name" class="block text-[14px] font-semibold text-slate-700 mb-2">Nama Varietas</label>
                <input type="text" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="input_name" value="{{ $defaultInputName }}" placeholder="Masukkan nama varietas" required>
            </div>
            
            <div class="mb-5">
                <label for="input_type" class="block text-[14px] font-semibold text-slate-700 mb-2">Tipe Benih</label>
                <select class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="input_type" required>
                    <option value="" disabled {{ $defaultInputType == '' ? 'selected' : '' }}>Pilih Tipe Benih</option>
                    <option value="FS" {{ $defaultInputType == 'FS' ? 'selected' : '' }}>FS</option>
                    <option value="SS" {{ $defaultInputType == 'SS' ? 'selected' : '' }}>SS</option>
                    <option value="ES" {{ $defaultInputType == 'ES' ? 'selected' : '' }}>ES</option>
                </select>
            </div>
            
            <input type="hidden" name="name" id="name" value="{{ old('name', $variety->name) }}">

            <div class="mb-5">
                <label for="description" class="block text-[14px] font-semibold text-slate-700 mb-2">Deskripsi</label>
                <textarea class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="description" name="description" rows="4" placeholder="Masukkan deskripsi varietas (opsional)">{{ old('description', $variety->description) }}</textarea>
            </div>
            
            <div class="flex items-center justify-between mt-8 pt-6 border-t border-slate-100">
                <a href="{{ route('varieties.index') }}" class="bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-bold rounded-lg text-[14px] px-5 py-2.5 transition-colors shadow-sm">Batal</a>
                <button type="submit" class="bg-[#16a34a] hover:bg-[#15803d] text-white font-bold rounded-lg text-[14px] px-6 py-2.5 transition-colors shadow-sm">Update Varietas</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('varietyForm').addEventListener('submit', function() {
        const inputName = document.getElementById('input_name').value.trim();
        const inputType = document.getElementById('input_type').value;
        if(inputName && inputType) {
            document.getElementById('name').value = inputName + ' ' + inputType;
        }
    });
</script>
@endsection
