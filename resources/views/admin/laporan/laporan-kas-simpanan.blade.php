@extends('layouts.laporan-admin2')

@section('title', 'Laporan Kas Simpanan')  
@section('title-1', 'Kas Simpanan')  
@section('title-content', 'Laporan Simpanan Anggota')  
@section('period', 'Periode 01 Mei 2025 - 31 Mei 2025')  
@section('sub-title', 'Laporan Kas Simpanan')  

@section('content')

<x-menu.month-filter/>
<x-menu.unduh/>

<div class="laporan-simpanan-wrap">
  <div class="table-scroll-wrapper">
    <table class="laporan-simpanan-table">
      <thead>
        <tr>
          <th>No.</th>
          <th>Keterangan</th>
          <th>Nominal Simpanan</th>
          <th>Nominal Penarikan</th>
          <th>Jumlah</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>Simpanan Sukarela</td>
          <td>1.000.000</td>
          <td>817.437</td>
          <td>182.563</td>
        </tr>
        <tr>
          <td>2</td>
          <td>Simpanan Pokok</td>
          <td>400.000</td>
          <td>0</td>
          <td>400.000</td>
        </tr>
        <tr>
          <td>3</td>
          <td>Simpanan Wajib</td>
          <td>13.500.000</td>
          <td>0</td>
          <td>13.500.000</td>
        </tr>
        <tr class="total-row">
          <td colspan="2"><strong>Jumlah Total</strong></td>
          <td><strong>14.900.000</strong></td>
          <td><strong>817.437</strong></td>
          <td><strong>14.082.563</strong></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

{{-- Pagination --}}
<x-menu.pagination />

<style>
:root {
  --primary: #6ba1be;         
  --primary-dark: #558ca3;    
  --header-bg: #4a4a4a;      
  --header-text: #ffffff;
  --border: #c0c0c0;
  --background: #e0edf3;      
  --text: #222;
}

/* ===== Wrapper luar ===== */
.laporan-simpanan-wrap {
  border: 1.5px solid var(--outer-border);
  border-radius: 0;
  background: var(--bg);
  width: 98%;          
  margin-left: 10px;     
  margin-top: 65px;      
  padding: 0;             
  box-shadow: none;       
  overflow-x: visible;
}

/* ===== Wrapper scroll (agar tabel bisa horizontal scroll) ===== */
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
}
.table-scroll-wrapper::-webkit-scrollbar-thumb {
  background: var(--primary);
  border-radius: 4px;
}
.table-scroll-wrapper::-webkit-scrollbar-track {
  background: #f0f0f0;
}

/* ===== Tabel utama ===== */
.laporan-simpanan-table {
  width: 100%;
  min-width: 1000px; /* biar bisa scroll horizontal */
  border-collapse: collapse;
  background: white;
  font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
  font-size: 14px;
  table-layout: auto;
}

/* ===== Header ===== */
.laporan-simpanan-table thead {
  background: var(--header-bg);
  color: var(--header-text);
  position: sticky;
  top: 0;
  z-index: 1;
}

.laporan-simpanan-table th,
.laporan-simpanan-table td {
  text-align: center;
  padding: 10px 14px;
  border: 1px solid var(--border);
  white-space: nowrap;
  vertical-align: middle;
}

/* ===== Warna baris ===== */
.laporan-simpanan-table tbody tr:nth-child(even) {
  background-color: #f9f9f9;
}
.laporan-simpanan-table tbody tr:hover {
  background-color: #eef7ff;
}

/* ===== Baris total ===== */
.total-row td {
  background-color: var(--header-bg);
  color: #ffffff;
  font-weight: bold;
}
</style>

@endsection
