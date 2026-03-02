@extends('layouts.public')

@section('title', '- Informasi Stok Benih')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold" style="color: #111827;">Informasi Stok Benih</h2>
        <p class="lead text-muted">Total ketersediaan benih padi berdasarkan varietas saat ini.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th class="py-4 px-4 border-0">#</th>
                                <th class="py-4 px-4 border-0">Varietas</th>
                                <th class="py-4 px-4 border-0">Tgl Kadaluarsa</th>
                                <th class="py-4 px-4 text-end border-0">Total Stok (kg)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stocks as $index => $stock)
                            <tr>
                                <td class="py-3 px-4">{{ $index + 1 }}</td>
                                <td class="py-3 px-4">
                                    <div class="fw-bold text-dark">{{ $stock->variety->name ?? 'Unknown' }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    {{ \Carbon\Carbon::parse($stock->expiry_date)->format('d M Y') }}
                                    @php
                                        $statusData = \App\Models\Inventory::getStatusData($stock->expiry_date);
                                    @endphp
                                    @if($statusData['status'] != 'safe')
                                        <span class="badge bg-{{ $statusData['badge'] }} {{ $statusData['badge'] == 'warning' ? 'text-dark' : '' }} ms-2">
                                            {{ $statusData['label'] }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-end text-success fw-bold fs-5">
                                    {{ number_format($stock->total_quantity) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">Belum ada data stok benih.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="text-center mt-5">
                <a href="{{ route('home') }}" class="btn btn-outline-success px-4 py-2 fw-semibold" style="border-radius: 8px;">
                    <i class="bi bi-arrow-left me-2"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
