@extends('layouts.laporan-admin2')

@push('styles')
  @vite('resources/css/style-laporanNeraca.css')
@endpush

@section('title', 'Laporan Neraca')  
@section('title-1', 'Neraca')  
@section('title-content', 'Laporan Neraca')  
@section('period', 'Per Tanggal 31 Des 2025')  
@section('sub-title', 'Laporan Neraca')  

@section('content')

<x-menu.date-filter/>
<x-menu.unduh/>

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
        @isset($neraca)
          @forelse($neraca as $item)
            @php
              // Deteksi header akun utama (misal kode hanya huruf A, B, C, dst)
              $isHeader = preg_match('/^[A-Z]\.?$/', $item['kode']);
            @endphp

            @if($isHeader)
              <tr class="akun-header">
                <td colspan="3">
                  <i class="bi bi-folder-fill text-primary me-2"></i>
                  {{ $item['kode'] }}. {{ $item['nama_akun'] }}
                </td>
              </tr>
            @else
              <tr class="akun-item">
                <td class="nama-akun-item">{{ $item['kode'] }}. {{ $item['nama_akun'] }}</td>
                <td class="debet">{{ number_format($item['debet'] ?? 0, 0, ',', '.') }}</td>
                <td class="kredit">{{ number_format($item['kredit'] ?? 0, 0, ',', '.') }}</td>
              </tr>
            @endif
          @empty
            <tr>
              <td colspan="3" class="empty-cell">Belum ada data neraca.</td>
            </tr>
          @endforelse
        @else
          <tr>
            <td colspan="3" class="empty-cell">Belum ada data neraca.</td>
          </tr>
        @endisset
      </tbody>
    </table>
  </div>
</div>

@endsection
