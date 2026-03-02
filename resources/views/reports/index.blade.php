@extends('layouts.app')

@section('title', 'Laporan Bulanan')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h2 class="text-[28px] font-bold text-slate-800 tracking-tight leading-tight">Laporan Bulanan</h2>
        <p class="text-slate-600 mt-1 text-base">Unduh rekapitulasi transaksi masuk dan keluar benih tiap bulan</p>
    </div>
    
    <div class="bg-white rounded-lg border border-slate-200 shadow-sm p-1.5 flex items-center w-full md:w-auto">
        <form action="{{ route('report.index') }}" method="GET" class="flex w-full">
            <select name="year" class="bg-transparent border-none text-slate-700 font-semibold focus:ring-0 cursor-pointer py-1.5 px-3 outline-none" onchange="this.form.submit()">
                @for($y = date('Y') - 2; $y <= date('Y'); $y++)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>Tahun {{ $y }}</option>
                @endfor
            </select>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @foreach($months as $month)
        <div class="bg-white rounded-[16px] border border-slate-200 shadow-sm overflow-hidden flex flex-col transition-all hover:shadow-md hover:border-emerald-200">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-[17px] font-bold text-slate-800">{{ $month['month_name'] }}</h3>
                    <p class="text-[13px] text-slate-500 font-medium">{{ $year }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i class="bi bi-calendar-check text-[18px]"></i>
                </div>
            </div>
            
            <div class="p-5 flex-1 bg-slate-50/50">
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <p class="text-[12px] text-slate-500 font-medium mb-0.5">Masuk <span class="text-emerald-500 ml-1"><i class="bi bi-arrow-down"></i></span></p>
                        <p class="text-[15px] font-bold text-slate-800">{{ number_format($month['total_in']) }} <span class="text-[11px] font-normal text-slate-500">kg</span></p>
                    </div>
                    <div>
                        <p class="text-[12px] text-slate-500 font-medium mb-0.5">Keluar <span class="text-red-500 ml-1"><i class="bi bi-arrow-up"></i></span></p>
                        <p class="text-[15px] font-bold text-slate-800">{{ number_format($month['total_out']) }} <span class="text-[11px] font-normal text-slate-500">kg</span></p>
                    </div>
                </div>
                <div class="pt-3 border-t border-slate-200/60 flex items-center justify-between">
                    <p class="text-[13px] text-slate-600">
                        <span class="font-bold text-slate-800">{{ $month['trx_count'] }}</span> transaksi
                    </p>
                    @if($month['trx_count'] > 0)
                        <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span>
                    @else
                        <span class="inline-block w-2 h-2 rounded-full bg-slate-300"></span>
                    @endif
                </div>
            </div>
            
            <div class="p-4 bg-white border-t border-slate-100 mt-auto">
                <a href="{{ route('report.show', ['report' => $month['month_number'], 'year' => $year]) }}" 
                   class="w-full flex items-center justify-center gap-2 py-2.5 rounded-lg {{ $month['trx_count'] > 0 ? 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm' : 'bg-slate-100 text-slate-400 pointer-events-none' }} font-semibold text-[14px] transition-colors"
                >
                    <i class="bi bi-file-earmark-pdf text-[16px]"></i> Unduh PDF
                </a>
            </div>
        </div>
    @endforeach
</div>
@endsection
