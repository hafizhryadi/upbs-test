<?php

namespace App\Http\Controllers;

use App\Models\Variety;
use Illuminate\Http\Request;

class VarietyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Variety::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%");
        }

        $varieties = $query->latest()->get();
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
            'name' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('varieties')->where(function ($query) use ($request) {
                    return $query->where('type', $request->type);
                })
            ],
            'type' => 'required|in:FS,SS,ES',
            'description' => 'nullable|string',
        ], [
            'name.unique' => 'Kombinasi nama dan tipe varietas ini sudah terdaftar.'
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
            'name' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('varieties')->where(function ($query) use ($request) {
                    return $query->where('type', $request->type);
                })->ignore($id)
            ],
            'type' => 'required|in:FS,SS,ES',
            'description' => 'nullable|string',
        ], [
            'name.unique' => 'Kombinasi nama dan tipe varietas ini sudah terdaftar.'
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
