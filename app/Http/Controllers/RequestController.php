<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requests = \App\Models\Request::latest()->paginate(10);
        return view('requests.index', compact('requests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('requests.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'kelompok_tani' => 'required|string|max:255',
            'alamat' => 'required|string',
            'benih' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'rencana_tanam' => 'required|string|max:255',
            'lokasi_lahan' => 'required|string|max:255',
            'luas_lahan' => 'required|integer|min:1',
            'surat_permohonan' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('surat_permohonan')) {
            $file = $request->file('surat_permohonan');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/permohonan'), $filename);
            $validated['surat_permohonan'] = 'uploads/permohonan/' . $filename;
        }

        \App\Models\Request::create($validated);

        return redirect()->route('request.success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $request = \App\Models\Request::findOrFail($id);
        $filePath = public_path($request->surat_permohonan);

        if (file_exists($filePath)) {
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
            $cleanName = 'Surat_Permohonan_' . preg_replace('/[^A-Za-z0-9\-]/', '_', $request->nama) . '.' . $extension;
            return response()->download($filePath, $cleanName);
        }

        return redirect()->route('request.index')->with('error', 'File tidak ditemukan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
