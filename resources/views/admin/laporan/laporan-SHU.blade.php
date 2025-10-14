@extends('layouts.laporan-admin2')


@section('title', 'Laporan Sisa Hasil Usaha')  
@section('title-1', 'Sisa Hasil Usaha')  
@section('title-content', 'Laporan Pembagian SHU')  
@section('period', 'Periode 1 Jan 2025 - 31 Des 2025')  
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
        <td class="right">-12,955,033  {{-- -{{ number_format($shu_admin->saldo_sebelum_pajak ?? 0, 0, ',', '.') }} --}}</td>
    </tr>
    <tr>
        <td>Pajak PPh (0.5%)</td>
        <td class="center"></td>
        <td class="right">-64,775 {{-- -{{ number_format($shu_admin->pajak_pph ?? 0, 0, ',', '.') }} --}}</td>
    </tr>
    <tr>
        <td>SHU Setelah Pajak</td>
        <td class="center"></td>
        <td class="right">-12,890,258 {{-- -{{ number_format($shu_admin->saldo_setelah_pajak ?? 0, 0, ',', '.') }} --}}</td>
    </tr>
    <tr>
        <td colspan="3" class="left bold">PEMBAGIAN SHU UNTUK DANA-DANA</td>
    </tr>
    <tr>
        <td>Dana Cadangan</td>
        <td class="center">50 {{-- {{ number_format($biaya_administrasi->dana_cadangan, 0, ',', '.') }} --}}%</td>
        <td class="right">-6,445,129 {{-- -{{ number_format($shu_admin->dana_cadangan ?? 0, 0, ',', '.') }} --}}</td>
    </tr>
    <tr>
        <td>Jasa Anggota</td>
        <td class="center">30  {{-- {{ number_format($biaya_administrasi->jasa_anggota, 0, ',', '.') }} --}} %</td>
        <td class="right">-3,867,077 {{-- -{{ number_format($shu_admin->jasa_anggota ?? 0, 0, ',', '.') }} --}}</td>
    </tr>
    <tr>
        <td>Dana Pengurus</td>
        <td class="center">6% {{-- {{ number_format($biaya_administrasi->dana_pengurus, 0, ',', '.') }} --}}</td>
        <td class="right">-773,415 {{-- -{{ number_format($shu_admin->dana_pengurus ?? 0, 0, ',', '.') }} --}}</td>
    </tr>
    <tr>
        <td>Dana Karyawan</td>
        <td class="center">10 {{-- {{ number_format($biaya_administrasi->dana_karyawan, 0, ',', '.') }} --}}%</td>
        <td class="right">-1,289,026 {{-- -{{ number_format($shu_admin->dana_karyawan ?? 0, 0, ',', '.') }} --}}</td>
    </tr>
    <tr>
        <td>Dana Pendidikan</td>
        <td class="center">2{{-- {{ number_format($biaya_administrasi->dana_pendidikan, 0, ',', '.') }} --}}%</td>
        <td class="right">-257,805 {{-- -{{ number_format($shu_admin->dana_pendidikan ?? 0, 0, ',', '.') }} --}}</td>
    </tr>
    <tr>
        <td>Dana Sosial</td>
        <td class="center">2{{-- {{ number_format($biaya_administrasi->dana_sosial, 0, ',', '.') }} --}}%</td>
        <td class="right">-257,805 {{-- -{{ number_format($shu_admin->dana_sosial ?? 0, 0, ',', '.') }} --}}</td>
    </tr>
    <tr>
        <td colspan="3" class="left bold">PEMBAGIAN SHU ANGGOTA</td>
    </tr>
    <tr>
        <td>Jasa Usaha</td>
        <td class="center">70{{-- {{ number_format($biaya_administrasi->jasa_usaha, 0, ',', '.') }} --}}%</td>
        <td class="right">-2,706,954 {{-- -{{ number_format($shu_admin->jasa_usaha ?? 0, 0, ',', '.') }} --}}</td>
    </tr>
    <tr>
        <td>Jasa Modal</td>
        <td class="center">30{{-- {{ number_format($biaya_administrasi->jasa_modal, 0, ',', '.') }} --}}%</td>
        <td class="right">-1,160,123 {{-- -{{ number_format($shu_admin->jasa_modal ?? 0, 0, ',', '.') }} --}}</td>
    </tr>
    <tr>
        <td>Total Simpanan Anggota</td>
        <td class="center"></td>
        <td class="right">985,197,260 {{-- -{{ number_format($shu_admin->total_simpanan ?? 0, 0, ',', '.') }} --}}</td>
    </tr>
    <tr>
        <td>Total Pendapatan Anggota</td>
        <td class="center"></td>
        <td class="right">59,547,035 {{-- -{{ number_format($shu_admin->total_pendapatan ?? 0, 0, ',', '.') }} --}}</td>
    </tr>
</table>


<style>
    table {
        width: 870px;
        border-collapse: collapse;
        font-size: 13px;
        margin-left:25px;
        margin-top:70px;
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
