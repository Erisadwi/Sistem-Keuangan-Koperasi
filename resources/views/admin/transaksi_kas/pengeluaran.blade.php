@extends('layouts.app-admin3')

@section('title', 'Transaksi Pengeluaran Kas')
@section('title-1', 'Transaksi Kas')
@section('sub-title', 'Data Pengeluaran Kas Tunai')

@section('content')

{{-- Komponen tombol tambah & unduh --}}
<x-menu.tambah-edit-hapus
    addUrl="#" {{-- nanti bisa diganti route('pengeluaran.create') --}}
/>
<x-menu.toolbar-right/>

{{-- Wrapper konten tabel --}}
<div class="content-inner">
  <div class="table-scroll-wrapper">
    <table class="table table-bordered table-striped pengeluaran-table">
      <thead class="table-primary text-center">
        <tr>
          <th>No</th>
          <th>Kode Transaksi</th>
          <th>Tanggal Transaksi</th>
          <th>Uraian</th>
          <th>Dari Kas</th>
          <th>Untuk Akun</th>
          <th>Jumlah</th>
          <th>User</th>
        </tr>
      </thead>

      <tbody>
        {{-- Loop data transaksi, aman walau belum ada controller/database --}}
        @forelse(($transaksi ?? collect()) as $index => $row)
          <tr class="text-center">
            <td>{{ $index + 1 }}</td>
            <td>{{ $transaksi->kode_transaksi ?? '-' }}</td>
            <td>{{ $transaksi->tanggal_transaksi ?? '-' }}</td>
            <td>{{ $transaksi->ket_transaksi ?? '-' }}</td>
            <td>{{ $transaksi->jenisAkunTransaksi_sumber ?? '-' }}</td>
            <td>{{ $transaksi->jenisAkunTransaksi_tujuan ?? '-' }}</td>
            <td>{{ isset($transaksi->jumlah_transaksi) ? number_format($row->jumlah, 0, ',', '.') : '-' }}</td>
            <td>{{ $transaksi->user ?? '-' }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="8" class="empty-cell"> 
              Belum ada data transaksi pengeluaran kas.
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
  padding-left: 25px;
  padding-right: 60px;
  margin-top: 25px;
}

/* Scroll area tabel */
.table-scroll-wrapper {
  overflow-x: auto;
  overflow-y: auto;
  max-height: 380px;
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
.pengeluaran-table {
  width: 100%;
  min-width: 1000px;
  border-collapse: collapse;
  font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
  font-size: 14px;
  color: var(--text);
}

.pengeluaran-table thead {
  background: var(--header-bg);
  color: var(--header-text);
  position: sticky;
  top: 0;
  z-index: 2;
}

.pengeluaran-table th,
.pengeluaran-table td {
  text-align: center;
  padding: 10px 14px;
  border: 1px solid var(--border);
  white-space: nowrap;
}

.pengeluaran-table tbody tr:nth-child(even) {
  background-color: #f9f9f9;
}

.pengeluaran-table tbody tr:hover {
  background-color: #eef7ff;
}

.pengeluaran-table .empty-cell {
    text-align: center;
    padding: 8px 10px;
    color: #6b7280;
    font-style: italic;
  }


/* Responsif */
@media (max-width: 640px) {
  .pengeluaran-table {
    font-size: 12px;
  }
  .pengeluaran-table th,
  .pengeluaran-table td {
    padding: 8px;
  }
}
</style>

@endsection
