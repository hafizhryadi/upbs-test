@extends('layouts.app')

@section('title', 'Manajemen Varietas')

@section('content')
<div class="mb-8">
    <h2 class="text-[28px] font-bold text-slate-800 tracking-tight leading-tight">Manajemen Varietas</h2>
    <p class="text-slate-600 mt-1 text-base">Kelola data varietas benih padi</p>
</div>

<div class="bg-white rounded-[16px] border border-slate-200 shadow-sm overflow-hidden">
    <!-- Card Header -->
    <div class="p-6 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center">
            <div class="text-[#10b981] mr-3 font-bold">
                <i class="bi bi-flower1 text-[24px]"></i>
            </div>
            <h3 class="text-[20px] font-bold text-[#10b981]">Daftar Varietas Benih</h3>
        </div>
        
        <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
            <form action="{{ route('varieties.index') }}" method="GET" class="relative w-full sm:w-[320px]">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <i class="bi bi-search text-slate-400"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" class="bg-slate-100 border-none text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] w-full pl-10 px-4 py-2.5 transition-all outline-none font-medium placeholder-slate-400" placeholder="Cari varietas atau deskripsi">
            </form>
            <a href="{{ route('varieties.create') }}" class="w-full sm:w-auto bg-[#16a34a] hover:bg-[#15803d] text-white font-bold rounded-lg text-[14px] px-5 py-2.5 text-center transition-colors shadow-sm flex items-center justify-center">
                <i class="bi bi-plus text-lg mr-1"></i> Tambah Varietas
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-slate-700">
            <thead class="text-[14px] text-slate-800 bg-white border-b border-slate-200">
                <tr>
                    <th scope="col" class="px-8 py-5 font-bold w-24">No</th>
                    <th scope="col" class="px-8 py-5 font-bold w-56">Nama Varietas</th>
                    <th scope="col" class="px-8 py-5 font-bold w-24">Tipe Varietas</th>
                    <th scope="col" class="px-8 py-5 font-bold">Deskripsi</th>
                    <th scope="col" class="px-8 py-5 font-bold text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($varieties as $index => $variety)
                    <tr class="bg-white border-b border-slate-100 hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-5 font-bold text-slate-800 text-[14px]">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-8 py-5 font-medium text-[14px]">
                            {{ $variety->name }}
                        </td>
                        <td class="px-8 py-5 text-[14px]">
                            @if($variety->type == 'FS')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                    FS
                                </span>
                            @elseif($variety->type == 'SS')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-blue-50 text-blue-600 border border-blue-200">
                                    SS
                                </span>
                            @elseif($variety->type == 'ES')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-600 border border-amber-200">
                                    ES
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-50 text-slate-600 border border-slate-200">
                                    {{ $variety->type }}
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-5 text-slate-600 text-[14px] leading-relaxed">
                            {{ $variety->description }}
                        </td>
                        <td class="px-8 py-5 text-center">
                            <div class="flex items-center justify-center gap-4">
                                <a href="{{ route('varieties.edit', $variety->id) }}" class="font-medium text-slate-600 hover:text-slate-900 transition-colors tooltip" title="Edit">
                                    <i class="bi bi-pencil-square text-[18px]"></i>
                                </a>
                                <form action="{{ route('varieties.destroy', $variety->id) }}" method="POST" class="inline-block m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus varietas ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-red-500 hover:text-red-700 transition-colors tooltip flex items-center" title="Hapus">
                                        <i class="bi bi-trash text-[18px]"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-8 py-10 text-center text-slate-500 text-[14px]">
                            Belum ada data varietas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

