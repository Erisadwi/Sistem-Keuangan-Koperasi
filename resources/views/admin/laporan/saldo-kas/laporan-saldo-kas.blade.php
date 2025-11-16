@extends('layouts.laporan-admin2')


@section('title', 'Laporan Saldo Kas')  
@section('title-1', 'Saldo Kas')  
@section('title-content', 'Laporan Saldo Kas')  
@section('period')
  Periode {{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y') }}
@endsection
@section('sub-title', 'Laporan Saldo Kas')  

@section('content')

<x-menu.month-filter/>
<x-menu.unduh :url="route('saldo-kas.exportPdf', ['bulan' => $bulan, 'tahun' => $tahun])" text="Unduh PDF" />


<table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Kas</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
        <tr>
            <td colspan="2" class="merged-cell">Saldo Periode Sebelumnya</td> 
            <td class="saldo">{{ number_format($saldo_periode_sebelumnya ?? 0, 0, ',', '.') }}</td> 
        </tr>
        @foreach($data as $index => $kas)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $kas->nama_kas }}</td>
            <td>{{ number_format($kas->total_saldo ?? 0, 0, ',', '.') }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="2" class="header">Jumlah</td>
            <td class="saldo">{{ number_format($jumlah_kas ?? 0, 0, ',', '.') }}</td>
        </tr>

        </tbody>
    </table>


<style>
        table {
            border-collapse: collapse;
            background-color: #a7c7d9;
            border-radius: 8px;
            width: 98%;          
            margin-left: 10px;     
            margin-top: 90px;
        }
        th, td {
            font-size:14px;
            padding: 6px;
            text-align: center;
            border: 1px solid #ccc;
        }
        th {
            background-color: #4c4c4c;
            color: white;
        }
        td {
            background-color: white;
        }
        .header {
            font-weight: bold;
        }
        th:first-child, td:first-child {
            width: 50px; 
        }
        .saldo {
            text-align: center;
        }
        .merged-cell {
            text-align: center;
        }
</style>

@endsection
