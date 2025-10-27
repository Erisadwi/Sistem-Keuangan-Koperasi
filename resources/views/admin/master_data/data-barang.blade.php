@extends('layouts.app-admin3')

@section('title', 'Data Barang')  
@section('title-1', 'Master Data')  
@section('sub-title', 'Data Barang')  

@section('content')

<x-menu.tambah-unduh 
    addUrl="{{ route('jenis-barang.create') }}" 
    downloadFile="data_barang.pdf" />

<div class="barang-inventaris-table-wrap">
  <table class="barang-inventaris-table">
    <thead>
      <tr class="head-group">
        <th>Nama Barang</th>
        <th>Type</th>
        <th>Jumlah</th>
        <th>Keterangan</th>
        <th>Aksi</th> 
      </tr>
    </thead>

    <tbody>
      @forelse(($jenis_barang ?? collect()) as $idx => $row)
        <tr>
          <td>{{ $row->nama_barang ?? '' }}</td>
          <td>{{ $row->type_barang ?? '' }}</td>
          <td>{{ $row->jumlah_barang ?? '' }}</td>
          <td>{{ $row->keterangan_barang ?? '' }}</td>
          <td class="actions">
            <a href="{{ route('jenis-barang.edit', ['id' => $row->id_barangInventaris]) }}" class="edit">✏️ Edit</a>
            <form action="{{ route('jenis-barang.destroy', ['id' => $row->id_barangInventaris]) }}" method="POST" class="form-hapus" style="display: inline;">
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

    <div class="pagination-container">
      <x-menu.pagination :data="$jenis_barang" />
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
    width: 96%;          
    margin-left: 20px;     
    margin-top: 30px;       
    padding: 0;
    box-shadow: none;
    overflow-x: visible;
  }

  .barang-inventaris-table {
    width: 100%;                
    border-collapse: collapse;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
    font-size: 13px;
    color: #222;
  }

  .barang-inventaris-table thead .head-group th {
    width: 20%;
    background: var(--head-dark);
    color: #fff;
    text-align: center;
    font-weight: 650;
    padding: 10px;
    border-bottom: 1px solid var(--grid);
    white-space: normal;
    word-wrap: break-word;  
    word-break: break-word;
  }

  .barang-inventaris-table td {
    padding: 10px;
    border-bottom: 1px solid var(--grid)!important;
    border-right: 1px solid var(--grid)!important;
    background: #fff;
    text-align: center;
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
    font-weight: 600;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    text-align: center;
    width:90px;
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

.pagination-container {
  margin-top: auto;        
  display: flex;
  justify-content: flex-end;
  align-items: center;
  padding: 12px 16px;
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

<script>
document.querySelectorAll('.form-hapus').forEach(function(form) {
    form.addEventListener('submit', function (e) {
        e.preventDefault(); 

        const yakin = confirm('⚠️ Apakah Anda yakin ingin menghapus data ini?');

        if (yakin) {
            alert('🗑️ Data berhasil dihapus!');
            form.submit(); 
        } else {
            alert('❌ Penghapusan data dibatalkan.');
        }
    });
});
</script>


@endsection