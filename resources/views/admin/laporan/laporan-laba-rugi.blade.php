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

<x-menu.date-filter-filter/>
<x-menu.unduh/>

<div class="laporan-laba-rugi-wrap">
  <div class="table-scroll-wrapper">
    
    {{-- Estimasi Data Pinjaman --}}
    <h4 class="judul-section">Estimasi Data Pinjaman</h4>
    @include('partials.buku-besar-table', ['data' => $kasBesar ?? null, 'label' => 'kas besar'])

    {{-- 2. Bank Mandiri --}}
    <h4 class="judul-section">2. Bank Mandiri</h4>
    @include('partials.buku-besar-table', ['data' => $bankMandiri ?? null, 'label' => 'bank mandiri'])

    {{-- 3. Kas Kecil --}}
    <h4 class="judul-section">3. Kas Kecil</h4>
    @include('partials.buku-besar-table', ['data' => $kasKecil ?? null, 'label' => 'kas kecil'])

    {{-- 4. Kas Niaga --}}
    <h4 class="judul-section">4. Kas Niaga</h4>
    @include('partials.buku-besar-table', ['data' => $kasNiaga ?? null, 'label' => 'kas niaga'])

    {{-- 5. Bank BNI --}}
    <h4 class="judul-section">5. Bank BNI</h4>
    @include('partials.buku-besar-table', ['data' => $bankBni ?? null, 'label' => 'bank bni'])

    {{-- 6. Barang Dalam Perjalanan --}}
    <h4 class="judul-section">6. Barang Dalam Perjalanan</h4>
    @include('partials.buku-besar-table', ['data' => $barangDalamPerjalanan ?? null, 'label' => 'barang dalam perjalanan'])

    {{-- 7. Pinjaman Perusahaan --}}
    <h4 class="judul-section">7. Pinjaman Perusahaan</h4>
    @include('partials.buku-besar-table', ['data' => $pinjamanPerusahaan ?? null, 'label' => 'pinjaman perusahaan'])

    {{-- 8. Persediaan Barang --}}
    <h4 class="judul-section">8. Persediaan Barang</h4>
    @include('partials.buku-besar-table', ['data' => $persediaanBarang ?? null, 'label' => 'persediaan barang'])

    {{-- 9. Pinjaman Karyawan --}}
    <h4 class="judul-section">9. Pinjaman Karyawan</h4>
    @include('partials.buku-besar-table', ['data' => $pinjamanKaryawan ?? null, 'label' => 'pinjaman karyawan'])

  </div>
</div>



{{-- Komponen pagination --}}
<x-menu.pagination />

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
  max-height: 400px;
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
.laporan-laba-rugi-table {
  width: 100%;
  min-width: 1000px; /* Paksa scroll horizontal jika terlalu lebar */
  border-collapse: collapse;
  background: white;
  font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
  font-size: 14px;
  table-layout: auto
}

.laporan-laba-rugi-table thead {
  background: var(--header-bg);
  color: var(--header-text);
  position: sticky;
  top: 0;
  z-index: 1;
}

.laporan-laba-rugi-table th,
.laporan-laba-rugi-table td {
  text-align: center;
  padding: 10px 14px;
  border: 1px solid var(--border);
  white-space: nowrap;
  vertical-align: middle;
}

.laporan-laba-rugi-table tbody tr:nth-child(even) {
  background-color: #f9f9f9;
}

.laporan-laba-rugi-table tbody tr:hover {
  background-color: #eef7ff;
}

.laporan-laba-rugi-table .empty-cell {
  width: 200px;          
  text-align: center;
  padding: 10px;
  color: #6b7280;
  font-style: italic;
  background: #ffffff;
  border-radius: 6px;
}
</style>