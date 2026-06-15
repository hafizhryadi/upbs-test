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
    public function index(Request $request)
    {
        $query = Inventory::with(['variety', 'location'])->latest();

        $search = $request->get('search');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('batch_code', 'like', "%{$search}%")
                  ->orWhereHas('variety', function($qVariety) use ($search) {
                      $qVariety->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $inventories = $query->get();

        $statusFilter = $request->get('status');
        if ($statusFilter && $statusFilter !== 'all') {
            $inventories = $inventories->filter(function($item) use ($statusFilter) {
                return $item->expiry_status === $statusFilter;
            });
        } elseif (!$statusFilter) {
            $inventories = $inventories->filter(function($item) {
                return $item->quantity > 0;
            });
        }

        $sortBy = $request->get('sort_by');
        $order = $request->get('order', 'asc');

        if ($sortBy) {
            $callback = function($item) use ($sortBy) {
                if ($sortBy == 'variety') return $item->variety->name ?? '';
                if ($sortBy == 'location') return $item->location->name ?? '';
                return $item->$sortBy;
            };

            if ($order === 'desc') {
                $inventories = $inventories->sortByDesc($callback);
            } else {
                $inventories = $inventories->sortBy($callback);
            }
        }

        return view('inventories.index', compact('inventories'));
    }

    /**
     * Display public stock grouping by variety.
     */
    public function publicStok()
    {
        $stocks = Inventory::selectRaw('variety_id, expiry_date, SUM(quantity) as total_quantity')
            ->where('expiry_date', '>=', now()->toDateString())
            ->where('quantity', '>', 0)
            ->with('variety')
            ->groupBy('variety_id', 'expiry_date')
            ->havingRaw('SUM(quantity) > 0')
            ->orderBy('expiry_date', 'asc')
            ->get();
            
        return view('stok', compact('stocks'));
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
            'quantity' => 'required|integer|min:0',
        ]);
        if ($validated['quantity'] == 0) {
            return redirect()->route('inventories.index')->with('success', 'Inventory tidak disimpan karena kuantitas bernilai 0.');
        }

        $validated['batch_code'] = 'BATCH-' . strtoupper(\Illuminate\Support\Str::random(8));
        
        Inventory::create($validated);
        return redirect()->route('inventories.index')->with('success', 'Inventory created successfully.');
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
