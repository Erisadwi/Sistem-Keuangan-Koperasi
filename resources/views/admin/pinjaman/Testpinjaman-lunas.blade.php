@extends('layouts.app-admin3')

@section('title', 'Pinjaman')
@section('title-1', 'Pinjaman')
@section('sub-title', 'Pinjaman Lunas')

@section('content')

<x-menu.toolbar-filter/>


{{-- 🔹 Tabel --}}
<div class="table-scroll-wrapper">
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
          <a href="{{ route('detail.pelunasan', ['id_pinjaman' => $row->id_pinjaman]) }}" class="btn-aksi">
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

{{-- ======================= STYLE ======================= --}}
<style>
:root {
  --primary: #6ba1be;
  --primary-dark: #558ca3;
  --header-bg: #4a4a4a;
  --header-text: #ffffff;
  --border: #c0c0c0;
}
 
/* ============================= */
/* TABEL */
/* ============================= */
.table-scroll-wrapper {
  overflow-x: auto;
  overflow-y: auto;
  max-height: 420px;
  width: 100%;
  left:10px;
  background: white;
  border: 1px solid var(--border);
  border-radius: 0;
  box-sizing: border-box;
}

.pinjaman-lunas-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 14px;
}

.pinjaman-lunas-table thead {
  background: var(--header-bg);
  color: var(--header-text);
  position: sticky;
  top: 0;
  z-index: 2;
}

.pinjaman-lunas-table th,
.pinjaman-lunas-table td {
  text-align: center;
  padding: 10px 14px;
  border: 1px solid var(--border);
  white-space: nowrap;
}

.pinjaman-lunas-table tbody tr:nth-child(even) {
  background-color: #f9f9f9;
}

.pinjaman-lunas-table tbody tr:hover {
  background-color: #eef7ff;
}

.empty-cell {
  text-align: center;
  padding: 12px;
  color: #6b7280;
  font-style: italic;
}

/* Tombol aksi tabel */
.btn-aksi {
  background: var(--primary);
  color: white;
  border: none;
  padding: 6px 10px;
  border-radius: 6px;
  cursor: pointer;
}
.btn-aksi:hover {
  background: var(--primary-dark);
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
