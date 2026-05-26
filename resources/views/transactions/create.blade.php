@extends('layouts.app')

@section('title', 'Catat Transaksi')

@section('content')
<div class="mb-8">
    <h2 class="text-[28px] font-bold text-slate-800 tracking-tight leading-tight">Catat Transaksi Baru</h2>
    <p class="text-slate-600 mt-1 text-base">Rekam aktivitas keluar masuk stok benih padi</p>
</div>

<div class="bg-white rounded-[16px] border border-slate-200 shadow-sm overflow-hidden max-w-3xl">
    <div class="p-6 border-b border-slate-200 flex items-center">
        <div class="text-[#10b981] mr-3 font-bold">
            <i class="bi bi-arrow-left-right text-[24px]"></i>
        </div>
        <h3 class="text-[20px] font-bold text-[#10b981]">Form Transaksi Stok</h3>
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

        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf
            
            <div class="mb-5">
                <label class="block text-[14px] font-semibold text-slate-700 mb-2">Jenis Transaksi</label>
                <input type="hidden" name="trx_type" id="trx_type_input" value="{{ old('trx_type', 'keluar') }}">
                
                <div class="flex rounded-2xl md:w-[400px] border border-slate-200 overflow-hidden bg-white shadow-sm">
                    <button type="button" id="btn_masuk" onclick="setTrxType('masuk')" class="flex-1 py-3 text-[16px] font-medium transition-colors bg-white text-slate-800">
                        Masuk
                    </button>
                    <button type="button" id="btn_keluar" onclick="setTrxType('keluar')" class="flex-1 py-3 text-[16px] font-medium transition-colors bg-[#16a34a] text-white border-l border-transparent">
                        Keluar
                    </button>
                </div>
            </div>

            <div class="mb-5">
                <label for="trx_date" class="block text-[14px] font-semibold text-slate-700 mb-2">Tanggal Transaksi</label>
                <input type="date" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="trx_date" name="trx_date" value="{{ old('trx_date', date('Y-m-d')) }}" required>
            </div>

            <!-- Fields for Masuk -->
            <div id="masuk_fields" style="display: none;">
                <div class="mb-5">
                    <label for="variety_id" class="block text-[14px] font-semibold text-slate-700 mb-2">Pilih Varietas Benih</label>
                    <select class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="variety_id" name="variety_id">
                        <option value="" selected disabled>-- Pilih Varietas --</option>
                        @foreach($varieties as $variety)
                            <option value="{{ $variety->id }}" {{ old('variety_id') == $variety->id ? 'selected' : '' }}>
                                {{ $variety->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-5">
                    <label for="batch_code" class="block text-[14px] font-semibold text-slate-700 mb-2">Kode Batch / Lot <span class="text-slate-400 font-normal">(Opsional)</span></label>
                    <input type="text" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="batch_code" name="batch_code" value="{{ old('batch_code') }}" placeholder="Contoh: LOT-12345">
                </div>

                <div class="mb-5">
                    <label for="location_id" class="block text-[14px] font-semibold text-slate-700 mb-2">Lokasi Gudang</label>
                    <select class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="location_id" name="location_id">
                        <option value="" selected disabled>-- Pilih Gudang --</option>
                        @foreach ($locations as $location)
                            <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-5">
                    <label for="expiry_date" class="block text-[14px] font-semibold text-slate-700 mb-2">Masa Edar / ED</label>
                    <input type="date" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="expiry_date" name="expiry_date" value="{{ old('expiry_date') }}">
                </div>
            </div>

            <!-- Fields for Keluar -->
            <div id="keluar_fields">
                <div class="mb-5">
                    <label for="inventory_id" class="block text-[14px] font-semibold text-slate-700 mb-2">Pilih Batch / Lot Fisik</label>
                    <select class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="inventory_id" name="inventory_id">
                        <option value="" selected disabled>-- Pilih Spesifik Stok --</option>
                        @foreach($inventories as $inv)
                            <option value="{{ $inv->id }}" {{ old('inventory_id') == $inv->id ? 'selected' : '' }}>
                                {{ $inv->batch_code ? '['.$inv->batch_code.'] ' : '' }}{{ $inv->variety->name ?? 'Varietas Unknown' }} - Sisa: {{ $inv->quantity }} kg (ED: {{ \Carbon\Carbon::parse($inv->expiry_date)->format('d M Y') }})
                            </option>
                        @endforeach
                    </select>
                    <p class="text-[12px] text-slate-500 mt-1.5"><i class="bi bi-info-circle mr-1"></i>Daftar diurutkan mulai dari stok yang masa edarnya paling cepat habis (Rekomendasi FEFO).</p>
                </div>

                <div class="mb-5">
                    <label for="category" class="block text-[14px] font-semibold text-slate-700 mb-2">Kategori Pengeluaran</label>
                    <select class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="category" name="category">
                        <option value="penjualan" {{ old('category') == 'penjualan' ? 'selected' : '' }}>Penjualan</option>
                        <option value="diseminasi" {{ old('category') == 'diseminasi' ? 'selected' : '' }}>Diseminasi</option>
                        <option value="penyesuaian" {{ old('category') == 'penyesuaian' ? 'selected' : '' }}>Penyesuaian Stok (Rusak / Selisih)</option>
                    </select>
                </div>
            </div>

            <div class="mb-5">
                <label for="quantity" class="block text-[14px] font-semibold text-slate-700 mb-2">Jumlah (kg)</label>
                <input type="number" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="quantity" name="quantity" min="1" value="{{ old('quantity') }}" placeholder="0" required>
            </div>

            <div class="mb-5">
                <label for="note" class="block text-[14px] font-semibold text-slate-700 mb-2">Catatan</label>
                <textarea class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="note" name="note" rows="3" placeholder="Masukkan keterangan tambahan jika ada">{{ old('note') }}</textarea>
            </div>

            <div class="flex items-center justify-between mt-8 pt-6 border-t border-slate-100">
                <a href="{{ route('transactions.index') }}" class="bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-bold rounded-lg text-[14px] px-5 py-2.5 transition-colors shadow-sm">Batal</a>
                <button type="submit" class="bg-[#16a34a] hover:bg-[#15803d] text-white font-bold rounded-lg text-[14px] px-6 py-2.5 transition-colors shadow-sm">Simpan Transaksi</button>
            </div>
        </form>
    </div>
</div>

<script>
    function setTrxType(type) {
        document.getElementById('trx_type_input').value = type;
        
        const btnMasuk = document.getElementById('btn_masuk');
        const btnKeluar = document.getElementById('btn_keluar');
        
        if (type === 'masuk') {
            btnMasuk.className = "flex-1 py-3 text-[16px] font-medium transition-colors bg-[#16a34a] text-white";
            btnKeluar.className = "flex-1 py-3 text-[16px] font-medium transition-colors bg-white text-slate-800 border-l border-slate-100";
        } else {
            btnMasuk.className = "flex-1 py-3 text-[16px] font-medium transition-colors bg-white text-slate-800";
            btnKeluar.className = "flex-1 py-3 text-[16px] font-medium transition-colors bg-[#16a34a] text-white border-l border-transparent";
        }
        
        toggleForm();
    }

    function toggleForm() {
        const trxType = document.getElementById('trx_type_input').value;
        const masukFields = document.getElementById('masuk_fields');
        const keluarFields = document.getElementById('keluar_fields');
        
        // Elements for required toggle
        const varietyInput = document.getElementById('variety_id');
        const locationInput = document.getElementById('location_id');
        const expiryInput = document.getElementById('expiry_date');
        
        const inventoryInput = document.getElementById('inventory_id');
        const categoryInput = document.getElementById('category');

        if (trxType === 'masuk') {
            masukFields.style.display = 'block';
            keluarFields.style.display = 'none';
            
            varietyInput.setAttribute('required', 'required');
            locationInput.setAttribute('required', 'required');
            expiryInput.setAttribute('required', 'required');
            
            inventoryInput.removeAttribute('required');
            categoryInput.removeAttribute('required');
        } else {
            masukFields.style.display = 'none';
            keluarFields.style.display = 'block';
            
            varietyInput.removeAttribute('required');
            locationInput.removeAttribute('required');
            expiryInput.removeAttribute('required');
            
            inventoryInput.setAttribute('required', 'required');
            categoryInput.setAttribute('required', 'required');
        }
    }

    // Run on load
    document.addEventListener('DOMContentLoaded', function() {
        const initialType = document.getElementById('trx_type_input').value;
        setTrxType(initialType);
    });
</script>
@endsection
