<!DOCTYPE html>
<html>
<head>
    <title>Laporan Permohonan {{ $monthName }} {{ $year }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #0a5c36; padding-bottom: 10px; }
        .header h2 { margin: 0 0 5px 0; color: #0a5c36; font-size: 20px; }
        .header h3 { margin: 0; color: #555; font-size: 16px; font-weight: normal; }
        
        .section-title { font-size: 14px; font-weight: bold; margin-bottom: 10px; color: #0a5c36; border-bottom: 1px solid #eee; padding-bottom: 5px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f7f9fa; font-weight: bold; color: #444; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        .status-disetujui { color: #16a34a; font-weight: bold; }
        .status-ditolak { color: #ef4444; font-weight: bold; }
        .status-pending { color: #d97706; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Permohonan Benih Padi</h2>
        <h3>Bulan: {{ $monthName }} {{ $year }}</h3>
    </div>

    @php
        $totalPermohonan = $requests->count();
        $totalDisetujui = $requests->where('status', 'disetujui')->count();
        $totalDitolak = $requests->where('status', 'ditolak')->count();
        $totalPending = $requests->where('status', 'pending')->count();
    @endphp

    <div>
        <div class="section-title">Daftar Permohonan</div>
        <table>
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Tanggal</th>
                    <th>Nama Pemohon</th>
                    <th>Kontak</th>
                    <th>Alamat</th>
                    <th>Jenis</th>
                    <th>Varietas</th>
                    <th class="text-right">Jumlah (kg)</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $request)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($request->created_at)->format('d M Y') }}</td>
                    <td>{{ $request->nama }}</td>
                    <td>{{ $request->phone }}<br><span style="font-size: 10px; color: #666;">{{ $request->email }}</span></td>
                    <td>{{ $request->alamat }}</td>
                    <td style="text-transform: capitalize;">{{ $request->jenis }}</td>
                    <td>{{ $request->variety->name ?? '-' }}</td>
                    <td class="text-right">{{ number_format($request->jumlah) }}</td>
                    <td class="text-center status-{{ $request->status }}">
                        {{ ucfirst($request->status) }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">Belum ada permohonan tercatat di bulan ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 30px;">
        <div class="section-title">Kesimpulan Laporan</div>
        <table style="width: 50%; margin: 0 auto; margin-top: 10px;">
            <tr>
                <th style="text-align: left;">Total Permohonan Masuk</th>
                <td style="text-align: right; font-weight: bold;">{{ number_format($totalPermohonan) }}</td>
            </tr>
            <tr>
                <th style="text-align: left;">Total Disetujui</th>
                <td style="text-align: right; color: #16a34a; font-weight: bold;">{{ number_format($totalDisetujui) }}</td>
            </tr>
            <tr>
                <th style="text-align: left;">Total Ditolak</th>
                <td style="text-align: right; color: #ef4444; font-weight: bold;">{{ number_format($totalDitolak) }}</td>
            </tr>
            <tr>
                <th style="text-align: left;">Total Pending</th>
                <td style="text-align: right; color: #d97706; font-weight: bold;">{{ number_format($totalPending) }}</td>
            </tr>
        </table>
    </div>

</body>
</html>
