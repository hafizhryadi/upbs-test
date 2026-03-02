<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Transaction;
use App\Models\Variety;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $total_varieties = Variety::count();
        $total_stock = Inventory::sum('quantity');
        $recent_transactions = Transaction::with('inventory.variety')->latest()->take(5)->get();
        
        $stock_by_expiry = Inventory::selectRaw('variety_id, expiry_date, SUM(quantity) as total_quantity')
            ->with('variety')
            ->groupBy('variety_id', 'expiry_date')
            ->orderBy('expiry_date')
            ->get();

        $low_stock_count = $stock_by_expiry->filter(function($item) {
            return $item->total_quantity < 100 || \Carbon\Carbon::parse($item->expiry_date)->isPast() || \Carbon\Carbon::parse($item->expiry_date)->lte(now()->addMonths(3));
        })->count();

        $trx_in = Transaction::where('trx_type', 'masuk')->count();
        $trx_out = Transaction::where('trx_type', 'keluar')->count();

        return view('welcome', compact('total_varieties', 'total_stock', 'recent_transactions', 'stock_by_expiry', 'low_stock_count', 'trx_in', 'trx_out'));
    }
}
