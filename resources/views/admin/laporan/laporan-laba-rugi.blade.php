@extends('layouts.laporan-admin2')

@push('styles')
 @vite('resources/css/style-laporanBukuBesar.css')
@endpush

@section('title', 'Laporan Laba Rugi')  
@section('title-1', 'Laba Rugi')  
@section('title-content', 'Laporan Laba Rugi')  
@section('period', 'Periode 1 Jan 2025 - 31 Des 2025')  
@section('sub-title', 'Laporan Laba Rugi')  

@section('content')

<x-menu.date-filter/>
<x-menu.unduh/>

<div class="laporan-laba-rugi-wrap">
  <div class="table-scroll-wrapper">
    
    <h4 class="judul-section">Estimasi Data Pinjaman</h4>
    @include('partials.laba-rugi-table', ['data' => $estimasiDataPinjaman ?? null, 'label' => 'estimasi data pinjaman'])

    <h4 class="judul-section">Pinjaman</h4>
    @include('partials.pinjaman-table', ['data' => $pinjaman ?? null, 'label' => 'pinjaman'])

    <h4 class="judul-section">Pendapatan</h4>
    @include('partials.pendapatan-table', ['data' => $pendapatan ?? null, 'label' => 'pendapatan'])

    <h4 class="judul-section">Biaya - Biaya</h4>
    @include('partials.pendapatan-table', ['data' => $biaya ?? null, 'label' => 'biaya - biaya'])

  </div>
</div>


@endsection

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

/* Wrapper luar */
.laporan-laba-rugi-wrap {
  border: 1.5px solid var(--outer-border);
  border-radius: 0;
  background: var(--bg);
  width: 870px;          
  margin-left: 25px;     
  margin-top: 65px;       
  padding: 0;             
  box-shadow: none;       
  overflow-x: visible; 
}

/* Judul section */
.judul-section {
  font-weight: 600;
  font-size: 16px;
  margin-top: 14px;      /* ↑ agak diturunkan biar tidak nabrak judul atas */
  margin-bottom: 4px;    /* ↓ jarak ke tabel sedikit lebih dekat */
  color: #333;
}

/* Wrapper scroll */
.table-scroll-wrapper {
  overflow-x: auto;
  overflow-y: auto;
  max-height: 700px;
  width: 100%;
  padding: 8px 16px 10px 16px; /* ↓ kecilkan padding atas biar tabel lebih dekat dengan judul */
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

/* Tabel utama */
.laba-rugi-table {
  width: 100%;
  min-width: 1000px; /* Paksa scroll horizontal jika terlalu lebar */
  border-collapse: collapse;
  background: white;
  font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
  font-size: 14px;
  table-layout: auto
}

.laba-rugi-table thead {
  background: var(--header-bg);
  color: var(--header-text);
  position: sticky;
  top: 0;
  z-index: 1;
}

.laba-rugi-table th,
.laba-rugi-table td {
  text-align: center;
  padding: 10px 14px;
  border: 1px solid var(--border);
  white-space: nowrap;
  vertical-align: middle;
}

.laba-rugi-table tbody tr:nth-child(even) {
  background-color: #f9f9f9;
}

.laba-rugi-table tbody tr:hover {
  background-color: #eef7ff;
}

.laba-rugi-table .empty-cell {
  width: 200px;          
  text-align: center;
  padding: 10px;
  color: #6b7280;
  font-style: italic;
  background: #ffffff;
  border-radius: 6px;
}
</style>