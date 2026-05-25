<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Inventory;
use App\Models\Variety;
use App\Models\Location;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Transaction::with('variety')->latest();

        if ($request->filled('start_date')) {
            $query->whereDate('trx_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('trx_date', '<=', $request->end_date);
        }

        $transactions = $query->get();

        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $varieties = Variety::with(['inventories' => function($q) {
            $q->where('quantity', '>', 0)->where('status', '!=', 'expired');
        }])->get();
        
        $locations = Location::all();

        return view('transactions.create', compact('varieties', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'trx_type' => 'required|in:masuk,keluar',
            'variety_id' => 'required|exists:varieties,id',
            'trx_date' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string',
        ]);

        $varietyId = $validated['variety_id'];
        $requestedQuantity = $validated['quantity'];

        if ($validated['trx_type'] == 'masuk') {
            $masukValidated = $request->validate([
                'location_id' => 'required|exists:locations,id',
                'expiry_date' => 'required|date',
                'status' => 'required|in:ready,packing,hold,expired',
            ]);

            // Create Inventory (type will use default from schema or be omitted since it's merged)
            $inventory = Inventory::create([
                'variety_id' => $varietyId,
                'location_id' => $masukValidated['location_id'],
                'batch_code' => 'BATCH-' . strtoupper(\Illuminate\Support\Str::random(8)),
                'expiry_date' => $masukValidated['expiry_date'],
                'status' => $masukValidated['status'],
                'quantity' => $requestedQuantity,
            ]);

            // Create Transaction
            Transaction::create([
                'variety_id' => $varietyId,
                'trx_date' => $validated['trx_date'],
                'trx_type' => 'masuk',
                'category' => null, // category is only for keluar based on user requirements
                'quantity' => $requestedQuantity,
                'note' => $validated['note'],
            ]);

            return redirect()->route('transactions.index')->with('success', 'Transaksi masuk berhasil dicatat dan stok ditambahkan.');
        } else {
            $keluarValidated = $request->validate([
                'category' => 'required|in:penjualan,diseminasi',
            ]);

            // Get available inventories for this variety, ordered by expiry date (FEFO)
            $inventories = Inventory::where('variety_id', $varietyId)
                ->where('quantity', '>', 0)
                ->where('status', '!=', 'expired')
                ->orderBy('expiry_date', 'asc')
                ->get();

            $totalAvailable = $inventories->sum('quantity');

            if ($totalAvailable < $requestedQuantity) {
                return back()->withErrors(['quantity' => 'Stok tidak mencukupi. Total sisa stok kelas benih ini: ' . $totalAvailable . ' kg'])->withInput();
            }

            $remainingQuantity = $requestedQuantity;

            foreach ($inventories as $inventory) {
                if ($remainingQuantity <= 0) {
                    break;
                }

                $takeQuantity = min($inventory->quantity, $remainingQuantity);
                
                // Deduct stock
                $inventory->decrement('quantity', $takeQuantity);
                $remainingQuantity -= $takeQuantity;
            }

            // Create exactly 1 transaction record
            Transaction::create([
                'variety_id' => $varietyId,
                'trx_date' => $validated['trx_date'],
                'trx_type' => 'keluar',
                'category' => $keluarValidated['category'],
                'quantity' => $requestedQuantity,
                'note' => $validated['note'],
            ]);

            return redirect()->route('transactions.index')->with('success', 'Transaksi keluar berhasil disimpan dan stok otomatis dikurangi (Sistem FEFO).');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $transaction = Transaction::with('variety')->findOrFail($id);
        $varieties = Variety::all();
        $locations = Location::all();
        
        return view('transactions.edit', compact('transaction', 'varieties', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'trx_date' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string',
        ]);

        $transaction = Transaction::findOrFail($id);
        $varietyId = $transaction->variety_id;
        $requestedQuantity = $validated['quantity'];

        if ($transaction->trx_type == 'keluar') {
            $keluarValidated = $request->validate([
                'category' => 'required|in:penjualan,diseminasi',
            ]);
            $validated['category'] = $keluarValidated['category'];

            // 1. Revert old transaction: Add back to the newest inventory batch for this variety
            $newestInventory = Inventory::where('variety_id', $varietyId)
                ->orderBy('created_at', 'desc')->first();
            if ($newestInventory) {
                $newestInventory->increment('quantity', $transaction->quantity);
            }

            // 2. Apply new transaction using FEFO
            $inventories = Inventory::where('variety_id', $varietyId)
                ->where('quantity', '>', 0)
                ->where('status', '!=', 'expired')
                ->orderBy('expiry_date', 'asc')
                ->get();

            $totalAvailable = $inventories->sum('quantity');

            if ($totalAvailable < $requestedQuantity) {
                // Re-apply old transaction to restore state
                if ($newestInventory) {
                    $newestInventory->decrement('quantity', $transaction->quantity);
                }
                return back()->withErrors(['quantity' => 'Stok tidak mencukupi untuk perubahan ini. Total sisa stok: ' . $totalAvailable . ' kg'])->withInput();
            }
            
            $remainingQuantity = $requestedQuantity;

            foreach ($inventories as $inventory) {
                if ($remainingQuantity <= 0) break;

                $takeQuantity = min($inventory->quantity, $remainingQuantity);
                $inventory->decrement('quantity', $takeQuantity);
                $remainingQuantity -= $takeQuantity;
            }
            
            $transaction->update($validated);
            return redirect()->route('transactions.index')->with('success', 'Transaksi keluar diperbarui dan stok disesuaikan.');
        } else {
            // For 'masuk' transaction, we just update the transaction log.
            $diff = $requestedQuantity - $transaction->quantity;
            $newestInventory = Inventory::where('variety_id', $varietyId)
                ->orderBy('created_at', 'desc')->first();
            if ($newestInventory) {
                $newestInventory->increment('quantity', $diff);
            }
            
            $transaction->update($validated);
            return redirect()->route('transactions.index')->with('success', 'Transaksi masuk diperbarui.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaction = Transaction::findOrFail($id);
        $varietyId = $transaction->variety_id;

        // Revert stock
        $newestInventory = Inventory::where('variety_id', $varietyId)
            ->orderBy('created_at', 'desc')->first();
            
        if ($newestInventory) {
            if ($transaction->trx_type == 'keluar') {
                $newestInventory->increment('quantity', $transaction->quantity);
            } else {
                $newestInventory->decrement('quantity', min($newestInventory->quantity, $transaction->quantity));
            }
        }

        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaksi dihapus dan stok dikembalikan.');
    }
}
