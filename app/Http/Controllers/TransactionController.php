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
        $query = Transaction::with(['variety', 'inventory'])->latest();

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
        $varieties = Variety::all();
        
        $inventories = Inventory::with('variety')
            ->where('quantity', '>', 0)
            ->orderBy('expiry_date', 'asc')
            ->get();
            
        $locations = Location::all();

        return view('transactions.create', compact('varieties', 'inventories', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'trx_type' => 'required|in:masuk,keluar',
            'trx_date' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string',
            'variety_id' => 'required_if:trx_type,masuk|nullable|exists:varieties,id',
            'location_id' => 'required_if:trx_type,masuk|nullable|exists:locations,id',
            'batch_code' => 'nullable|string|max:255',
            'expiry_date' => 'required_if:trx_type,masuk|nullable|date',
            'inventory_id' => 'required_if:trx_type,keluar|nullable|exists:inventories,id',
            'category' => 'required_if:trx_type,keluar|nullable|in:penjualan,diseminasi,penyesuaian',
        ]);

        $requestedQuantity = $validated['quantity'];

        if ($validated['trx_type'] == 'masuk') {
            $batchCode = $validated['batch_code'] ?? 'BATCH-' . strtoupper(\Illuminate\Support\Str::random(8));

            // Create Inventory
            $inventory = Inventory::create([
                'variety_id' => $validated['variety_id'],
                'location_id' => $validated['location_id'],
                'batch_code' => $batchCode,
                'expiry_date' => $validated['expiry_date'],
                'quantity' => $requestedQuantity,
            ]);

            // Create Transaction
            Transaction::create([
                'variety_id' => $validated['variety_id'],
                'inventory_id' => $inventory->id,
                'trx_date' => $validated['trx_date'],
                'trx_type' => 'masuk',
                'category' => null,
                'quantity' => $requestedQuantity,
                'note' => $validated['note'],
            ]);

            return redirect()->route('transactions.index')->with('success', 'Transaksi masuk berhasil dicatat dan stok ditambahkan.');
        } else if ($validated['trx_type'] == 'keluar') {
            $inventory = Inventory::findOrFail($validated['inventory_id']);

            if ($inventory->quantity < $requestedQuantity) {
                return back()->withErrors(['quantity' => 'Stok tidak mencukupi di Batch/Lot ini. Total sisa stok: ' . $inventory->quantity . ' kg'])->withInput();
            }

            // Deduct stock
            $inventory->decrement('quantity', $requestedQuantity);

            // Create transaction record
            Transaction::create([
                'variety_id' => $inventory->variety_id,
                'inventory_id' => $inventory->id,
                'trx_date' => $validated['trx_date'],
                'trx_type' => 'keluar',
                'category' => $validated['category'],
                'quantity' => $requestedQuantity,
                'note' => $validated['note'],
            ]);

            return redirect()->route('transactions.index')->with('success', 'Transaksi keluar berhasil disimpan dan stok dikurangi dari Lot/Batch yang dipilih.');
        }
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

            // 1. Revert old transaction
            $inventoryToRevert = Inventory::find($transaction->inventory_id);

            if ($inventoryToRevert) {
                $inventoryToRevert->increment('quantity', $transaction->quantity);
            }

            // 2. Apply new transaction quantity
            if ($inventoryToRevert && $inventoryToRevert->quantity < $requestedQuantity) {
                // Re-apply old transaction to restore state
                $inventoryToRevert->decrement('quantity', $transaction->quantity);
                return back()->withErrors(['quantity' => 'Stok tidak mencukupi untuk perubahan ini.'])->withInput();
            }
            
            if ($inventoryToRevert) {
                $inventoryToRevert->decrement('quantity', $requestedQuantity);
            }
            
            $transaction->update($validated);
            return redirect()->route('transactions.index')->with('success', 'Transaksi keluar diperbarui dan stok disesuaikan.');
        } else {
            // For 'masuk' transaction, we just update the transaction log and adjust the related inventory.
            $diff = $requestedQuantity - $transaction->quantity;
            $inventoryToAdjust = Inventory::find($transaction->inventory_id);

            if ($inventoryToAdjust) {
                $inventoryToAdjust->increment('quantity', $diff);
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
        $inventoryToRevert = Inventory::find($transaction->inventory_id);
            
        if ($inventoryToRevert) {
            if ($transaction->trx_type == 'keluar') {
                $inventoryToRevert->increment('quantity', $transaction->quantity);
            } else {
                $inventoryToRevert->decrement('quantity', min($inventoryToRevert->quantity, $transaction->quantity));
            }
        }

        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaksi dihapus dan stok dikembalikan.');
    }
}
