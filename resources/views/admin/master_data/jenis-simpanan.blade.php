@extends('layouts.app-admin')

@push('styles')
  @vite('resources/css/admin/jenis-simpanan.css')
@endpush

@section('title', 'Jenis Simpanan')  
@section('title-1', 'Master Data')  
@section('sub-title', 'Jenis Simpanan')  

@section('content')

<div class="simpanan-table-wrap">
  <table class="simpanan-table">
    <thead>
      <tr class="head-group">
        <th>Jenis Simpanan</th>
        <th>Jumlah</th>
        <th>Tampil</th>
        <th>Aksi</th> 
      </tr>
    </thead>

    <tbody>
      @forelse(($jenis_simpanan ?? collect()) as $idx => $row)
        <tr>
          <td>{{ $row->jenis_simpanan ?? '' }}</td>
          <td>
            @php $nominal = $row->jumlah_simpanan ?? null; @endphp
            {{ $nominal !== null ? number_format($nominal, 0, ',', '.') : '' }}
          </td>
          <td>{{ $row->tampil_simpanan ?? '' }}</td>

          <td class="actions">
            <a href="{{ route('simpanan.edit', ['id' => $row->id]) }}" class="edit">✏️ Edit</a>
            <form action="{{ route('simpanan.destroy', ['id' => $row->id]) }}" method="POST" style="display: inline;">
              @csrf
              @method('DELETE')
              <button type="submit" class="delete">❌ Hapus</button>
            </form>
          </td> 

      @empty
        <tr>
          <td colspan="4" class="empty-cell">Belum ada data jenis simpanan</td>
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

  .simpanan-table-wrap {
    border: 1.5px solid var(--outer-border);
    border-radius: 0;
    background: var(--bg);
    width: 870px;
    margin-left: 25px;
    margin-top: 75px;
    padding: 0;
    box-shadow: none;
    overflow-x: visible;
  }

  .simpanan-table {
    width: 870px;
    border-collapse: collapse;
    table-layout: fixed;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
    font-size: 13px;
    color: #222;
  }

  .simpanan-table thead .head-group th {
    background: var(--head-dark);
    color: #fff;
    text-align: center;
    font-weight: 600;
    padding: 10px;
    border-bottom: 1px solid var(--grid);
    white-space: nowrap;
  }

  .simpanan-table td {
    padding: 10px;
    border-bottom: 1px solid var(--grid)!important;
    border-right: 1px solid var(--grid)!important;
    background: #fff;
  }

  .simpanan-table tbody td:last-child {
    border-right: 2px solid var(--grid)!important;
  }

  .simpanan-table tbody tr td:nth-child(1) {
    border-right: 1.5px solid var(--line) !important;
  }

  .simpanan-table tbody tr {
    background: #fff;
  }

  .simpanan-table tbody tr:nth-child(even) {
    background: #fff;
  }

  .simpanan-table tbody tr:hover {
    background: #fff;
  }

  .simpanan-table .empty-cell {
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
    .simpanan-table {
      font-size: 13px;
    }

    .simpanan-table td,
    .simpanan-table th {
      padding: 10px;
    }
  }

  @media (max-width: 768px) {
    .simpanan-table thead .head-group th:nth-child(3),
    .simpanan-table tbody td:nth-child(3),
    .simpanan-table thead .head-group th:nth-child(4),
    .simpanan-table tbody td:nth-child(4) {
      display: none;
    }
  }
</style>


@endsection