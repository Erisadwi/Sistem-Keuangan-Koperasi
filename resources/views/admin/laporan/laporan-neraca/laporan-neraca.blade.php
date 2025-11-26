@extends('layouts.laporan-admin2')

@section('title', 'Laporan Neraca')  
@section('title-1', 'Neraca')  
@section('title-content', 'Laporan Neraca')  
@section('period')
  Per Tanggal {{ \Carbon\Carbon::create($tahun, $bulan, 1)->endOfMonth()->translatedFormat('d M Y') }}
@endsection
@section('sub-title', 'Laporan Neraca')  

@section('content')

<x-menu.month-filter/>
<x-menu.unduh :url="route('laporan-neraca.exportPdf', ['bulan' => $bulan, 'tahun' => $tahun])" text="Unduh PDF" />

<table class="laporan-neraca-table">
    <thead>
        <tr>
            <th>Nama Akun</th>
            <th>Debet</th>
            <th>Kredit</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($neracaGrouped as $groupName => $items)
            <tr class="group-header">
                <td colspan="3"><b>{{ strtoupper($groupName) }}</b></td>
            </tr>

            @foreach ($items as $item)
                <tr>
                    <td style="text-align:left;">
                        {{ $item->kode_aktiva }}. {{ $item->nama_akun }}
                    </td>
                    <td class="saldo">
                        @if ($item->kode_aktiva == 'I02.01')
                            {{ $laba_bersih < 0 ? number_format(abs($laba_bersih), 0, ',', '.') : '-' }}
                        @else
                            {{ $item->total_debit > 0 ? number_format($item->total_debit, 0, ',', '.') : '-' }}
                        @endif
                    </td>
                    <td class="saldo">
                        @if ($item->kode_aktiva == 'I02.01')
                            {{ $laba_bersih > 0 ? number_format($laba_bersih, 0, ',', '.') : '-' }}
                        @else
                            {{ $item->total_kredit > 0 ? number_format($item->total_kredit, 0, ',', '.') : '-' }}
                        @endif
                    </td>
                </tr>
            @endforeach
        @empty
            <tr>
                <td colspan="3" class="empty-cell">Belum ada data neraca.</td>
            </tr>
        @endforelse

        <tr class="header">
            <td><b>JUMLAH</b></td>
            <td class="saldo"><b>{{ number_format($totalDebit, 0, ',', '.') }}</b></td>
            <td class="saldo"><b>{{ number_format($totalKredit, 0, ',', '.') }}</b></td>
        </tr>
    </tbody>
</table>

<style>
    
    .laporan-neraca-table {
        border-collapse: collapse;
        background-color: #a7c7d9; 
        border-radius: 8px;
        width: 98%;          
        margin-left: 10px;     
        margin-top: 90px;
    }
    .laporan-neraca-table th, 
    .laporan-neraca-table td {
        font-size: 14px;
        padding: 6px;
        text-align: center;
        border: 1px solid #ccc;
    }
    .laporan-neraca-table th {
        background-color: #4c4c4c;
        color: white;
    }
    .laporan-neraca-table td {
        background-color: white;
    }
    .laporan-neraca-table .group-header td {
        background-color: #eef2f7;
        font-weight: bold;
        text-align: left;
    }
    .laporan-neraca-table .header td {
        font-weight: bold;
        background-color: #dceaf5;
    }
    .laporan-neraca-table .saldo {
        text-align: center;
    }
    .laporan-neraca-table .empty-cell {
        text-align: center;
        font-style: italic;
        color: #6b7280;
        background: #ffffff;
    }
</style>

@endsection