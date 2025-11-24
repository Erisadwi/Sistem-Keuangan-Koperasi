@extends('layouts.laporan-admin')

@section('title', 'Laporan Laba Rugi')  
@section('title-1', 'Laba Rugi')  
@section('title-content', 'Laporan Laba Rugi')  
@section('period')
    {{ $periodeText }}
@endsection
@section('sub-title', 'Laporan Laba Rugi')  

@section('content')

<x-menu.date-filter/>
<x-menu.unduh 
    :url="route('laba-rugi.exportPdf', [
        'start_date' => request('start_date'),
        'end_date'   => request('end_date'),
        'preset'     => request('preset')
    ])" 
    text="Unduh Laporan"
/>



<div class="laporan-laba-rugi-wrap">
    
    <h3 class="judul-section">Pinjaman</h3>
    @include('partials.pinjaman-table', ['data' => $pinjaman ?? null, 'label' => 'pinjaman'])

    <h3 class="judul-section">Pendapatan</h3>
    @include('partials.pendapatan-table', ['data' => $pendapatan ?? null, 'label' => 'pendapatan'])

    <h3 class="judul-section">Biaya - Biaya</h3>
    @include('partials.biaya-table', ['data' => $biaya ?? null, 'label' => 'biaya - biaya'])

    {{-- ===== Total Laba Rugi ===== --}}
    @php
        $totalPendapatan = collect($pendapatan ?? [])->sum(function($item){
            return is_array($item) ? ($item['jumlah'] ?? 0) : ($item->jumlah ?? 0);
        });

        $totalBiaya = collect($biaya ?? [])->sum(function($item){
            return is_array($item) ? ($item['jumlah'] ?? 0) : ($item->jumlah ?? 0);
        });

        $labaRugi = $totalPendapatan - $totalBiaya;
    @endphp

    <h3 class="judul-section">Total Laba Rugi</h3>
    <table class="laba-rugi-table">
        <tbody>
            <tr class="laba-rugi-row">
                <td colspan="2" class="text-right"><strong>Total Laba Rugi</strong></td>
                <td class="text-right"><strong>{{ number_format($labaRugi, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>

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
  width: 98%;          
  margin-left: 10px;     
  margin-top: 65px;     
  padding: 0;             
  box-shadow: none;       
  overflow-x: visible; 
}

.judul-section {
  font-weight: 600;
  margin-top: 20px;    
  margin-bottom: 7px;    
  color: #333;
}

.laba-rugi-table {
  width: 100%;
  min-width: 850px; 
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
  text-align: left;
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
