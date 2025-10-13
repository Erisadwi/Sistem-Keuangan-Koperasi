@extends('layouts.app')

@push('styles')
 @vite('resources/css/style-laporanSimpanan.css')
@endpush


@section('title', 'Laporan')  
@section('title-1', 'Laporan')  
@section('sub-title', 'Laporan Simpanan')  

@section('content')

<x-menu.date-filter/>

<div class="laporan-simpanan-wrap">
    <table class="laporan-simpanan-table">
      <thead>
        <tr class="head-group">
          <th>Tanggal</th>
          <th>Jenis</th>
          <th>Jumlah</th>
          <th>Keterangan</th>
        
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>10-09-2025</td>
          <td>Setoran</td>
          <td>100.000</td>
        </tr>
      </tbody>
    </table>
</div>

{{-- Komponen pagination --}}
<x-menu.pagination />

@endsection
