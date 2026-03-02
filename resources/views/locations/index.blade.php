@extends('layouts.app')

@section('title', 'Manajemen Lokasi')

@section('content')
<div class="mb-8">
    <h2 class="text-[28px] font-bold text-slate-800 tracking-tight leading-tight">Manajemen Lokasi</h2>
    <p class="text-slate-600 mt-1 text-base">Kelola data gudang penyimpanan benih</p>
</div>

<div class="bg-white rounded-[16px] border border-slate-200 shadow-sm overflow-hidden">
    <!-- Card Header -->
    <div class="p-6 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center">
            <div class="text-[#10b981] mr-3 font-bold">
                <i class="bi bi-geo-alt text-[24px]"></i>
            </div>
            <h3 class="text-[20px] font-bold text-[#10b981]">Daftar Lokasi Gudang</h3>
        </div>
        
        <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
            <div class="relative w-full sm:w-[320px]">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <i class="bi bi-search text-slate-400"></i>
                </div>
                <input type="text" class="bg-slate-100 border-none text-slate-800 text-[14px] rounded-lg focus:ring-2 focus:ring-[#10b981] w-full pl-10 px-4 py-2.5 transition-all outline-none font-medium placeholder-slate-400" placeholder="Cari lokasi atau deskripsi">
            </div>
            <a href="{{ route('locations.create') }}" class="w-full sm:w-auto bg-[#16a34a] hover:bg-[#15803d] text-white font-bold rounded-lg text-[14px] px-5 py-2.5 text-center transition-colors shadow-sm flex items-center justify-center">
                <i class="bi bi-plus text-lg mr-1"></i> Tambah Lokasi
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-slate-700">
            <thead class="text-[14px] text-slate-800 bg-white border-b border-slate-200">
                <tr>
                    <th scope="col" class="px-8 py-5 font-bold w-24">ID</th>
                    <th scope="col" class="px-8 py-5 font-bold">Nama Lokasi</th>
                    <th scope="col" class="px-8 py-5 font-bold">Alamat</th>
                    <th scope="col" class="px-8 py-5 font-bold text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($locations as $index => $location)
                    <tr class="bg-white border-b border-slate-100 hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-5 font-bold text-slate-800 text-[14px]">
                            {{ str_pad($loop->iteration, 3, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-8 py-5 font-medium text-[14px]">
                            {{ $location->name }}
                        </td>
                        <td class="px-8 py-5 text-slate-600 text-[14px]">
                            {{ $location->address }}
                        </td>
                        <td class="px-8 py-5 text-center">
                            <div class="flex items-center justify-center gap-4">
                                <a href="{{ route('locations.edit', $location->id) }}" class="font-medium text-slate-600 hover:text-slate-900 transition-colors tooltip" title="Edit">
                                    <i class="bi bi-pencil-square text-[18px]"></i>
                                </a>
                                <form action="{{ route('locations.destroy', $location->id) }}" method="POST" class="inline-block m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lokasi ini?');">
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
                        <td colspan="4" class="px-8 py-10 text-center text-slate-500 text-[14px]">
                            Belum ada data lokasi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
