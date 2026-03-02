<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $year = request('year', date('Y'));
        $months = [];
        
        for ($m = 1; $m <= 12; $m++) {
            $date = \Carbon\Carbon::create($year, $m, 1);
            
            // Get stats for this month
            $totalIn = \App\Models\Transaction::where('trx_type', 'masuk')
                ->whereYear('trx_date', $year)
                ->whereMonth('trx_date', $m)
                ->sum('quantity');
                
            $totalOut = \App\Models\Transaction::where('trx_type', 'keluar')
                ->whereYear('trx_date', $year)
                ->whereMonth('trx_date', $m)
                ->sum('quantity');
                
            $trxCount = \App\Models\Transaction::whereYear('trx_date', $year)
                ->whereMonth('trx_date', $m)
                ->count();
                
            $months[] = [
                'month_number' => $m,
                'month_name' => $date->translatedFormat('F'),
                'total_in' => $totalIn,
                'total_out' => $totalOut,
                'trx_count' => $trxCount,
            ];
        }
        
        return view('reports.index', compact('months', 'year'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        
        $monthName = \Carbon\Carbon::create($year, $month, 1)->translatedFormat('F');
        $transactions = \App\Models\Transaction::with(['inventory.variety', 'inventory.location'])
            ->whereYear('trx_date', $year)
            ->whereMonth('trx_date', $month)
            ->orderBy('trx_date', 'asc')
            ->get();
            
        // Generate Analytics Data
        $daysInMonth = \Carbon\Carbon::create($year, $month, 1)->daysInMonth;
        $labels = [];
        $masukData = [];
        $keluarData = [];
        
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $labels[] = strval($i);
            $masukData[] = 0;
            $keluarData[] = 0;
        }

        foreach ($transactions as $trx) {
            $dayIndex = intval(\Carbon\Carbon::parse($trx->trx_date)->format('d')) - 1;
            if ($trx->trx_type == 'masuk') {
                $masukData[$dayIndex] += floatval($trx->quantity);
            } else {
                $keluarData[$dayIndex] += floatval($trx->quantity);
            }
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

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.pdf', compact('transactions', 'monthName', 'year', 'chartUrl'));
        $pdf->setPaper('A4', 'portrait');
        
        $pdfFileName = "Laporan_Bulanan_{$monthName}_{$year}.pdf";
        return $pdf->download($pdfFileName);
    }
}
