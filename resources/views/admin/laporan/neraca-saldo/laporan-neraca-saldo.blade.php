@extends('layouts.laporan-admin3')

@push('styles')
@vite('resources/css/style-laporanNeracaSaldo.css')
@endpush

@section('title', 'Laporan Neraca Saldo')
@section('title-1', 'Neraca Saldo')
@section('title-content', 'Laporan Neraca Saldo')
@php
    $tahun = $tahun ?? date('Y'); 
    $awal = "01 Jan $tahun";
    $akhir = "31 Des $tahun";
@endphp

@section('period', "Periode $awal - $akhir")

@section('sub-title', 'Laporan Neraca Saldo')

@section('filter-area')
<div class="header-flex">
    <div class="left-tools">
      <x-menu.date-filter />
      <x-menu.unduh :url="route('laporan-neraca-saldo.export-pdf', ['tahun' => $tahun])" text="Unduh PDF" />
    </div>
</div>
@endsection

@section('content')

<div class="laporan-neraca-saldo-wrap">
  <div class="table-scroll-wrapper">
    <table class="laporan-neraca-saldo-table">
      <thead>
        <tr class="head-group">
          <th class="nama-akun">Nama Akun</th>
          <th class="debet">Debet</th>
          <th class="kredit">Kredit</th>
        </tr>
      </thead>

      <tbody>

        @if(!empty($neracaKelompok))
        @foreach($neracaKelompok as $judul => $list)

        {{-- ===================== --}}
        {{-- Sub Judul (Kelompok) --}}
        {{-- ===================== --}}
        <tr class="akun-header">
          <td colspan="3" style="font-weight:600; background:#e5e5e5;">
            {{ $judul }}
          </td>
        </tr>

        {{-- ===================== --}}
        {{-- Daftar Akun per kategori --}}
        {{-- ===================== --}}
        @foreach($list as $item)
        <tr class="akun-item">
          <td class="nama-akun-item">
            {{ $item['kode'] }}. {{ $item['nama'] }}
          </td>

          <td class="debet">
            {{ $item['debet'] > 0 ? number_format($item['debet'], 0, ',', '.') : '-' }}
          </td>

          <td class="kredit">
            {{ $item['kredit'] > 0 ? number_format($item['kredit'], 0, ',', '.') : '-' }}
          </td>
        </tr>
        @endforeach

        @endforeach

        @else
        <tr>
          <td colspan="3" class="empty-cell">Belum ada data neraca saldo.</td>
        </tr>
        @endif

      {{-- =========================== --}}
      {{--     TOTAL DEBET & KREDIT    --}}
      {{-- =========================== --}}
      @isset($totalDebet, $totalKredit)
      <tr class="total-row final-total" style="background:#f2faff; font-weight:700;">
          <td class="text-end text-primary" style="padding-right:20px;">
              JUMLAH
          </td>
          <td class="debet text-primary">
              {{ number_format($totalDebet, 0, ',', '.') }}
          </td>
          <td class="kredit text-primary">
              {{ number_format($totalKredit, 0, ',', '.') }}
          </td>
      </tr>
      @endisset

      </tbody>
    </table>
  </div>
</div>

@endsection