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
                <label for="trx_date" class="block text-[14px] font-semibold text-slate-700 mb-2">Tanggal Transaksi</label>
                <input type="date" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="trx_date" name="trx_date" value="{{ date('Y-m-d') }}" required>
            </div>

            <div class="mb-5">
                <label for="inventory_id" class="block text-[14px] font-semibold text-slate-700 mb-2">Pilih Stok (Batch)</label>
                <select class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="inventory_id" name="inventory_id" required>
                    <option value="" selected disabled>-- Pilih Varietas & Batch --</option>
                    @foreach($inventories as $inv)
                        <option value="{{ $inv->id }}">
                            {{ $inv->variety->name ?? 'Unknown' }} - Batch: {{ $inv->batch_code }} (Sisa: {{ $inv->quantity }} kg)
                        </option>
                    @endforeach
                </select>
                <p class="text-[13px] text-slate-500 mt-2"><i class="bi bi-info-circle mr-1"></i>Pilih batch stok yang akan diproses.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label for="trx_type" class="block text-[14px] font-semibold text-slate-700 mb-2">Jenis Transaksi</label>
                    <select class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="trx_type" name="trx_type" required>
                        <option value="masuk">Masuk (In)</option>
                        <option value="keluar">Keluar (Out)</option>
                    </select>
                </div>
                <div>
                    <label for="category" class="block text-[14px] font-semibold text-slate-700 mb-2">Kategori</label>
                    <select class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] focus:border-[#10b981] px-4 py-2.5 transition-all outline-none font-medium" id="category" name="category" required>
                        <option value="Produksi">Produksi</option>
                        <option value="Penjualan">Penjualan</option>
                        <option value="Subsidi">Subsidi</option>
                        <option value="Transfer">Transfer</option>
                        <option value="Koreksi">Koreksi</option>
                        <option value="Retur">Retur</option>
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
@endsection
