@extends('layouts.app')

@push('styles')
  @vite('resources/css/components/tabel.css')
@endpush


@section('title', 'Data Pengajuan')  
@section('title-1', 'Data Pengajuan')  
@section('sub-title', 'Data Pengajuan')  

@section('content')

{{-- contoh di mana saja --}}
<x-menu.date-filter/>


<div class="shu-table-wrap">
  <table class="shu-table">
    <thead>
      <tr class="head-title">
        <th colspan="4">Pembagian SHU</th>
      </tr>
      <tr class="head-group">
        <th colspan="2" class="group-left">Jasa Usaha</th>
        <th colspan="2" class="group-right">Modal Usaha</th>
      </tr>
    </thead>

    <tbody>
      <tr>
        <td class="label">Laba Anggota</td>
        <td class="value">875.000 {{-- -{{ number_format($shu->laba_anggota ?? 0, 0, ',', '.') }} --}}</td>
        <td class="label">Simpanan Anggota</td>
        <td class="value">5.210.000 {{-- -{{ number_format($shu->saldo_simpanan ?? 0, 0, ',', '.') }} --}}</td>
      </tr>

      <tr>
        <td class="label">Total Laba</td>
        <td class="value">59.547.035{{-- -{{ number_format($shu->total_laba ?? 0, 0, ',', '.') }} --}}</td>
        <td class="label">Total Simpanan</td>
        <td class="value">985.197.260{{-- -{{ number_format($shu->total_simpanan ?? 0, 0, ',', '.') }} --}}</td>
      </tr>

      <tr>
        <td class="label">Jasa Usaha</td>
        <td class="value negative">-2.706.954{{-- {{ number_format($shu->jasa_usaha ?? 0, 0, ',', '.') }} --}}</td>
        <td class="label">Jasa Simpanan</td>
        <td class="value negative">-1.160.123 {{-- -{{ number_format($shu->jasa_simpanan ?? 0, 0, ',', '.') }} --}}</td>
      </tr>

      <tr>
        <td class="label">SHU Jasa Usaha</td>
        <td class="value negative">-39.777 {{-- -{{ number_format($shu->shu_jasa_usaha ?? 0, 0, ',', '.') }} --}}</td>
        <td class="label">SHU Jasa Modal</td>
        <td class="value negative">-6.135 {{-- -{{ number_format($shu->shu_jasa_modal ?? 0, 0, ',', '.') }} --}}</td>
      </tr>
    </tbody>
  </table>
</div>
<x-menu.pagination/>

@endsection
