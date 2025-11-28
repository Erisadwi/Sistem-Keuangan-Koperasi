@extends('layouts.laporan-admin2')

@section('title', 'Laporan Kas Simpanan')  
@section('title-1', 'Kas Simpanan')  
@section('title-content', 'Laporan Simpanan Anggota')  
@section('period')
    {{ $periodeText }}
@endsection 
@section('sub-title', 'Laporan Kas Simpanan')  

@section('content')

<x-menu.date-filter/>
<x-menu.unduh 
    :url="route('kas-simpanan.exportPdf', [
        'start_date' => request('start_date'),
        'end_date'   => request('end_date'),
        'preset'     => request('preset')
    ])" 
    text="Unduh Laporan"
/>

<div class="laporan-simpanan-wrap">
  <div class="table-scroll-wrapper">
    <table class="laporan-simpanan-table">
      <thead>
        <tr>
          <th>No</th>
          <th>Jenis Akun</th>
          <th>Simpanan</th>
          <th>Penarikan</th>
          <th>Jumlah</th>
        </tr>
      </thead>

      <tbody>
        @forelse ($data as $item)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $item->jenis_akun }}</td>
          <td>{{ number_format($item->simpanan, 0, ',', '.') }}</td>
          <td>{{ number_format($item->penarikan, 0, ',', '.') }}</td>
          <td>{{ number_format($item->jumlah, 0, ',', '.') }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="5">Tidak ada data</td>
        </tr>
        @endforelse

        <tr class="total-row">
          <td colspan="2"><strong>Jumlah Total</strong></td>
          <td><strong>{{ number_format($totalSimpanan, 0, ',', '.') }}</strong></td>
          <td><strong>{{ number_format($totalPenarikan, 0, ',', '.') }}</strong></td>
          <td><strong>{{ number_format($totalJumlah, 0, ',', '.') }}</strong></td>
        </tr>
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
  --background: #e0edf3;      
  --text: #222;
}

.laporan-simpanan-wrap {
  border: 1.5px solid var(--outer-border);
  border-radius: 0;
  background: var(--bg);
  width: 98%;          
  margin-left: 10px;     
  margin-top: 100px;      
  padding: 0;             
  box-shadow: none;       
  overflow-x: visible;
}

.laporan-simpanan-table {
  width: 100%;
  min-width: 860px;
  border-collapse: collapse;
  background: white;
  font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
  font-size: 14px;
  table-layout: auto;
}

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

.laporan-simpanan-table tbody tr:nth-child(even) {
  background-color: #f9f9f9;
}
.laporan-simpanan-table tbody tr:hover {
  background-color: #eef7ff;
}

.total-row td {
  background-color: var(--header-bg);
  color: #ffffff;
  font-weight: bold;
}
</style>

@endsection
