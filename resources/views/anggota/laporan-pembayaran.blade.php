@extends('layouts.app')

@push('styles')
    @vite('resources/css/style-laporanPembayaran.css')
@endpush

@section('title', 'Laporan')  
@section('title-1', 'Laporan')  
@section('sub-title', 'Laporan Pembayaran')  

@section('content')

<div class="laporan-pembayaran-wrap">
  <div class="table-scroll-wrapper">
    <table class="laporan-pembayaran-table">
      <thead>
        <tr class="head-group">
          <th>Tanggal</th>
          <th>Jenis</th>
          <th>Angsuran Ke-</th>
          <th>Denda</th>
          <th>Jumlah Bayar</th>
          <th>Keterangan</th>
        </tr>
      </thead>
      <tbody>
        @isset($data)
            @forelse($data as $row)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($row->tanggal_bayar)->format('d-m-Y') }}</td>
                    <td>{{ $row->jenis }}</td>
                    <td>{{ $row->angsuran_ke }}</td>
                    <td>Rp {{ number_format($row->denda, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($row->angsuran_per_bulan, 0, ',', '.') }}</td>
                    <td>{{ $row->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="empty-cell">Belum ada data pembayaran.</td>
                </tr>
            @endforelse
        @else
            <tr>
                <td colspan="6" class="empty-cell">Belum ada data pembayaran.</td>
            </tr>
        @endisset
    </tbody>
    </table>
  </div>
</div>

<div class="pagination-container">
      <x-menu.pagination :data="$data" />
 </div> 

@endsection
