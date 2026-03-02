@extends('layouts.app')

@section('title', 'Edit Transaksi')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white font-weight-bold">
                    Edit Transaksi
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i> Perhatian: Mengedit jumlah atau tipe transaksi akan mempengaruhi stok saat ini. Pastikan perubahan sudah benar.
                    </div>
                    <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="trx_date" class="form-label">Tanggal Transaksi</label>
                            <input type="date" class="form-control" id="trx_date" name="trx_date" value="{{ $transaction->trx_date }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="inventory_id" class="form-label">Stok (Batch)</label>
                            <input type="text" class="form-control" value="{{ $transaction->inventory->variety->name }} - {{ $transaction->inventory->batch_code }}" disabled>
                            <input type="hidden" name="inventory_id" value="{{ $transaction->inventory_id }}">
                            <div class="form-text">Batch stok tidak dapat diubah saat edit. Hapus dan buat baru jika salah batch.</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="trx_type" class="form-label">Jenis Transaksi</label>
                                <select class="form-select" id="trx_type" name="trx_type" required>
                                    <option value="masuk" {{ $transaction->trx_type == 'masuk' ? 'selected' : '' }}>Masuk (In)</option>
                                    <option value="keluar" {{ $transaction->trx_type == 'keluar' ? 'selected' : '' }}>Keluar (Out)</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">Kategori</label>
                                <select class="form-select" id="category" name="category" required>
                                    @foreach(['Produksi', 'Penjualan', 'Subsidi', 'Transfer', 'Koreksi', 'Retur'] as $cat)
                                        <option value="{{ $cat }}" {{ $transaction->category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Jumlah (kg)</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" min="1" value="{{ $transaction->quantity }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="note" class="form-label">Catatan</label>
                            <textarea class="form-control" id="note" name="note" rows="3">{{ $transaction->note }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Update Transaksi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
