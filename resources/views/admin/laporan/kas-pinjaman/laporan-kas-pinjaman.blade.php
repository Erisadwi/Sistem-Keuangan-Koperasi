@extends('layouts.laporan-admin2')

@section('title', 'Laporan Kas Pinjaman')
@section('title-1', 'Kas Pinjaman')
@section('title-content', 'Laporan Pinjaman')
@section('period')
    {{ $periodeText }}
@endsection
@section('sub-title', 'Laporan Kas Pinjaman')  

@section('content')

<x-menu.date-filter/>
<x-menu.unduh 
    :url="route('kas-pinjaman.exportPdf', [
        'start_date' => request('start_date'),
        'end_date'   => request('end_date'),
        'preset'     => request('preset')
    ])" 
    text="Unduh Laporan"
/>

<div class="laporan-kas-pinjaman-wrap">
  <div class="table-scroll-wrapper">

    <div class="laporan-info">
      <p>Jumlah Peminjam : {{ $jumlahPeminjam }}</p>
      <p>Peminjam Lunas : {{ $jumlahLunas }}</p>
      <p>Pinjaman Belum Lunas : {{ $jumlahBelumLunas }}</p>
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
          <td>{{ number_format($totalPokokPinjaman, 0, ',', '.') }}</td>
        </tr>

        <tr>
          <td>2</td>
          <td>Tagihan Pinjaman</td>
          <td>{{ number_format($totalTagihan, 0, ',', '.') }}</td>
        </tr>

        <tr>
          <td>3</td>
          <td>Tagihan Denda</td>
          <td>{{ number_format($totalDenda, 0, ',', '.') }}</td>
        </tr>

        <tr class="total-row">
          <td colspan="2"><b>Jumlah Tagihan + Denda</b></td>
          <td><b>{{ number_format($totalTagihan + $totalDenda, 0, ',', '.') }}</b></td>
        </tr>

        <tr>
          <td>4</td>
          <td>Tagihan Sudah Dibayar</td>
          <td>{{ number_format($totalSudahDibayar, 0, ',', '.') }}</td>
        </tr>

        <tr>
          <td>5</td>
          <td>Sisa Tagihan</td>
          <td>{{ number_format($sisaTagihan, 0, ',', '.') }}</td>
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
  --background: #ffffff;
  --text: #222;
}

.laporan-kas-pinjaman-wrap {
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

.laporan-info {
  font-size: 14px;
  color: var(--text);
  margin-bottom: 12px;
  line-height: 1.5;
}

.laporan-kas-pinjaman-table {
  width: 100%;
  min-width: 860px;
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
</style>

@endsection