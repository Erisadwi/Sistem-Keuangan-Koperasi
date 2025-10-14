@extends('layouts.laporan-admin')


@section('title', 'Laporan Saldo Kas')  
@section('title-1', 'Saldo Kas')  
@section('title-content', 'Laporan Saldo Kas')  
@section('period', 'Periode Oktober 2025')  
@section('sub-title', 'Laporan Saldo Kas')  

@section('content')

<x-menu.month-filter/>
<x-menu.unduh/>


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
                <td class="saldo">429.565.371 {{-- {{ number_format($kas->saldo_periode_sebelumnya ?? 0, 0, ',', '.') }} --}}</td> 
            </tr>
            <tr>
                <td>1</td>
                <td>Kas Besar</td>
                <td>9.364.663 {{-- -{{ number_format($kas->kas_besar?? 0, 0, ',', '.') }} --}}</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Bank Mandiri</td>
                <td>417.795.708 {{-- -{{ number_format($kas->bank_mandiri ?? 0, 0, ',', '.') }} --}}</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Kas Kecil</td>
                <td>0 {{-- -{{ number_format($kas->kas_kecil ?? 0, 0, ',', '.') }} --}}</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Kas Niaga</td>
                <td>208.500 {{-- -{{ number_format($kas->kas_niaga ?? 0, 0, ',', '.') }} --}}</td>
            </tr>
            <tr>
                <td>5</td>
                <td>Bank BRI</td>
                <td>2.196.500 {{-- -{{ number_format($kas->bank_bri ?? 0, 0, ',', '.') }} --}}</td>
            </tr>
            <tr>
                <td colspan="2" class="header">Jumlah</td>
                <td class="saldo">429.565.371 {{-- -{{ number_format($kas->jumlah_kas ?? 0, 0, ',', '.') }} --}}</td>
            </tr>
        </tbody>
    </table>


<style>
        table {
            width: 860px;
            border-collapse: collapse;
            background-color: #a7c7d9;
            border-radius: 8px;
            margin-left:30px;
            margin-top:60px;
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
