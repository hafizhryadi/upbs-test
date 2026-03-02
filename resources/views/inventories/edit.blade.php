@extends('layouts.app')

@section('title', 'Edit Inventory')

@section('content')
    <div class="container mt-4">
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-white font-weight-bold">
                        Edit Data Stok
                    </div>
                    <div class="card-body">
                        <form action="{{ route('inventories.update', $inventory->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="variety_id" class="form-label">Varietas</label>
                                <select class="form-select" id="variety_id" name="variety_id" required>
                                    <option value="">Pilih Varietas</option>
                                    @foreach ($varieties as $variety)
                                        <option value="{{ $variety->id }}"
                                            {{ old('variety_id', $inventory->variety_id) == $variety->id ? 'selected' : '' }}>
                                            {{ $variety->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="location_id" class="form-label">Lokasi Gudang</label>
                                <select class="form-select" id="location_id" name="location_id" required>
                                    <option value="">Pilih Gudang</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}"
                                            {{ old('location_id', $inventory->location_id) == $location->id ? 'selected' : '' }}>
                                            {{ $location->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="batch_code" class="form-label">Kode Batch</label>
                                <input type="text" class="form-control" id="batch_code" name="batch_code"
                                    value="{{ old('batch_code', $inventory->batch_code) }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="expiry_date" class="form-label">Tanggal Kadaluarsa</label>
                                <input type="date" class="form-control" id="expiry_date" name="expiry_date"
                                    value="{{ old('expiry_date', $inventory->expiry_date) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="ready" {{ old('status', $inventory->status) == 'ready' ? 'selected' : '' }}>Ready (Siap Jual)</option>
                                    <option value="packing" {{ old('status', $inventory->status) == 'packing' ? 'selected' : '' }}>Packing (Dalam Kemasan)</option>
                                    <option value="hold" {{ old('status', $inventory->status) == 'hold' ? 'selected' : '' }}>Hold (Tertahan)</option>
                                    <option value="expired" {{ old('status', $inventory->status) == 'expired' ? 'selected' : '' }}>Expired (Kadaluarsa)</option>
                                </select>
                            </div>
                            <div class="alert alert-warning">
                                <i class="bi bi-info-circle"></i> <strong>Perhatian:</strong> Mengubah jumlah stok di sini hanya disarankan untuk koreksi data awal (Opname). Untuk transaksi masuk/keluar harian, gunakan menu <strong>Transaksi</strong>.
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Jumlah (kg)</label>
                                <input type="number" class="form-control" id="quantity" name="quantity"
                                    value="{{ old('quantity', $inventory->quantity) }}" min="0" required>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('inventories.index') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Update Stok</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
