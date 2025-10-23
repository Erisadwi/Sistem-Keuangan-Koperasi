@extends('layouts.app-admin3')

@section('title', 'Pinjaman')
@section('title-1', 'Pinjaman')
@section('sub-title', 'Data Pinjaman')

@section('content')
<x-menu.toolbar-filter/>


<div class="data-pinjaman-wrap">
  <div class="table-scroll-wrapper">
    <table class="data-pinjaman-table">
    <thead>
      <tr class="head-group">
        <th>No</th>
        <th>Kode</th>
        <th>Tanggal Pinjam</th>
        <th>Nama Anggota</th>
        <th>Hitungan</th>
        <th>Total Tagihan</th>
        <th>Keterangan</th>
        <th>Lunas</th>
        <th>User</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @if(isset($data) && count($data) > 0)
        @foreach ($data as $index => $row)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $row->kode }}</td>
          <td>{{ \Carbon\Carbon::parse($row->tanggal_pinjaman)->format('d-m-Y') }}</td>
          <td>{{ $row->nama_anggota }}</td>
          <td>{{ number_format($row->hitungan, 0, ',', '.') }}</td>
          <td>{{ number_format($row->total_tagihan, 0, ',', '.') }}</td>
          <td>{{ $row->keterangan }}</td>
          <td>{{ $row->lunas }}</td>
          <td>{{ $row->user }}</td>
          <td><button class="btn-aksi">Detail</button></td>
          <td><button class="btn-nota">🧾 Nota</a>
        </tr>
        @endforeach
      @else
      <tr>
        <td colspan="11" class="empty-cell">Belum ada data pinjaman.</td>
      </tr>
      @endif
    </tbody>
  </table>
</div>

<x-menu.pagination />

<style>
:root {
  --primary: #6ba1be;
  --primary-dark: #558ca3;
  --header-bg: #4a4a4a;
  --header-text: #ffffff;
  --border: #c0c0c0;
  --text: #222;
}

.data-pinjaman-wrap {
  border-radius: 0;
  background: var(--bg);
  width: 100%;
  margin-left: 15px;
  margin-top: 0px;
  padding: 0;
  box-shadow: none;
}

/* Scroll aktif */
.table-scroll-wrapper {
  overflow-x: auto;
  overflow-y: auto;
  max-height: 400px;
  width: 100%;
  padding: 30px 16px 10px 16px;
  box-sizing: border-box;
}
.table-scroll-wrapper::-webkit-scrollbar {
  height: 8px;
  width: 8px;
}
.table-scroll-wrapper::-webkit-scrollbar-thumb {
  background: var(--primary);
  border-radius: 4px;
}
.table-scroll-wrapper::-webkit-scrollbar-track {
  background: #f0f0f0;
}

/* Tabel */
.data-pinjaman-table {
  width: 97%;
  border-collapse: collapse;
  background: #ffffff;
  font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
  font-size: 13px;
  color: var(--text);
  table-layout: auto;
}

.data-pinjaman-table thead {
  background: var(--header-bg);
  color: var(--header-text);
  position: sticky;
  top: 0;
  z-index: 1;
}

.data-pinjaman-table th,
.data-pinjaman-table td {
  text-align: center;
  padding: 10px 14px;
  border: 1px solid var(--border);
  white-space: nowrap;
  vertical-align: middle;
}

.data-pinjaman-table tbody tr:nth-child(even) {
  background-color: #f9f9f9;
}

data-pinjaman-table tbody tr:hover {
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
</style>

@endsection
