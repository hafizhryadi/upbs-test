<?php

namespace App\Http\Controllers;

use App\Models\Request as RequestModel;
use App\Models\Variety;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requests = RequestModel::with('variety')->latest()->paginate(10);
        return view('requests.index', compact('requests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $varieties = Variety::orderBy('name')->get();
        return view('requests.create', compact('varieties'));
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
            'alamat' => 'required|string',
            'variety_id' => 'required|exists:varieties,id',
            'jumlah' => 'required|integer|min:1',
            'jenis' => 'required|in:pembelian,diseminasi',
            'surat_permohonan' => 'required_if:jenis,diseminasi|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('surat_permohonan')) {
            $file = $request->file('surat_permohonan');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/permohonan'), $filename);
            $validated['surat_permohonan'] = 'uploads/permohonan/' . $filename;
        } else {
            $validated['surat_permohonan'] = null;
        }

        RequestModel::create($validated);

        return redirect()->route('request.success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $request = RequestModel::findOrFail($id);
        
        if (!$request->surat_permohonan) {
            return redirect()->route('request.index')->with('error', 'Tidak ada surat permohonan untuk permohonan ini.');
        }

        $filePath = public_path($request->surat_permohonan);

        if (file_exists($filePath)) {
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
            $cleanName = 'Surat_Permohonan_' . preg_replace('/[^A-Za-z0-9\-]/', '_', $request->nama) . '.' . $extension;
            return response()->download($filePath, $cleanName);
        }

        return redirect()->route('request.index')->with('error', 'File tidak ditemukan.');
    }

    public function updateStatus(Request $request, string $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,disetujui,ditolak',
        ]);

        $requestModel = RequestModel::findOrFail($id);
        $requestModel->status = $validated['status'];
        $requestModel->save();

        return redirect()->back()->with('success', 'Status permohonan berhasil diperbarui.');
    }


}
