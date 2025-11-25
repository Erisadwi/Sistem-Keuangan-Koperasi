@extends('layouts.laporan-admin2')

@push('styles')
 @vite('resources/css/style-laporanJatuhTempo.css')
@endpush

@section('title', 'Laporan Jatuh Tempo')  
@section('title-1', 'Jatuh Tempo')  
@section('title-content', 'Laporan Jatuh Tempo Pembayaran Kredit')  

@section('period')
  Periode {{ $periode }}
@endsection

@section('sub-title', 'Laporan Jatuh Tempo Pembayaran Kredit')  

@section('content')

<x-menu.month-filter/>
<x-menu.unduh :url="route('laporan.jatuh-tempo.export', ['bulan' => $bulan, 'tahun' => $tahun])" text="Unduh Laporan" />


<div class="laporan-jatuh-tempo-wrap">
  <div class="table-scroll-wrapper">
  <table class="laporan-jatuh-tempo-table">
    <thead>
      <tr class="head-group">
        <th>No</th>
        <th>Kode Pinjam</th>
        <th>Nama Anggota</th>
        <th>Tanggal Pinjam</th>
        <th>Tanggal Tempo</th>
        <th>Lama Pinjam</th>
        <th>Jumlah Tagihan</th>
        <th>Dibayar</th>
        <th>Sisa Tagihan</th>
      </tr>
    </thead>
    <tbody>
     @isset($dataPinjaman)
      @forelse($dataPinjaman as $index => $row)
          <tr>
              <td>{{ $index + 1 }}</td>
              <td>{{ $row->kode_pinjam }}</td>
              <td>{{ $row->nama_anggota }}</td>
              <td>{{ \Carbon\Carbon::parse($row->tanggal_pinjam)->format('d-m-Y') }}</td>
              <td>{{ \Carbon\Carbon::parse($row->tanggal_tempo)->format('d-m-Y') }}</td>
              <td>{{ $row->lama_pinjam }} bulan</td>
              <td>Rp {{ number_format($row->jumlah_tagihan, 0, ',', '.') }}</td>
              <td>Rp {{ number_format($row->dibayar, 0, ',', '.') }}</td>
              <td>Rp {{ number_format($row->sisa_tagihan, 0, ',', '.') }}</td>
          </tr>
      @empty
          <tr>
              <td colspan="9" class="empty-cell">Belum ada data jatuh tempo.</td>
          </tr>
      @endforelse

      @if($dataPinjaman->count() > 0)
          <tr class="total-row">
              <td colspan="6" style="text-align: right; font-weight: bold;">Jumlah Total</td>
              <td style="font-weight: bold;">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</td>
              <td style="font-weight: bold;">Rp {{ number_format($totalDibayar, 0, ',', '.') }}</td>
              <td style="font-weight: bold;">Rp {{ number_format($totalSisa, 0, ',', '.') }}</td>
          </tr>
      @endif
  @endisset
    </tbody>
  </table>
  </div>
</div>

  <div class="pagination-container">
      <x-menu.pagination :data="$dataPinjaman" />
  </div>

@endsection
