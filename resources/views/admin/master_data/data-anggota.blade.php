@extends('layouts.app-admin')

@section('title', 'Data Anggota')
@section('title-1', 'Master Data')
@section('sub-title', 'Data Anggota')

@section('content')

{{-- Komponen tombol tambah & unduh --}}
<x-menu.tambah-unduh-cari
    addUrl="#" {{-- nanti bisa diganti route('anggota.create') --}}
    downloadFile="data-anggota.pdf" 
/>

{{-- Wrapper konten tabel --}}
<div class="content-inner">
  <div class="table-scroll-wrapper">
    <table class="table table-bordered table-striped data-anggota-table">
      <thead class="table-primary text-center">
        <tr>
          <th>Foto</th>
          <th>ID Anggota</th>
          <th>Username</th>
          <th>Nama Lengkap</th>
          <th>Jenis Kelamin</th>
          <th>Alamat</th>
          <th>Kota</th>
          <th>Jabatan</th>
          <th>Tanggal Registrasi</th>
          <th>Tanggal Keluar</th>
          <th>Keanggotaan</th>
          <th>Aksi</th>
        </tr>
      </thead>

      <tbody>
        {{-- Loop data anggota, aman walau belum ada controller/database --}}
        @forelse(($anggota ?? collect()) as $row)
          <tr class="text-center">
            <td>
              <img src="{{ asset($row->foto ?? 'images/default-user.png') }}" 
                   width="40" height="40" 
                   class="rounded-circle border" 
                   alt="Foto">
            </td>
            <td>{{ $row->id_anggota ?? '-' }}</td>
            <td>{{ $row->username ?? '-' }}</td>
            <td>{{ $row->nama_lengkap ?? '-' }}</td>
            <td>{{ $row->jenis_kelamin ?? '-' }}</td>
            <td>{{ $row->alamat ?? '-' }}</td>
            <td>{{ $row->kota ?? '-' }}</td>
            <td>{{ $row->jabatan ?? '-' }}</td>
            <td>{{ $row->tanggal_registrasi ?? '-' }}</td>
            <td>{{ $row->tanggal_keluar ?? '-' }}</td>
            <td>{{ $row->status_keanggotaan ?? '-' }}</td>
            <td class="actions">
              <a href="{{ route('anggota.edit', $row->id ?? '#') }}" class="btn btn-sm btn-warning">✏️ Edit</a>
              <button class="btn btn-sm btn-danger">🗑️ Hapus</button>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="12" class="text-center text-muted py-3">
              Belum ada data anggota.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- Komponen pagination --}}
<x-menu.pagination />

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

/* Wrapper utama agar sejajar dengan tombol */
.content-inner {
  padding-left: 25px;
  padding-right: 25px;
  margin-top: 25px;
}

/* Scroll area tabel */
.table-scroll-wrapper {
  overflow-x: auto;
  overflow-y: auto;
  max-height: 400px;
  width: 100%;
  background: transparent;
  border-radius: 4px;
  padding-bottom: 8px;
}

/* Pastikan tabel tetap putih */
.table-scroll-wrapper table {
  margin-bottom: 0;
  background: white;
}

/* Scrollbar styling */
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

/* Tabel */
.data-anggota-table {
  width: 100%;
  min-width: 1000px;
  border-collapse: collapse;
  font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
  font-size: 14px;
  color: var(--text);
}

.data-anggota-table thead {
  background: var(--header-bg);
  color: var(--header-text);
  position: sticky;
  top: 0;
  z-index: 2;
}

.data-anggota-table th,
.data-anggota-table td {
  text-align: center;
  padding: 10px 14px;
  border: 1px solid var(--border);
  white-space: nowrap;
}

.data-anggota-table tbody tr:nth-child(even) {
  background-color: #f9f9f9;
}

.data-anggota-table tbody tr:hover {
  background-color: #eef7ff;
}

/* Tombol Aksi */
.actions {
  display: flex;
  justify-content: center;
  gap: 8px;
}

.actions .btn {
  font-size: 13px;
  padding: 5px 10px;
  border-radius: 5px;
}

.actions .btn-warning {
  background-color: #f0ad4e;
  color: white;
  border: none;
}

.actions .btn-danger {
  background-color: #d9534f;
  color: white;
  border: none;
}

/* Pagination */
.pagination {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  gap: 6px;
  margin-top: 15px;
  font-size: 14px;
}

.pagination select,
.pagination button {
  padding: 4px 6px;
  border-radius: 4px;
  border: 1px solid var(--border);
  background: white;
  cursor: pointer;
}

.pagination button {
  background: var(--primary);
  color: white;
  border: none;
}

.pagination button:hover {
  background: var(--primary-dark);
}

/* Responsif */
@media (max-width: 640px) {
  .data-anggota-table {
    font-size: 12px;
  }
  .data-anggota-table th,
  .data-anggota-table td {
    padding: 8px;
  }
}
</style>

@endsection