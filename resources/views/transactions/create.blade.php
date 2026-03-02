@extends('layouts.app')

@section('title', 'Catat Transaksi')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white font-weight-bold">
                    Catat Transaksi Baru
                </div>
                <div class="card-body">
                    <form action="{{ route('transactions.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="trx_date" class="form-label">Tanggal Transaksi</label>
                            <input type="date" class="form-control" id="trx_date" name="trx_date" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="inventory_id" class="form-label">Pilih Stok (Batch)</label>
                            <select class="form-select" id="inventory_id" name="inventory_id" required>
                                <option value="" selected disabled>-- Pilih Varietas & Batch --</option>
                                @foreach($inventories as $inv)
                                    <option value="{{ $inv->id }}">
                                        {{ $inv->variety->name ?? 'Unknown' }} - Batch: {{ $inv->batch_code }} (Sisa: {{ $inv->quantity }} kg)
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Pilih batch stok yang akan diproses.</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="trx_type" class="form-label">Jenis Transaksi</label>
                                <select class="form-select" id="trx_type" name="trx_type" required>
                                    <option value="masuk">Masuk (In)</option>
                                    <option value="keluar">Keluar (Out)</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">Kategori</label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="Produksi">Produksi</option>
                                    <option value="Penjualan">Penjualan</option>
                                    <option value="Subsidi">Subsidi</option>
                                    <option value="Transfer">Transfer</option>
                                    <option value="Koreksi">Koreksi</option>
                                    <option value="Retur">Retur</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Jumlah (kg)</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
                        </div>

                        <div class="mb-3">
                            <label for="note" class="form-label">Catatan</label>
                            <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
