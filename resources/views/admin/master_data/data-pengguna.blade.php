@extends('layouts.app-admin3')

@section('title', 'Data Pengguna')  
@section('title-1', 'Master Data')  
@section('sub-title', 'Data Pengguna')  

@section('content')

<x-menu.tambah-unduh 
    addUrl="{{ route('data-user.create') }} " 
    downloadFile="{{ route('data-user.export') }}" />

<div class="laporan-data-pengguna-wrap">
  <div class="table-scroll-wrapper">
    <table class="data-pengguna-table">
      <thead>
        <tr class="head-group">
          <th>ID Pengguna</th>
          <th>Username</th>
          <th>Nama Lengkap</th>
          <th>Role</th>
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
        @forelse(($users ?? collect()) as $idx => $row)
          <tr>
            <td>{{ $row->id_user ?? '' }}</td>
            <td>{{ $row->username ?? '' }}</td>
            <td>{{ $row->nama_lengkap ?? '' }}</td>
            <td>{{ $row->role->nama_role ?? '' }}</td>
            <td>{{ $row->jenis_kelamin ?? '' }}</td>
            <td>{{ $row->alamat_user ?? '' }}</td>
            <td>{{ $row->tanggal_masuk ?? '' }}</td>
            <td>{{ $row->tanggal_keluar ?? '' }}</td>
            <td>
              <span class="{{ $row->status == 'Aktif' ? 'aktif' : 'nonaktif' }}">
                {{ $row->status ?? '' }}
              </span>
            </td>
            <td>
              @if ($row->foto_user)
              <img src="{{ asset('storage/foto_user/' . $row->foto_user) }}" 
                alt="Foto {{ $row->nama_lengkap }}" 
                width="70" height="70" 
                style="object-fit: cover; border-radius: 50%;">
              @else
                <img src="{{ asset('images/default-user.png') }}" 
                alt="Default" 
                width="70" height="70">
              @endif
            </td>
            <td class="actions">
              <div class="aksi-wrapper">
                <a href="{{ route('data-user.edit', ['id' => $row->id_user]) }}" class="edit">✏️ Edit</a>
                <form action="{{ route('data-user.destroy', ['id' => $row->id_user]) }}" method="POST" class="form-hapus">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="delete">❌ Hapus</button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="11" class="empty-cell">Belum ada data pengguna</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <x-menu.pagination :data="$users" />
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

.laporan-data-pengguna-wrap {
  border-radius: 0;
  background: var(--bg);
  width: 98%;          
  margin-left: 10px;     
  margin-top: 0px; 
  padding: 0;
  box-shadow: none;
}

.table-scroll-wrapper {
  overflow-x: auto;
  overflow-y: hidden; 
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

.data-pengguna-table {
  width: 100%;
  min-width: 1000px;
  border-collapse: collapse;
  background: #ffffff !important;
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
  background-color: #f9f9f9 !important;
}

.data-pengguna-table tbody tr:hover {
  background-color: #eef7ff !important;
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

/* --- PERBAIKAN DI SINI --- */
td.actions {
  background-color: inherit !important; /* ikut warna baris */
  padding: 10px !important;
  vertical-align: middle;
}

.aksi-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 8px;
  height: 100%;
}

.actions .edit,
.actions .delete {
  padding: 6px 12px;
  border-radius: 8px;
  text-decoration: none;
  font-weight: 600;
  color: #fff !important;
  display: inline-block;
  border: none;
  cursor: pointer;
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

<script>
document.querySelectorAll('.form-hapus').forEach(function(form) {
    form.addEventListener('submit', function (e) {
        e.preventDefault(); 

        const yakin = confirm('⚠️ Apakah Anda yakin ingin menghapus data ini?');

        if (yakin) {
            alert('🗑️ Data berhasil dihapus!');
            form.submit(); 
        } else {
            alert('❌ Penghapusan data dibatalkan.');
        }
    });
});
</script>

@endsection
