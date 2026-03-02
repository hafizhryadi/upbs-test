<?php

namespace App\Http\Controllers;

use App\Models\Variety;
use Illuminate\Http\Request;

class VarietyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $varieties = Variety::all();
        return view('varieties.index', compact('varieties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('varieties.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Variety::create($validatedData);

        return redirect()->route('varieties.index')->with('success', 'Variety created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $variety = Variety::findOrFail($id);
        return view('varieties.edit', compact('variety'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $variety = Variety::findOrFail($id);
        $variety->update($validatedData);

        return redirect()->route('varieties.index')->with('success', 'Variety updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $variety = Variety::findOrFail($id);
        $variety->delete();

        return redirect()->route('varieties.index')->with('success', 'Variety deleted successfully.');
    }
}
