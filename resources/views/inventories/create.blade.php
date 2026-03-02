@extends('layouts.app')

@section('title', 'Create Inventory')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-white font-weight-bold">
                        Tambah Stok Awal
                    </div>
                    <div class="card-body">
                        <form action="{{ route('inventories.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="variety_id" class="form-label">Varietas</label>
                                <select class="form-select" id="variety_id" name="variety_id" required>
                                    <option value="" selected disabled>-- Pilih Varietas --</option>
                                    @foreach ($varieties as $variety)
                                        <option value="{{ $variety->id }}" {{ old('variety_id') == $variety->id ? 'selected' : '' }}>
                                            {{ $variety->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="location_id" class="form-label">Lokasi Gudang</label>
                                <select class="form-select" id="location_id" name="location_id" required>
                                    <option value="" selected disabled>-- Pilih Gudang --</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                            {{ $location->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="expiry_date" class="form-label">Tanggal Kadaluarsa</label>
                                <input type="date" class="form-control" id="expiry_date" name="expiry_date"
                                    value="{{ old('expiry_date') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="ready" {{ old('status') == 'ready' ? 'selected' : '' }}>Ready (Siap Jual)</option>
                                    <option value="packing" {{ old('status') == 'packing' ? 'selected' : '' }}>Packing (Dalam Kemasan)</option>
                                    <option value="hold" {{ old('status') == 'hold' ? 'selected' : '' }}>Hold (Tertahan)</option>
                                    <option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>Expired (Kadaluarsa)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Jumlah Awal (kg)</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity') }}"
                                    min="0" required>
                                <div class="form-text">Masukkan jumlah stok awal. Untuk penambahan/pengurangan selanjutnya, gunakan menu Transaksi.</div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('inventories.index') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan Stok</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
