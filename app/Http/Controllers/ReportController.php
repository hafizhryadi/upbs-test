<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $year = request('year', date('Y'));
        $months = [];
        
        $stats = Transaction::selectRaw('
            MONTH(trx_date) as month,
            SUM(CASE WHEN trx_type = "masuk" THEN quantity ELSE 0 END) as total_in,
            SUM(CASE WHEN trx_type = "keluar" THEN quantity ELSE 0 END) as total_out,
            COUNT(*) as trx_count
        ')
        ->whereYear('trx_date', $year)
        ->groupBy('month')
        ->get()
        ->keyBy('month');
        
        for ($m = 1; $m <= 12; $m++) {
            $date = Carbon::create($year, $m, 1);
            $stat = $stats->get($m);
                
            $months[] = [
                'month_number' => $m,
                'month_name' => $date->locale('id')->translatedFormat('F'),
                'total_in' => $stat ? $stat->total_in : 0,
                'total_out' => $stat ? $stat->total_out : 0,
                'trx_count' => $stat ? $stat->trx_count : 0,
            ];
        }
        
        return view('reports.index', compact('months', 'year'));
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $year = request('year', date('Y'));
        $month = intval($id);
        
        if ($month < 1 || $month > 12) {
            abort(404);
        }
        
        $monthName = Carbon::create($year, $month, 1)->locale('id')->translatedFormat('F');
        
        $firstDayOfMonth = Carbon::create($year, $month, 1)->startOfDay();
        
        $stokAwal = \App\Models\Transaction::selectRaw('
            SUM(CASE WHEN trx_type = "masuk" THEN quantity ELSE 0 END) as masuk,
            SUM(CASE WHEN trx_type = "keluar" THEN quantity ELSE 0 END) as keluar
        ')->where('trx_date', '<', $firstDayOfMonth)->first();
            
        $stokAkhirBulanLalu = ($stokAwal->masuk ?? 0) - ($stokAwal->keluar ?? 0);

        $transactionsMasuk = \App\Models\Transaction::with(['variety'])
            ->where('trx_type', 'masuk')
            ->whereYear('trx_date', $year)
            ->whereMonth('trx_date', $month)
            ->orderBy('trx_date', 'asc')
            ->get();

        $transactionsKeluar = \App\Models\Transaction::with(['variety'])
            ->where('trx_type', 'keluar')
            ->whereYear('trx_date', $year)
            ->whereMonth('trx_date', $month)
            ->orderBy('trx_date', 'asc')
            ->get();
            
        // Generate Analytics Data
        $daysInMonth = Carbon::create($year, $month, 1)->daysInMonth;
        $labels = [];
        $masukData = [];
        $keluarData = [];
        
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $labels[] = strval($i);
            $masukData[] = 0;
            $keluarData[] = 0;
        }

        foreach ($transactionsMasuk as $trx) {
            $dayIndex = intval(Carbon::parse($trx->trx_date)->format('d')) - 1;
            $masukData[$dayIndex] += floatval($trx->quantity);
        }

        foreach ($transactionsKeluar as $trx) {
            $dayIndex = intval(Carbon::parse($trx->trx_date)->format('d')) - 1;
            $keluarData[$dayIndex] += floatval($trx->quantity);
        }

        $chartConfig = [
            'type' => 'line',
            'data' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Masuk (kg)',
                        'data' => $masukData,
                        'borderColor' => '#16a34a',
                        'backgroundColor' => 'transparent',
                        'fill' => false,
                        'borderWidth' => 2,
                    ],
                    [
                        'label' => 'Keluar (kg)',
                        'data' => $keluarData,
                        'borderColor' => '#ef4444',
                        'backgroundColor' => 'transparent',
                        'fill' => false,
                        'borderWidth' => 2,
                    ]
                ]
            ],
            'options' => [
                'title' => [
                    'display' => true,
                    'text' => 'Perbandingan Transaksi Harian (' . $monthName . ' ' . $year . ')'
                ],
                'legend' => [ 'position' => 'bottom' ]
            ]
        ];

        // Fetch quickchart image and encode as base64 to embed securely in dompdf
        $chartUrlRaw = 'https://quickchart.io/chart?c=' . urlencode(json_encode($chartConfig)) . '&w=700&h=300&bkg=white';
        
        $ctx = stream_context_create(['http' => ['timeout' => 5]]);
        $chartContents = @file_get_contents($chartUrlRaw, false, $ctx);
        $chartUrl = $chartContents ? 'data:image/png;base64,' . base64_encode($chartContents) : null;

        $transactionsPenjualan = $transactionsKeluar->where('category', 'penjualan');
        $transactionsDiseminasi = $transactionsKeluar->where('category', 'diseminasi');

        $pdf =  Pdf::loadView('reports.pdf', compact('transactionsMasuk', 'transactionsKeluar', 'transactionsPenjualan', 'transactionsDiseminasi', 'monthName', 'year', 'chartUrl', 'stokAkhirBulanLalu'));
        $pdf->setPaper('A4', 'portrait');
        
        $pdfFileName = "Laporan_Bulanan_{$monthName}_{$year}.pdf";
        return $pdf->download($pdfFileName);
    }
}
