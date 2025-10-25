@extends('layouts.app-admin3')

@section('title', 'Jenis Akun Transaksi')
@section('title-1', 'Master Data')
@section('sub-title', 'Jenis Akun Transaksi')

@section('content')

<x-menu.tambah-unduh-cari
    addUrl="{{ route('jenis-akun-transaksi.create') }}
    downloadFile="jenis-akun-transaksi.pdf" 
/>

{{-- Wrapper konten tabel --}}
<div class="content-inner">
  <div class="table-scroll-wrapper">
    <table class="table table-bordered table-striped jenis-akun-transaksi-table">
      <thead class="table-primary text-center">
        <tr>
          <th>Kode Aktiva</th>
          <th>Jenis Transaksi</th>
          <th>Akun</th>
          <th>Pemasukan</th>
          <th>Pengeluaran</th>
          <th>Aktif</th>
          <th>Laba Rugi</th>
          <th>Non Kas</th>
          <th>Simpanan</th>
          <th>Pinjaman</th>
          <th>Pinjaman dari</th>
          <th>Angsuran</th>
          <th>Aksi</th>
        </tr>
      </thead>

      <tbody>
        {{-- Jika belum ada data, tampilkan pesan --}}
        @forelse(($transaksi ?? collect()) as $row)
          <tr class="text-center">
            <td>{{ $row->kode_aktiva ?? '-' }}</td>
            <td>{{ $row->nama_transaksi ?? '-' }}</td>
            <td>{{ $row->akun ?? '-' }}</td>
            <td>{{ $row->pemasukan ?? '-' }}</td>
            <td>{{ $row->pengeluaran ?? '-' }}</td>
            <td>{{ $row->aktif ?? '-' }}</td>
            <td>{{ $row->laba_rugi ?? '-' }}</td>
            <td>{{ $row->non_kas ?? '-' }}</td>
            <td>{{ $row->simpanan ?? '-' }}</td>
            <td>{{ $row->pinjaman ?? '-' }}</td>
            <td>{{ $row->pinjam_dari ?? '-' }}</td>
            <td>{{ $row->angsuran ?? '-' }}</td>
            <td class="actions">
              <a href="{{ route('jenis-akun-transaksi.edit', ['id' => $row->id_jenisAkunTransaksi]) }}" class="btn btn-sm btn-warning">✏️ Edit</a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="13" class="empty-cell">
              Belum ada data jenis akun transaksi.
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

/* Wrapper utama agar sejajar dengan tombol */
.content-inner {
  padding-left: 25px;   /* sejajar tombol */
  padding-right: 25px;
  margin-top: 30px;     /* jarak ideal antara tombol dan tabel */
}

/* Scroll area tabel */
.table-scroll-wrapper {
  overflow-x: auto;
  overflow-y: auto;
  max-height: 400px;
  width: 100%;
  background: transparent;  /* hindari warna putih antar tabel dan scrollbar */
  border-radius: 4px;
  padding-bottom: 8px;       /* jarak kecil agar scrollbar tidak nempel */
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
.jenis-akun-transaksi-table {
  width: 100%;
  min-width: 1000px; /* supaya scroll horizontal aktif kalau kolom banyak */
  border-collapse: collapse;
  font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
  font-size: 13px;
  color: var(--text);
}

.jenis-akun-transaksi-table thead {
  background: var(--header-bg);
  color: var(--header-text);
  position: sticky;
  top: 0;
  z-index: 2;
}

.jenis-akun-transaksi-table th,
.jenis-akun-transaksi-table td {
  text-align: center;
  padding: 10px 14px;
  border: 1px solid var(--border);
  white-space: nowrap;
}

.jenis-akun-transaksi-table tbody tr:nth-child(even) {
  background-color: #f9f9f9;
}

.jenis-akun-transaksi-table tbody tr:hover {
  background-color: #eef7ff;
}

.jenis-akun-transaksi-table .empty-cell {
  text-align: center;
  color: #6b7280;
  font-style: italic;
}

.jenis-akun-transaksi-table .empty-cell {
    text-align: center;
    padding: 8px 10px;
    color: #6b7280;
    font-style: italic;
  }

/* Tombol Edit */
.actions {
  display: flex;
  justify-content: center;
  gap: 8px;
}

.edit {
  background-color: #25E11B;
  color: white;
  text-decoration: none;
  padding: 6px 10px;
  border-radius: 5px;
  font-size: 13px;
}

.edit:hover {
  background-color: #1da213;
}

/* Responsif */
@media (max-width: 640px) {
  .jenis-akun-transaksi-table {
    font-size: 12px;
  }
  .jenis-akun-transaksi-table th,
  .jenis-akun-transaksi-table td {
    padding: 8px;
  }
}
</style>

@endsection
