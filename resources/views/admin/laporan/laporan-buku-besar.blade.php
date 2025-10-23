@extends('layouts.laporan-admin2')

@push('styles')
 @vite('resources/css/style-laporanBukuBesar.css')
@endpush

@section('title', 'Laporan Buku Besar')  
@section('title-1', 'Buku Besar')  
@section('title-content', 'Laporan Buku Besar')  
@section('period', 'Periode Oktober 2025')  
@section('sub-title', 'Laporan Buku Besar')  

@section('content')

<x-menu.month-filter/>
<x-menu.unduh/>

<div class="laporan-buku-besar-wrap">
  <div class="table-scroll-wrapper">
    
    {{-- 1. Kas Besar --}}
    <h4 class="judul-section">1. Kas Besar</h4>
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





@endsection
