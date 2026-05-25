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

    @php
        $transaksiMasuk = $transactionsMasuk;
        $transaksiKeluar = $transactionsKeluar;
        $totalMasuk = $transaksiMasuk->sum('quantity');
        $totalKeluar = $transaksiKeluar->sum('quantity');
    @endphp

    <div>
        <div class="section-title">Riwayat Transaksi Masuk</div>
        <table>
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Tanggal Masuk</th>
                    <th>Varietas</th>
                    <th>Keterangan</th>
                    <th class="text-right">Jumlah (kg)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksiMasuk as $trx)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($trx->trx_date)->format('d M Y') }}</td>
                    <td>{{ $trx->variety->name ?? '-' }}</td>
                    <td>{{ $trx->note ?? '-' }}</td>
                    <td class="text-right">{{ number_format($trx->quantity) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada transaksi masuk tercatat di bulan ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        <div class="section-title">Riwayat Transaksi Keluar - Penjualan</div>
        <table>
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Varietas</th>
                    <th class="text-right">Jumlah Keluar (kg)</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactionsPenjualan as $trx)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $trx->variety->name ?? '-' }}</td>
                    <td class="text-right">{{ number_format($trx->quantity) }}</td>
                    <td>{{ \Carbon\Carbon::parse($trx->trx_date)->format('d M Y') }}</td>
                    <td>{{ $trx->note ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada transaksi penjualan tercatat di bulan ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        <div class="section-title">Riwayat Transaksi Keluar - Diseminasi</div>
        <table>
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Varietas</th>
                    <th class="text-right">Jumlah Keluar (kg)</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactionsDiseminasi as $trx)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $trx->variety->name ?? '-' }}</td>
                    <td class="text-right">{{ number_format($trx->quantity) }}</td>
                    <td>{{ \Carbon\Carbon::parse($trx->trx_date)->format('d M Y') }}</td>
                    <td>{{ $trx->note ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada transaksi diseminasi tercatat di bulan ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 30px;">
        <div class="section-title">Kesimpulan Laporan</div>
        <table style="width: 60%; margin: 0 auto; margin-top: 10px;">
            <tr>
                <th style="text-align: left;">Stok Akhir Bulan Sebelumnya</th>
                <td style="text-align: right; font-weight: bold;">{{ number_format($stokAkhirBulanLalu) }} kg</td>
            </tr>
            <tr>
                <th style="text-align: left;">Total Benih Masuk Bulan Ini</th>
                <td style="text-align: right; color: #16a34a; font-weight: bold;">{{ number_format($totalMasuk) }} kg</td>
            </tr>
            <tr>
                <th style="text-align: left;">Total Benih Keluar Bulan Ini</th>
                <td style="text-align: right; color: #ef4444; font-weight: bold;">{{ number_format($totalKeluar) }} kg</td>
            </tr>
            <tr>
                <th style="text-align: left;">Stok Akhir Bulan Ini</th>
                <td style="text-align: right; font-weight: bold;">{{ number_format($stokAkhirBulanLalu + $totalMasuk - $totalKeluar) }} kg</td>
            </tr>
        </table>
    </div>

</body>
</html>
