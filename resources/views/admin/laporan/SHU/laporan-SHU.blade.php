@extends('layouts.laporan-admin2')


@section('title', 'Laporan Sisa Hasil Usaha')  
@section('title-1', 'Sisa Hasil Usaha')  
@section('title-content', 'Laporan Pembagian SHU')  
@section('period')
    {{ $periodeText }}
@endsection 
@section('sub-title', 'Laporan SHU')  

@section('content')

<x-menu.date-filter/>
<x-menu.unduh/>


<table>
    <tr>
        <th>Deskripsi</th>
        <th class="center">%</th>
        <th class="right">Nilai</th>
    </tr>
    <tr>
        <td>SHU Sebelum Pajak</td>
        <td class="center"></td>
        <td class="right">{{ number_format($shu->shu_sebelum_pajak ?? 0, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Pajak PPh (0.5%)</td>
        <td class="center"></td>
        <td class="right">{{ number_format($shu->pajak ?? 0, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>SHU Setelah Pajak</td>
        <td class="center"></td>
        <td class="right">{{ number_format($shu->shu_sesudah_pajak ?? 0, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td colspan="3" class="left bold">PEMBAGIAN SHU UNTUK DANA-DANA</td>
    </tr>
    <tr>
        <td>Dana Cadangan</td>
        <td class="center">{{ number_format($biayaAdm->dana_cadangan ?? 0, 0, ',', '.') }}%</td>
        <td class="right">{{ number_format($shu->shu_dana_cadangan ?? 0, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Jasa Anggota</td>
        <td class="center">{{ number_format($biayaAdm->jasa_anggota ?? 0, 0, ',', '.') }}%</td>
        <td class="right">{{ number_format($shu->shu_jasa_anggota ?? 0, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Dana Pengurus</td>
        <td class="center">{{ number_format($biayaAdm->dana_pengurus ?? 0, 0, ',', '.') }}%</td>
        <td class="right">{{ number_format($shu->shu_dana_pengurus ?? 0, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Dana Karyawan</td>
        <td class="center">{{ number_format($biayaAdm->dana_karyawan ?? 0, 0, ',', '.') }}%</td>
        <td class="right">{{ number_format($shu->shu_jasa_karyawan ?? 0, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Dana Pendidikan</td>
        <td class="center">{{ number_format($biayaAdm->dana_pendidikan ?? 0, 0, ',', '.') }}%</td>
        <td class="right">{{ number_format($shu->shu_dana_pendidikan ?? 0, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Dana Sosial</td>
        <td class="center">{{ number_format($biayaAdm->dana_sosial ?? 0, 0, ',', '.') }}%</td>
        <td class="right">{{ number_format($shu->shu_dana_sosial ?? 0, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td colspan="3" class="left bold">PEMBAGIAN SHU ANGGOTA</td>
    </tr>
    <tr>
        <td>Jasa Usaha</td>
        <td class="center">{{ number_format($biayaAdm->jasa_usaha ?? 0, 0, ',', '.') }}%</td>
        <td class="right">{{ number_format($shu->shu_jasa_usaha ?? 0, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Jasa Modal</td>
        <td class="center">{{ number_format($biayaAdm->jasa_modal_anggota ?? 0, 0, ',', '.') }}%</td>
        <td class="right">{{ number_format($shu->shu_jasa_modal_anggota ?? 0, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Total Simpanan Anggota</td>
        <td class="center"></td>
        <td class="right">{{ number_format($shu->total_simpanan ?? 0, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Total Pendapatan Anggota</td>
        <td class="center"></td>
        <td class="right">{{ number_format($shu->total_pendapatan ?? 0, 0, ',', '.') }}</td>
    </tr>
</table>


<style>
    table {
        border-collapse: collapse;
        font-size: 13px;
        width: 98%;          
        margin-left: 10px;     
        margin-top: 100px;
        background-color: #fff;
    }
    td, th {
        padding: 6px 8px;
        text-align: left;
    }
    td {
        border: none;
    }
    th {
        display: none;
    }
    .center {
        text-align: center;
    }
    .left {
        text-align: left;
    }
    .right {
        text-align: right;
    }
    .bold {
        font-weight: bold;
    }
</style>

@endsection
