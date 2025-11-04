@extends('layouts.app-admin3')

@section('title', 'Pinjaman')
@section('title-1', 'Pinjaman')
@section('sub-title', 'Data Pinjaman')

@section('content')
<x-menu.date-filter/>

<div class="data-pinjaman-table-wrap">
  <table class="data-pinjaman-table">
    <thead>
      <tr class="head-group">
        <th>No</th>
        <th>Kode</th>
        <th>Tanggal Pinjam</th>
        <th>Nama Anggota</th>
        <th>Hitungan</th>
        <th>Total Tagihan</th>
        <th>Keterangan</th>
        <th>Lunas</th>
        <th>User</th>
        <th>Aksi</th>
      </tr>
    </thead>
      @if(isset($pinjaman) && count($pinjaman) > 0)
        @foreach ($pinjaman as $index => $row)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $row->kode }}</td>
          <td>{{ \Carbon\Carbon::parse($row->tanggal_pinjaman)->format('d-m-Y') }}</td>
          <td>{{ $row->nama_anggota }}</td>
          <td>{{ number_format($row->hitungan, 0, ',', '.') }}</td>
          <td>{{ number_format($row->total_tagihan, 0, ',', '.') }}</td>
          <td>{{ $row->keterangan }}</td>
          <td>{{ $row->lunas }}</td>
          <td>{{ $row->user }}</td>
          <td><button class="btn-aksi">Detail</button></td>
          <td><button class="btn-nota">🧾 Nota</a>
        </tr>
        @endforeach
      @else
      <tr>
        <td colspan="10" class="empty-cell">Belum ada data pinjaman.</td>
      </tr>
      @endif
    </tbody>
  </table>
</div>

<style>
  :root {
    --outer-border: #838383;
    --head-dark: #4a4a4a;
    --head-mid: #9a9a9a;
    --line: #fffafa;
    --grid: #fffcfc;
    --bg: #ffffff;
  }

  .data-pinjaman-table-wrap {
    border: 1.5px solid var(--outer-border);
    border-radius: 0;
    background: var(--bg);
    width: 95%;
    margin-left: 25px;
    margin-top: 30px;
    padding: 0;
    box-shadow: none;
    overflow-x: visible;
  }

  .data-pinjaman-table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
    font-size: 13px;
    color: #222;
  }

  .data-pinjaman-table thead .head-group th {
    background: var(--head-dark);
    color: #fff;
    text-align: center;
    font-weight: 600;
    padding: 10px;
    border-bottom: 1px solid var(--grid);
    white-space: nowrap;
  }

  .data-pinjaman-table td {
    padding: 10px;
    border-bottom: 1px solid var(--grid)!important;
    border-right: 1px solid var(--grid)!important;
    background: #fff;
  }

  .data-pinjaman-table tbody td:last-child {
    border-right: 2px solid var(--grid)!important;
  }

  .data-pinjaman-table tbody tr td:nth-child(1) {
    border-right: 1.5px solid var(--line) !important;
  }

  .data-pinjaman-table tbody tr {
    background: #fff;
  }

  .data-pinjaman-table tbody tr:nth-child(even) {
    background: #fff;
  }

  .data-pinjaman-table tbody tr:hover {
    background: #fff;
  }

  .data-pinjaman-table .empty-cell {
    text-align: center;
    padding: 8px 10px;
    color: #6b7280;
    font-style: italic;
  }

.btn-aksi {
  background: var(--primary);
  color: white;
  border: none;
  padding: 6px 10px;
  border-radius: 6px;
  cursor: pointer;
}
.btn-aksi:hover {
  background: var(--primary-dark);
}

  @media (max-width: 768px) {
    .pengajuan-pinjaman-table thead .head-group th:nth-child(3),
    .pengajuan-pinjaman-table tbody td:nth-child(3),
    .pengajuan-pinjaman-table thead .head-group th:nth-child(4),
    .pengajuan-pinjaman-table tbody td:nth-child(4) {
      display: none;
    }
  }
</style>

@endsection
