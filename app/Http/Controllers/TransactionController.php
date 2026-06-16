<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Inventory;
use App\Models\Variety;
use App\Models\Location;
use Illuminate\Support\Facades\DB;

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

        try {
            DB::transaction(function () use ($validated, $requestedQuantity) {
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
                } else if ($validated['trx_type'] == 'keluar') {
                    // Lock the row for update to prevent race conditions
                    $inventory = Inventory::where('id', $validated['inventory_id'])->lockForUpdate()->firstOrFail();

                    if ($inventory->quantity < $requestedQuantity) {
                        throw new \Exception('Stok tidak mencukupi di Batch/Lot ini. Total sisa stok: ' . $inventory->quantity . ' kg');
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
                }
            });

            $msg = $validated['trx_type'] == 'masuk' 
                ? 'Transaksi masuk berhasil dicatat dan stok ditambahkan.' 
                : 'Transaksi keluar berhasil disimpan dan stok dikurangi dari Lot/Batch yang dipilih.';
            return redirect()->route('transactions.index')->with('success', $msg);

        } catch (\Exception $e) {
            return back()->withErrors(['quantity' => $e->getMessage()])->withInput();
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::transaction(function () use ($id) {
                $transaction = Transaction::lockForUpdate()->findOrFail($id);

                if ($transaction->trx_type == 'masuk') {
                    // Check if this inventory has been used by any 'keluar' transactions
                    $keluarCount = Transaction::where('inventory_id', $transaction->inventory_id)
                        ->where('trx_type', 'keluar')
                        ->count();

                    if ($keluarCount > 0) {
                        throw new \Exception('Tidak dapat menghapus transaksi masuk ini karena stoknya sudah digunakan pada transaksi keluar.');
                    }

                    // If not used, we can delete the transaction AND the spawned inventory
                    $inventory = Inventory::where('id', $transaction->inventory_id)->lockForUpdate()->first();
                    $transaction->delete();
                    if ($inventory) {
                        $inventory->delete();
                    }
                } else {
                    // It's a 'keluar' transaction, we revert the stock back to the inventory
                    $inventory = Inventory::where('id', $transaction->inventory_id)->lockForUpdate()->first();
                    if ($inventory) {
                        $inventory->increment('quantity', $transaction->quantity);
                    }
                    $transaction->delete();
                }
            });

            return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus dan stok disesuaikan.');
        } catch (\Exception $e) {
            return redirect()->route('transactions.index')->with('error', $e->getMessage());
        }
    }
}
