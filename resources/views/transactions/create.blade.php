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
                <input type="date" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="trx_date" name="trx_date" value="{{ date('Y-m-d') }}" required>
            </div>

            <div class="mb-5">
                <label for="variety_id" class="block text-[14px] font-semibold text-slate-700 mb-2">Pilih Varietas</label>
                <select class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="variety_id" name="variety_id" required>
                    <option value="" selected disabled>-- Pilih Varietas --</option>
                    @foreach($varieties as $variety)
                        @php
                            $total_stock = $variety->inventories->sum('quantity');
                        @endphp
                        <option value="{{ $variety->id }}" data-stock="{{ $total_stock }}">
                            {{ $variety->name }} (Total Sisa Stok: {{ $total_stock }} kg)
                        </option>
                    @endforeach
                </select>
            </div>
            
            <p id="fefo_info" class="text-[13px] text-slate-500 mb-5"><i class="bi bi-info-circle mr-1"></i>Sistem otomatis akan mengurangi stok dari batch yang paling awal mendekati masa kedaluwarsa (FEFO).</p>

            <!-- Fields for Masuk -->
            <div id="masuk_fields" style="display: none;">
                <div class="mb-5">
                    <label for="location_id" class="block text-[14px] font-semibold text-slate-700 mb-2">Lokasi Gudang</label>
                    <select class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="location_id" name="location_id">
                        <option value="" selected disabled>-- Pilih Gudang --</option>
                        @foreach ($locations as $location)
                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label for="expiry_date" class="block text-[14px] font-semibold text-slate-700 mb-2">Masa Edar</label>
                        <input type="date" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="expiry_date" name="expiry_date">
                    </div>
                    <div>
                        <label for="status" class="block text-[14px] font-semibold text-slate-700 mb-2">Status</label>
                        <select class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="status" name="status">
                            <option value="ready">Ready (Siap Jual)</option>
                            <option value="packing">Packing (Dalam Kemasan)</option>
                            <option value="hold">Hold (Tertahan)</option>
                            <option value="expired">Expired (Kadaluarsa)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Fields for Keluar -->
            <div id="keluar_fields">
                <div class="mb-5">
                    <label for="category" class="block text-[14px] font-semibold text-slate-700 mb-2">Kategori Pengeluaran</label>
                    <select class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="category" name="category">
                        <option value="penjualan">Penjualan</option>
                        <option value="diseminasi">Diseminasi</option>
                    </select>
                </div>
            </div>

            <div class="mb-5">
                <label for="quantity" class="block text-[14px] font-semibold text-slate-700 mb-2">Jumlah (kg)</label>
                <input type="number" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="quantity" name="quantity" min="1" placeholder="0" required>
            </div>

            <div class="mb-5">
                <label for="note" class="block text-[14px] font-semibold text-slate-700 mb-2">Catatan</label>
                <textarea class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="note" name="note" rows="3" placeholder="Masukkan keterangan tambahan jika ada"></textarea>
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
        const fefoInfo = document.getElementById('fefo_info');
        
        // Elements for required toggle
        const locationInput = document.getElementById('location_id');
        const expiryInput = document.getElementById('expiry_date');
        const statusInput = document.getElementById('status');
        const categoryInput = document.getElementById('category');

        if (trxType === 'masuk') {
            masukFields.style.display = 'block';
            keluarFields.style.display = 'none';
            fefoInfo.style.display = 'none';
            
            locationInput.setAttribute('required', 'required');
            expiryInput.setAttribute('required', 'required');
            statusInput.setAttribute('required', 'required');
            categoryInput.removeAttribute('required');
        } else {
            masukFields.style.display = 'none';
            keluarFields.style.display = 'block';
            fefoInfo.style.display = 'block';
            
            locationInput.removeAttribute('required');
            expiryInput.removeAttribute('required');
            statusInput.removeAttribute('required');
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
