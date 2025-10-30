@extends('layouts.app-admin3')

@section('title', 'Simpanan Setoran Tunai')
@section('title-1', 'Simpanan')
@section('sub-title', 'Data Transaksi Setoran Tunai')

@section('content')

{{-- Komponen --}}
<x-menu.toolbar-simpanan 
    addUrl="{{ route('setoran-tunai.create') }}"
    editUrl="{{ route('setoran-tunai.edit', ['id' => '__ID__']) }}"
    exportUrl="{{ route('setoran-tunai.export') }}"
/>



{{-- Wrapper konten tabel --}}
<div class="content-inner">
  <div class="table-scroll-wrapper">
    <table class="table table-bordered table-striped simpanan-table">
      <thead class="table-primary text-center">
        <tr>
          <th>No</th>
          <th>Kode Transaksi</th>
          <th>Tanggal Transaksi</th>
          <th>ID Anggota</th>
          <th>Nama Anggota</th>
          <th>Jenis Simpanan</th>
          <th>Jumlah</th>
          <th>User</th>
          <th>Cetak Nota</th>
        </tr>
      </thead>

      <tbody>
        @forelse($setoranTunai ?? collect() as $index => $simpanan)
          <tr class="text-center">
            <td>{{ $index + 1 }}</td>
            <td>{{ $simpanan->kode_simpanan ?? '-' }}</td>
            <td>{{ $simpanan->tanggal_transaksi ? \Carbon\Carbon::parse($simpanan->tanggal_transaksi)->format('d-m-Y H:i') : '-' }}</td>
            <td>{{ $simpanan->anggota->id_anggota ?? '-' }}</td>
            <td>{{ $simpanan->anggota->nama_anggota ?? '-' }}</td>
            <td>{{ $simpanan->jenisSimpanan->jenis_simpanan ?? '-' }}</td>
            <td>{{ isset($simpanan->jumlah_simpanan) ? number_format($simpanan->jumlah_simpanan, 0, ',', '.') : '-' }}</td>
            <td>{{ $simpanan->data_user->nama_lengkap ?? '-' }}</td>
            <td>
              <a href="{{ route('simpanan.cetak', $simpanan->id_simpanan ?? 0) }}" 
                 class="btn-nota">🧾 Nota</a>
            </td>
          </tr>   
        @empty
          <tr>
            <td colspan="9" class="empty-cell"> 
              Belum ada data setoran tunai.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- STYLE --}}
<style>
:root {
  --primary: #6ba1be;
  --primary-dark: #558ca3;
  --header-bg: #4a4a4a;
  --header-text: #ffffff;
  --border: #c0c0c0;
  --text: #222;
}

.content-inner {
  padding-left: 25px;
  padding-right: 25px;
  margin-top: 25px;
}

.table-scroll-wrapper {
  overflow-x: auto;
  overflow-y: auto;
  max-height: 400px;
  width: 100%;
  background: transparent;
  border-radius: 4px;
  padding-bottom: 8px;
}

.table-scroll-wrapper table {
  margin-bottom: 0;
  background: white;
}

.table-scroll-wrapper::-webkit-scrollbar {
  height: 8px;
}
.table-scroll-wrapper::-webkit-scrollbar-thumb {
  background: var(--primary);
  border-radius: 4px;
}
.table-scroll-wrapper::-webkit-scrollbar-track {
  background: #f0f0f0;
}

.simpanan-table {
  width: 100%;
  border-collapse: collapse;
  font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
  font-size: 14px;
  color: var(--text);
}

.simpanan-table thead {
  background: var(--header-bg);
  color: var(--header-text);
  position: sticky;
  top: 0;
  z-index: 2;
}

.simpanan-table th,
.simpanan-table td {
  text-align: center;
  padding: 10px 14px;
  border: 1px solid var(--border);
  white-space: nowrap;
}

.simpanan-table tbody tr:nth-child(even) {
  background-color: #f9f9f9;
}

.simpanan-table tbody tr:hover {
  background-color: #eef7ff;
}

.simpanan-table .empty-cell {
  text-align: center;
  padding: 8px 10px;
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

@media (max-width: 640px) {
  .simpanan-table {
    font-size: 12px;
  }
  .simpanan-table th,
  .simpanan-table td {
    padding: 8px;
  }
}
</style>

@endsection
