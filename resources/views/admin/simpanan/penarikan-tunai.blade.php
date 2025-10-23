@extends('layouts.app-admin3')

@section('title', 'Transaksi Simpanan')
@section('title-1', 'Simpanan')
@section('sub-title', 'Penarikan Tunai')

@section('content')

<x-menu.toolbar-simpanan
    addUrl="#" {{-- nanti bisa diganti route('penarikan.create') --}}
/>

<div class="penarikan-wrap">
  <div class="table-scroll-wrapper">
    <table class="penarikan-table">
      <thead>
        <tr class="head-group">
          <th>No</th>
          <th>Kode Transaksi</th>
          <th>Tanggal Transaksi</th>
          <th>ID Anggota</th>
          <th>Nama Anggota</th>
          <th>Jenis Penarikan</th>
          <th>Jumlah</th>
          <th>User</th>
          <th>Cetak Nota</th>
        </tr>
      </thead>
      <tbody>
        @forelse(($transaksi ?? collect()) as $index => $row)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $row->kode_transaksi ?? '-' }}</td>
            <td>{{ $row->tanggal_transaksi ?? '-' }}</td>
            <td>{{ $row->id_anggota ?? '-' }}</td>
            <td>{{ $row->nama_anggota ?? '-' }}</td>
            <td>{{ $row->jenis_penarikan ?? '-' }}</td>
            <td>{{ isset($row->jumlah) ? number_format($row->jumlah, 0, ',', '.') : '-' }}</td>
            <td>{{ $row->user ?? '-' }}</td>
            <td>
              <a href="{{ route('simpanan.cetak', $row->id ?? '#') }}" 
                 class="btn-nota">🧾 Nota</a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="9" class="empty-cell">Belum ada data penarikan tunai.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<style>
:root {
  --primary: #6ba1be;
  --primary-dark: #558ca3;
  --header-bg: #4a4a4a;
  --header-text: #ffffff;
  --border: #c0c0c0;
  --text: #222;
}

.penarikan-wrap {
  border-radius: 0;
  background: var(--bg);
  width: 100%;
  margin-left: 15px;
  margin-top: -15px;
  padding: 0;
  box-shadow: none;
}

/* Scroll aktif */
.table-scroll-wrapper {
  overflow-x: auto;
  overflow-y: auto;
  max-height: 400px;
  width: 98%;
  padding: 30px 16px 8px 16px;
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
.penarikan-table {
  width: 100%;
  min-width: 1000px;
  border-collapse: collapse;
  background: #ffffff;
  font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
  font-size: 13px;
  color: var(--text);
  table-layout: auto;
}

.penarikan-table thead {
  background: var(--header-bg);
  color: var(--header-text);
  position: sticky;
  top: 0;
  z-index: 1;
}

.penarikan-table th,
.penarikan-table td {
  text-align: center;
  padding: 10px 14px;
  border: 1px solid var(--border);
  white-space: nowrap;
  vertical-align: middle;
}

.penarikan-table tbody tr:nth-child(even) {
  background-color: #f9f9f9;
}

.penarikan-table tbody tr:hover {
  background-color: #eef7ff;
}

.empty-cell {
  text-align: center;
  color: #6b7280;
  font-style: italic;
}

/* Tombol Nota */
.btn-nota {
  display: inline-block;
  background-color: #0099cc;
  color: #fff;
  padding: 4px 10px;
  border-radius: 4px;
  text-decoration: none;
  font-size: 13px;
  transition: background 0.2s;
}
.btn-nota:hover {
  background-color: #0077aa;
}
</style>

@endsection