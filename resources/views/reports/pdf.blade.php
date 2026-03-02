<!DOCTYPE html>
<html>
<head>
    <title>Laporan Bulanan {{ $monthName }} {{ $year }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #0a5c36; padding-bottom: 10px; }
        .header h2 { margin: 0 0 5px 0; color: #0a5c36; font-size: 20px; }
        .header h3 { margin: 0; color: #555; font-size: 16px; font-weight: normal; }
        
        .chart-container { text-align: center; margin-bottom: 30px; padding: 15px; border: 1px solid #eee; background-color: #fafafa; border-radius: 8px; }
        .chart-container h4 { margin-top: 0; margin-bottom: 15px; color: #444; }
        .chart-img { max-width: 100%; height: auto; }
        
        .section-title { font-size: 14px; font-weight: bold; margin-bottom: 10px; color: #0a5c36; border-bottom: 1px solid #eee; padding-bottom: 5px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f7f9fa; font-weight: bold; color: #444; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        .badge-masuk { color: #16a34a; font-weight: bold; }
        .badge-keluar { color: #ef4444; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Transaksi Benih Padi</h2>
        <h3>Bulan: {{ $monthName }} {{ $year }}</h3>
    </div>

    @if($chartUrl)
    <div class="chart-container">
        <h4>Grafik Analitik Transaksi Harian (Masuk & Keluar)</h4>
        <img src="{{ $chartUrl }}" class="chart-img" alt="Grafik Transaksi">
    </div>
    @endif

    <div>
        <div class="section-title">Riwayat Transaksi Detail</div>
        <table>
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Tanggal</th>
                    <th>Varietas</th>
                    <th>Lokasi</th>
                    <th>Kode Batch</th>
                    <th class="text-center">Tipe</th>
                    <th>Kategori</th>
                    <th class="text-right">Jumlah (kg)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $trx)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($trx->trx_date)->format('d/m/Y') }}</td>
                    <td>{{ $trx->inventory->variety->name ?? '-' }}</td>
                    <td>{{ $trx->inventory->location->name ?? '-' }}</td>
                    <td>{{ $trx->inventory->batch_code ?? '-' }}</td>
                    <td class="text-center">
                        @if($trx->trx_type == 'masuk')
                            <span class="badge-masuk">Masuk</span>
                        @else
                            <span class="badge-keluar">Keluar</span>
                        @endif
                    </td>
                    <td>{{ ucfirst($trx->category) }}</td>
                    <td class="text-right">{{ number_format($trx->quantity) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Belum ada transaksi tercatat di bulan ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</body>
</html>
