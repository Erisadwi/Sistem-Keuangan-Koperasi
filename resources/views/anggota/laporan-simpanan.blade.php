@extends('layouts.app')

@push('styles')
  @vite('resources/css/style-laporanSimpanan.css')
@endpush

@section('title', 'Laporan Simpanan')
@section('title-1', 'Laporan')
@section('sub-title', 'Laporan Simpanan')

@section('content')
  {{-- Filter --}}
  <x-menu.date-filter/>

  {{-- Tabel Laporan Simpanan --}}
  <div class="laporan-simpanan-wrap">
    <table class="laporan-simpanan-table">
      <thead>
        <tr>
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
          <td>-</td>
        </tr>
      </tbody>
    </table>
  </div>
@endsection
