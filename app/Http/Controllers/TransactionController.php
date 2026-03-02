<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Inventory;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::with('inventory.variety')->latest()->get();
        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $inventories = Inventory::with('variety')->where('status', '!=', 'expired')->get();
        return view('transactions.create', compact('inventories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inventory_id' => 'required|exists:inventories,id',
            'trx_date' => 'required|date',
            'trx_type' => 'required|in:masuk,keluar',
            'category' => 'required|in:Produksi,Penjualan,Subsidi,Transfer,Koreksi,Retur',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string',
        ]);

        $inventory = Inventory::findOrFail($validated['inventory_id']);

        if ($validated['trx_type'] == 'keluar') {
            if ($inventory->quantity < $validated['quantity']) {
                return back()->withErrors(['quantity' => 'Stok tidak mencukupi untuk transaksi keluar. Sisa stok: ' . $inventory->quantity])->withInput();
            }
            $inventory->decrement('quantity', $validated['quantity']);
        } else {
            $inventory->increment('quantity', $validated['quantity']);
        }

        Transaction::create($validated);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan dan stok diperbarui.');
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
        $transaction = Transaction::with('inventory.variety')->findOrFail($id);
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
            'trx_type' => 'required|in:masuk,keluar',
            'category' => 'required|in:Produksi,Penjualan,Subsidi,Transfer,Koreksi,Retur',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string',
        ]);

        $transaction = Transaction::findOrFail($id);
        $inventory = $transaction->inventory;

        // 1. Revert old transaction
        if ($transaction->trx_type == 'keluar') {
            $inventory->increment('quantity', $transaction->quantity);
        } else {
            // If it was 'masuk', we remove the added stock
            // Check if removing it makes stock negative (though 'masuk' usually adds, removing it might reveal we oversold?)
            if ($inventory->quantity < $transaction->quantity) {
                 // This is a rare edge case: we added stock, sold it, and now try to reduce the initial add? 
                 // For now, let's allow it but warn or block?
                 // Let's block if it makes stock negative
                 return back()->withErrors(['quantity' => 'Tidak dapat mengubah transaksi Masuk ini karena stok saat ini sudah kurang dari jumlah awal.'])->withInput();
            }
            $inventory->decrement('quantity', $transaction->quantity);
        }

        // 2. Apply new transaction
        if ($validated['trx_type'] == 'keluar') {
             if ($inventory->quantity < $validated['quantity']) {
                // Re-apply old transaction to restore state before failing?
                // Or just fail. If we fail here, the model is already dirty in memory but not saved?
                // No, we called increment/decrement on the model instance and it SAVES immediately in Laravel unless we use local logic.
                // Eloquent increment/decrement persists to DB.
                // WE SHOULD USE DB TRANSACTION or manual attribute update.
                
                // Fix strategy:
                // Rollback the revert manually?
                if ($transaction->trx_type == 'keluar') {
                    $inventory->decrement('quantity', $transaction->quantity);
                } else {
                    $inventory->increment('quantity', $transaction->quantity);
                }
                return back()->withErrors(['quantity' => 'Stok tidak mencukupi untuk perubahan ini.'])->withInput();
            }
            $inventory->decrement('quantity', $validated['quantity']);
        } else {
            $inventory->increment('quantity', $validated['quantity']);
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
        $inventory = $transaction->inventory;

        // Revert stock
        if ($transaction->trx_type == 'keluar') {
            $inventory->increment('quantity', $transaction->quantity);
        } else {
            if ($inventory->quantity < $transaction->quantity) {
                return back()->withErrors(['error' => 'Gagal menghapus transaksi masuk: Stok saat ini lebih kecil dari jumlah transaksi (mungkin sudah terpakai).']);
            }
            $inventory->decrement('quantity', $transaction->quantity);
        }

        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaksi dihapus dan stok dikembalikan.');
    }
}
