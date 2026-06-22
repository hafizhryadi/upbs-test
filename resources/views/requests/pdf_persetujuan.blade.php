<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Persetujuan Permohonan Benih</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
            margin: 40px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 14px;
        }
        .content {
            margin-bottom: 30px;
        }
        .content p {
            margin: 10px 0;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .details-table th, .details-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .details-table th {
            width: 30%;
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
        }
        .signature {
            display: inline-block;
            text-align: center;
        }
        .signature-line {
            margin-top: 80px;
            border-top: 1px solid #333;
            width: 200px;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>UNIT PENGELOLA BENIH SUMBER (UPBS)</h1>
        <p>Badan Riset dan Inovasi Daerah Provinsi Sumatera Selatan</p>
    </div>

    <div class="content">
        <p>Berdasarkan permohonan yang telah diajukan melalui sistem informasi UPBS, dengan ini menerangkan bahwa permohonan atas nama:</p>
        
        <table class="details-table">
            <tr>
                <th>Nama Lengkap</th>
                <td>{{ $requestData->nama }}</td>
            </tr>
            <tr>
                <th>No. Telepon / HP</th>
                <td>{{ $requestData->phone }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $requestData->alamat }}</td>
            </tr>
            <tr>
                <th>Jenis Permohonan</th>
                <td>{{ ucfirst($requestData->jenis) }}</td>
            </tr>
            <tr>
                <th>Varietas Benih</th>
                <td>{{ $requestData->variety->name }}</td>
            </tr>
            <tr>
                <th>Jumlah Disetujui</th>
                <td><strong>{{ number_format($requestData->jumlah) }} kg</strong></td>
            </tr>
        </table>

        <p>Telah <strong>DISETUJUI</strong> dan dapat dilakukan proses pengambilan atau pengiriman benih sesuai ketentuan yang berlaku. Stok benih pada sistem telah otomatis disesuaikan.</p>
    </div>

    <div class="footer">
        <div class="signature">
            <p>Palembang, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</p>
            <p>Admin UPBS,</p>
            <div class="signature-line"></div>
            <p><strong>{{ auth()->user()->name ?? 'Administrator' }}</strong></p>
        </div>
    </div>
</body>
</html>
