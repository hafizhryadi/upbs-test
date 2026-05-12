<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Inventory;
use App\Models\Variety;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::with('variety')->latest()->get();
        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $varieties = Variety::with(['inventories' => function($q) {
            $q->where('quantity', '>', 0)->where('status', '!=', 'expired');
        }])->get()->filter(function($variety) {
            return $variety->inventories->sum('quantity') > 0;
        });

        return view('transactions.create', compact('varieties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'variety_id' => 'required|exists:varieties,id',
            'trx_date' => 'required|date',
            'category' => 'required|in:penjualan,diseminasi',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string',
        ]);

        $varietyId = $validated['variety_id'];
        $requestedQuantity = $validated['quantity'];

        // Get available inventories for this variety, ordered by expiry date (FEFO)
        $inventories = Inventory::where('variety_id', $varietyId)
            ->where('quantity', '>', 0)
            ->where('status', '!=', 'expired')
            ->orderBy('expiry_date', 'asc')
            ->get();

        $totalAvailable = $inventories->sum('quantity');

        if ($totalAvailable < $requestedQuantity) {
            return back()->withErrors(['quantity' => 'Stok tidak mencukupi. Total sisa stok varietas ini: ' . $totalAvailable . ' kg'])->withInput();
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
            'category' => $validated['category'],
            'quantity' => $requestedQuantity,
            'note' => $validated['note'],
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan dan stok otomatis dikurangi (Sistem FEFO).');
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
        // We generally don't want to allow changing the inventory item itself on edit to avoid complex logic
        // But for this simple app, we can just show the current one or allow note edits.
        // For full flexibility, we'd need to reverse old stock and apply new stock.
        
        return view('transactions.edit', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'trx_date' => 'required|date',
            'category' => 'required|in:penjualan,diseminasi',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string',
        ]);

        $transaction = Transaction::findOrFail($id);
        $varietyId = $transaction->variety_id;

        // 1. Revert old transaction: Add back to the newest inventory batch for this variety
        $newestInventory = Inventory::where('variety_id', $varietyId)->orderBy('created_at', 'desc')->first();
        if ($newestInventory) {
            $newestInventory->increment('quantity', $transaction->quantity);
        }

        // 2. Apply new transaction using FEFO
        $requestedQuantity = $validated['quantity'];
        
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
            return back()->withErrors(['quantity' => 'Stok tidak mencukupi untuk perubahan ini. Total sisa stok varietas ini: ' . $totalAvailable . ' kg'])->withInput();
        }
        
        $remainingQuantity = $requestedQuantity;

        foreach ($inventories as $inventory) {
            if ($remainingQuantity <= 0) break;

            $takeQuantity = min($inventory->quantity, $remainingQuantity);
            $inventory->decrement('quantity', $takeQuantity);
            $remainingQuantity -= $takeQuantity;
        }

        $transaction->update($validated);
        
        return redirect()->route('transactions.index')->with('success', 'Transaksi diperbarui dan stok disesuaikan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaction = Transaction::findOrFail($id);
        $varietyId = $transaction->variety_id;

        // Revert stock (add back to newest inventory)
        $newestInventory = Inventory::where('variety_id', $varietyId)->orderBy('created_at', 'desc')->first();
        if ($newestInventory) {
            $newestInventory->increment('quantity', $transaction->quantity);
        }

        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaksi dihapus dan stok dikembalikan.');
    }
}
