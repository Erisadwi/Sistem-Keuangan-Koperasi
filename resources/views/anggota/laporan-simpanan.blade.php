@extends('layouts.app')

@section('title', 'Laporan')  
@section('title-1', 'Laporan')  
@section('sub-title', 'Laporan Simpanan dan Penarikan')  

@section('content')

<div class="content-inner">
  <div class="table-scroll-wrapper">
    <table class="table table-bordered table-striped simpanan-table">
      <thead class="table-primary text-center">
      <tr class="head-group">
        <th>Tanggal</th>
        <th>Jenis</th>
        <th>Jumlah</th>
        <th>Keterangan</th>
      </tr>
    </thead>
    <tbody>
     @if(isset($data) && count($data) > 0)
      @foreach ($data as $row)
      <tr>
        <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}</td>
        <td>{{ $row->jenis }}</td>
        <td>{{ number_format($row->jumlah, 0, ',', '.') }}</td>
        <td>{{ $row->keterangan ?? '-' }}</td>
      </tr>
      @endforeach
    @else
    <tr>
      <td colspan="4" class="empty-cell">Belum ada data simpanan.</td>
    </tr>
    @endif
    </tbody>
  </table>
  </div>
</div>

<div class="pagination-container">
      <x-menu.pagination :data="$data" />
 </div> 

<style>
:root {
  --primary: #6ba1be;
  --primary-dark: #558ca3;
  --header-bg: #4a4a4a;
  --header-text: #ffffff;
  --border: #c0c0c0;
  --text: #222;
}

.content-inner {
  padding-left: 25px;
  padding-right: 60px;
  margin-top: 25px;
}


.table-scroll-wrapper {
  overflow-x: auto;
  overflow-y: auto;
  max-height: 380px;
  width: 100%;
  background: transparent;
  border-radius: 4px;
  padding-bottom: 8px;
  margin-top: 100px;
}

.table-scroll-wrapper table {
  margin-bottom: 0;
  background: white;
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

.simpanan-table {
  width: 100%;
  min-width: 1000px;
  border-collapse: collapse;
  font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
  font-size: 14px;
  color: var(--text);
}

.simpanan-table thead {
  background: var(--header-bg);
  color: var(--header-text);
  position: sticky;
  top: 0;
  z-index: 2;
}

.simpanan-table th,
.simpanan-table td {
  text-align: center;
  padding: 10px 14px;
  border: 1px solid var(--border);
  white-space: nowrap;
}

.simpanan-table tbody tr:nth-child(even) {
  background-color: #f9f9f9;
}

.simpanan-table tbody tr:hover {
  background-color: #eef7ff;
}

.simpanan-table .empty-cell {
    text-align: center;
    padding: 8px 10px;
    color: #6b7280;
    font-style: italic;
  }

.pagination-container {
  margin-top: auto;        
  display: flex;
  justify-content: flex-end;
  align-items: center;
  padding: 12px 16px;
}

@media (max-width: 640px) {
  .simpanan-table {
    font-size: 12px;
  }
  .simpanan-table th,
  .simpanan-table td {
    padding: 8px;
  }
}

.selectable-row.selected td{
  background-color: #b6d8ff !important;
  color: #000;
}
</style>

@endsection
