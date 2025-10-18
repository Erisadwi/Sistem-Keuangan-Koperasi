@extends('layouts.app')

@push('styles')
 @vite('resources/css/style-laporanSimpanan.css')
@endpush


@section('title', 'Laporan')  
@section('title-1', 'Laporan')  
@section('sub-title', 'Laporan Simpanan')  

@section('content')

<div class="laporan-simpanan-wrap">
  <div class="table-scroll-wrapper">
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
     @if(isset($data) && count($data) > 0)
      @foreach ($data as $row)
      <tr>
        <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}</td>
        <td>{{ $row->jenis }}</td>
        <td>{{ number_format($row->jumlah, 0, ',', '.') }}</td>
        <td>{{ $row->keterangan ?? '-' }}</td>
      </tr>
      @endforeach
    @else
    <tr>
      <td colspan="4" class="empty-cell">Belum ada data simpanan.</td>
    </tr>
    @endif
    </tbody>
  </table>
  </div>
</div>

{{-- Komponen pagination --}}
<x-menu.pagination />

@endsection
