@extends('layouts.laporan-admin2')

@section('title', 'Laporan Kas Pinjaman')
@section('title-1', 'Kas Pinjaman')
@section('title-content', 'Laporan Pinjaman')
@section('period', 'Periode 01 Jan 2025 - 31 Des 2025')
@section('sub-title', 'Laporan Kas Pinjaman')

@section('content')

<x-menu.month-filter/>
<x-menu.unduh/>

<div class="laporan-kas-pinjaman-wrap">
  <div class="table-scroll-wrapper">
    <div class="laporan-info">
      <p>Jumlah Peminjam : 504</p>
      <p>Peminjam Lunas : 376</p>
      <p>Pinjaman Belum Lunas : 128</p>
    </div>

    <table class="laporan-kas-pinjaman-table">
      <thead>
        <tr class="head-group">
          <th>No.</th>
          <th>Keterangan</th>
          <th>Jumlah</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>Pokok Pinjaman</td>
          <td>660.117.616</td>
        </tr>
        <tr>
          <td>2</td>
          <td>Tagihan Pinjaman</td>
          <td>751.662.700</td>
        </tr>
        <tr>
          <td>3</td>
          <td>Tagihan Denda</td>
          <td>0</td>
        </tr>
        <tr class="total-row">
          <td colspan="2"><b>Jumlah Tagihan + Denda</b></td>
          <td><b>751.662.700</b></td>
        </tr>
        <tr>
          <td>4</td>
          <td>Tagihan Sudah Dibayar</td>
          <td>237.211.000</td>
        </tr>
        <tr>
          <td>5</td>
          <td>Sisa Tagihan</td>
          <td>514.451.700</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

{{-- Komponen pagination --}}
<x-menu.pagination />

<style>
:root {
  --primary: #6ba1be;
  --primary-dark: #558ca3;
  --header-bg: #4a4a4a;
  --header-text: #ffffff;
  --border: #c0c0c0;
  --background: #ffffff;
  --text: #222;
}

/* Wrapper luar */
.laporan-kas-pinjaman-wrap {
  border: 1.5px solid var(--outer-border);
  border-radius: 0;
  background: var(--bg);
  width: 870px;          
  margin-left: 25px;     
  margin-top: 60px;       
  padding: 0;             
  box-shadow: none;       
  overflow-x: visible;
}

/* Scroll wrapper */
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

/* Info text di atas tabel */
.laporan-info {
  font-size: 14px;
  color: var(--text);
  margin-bottom: 12px;
  line-height: 1.5;
}

/* Tabel utama */
.laporan-kas-pinjaman-table {
  width: 100%;
  min-width: 1000px;
  border-collapse: collapse;
  background: #ffffff;
  font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
  font-size: 14px;
  table-layout: auto;
}

.laporan-kas-pinjaman-table thead {
  background: var(--header-bg);
  color: var(--header-text);
  position: sticky;
  top: 0;
  z-index: 1;
}

.laporan-kas-pinjaman-table th,
.laporan-kas-pinjaman-table td {
  text-align: center;
  padding: 10px 14px;
  border: 1px solid var(--border);
  white-space: nowrap;
  vertical-align: middle;
}

.laporan-kas-pinjaman-table tbody tr:nth-child(even) {
  background-color: #f9f9f9;
}

.laporan-kas-pinjaman-table tbody tr:hover {
  background-color: #eef7ff;
}

.laporan-kas-pinjaman-table .total-row {
  background-color: #e6f1f8;
  font-weight: bold;
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
</style>

@endsection
