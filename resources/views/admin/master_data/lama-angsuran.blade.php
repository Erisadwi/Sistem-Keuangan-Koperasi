@extends('layouts.app-admin3')

@section('title', 'Lama Angsuran')  
@section('title-1', 'Master Data')  
@section('sub-title', 'Lama Angsuran')  

@section('content')

<x-menu.tambah-unduh 
    addUrl="{{ route('lama-angsuran.create') }}" 
    downloadFile="lama_angsuran.pdf" />

<div class="lama-angsuran-table-wrap">
  <table class="lama-angsuran-table">
    <thead>
      <tr class="head-group">
        <th>Lama Angsuran (Bulan)</th>
        <th>Keterangan Aktif</th>
        <th>Aksi</th> 
      </tr>
    </thead>

    <tbody>
      @forelse(($lama_angsuran ?? collect()) as $idx => $row)
        <tr>
          <td class="text-center">{{ $row->lama_angsuran ?? '' }}</td>
          <td class="text-center">{{ $row->status_angsuran == 'Y' ? 'Y' : 'T' }}</td>
          <td class="actions">
            <a href="{{ route('lama-angsuran.edit', ['id' => $row->id_lamaAngsuran]) }}" class="edit">✏️ Edit</a>
            <form action="{{ route('lama-angsuran.destroy', ['id' => $row->id_lamaAngsuran]) }}" method="POST" style="display: inline;">
              @csrf
              @method('DELETE')
              <button type="submit" class="delete">❌ Hapus</button>
            </form>
          </td> 
        </tr>
      @empty
        <tr>
          <td colspan="3" class="empty-cell">Belum ada data lama angsuran</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

    <div class="pagination-container">
      <x-menu.pagination :data="$lama_angsuran" />
    </div>

<style>
  :root {
    --border: #cccccc;
    --head-bg: #4a4a4a;
    --table-bg: #ffffff;
    --hover-bg: #f9f9f9;
  }

  .lama-angsuran-table-wrap {
    background: var(--table-bg);
    width: 96%;
    margin-left: 25px;
    margin-top: 30px;
    overflow-x: auto;
  }

  .lama-angsuran-table {
    width: 100%;
    border-collapse: collapse;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
    font-size: 13px;
    color: #222;
  }

  .lama-angsuran-table th {
    background: var(--head-bg);
    color: #fff;
    text-align: center;
    font-weight: 650;
    padding: 10px;
  }

  .lama-angsuran-table td {
    padding: 8px 10px;
    border-bottom: 1px solid var(--border);
    text-align: center;
  }

  .lama-angsuran-table tbody tr:hover {
    background: var(--hover-bg);
  }

  .empty-cell {
    text-align: center;
    color: #6b7280;
    font-style: italic;
  }

  .actions {
    display: flex;
    justify-content: center;
    gap: 8px;
  }

  .edit,
  .delete {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 6px;
    border-radius: 4px;
    text-decoration: none;
    cursor: pointer;
    font-size: 14px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    text-align: center;
    width:90px;
  }

  .edit {
    background-color: #25E11B;
    color: #fff;
  }

  .edit:hover {
    background-color: #1cc10f;
  }

  .delete {
    background-color: #FF0000;
    color: #fff;
    border: none;
  }

  .delete:hover {
    background-color: #d90b0b;
  }

  .pagination-container {
  margin-top: auto;        
  display: flex;
  justify-content: flex-end;
  align-items: center;
  padding: 12px 16px;
}

  @media (max-width: 640px) {
    .lama-angsuran-table {
      font-size: 12px;
    }

    .lama-angsuran-table th,
    .lama-angsuran-table td {
      padding: 8px;
    }
  }
</style>

@endsection
