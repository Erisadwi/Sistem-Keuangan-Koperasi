@extends('layouts.app-admin3')

@section('title', 'Data Anggota')
@section('title-1', 'Master Data')
@section('sub-title', 'Data Anggota')

@section('content')

<x-menu.tambah-unduh-cari
    addUrl="{{ route('anggota.create') }}" 
    downloadFile="data-anggota.pdf" 
/>

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
        @forelse(($anggota ?? collect()) as $row)
          <tr class="text-center">
            <td>
              <img src="{{ asset($row->foto ?? 'images/default-user.png') }}" 
                   width="40" height="40" 
                   class="rounded-circle border" 
                   alt="Foto">
            </td>
            <td>{{ $row->id_anggota ?? '-' }}</td>
            <td>{{ $row->username_anggota ?? '-' }}</td>
            <td>{{ $row->nama_anggota ?? '-' }}</td>
            <td>{{ $row->jenis_kelamin ?? '-' }}</td>
            <td>{{ $row->alamat_anggota ?? '-' }}</td>
            <td>{{ $row->kota_anggota ?? '-' }}</td>
            <td>{{ $row->jabatan ?? '-' }}</td>
            <td>{{ $row->tanggal_registrasi ?? '-' }}</td>
            <td>{{ $row->tanggal_keluar ?? '-' }}</td>
            <td>{{ $row->status_anggota ?? '-' }}</td>
            <td class="actions">
              <a href="{{ route('anggota.edit', ['id' => $row->id_anggota]) }}" class="btn btn-sm btn-warning">✏️ Edit</a>
              <form action="{{ route('anggota.destroy', ['id' => $row->id_anggota]) }}" method="POST" class="form-hapus" style="display: inline;">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger">❌ Hapus</button>
            </form
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="12" class="empty-cell">
              Belum ada data anggota.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

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
  font-size: 13px;
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

.data-anggota-table .empty-cell {
    text-align: center;
    padding: 8px 10px;
    color: #6b7280;
    font-style: italic;
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
  background-color: #25E11B;
  color: white;
  border: none;
  text-decoration: none;
}

.actions .btn-danger {
  background-color: #d9534f;
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