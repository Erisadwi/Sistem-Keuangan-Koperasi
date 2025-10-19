@extends('layouts.app-admin3')

@section('title', 'Data Pengguna')  
@section('title-1', 'Master Data')  
@section('sub-title', 'Data Pengguna')  

@section('content')

<x-menu.tambah-unduh 
    addUrl="# {{-- {{ route('data-pengguna.create') }} --}}" 
    downloadFile="data_pengguna.pdf" />

<div class="laporan-data-pengguna-wrap">
  <div class="table-scroll-wrapper">
    <table class="data-pengguna-table">
      <thead>
        <tr class="head-group">
          <th>ID Pengguna</th>
          <th>Username</th>
          <th>Nama Lengkap</th>
          <th>Jenis Kelamin</th>
          <th>Alamat</th>
          <th>Tanggal Masuk</th>
          <th>Tanggal Keluar</th>
          <th>Keanggotaan</th>
          <th>Foto</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse(($pengguna ?? collect()) as $idx => $row)
          <tr>
            <td>{{ $row->id_pengguna ?? '' }}</td>
            <td>{{ $row->username ?? '' }}</td>
            <td>{{ $row->nama_lengkap ?? '' }}</td>
            <td>{{ $row->jenis_kelamin ?? '' }}</td>
            <td>{{ $row->alamat ?? '' }}</td>
            <td>{{ $row->tgl_masuk ?? '' }}</td>
            <td>{{ $row->tgl_keluar ?? '-' }}</td>
            <td>
              <span class="{{ $row->keanggotaan == 'Aktif' ? 'aktif' : 'nonaktif' }}">
                {{ $row->keanggotaan ?? '' }}
              </span>
            </td>
            <td>
              @if(!empty($row->foto))
                <img src="{{ asset('storage/foto/' . $row->foto) }}" alt="Foto" class="foto-user">
              @else
                <span>-</span>
              @endif
            </td>
            <td class="actions">
              <a href="{{ route('data-pengguna.edit', ['id' => $row->id]) }}" class="edit">✏️ Edit</a>
              <form action="{{ route('data-pengguna.destroy', ['id' => $row->id]) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete">❌ Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="10" class="empty-cell">Belum ada data pengguna</td>
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

/* Wrapper utama tabel agar mirip Kas Pinjaman */
.laporan-data-pengguna-wrap {
  border: 1.5px solid var(--border);
  border-radius: 0;
  background: var(--bg);
  width: 870px;
  margin-left: 25px;
  margin-top: 60px;
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
.data-pengguna-table {
  width: 100%;
  min-width: 1000px;
  border-collapse: collapse;
  background: #ffffff;
  font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
  font-size: 13px;
  color: var(--text);
  table-layout: auto;
}

.data-pengguna-table thead {
  background: var(--header-bg);
  color: var(--header-text);
  position: sticky;
  top: 0;
  z-index: 1;
}

.data-pengguna-table th,
.data-pengguna-table td {
  text-align: center;
  padding: 10px 14px;
  border: 1px solid var(--border);
  white-space: nowrap;
  vertical-align: middle;
}

.data-pengguna-table tbody tr:nth-child(even) {
  background-color: #f9f9f9;
}

.data-pengguna-table tbody tr:hover {
  background-color: #eef7ff;
}

/* Foto & Status */
.foto-user {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
}

.aktif {
  color: green;
  font-weight: 600;
}

.nonaktif {
  color: red;
  font-weight: 600;
}

/* Tombol aksi */
.actions {
  display: flex;
  justify-content: center;
  gap: 8px;
}

.edit, .delete {
  padding: 6px 10px;
  border-radius: 5px;
  text-decoration: none;
  font-weight: 600;
  border: none;
  cursor: pointer;
  color: #fff;
}

.edit {
  background-color: #25E11B;
}

.edit:hover {
  background-color: #1db113;
}

.delete {
  background-color: #FF0000;
}

.delete:hover {
  background-color: #c60b0b;
}

.empty-cell {
  text-align: center;
  color: #6b7280;
  font-style: italic;
}
</style>

@endsection
