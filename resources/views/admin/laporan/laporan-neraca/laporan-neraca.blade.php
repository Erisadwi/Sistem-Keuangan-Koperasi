@extends('layouts.laporan-admin2')

@push('styles')
  @vite('resources/css/style-laporanNeraca.css')
@endpush

@section('title', 'Laporan Neraca')  
@section('title-1', 'Neraca')  
@section('title-content', 'Laporan Neraca')  
@section('period', 'Per Tanggal ' . $periode)
@section('sub-title', 'Laporan Neraca')  

@section('content')

<x-menu.date-filter/>
<x-menu.unduh 
    :url="route('laporan-neraca.exportPdf', [
        'start_date' => request('start_date'),
        'end_date'   => request('end_date'),
        'preset'     => request('preset')
    ])" 
    text="Unduh Laporan"
/>

<div class="laporan-neraca-wrap">
  <div class="table-scroll-wrapper">
    <table class="laporan-neraca-table">
      <thead>
        <tr class="head-group">
          <th class="nama-akun">Nama Akun</th>
          <th class="debet">Debet</th>
          <th class="kredit">Kredit</th>
        </tr>
      </thead>

      <tbody>

        @php
          // gabungkan data
          $listNeraca = $activa->concat($pasiva)->sortBy('id_akun');
        @endphp

        @forelse($listNeraca as $item)
          <tr class="akun-item">
            <td class="nama-akun-item">{{ $item->kode_aktiva }}. {{ $item->nama_akun }}</td>

            <td class="debet">
              {{ $item->keterangan_akun === 'ACTIVA' ? number_format($item->total_debit ?? 0, 0, ',', '.') : '-' }}
            </td>

            <td class="kredit">
              {{ $item->keterangan_akun === 'PASIVA' ? number_format($item->total_kredit ?? 0, 0, ',', '.') : '-' }}
            </td>
          </tr>
        @empty
          <tr><td colspan="3" class="empty-cell">Belum ada data neraca.</td></tr>
        @endforelse

        <tr class="total-row final-total">
          <td class="nama-akun-item text-end text-primary"><b>JUMLAH</b></td>
          <td class="debet text-primary"><b>{{ number_format($totalActiva, 0, ',', '.') }}</b></td>
          <td class="kredit text-primary"><b>{{ number_format($totalPasiva, 0, ',', '.') }}</b></td>
      </tr>
      </tbody>
    </table>
  </div>
</div>

@endsection
