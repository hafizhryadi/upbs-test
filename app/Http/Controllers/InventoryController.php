<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Variety;
use App\Models\Location;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventories = Inventory::with(['variety', 'location'])->get();
        return view('inventories.index', compact('inventories'));
    }

    /**
     * Display public stock grouping by variety.
     */
    public function publicStok()
    {
        $stocks = Inventory::selectRaw('variety_id, expiry_date, SUM(quantity) as total_quantity')
            ->with('variety')
            ->groupBy('variety_id', 'expiry_date')
            ->orderBy('expiry_date', 'asc')
            ->get();
            
        return view('public.stok', compact('stocks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $varieties = Variety::all();
        $locations = Location::all();
        return view('inventories.create', compact('varieties', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'variety_id' => 'required|exists:varieties,id',
            'location_id' => 'required|exists:locations,id',
            'expiry_date' => 'required|date',
            'status' => 'required|in:ready,packing,hold,expired',
            'quantity' => 'required|integer|min:0',
        ]);
        
        $validated['batch_code'] = 'BATCH-' . strtoupper(\Illuminate\Support\Str::random(8));
        
        Inventory::create($validated);
        return redirect()->route('inventories.index')->with('success', 'Inventory created successfully.');
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
        $inventory = Inventory::findOrFail($id);
        $varieties = Variety::all();
        $locations = Location::all();
        return view('inventories.edit', compact('inventory', 'varieties', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'variety_id' => 'required|exists:varieties,id',
            'location_id' => 'required|exists:locations,id',
            'expiry_date' => 'required|date',
            'status' => 'required|in:ready,packing,hold,expired',
            'quantity' => 'required|integer|min:0',
        ]);
        $inventory = Inventory::findOrFail($id);
        $inventory->update($validated);
        return redirect()->route('inventories.index')->with('success', 'Inventory updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();
        return redirect()->route('inventories.index')->with('success', 'Inventory deleted successfully.');
    }
}
