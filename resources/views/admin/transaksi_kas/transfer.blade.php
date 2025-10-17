@extends('layouts.app-admin3')

@section('title', 'Transfer')  
@section('title-1', 'Transaksi Kas')  
@section('sub-title', 'Transfer')  

@section('content')
<x-menu.tambah-edit-hapus/>

<div class="transfer-table-wrap">
  <table class="transfer-table">
    <thead>
      <tr class="head-group">
        <th>Kode Transaksi</th>
        <th>Tanggal</th>
        <th>Keterangan</th>
        <th>Jumlah</th>
        <th>Dari Kas</th>
        <th>Untuk Kas</th>
        <th>User</th>
      </tr>
    </thead>

    <tbody>
      @forelse(($ajuan_pinjaman ?? collect()) as $idx => $row)
        <tr>
          <td>{{ $row->id_transaksi ?? '' }}</td>
          <td>{{ \Carbon\Carbon::parse($row->tanggal_transaksi)->format('d-m-Y') ?? '' }}</td>
          <td>{{ $row->ket_transaksi ?? 'Nama tidak tersedia' }}</td>
          <td>{{ $row->dari_kas ?? '' }}</td>
          <td>{{ $row->untuk_kas ?? '' }}</td>
          <td>{{ number_format($row->jumlah_transaksi ?? 0, 0, ',', '.') }}</td>
          <td>{{ $row->data_user->nama_lengkap ?? '' }}</td>
      @empty
        <tr>
          <td colspan="7" class="empty-cell">Belum ada data transfer</td>
        </tr>
      @endforelse
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

  .transfer-table-wrap {
    border: 1.5px solid var(--outer-border);
    border-radius: 0;
    background: var(--bg);
    width: 870px;
    margin-left: 25px;
    margin-top: 20px;
    padding: 0;
    box-shadow: none;
    overflow-x: visible;
  }

  .transfer-table {
    width: 870px;
    border-collapse: collapse;
    table-layout: fixed;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
    font-size: 13px;
    color: #222;
  }

  .transfer-table thead .head-group th {
    background: var(--head-dark);
    color: #fff;
    text-align: center;
    font-weight: 600;
    padding: 10px;
    border-bottom: 1px solid var(--grid);
    white-space: nowrap;
  }

  .transfer-table td {
    padding: 10px;
    border-bottom: 1px solid var(--grid)!important;
    border-right: 1px solid var(--grid)!important;
    background: #fff;
  }

  .transfer-table tbody td:last-child {
    border-right: 2px solid var(--grid)!important;
  }

  .transfer-table tbody tr td:nth-child(1) {
    border-right: 1.5px solid var(--line) !important;
  }

  .transfer-table tbody tr {
    background: #fff;
  }

  .transfer-table tbody tr:nth-child(even) {
    background: #fff;
  }

  .transfer-table tbody tr:hover {
    background: #fff;
  }

  .transfer-table .empty-cell {
    text-align: center;
    padding: 8px 10px;
    color: #6b7280;
    font-style: italic;
  }

  .actions {
    display: flex;
    justify-content: center;
    gap: 10px;
  }

  .disetujui,
  .ditolak {
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
  }

  .disetujui {
    background-color: #25E11B;
    color: white;
    text-decoration: none; 
  }

  .disetujui:hover {
    background-color: #45a049; 
  }

  .ditolak {
    background-color: #FF0000;
    color: white;
    border: none; 
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
  }

  .ditolak:hover {
    background-color: #f12f2f;
  }

  @media (max-width: 640px) {
    .pemasukan-table {
      font-size: 13px;
    }

    .transfer-table td,
    .transfer-table th {
      padding: 10px;
    }
  }

  @media (max-width: 768px) {
    .transfer-table thead .head-group th:nth-child(3),
    .transfer-table tbody td:nth-child(3),
    .transfer-table thead .head-group th:nth-child(4),
    .transfer-table tbody td:nth-child(4) {
      display: none;
    }
  }
</style>


@endsection