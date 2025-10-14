@extends('layouts.app')

@push('styles')
  @vite('resources/css/style-laporanPinjaman.css')
@endpush

@section('title', 'Laporan')  
@section('title-1', 'Laporan')  
@section('sub-title', 'Laporan pinjaman')  

@section('content')

<div class="laporan-pinjaman-wrap">
  <div class="table-scroll-wrapper">
    <table class="laporan-pinjaman-table">
      <thead>
        <tr class="head-group">
          <th>Tanggal</th>
          <th>Lama Angsuran</th>
          <th>Jumlah</th>
          <th>Bunga</th>
          <th>Administrasi</th>
          <th>Angsuran Per Bulan</th>
          <th>Tagihan</th>
          <th>Tempo</th>
          <th>Lunas</th>
          <th>Keterangan</th>
          <th>Opsi</th>
        </tr>
      </thead>
      <tbody>
        @isset($data)
          @forelse ($data as $row)
            <tr>
              <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}</td>
              <td>{{ $row->lama_angsuran }} bulan</td>
              <td>Rp {{ number_format($row->jumlah, 0, ',', '.') }}</td>
              <td>{{ $row->bunga }}%</td>
              <td>Rp {{ number_format($row->administrasi, 0, ',', '.') }}</td>
              <td>Rp {{ number_format($row->angsuran_per_bulan, 0, ',', '.') }}</td>
              <td>Rp {{ number_format($row->tagihan, 0, ',', '.') }}</td>
              <td>{{ \Carbon\Carbon::parse($row->tempo)->format('d-m-Y') }}</td>
              <td>{{ $row->lunas ? 'Ya' : 'Belum' }}</td>
              <td>{{ $row->keterangan ?? '-' }}</td>
              <td>...</td>
            </tr>
          @empty
            <tr>
              <td colspan="11" class="empty-cell">Belum ada data pinjaman.</td>
            </tr>
          @endforelse
        @else
          <tr>
            <td colspan="11" class="empty-cell">Belum ada data pinjaman.</td>
          </tr>
        @endisset
      </tbody>
    </table>
  </div>
</div>

{{-- Komponen pagination --}}
<x-menu.pagination />

@endsection
