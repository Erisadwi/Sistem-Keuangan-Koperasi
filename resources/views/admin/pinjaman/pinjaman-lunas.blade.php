@extends('layouts.app-admin3')

@section('title', 'Pinjaman')
@section('title-1', 'Pinjaman')
@section('sub-title', 'Pinjaman Lunas')

@section('content')

<x-menu.toolbar-filter/>


<div class="pinjaman-lunas-table-wrap">
  <table class="pinjaman-lunas-table">
    <thead>
      <tr class="head-group">
        <th>No</th>
        <th>Kode</th>
        <th>Nama Anggota</th>
        <th>Departemen</th>
        <th>Tanggal Pinjaman</th>
        <th>Tanggal Tempo</th>
        <th>Lama Pinjaman</th>
        <th>Total Tagihan</th>
        <th>Total Denda</th>
        <th>Dibayar</th>
        <th>Aksi</th>
      </tr>
    </thead>

    <tbody>
@if(isset($dataPinjamanLunas) && count($dataPinjamanLunas) > 0)
    @foreach ($dataPinjamanLunas as $index => $row)
    <tr>
      <td>{{ $index + 1 }}</td>
      <td>{{ $row->kode_transaksi ?? '-' }}</td>
      <td>{{ $row->nama_anggota ?? '-' }}</td>
      <td>{{ $row->departemen ?? '-' }}</td>
      <td>{{ \Carbon\Carbon::parse($row->tanggal_pinjaman)->format('d-m-Y') }}</td>
      <td>{{ $row->tanggal_jatuh_tempo ?? '-' }}</td>
      <td>{{ $row->lama_angsuran ?? '-' }} bulan</td>
      <td>{{ number_format($row->total_tagihan ?? 0, 0, ',', '.') }}</td>
      <td>{{ number_format($row->total_denda ?? 0, 0, ',', '.') }}</td>
      <td>{{ number_format($row->total_tagihan ?? 0, 0, ',', '.') }}</td>
      <td class="actions">
          <a href="{{ route('detail.pelunasan', ['kode_transaksi' => $row->kode_transaksi]) }}" class="btn-detail">
            🔍 Detail
          </a>
        </td>
    </tr>
    @endforeach
  @else
    <tr>
      <td colspan="11" class="empty-cell">Belum ada data pinjaman lunas.</td>
    </tr>
  @endif
    </tbody>
  </table>
</div>

<div class="pagination-container">
      <x-menu.pagination :data="$dataPinjamanLunas" />
    </div>

<style>
:root {
  --border: #d1d5db;
  --header-bg: #111827; 
  --header-text: #ffffff;
  --body-bg: #ffffff;
  --body-text: #000000;
}

.pinjaman-lunas-table-wrap {
  border: 1.5px solid var(--border);
  background: var(--body-bg);
  width: 96%;
  margin-left: 25px;
  margin-top: 20px;
  overflow-x: auto;
  border-radius: 4px;
}

.pinjaman-lunas-table {
  width: 100%;
  border-collapse: collapse;
  font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
  font-size: 13px;
  color: var(--body-text);
  text-align: center;
}

.pinjaman-lunas-table thead .head-group th {
  background: var(--header-bg);
  color: var(--header-text);
  padding: 10px;
  font-weight: 650;
  border: 1px solid var(--border);
}

.pinjaman-lunas-table tbody tr {
  background: var(--body-bg);
  border-bottom: 1px solid var(--border);
}

.pinjaman-lunas-table td {
  padding: 8px;
  border: 1px solid var(--border);
  color: var(--body-text);
}

.actions {
  display: flex;
  justify-content: center;
  align-items: center;
}

.btn-detail {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  background: #0ea5e9;
  color: #fff;
  padding: 4px 8px;
  border-radius: 5px;
  text-decoration: none;
  font-size: 12px;
  font-weight: 500;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.btn-detail:hover {
  background: #0284c7;
}

.empty-cell {
 padding: 8px 10px;
 color: #6b7280;
 font-style: italic;
}

.row-late {
background-color: #ffcccc !important;
}

.pagination-container {
  margin-top: auto;        
  display: flex;
  justify-content: flex-end;
  align-items: center;
  padding: 12px 16px;
}

</style>

@endsection
