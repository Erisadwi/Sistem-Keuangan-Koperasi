@extends('layouts.app-admin3')

@section('title', 'Data Barang')  
@section('title-1', 'Master Data')  
@section('sub-title', 'Data Barang')  

@section('content')

<x-menu.tambah-unduh 
    addUrl="# {{-- {{ route('data-barang.create') }} --}}" 
    downloadFile="data_barang.pdf" />

<div class="barang-inventaris-table-wrap">
  <table class="barang-inventaris-table">
    <thead>
      <tr class="head-group">
        <th>Nama Barang</th>
        <th>Type</th>
        <th>Type</th>
        <th>Jumlah</th>
        <th>Keterangan</th>
        <th>Aksi</th> 
      </tr>
    </thead>

    <tbody>
      @forelse(($barang_inventaris ?? collect()) as $idx => $row)
        <tr>
          <td>{{ $row->nama_barang ?? '' }}</td>
          <td>{{ $row->type_barang ?? '' }}</td>
          <td>{{ $row->jumlah_barang ?? '' }}</td>
          <td>{{ $row->keterangan_barang ?? '' }}</td>
          <td class="actions">
            <a href="{{ route('barang-inventaris.edit', ['id' => $row->id]) }}" class="edit">✏️ Edit</a>
            <form action="{{ route('barang-inventaris.destroy', ['id' => $row->id]) }}" method="POST" style="display: inline;">
              @csrf
              @method('DELETE')
              <button type="submit" class="delete">❌ Hapus</button>
            </form>
          </td> 

      @empty
        <tr>
          <td colspan="6" class="empty-cell">Belum ada data barang inventaris</td>
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

  .barang-inventaris-table-wrap {
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

  .barang-inventaris-table {
    width: 870px;
    border-collapse: collapse;
    table-layout: fixed;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
    font-size: 13px;
    color: #222;
  }

  .barang-inventaris-table thead .head-group th {
    background: var(--head-dark);
    color: #fff;
    text-align: center;
    font-weight: 600;
    padding: 10px;
    border-bottom: 1px solid var(--grid);
    white-space: nowrap;
  }

  .barang-inventaris-table td {
    padding: 10px;
    border-bottom: 1px solid var(--grid)!important;
    border-right: 1px solid var(--grid)!important;
    background: #fff;
  }

  .barang-inventaris-table tbody td:last-child {
    border-right: 2px solid var(--grid)!important;
  }

  .barang-inventaris-table tbody tr td:nth-child(1) {
    border-right: 1.5px solid var(--line) !important;
  }

  .barang-inventaris-table tbody tr {
    background: #fff;
  }

  .barang-inventaris-table tbody tr:nth-child(even) {
    background: #fff;
  }

  .barang-inventaris-table tbody tr:hover {
    background: #fff;
  }

  .barang-inventaris-table .empty-cell {
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

  .edit,
  .delete {
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
  }

  .edit {
    background-color: #25E11B;
    color: white;
    text-decoration: none; 
  }

  .edit:hover {
    background-color: #45a049; 
  }

  .delete {
    background-color: #FF0000;
    color: white;
    border: none; 
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
  }

  .delete:hover {
    background-color: #f12f2f;
  }

  @media (max-width: 640px) {
    .barang-inventaris-table {
      font-size: 13px;
    }

    .barang-inventaris-table td,
    .barang-inventaris-table th {
      padding: 10px;
    }
  }

  @media (max-width: 768px) {
    .barang-inventaris-table thead .head-group th:nth-child(3),
    .barang-inventaris-table tbody td:nth-child(3),
    .barang-inventaris-table thead .head-group th:nth-child(4),
    .barang-inventaris-table tbody td:nth-child(4) {
      display: none;
    }
  }
</style>


@endsection