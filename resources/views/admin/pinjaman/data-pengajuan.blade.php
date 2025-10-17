@extends('layouts.app-admin3')

@section('title', 'Pengajuan Pinjaman')  
@section('title-1', 'Pinjaman')  
@section('sub-title', 'Data Pengajuan Pinjaman')  

@section('content')

<x-menu.toolbar-search-ajuan/>
<x-menu.unduh-right/>



<div class="pengajuan-pinjaman-table-wrap">
  <table class="pengajuan-pinjaman-table">
    <thead>
      <tr class="head-group">
        <th>ID Pengajuan</th>
        <th>Tanggal</th>
        <th>Nama Anggota</th>
        <th>Jenis</th>
        <th>Jumlah</th>
        <th>Angsuran</th>
        <th>Ket.</th>
        <th>Status</th>
        <th>Sisa Pinjaman</th>
        <th>Aksi</th> 
      </tr>
    </thead>

    <tbody>
      @forelse(($ajuan_pinjaman ?? collect()) as $idx => $row)
        <tr>
          <td>{{ $row->id_ajuanPinjaman ?? '' }}</td>
          <td>{{ $row->tanggal ?? '' }}</td>
          <td>{{ $row->anggota->nama_anggota ?? 'Nama tidak tersedia' }}</td>
          <td>{{ $row->jenis_ajuan ?? '' }}</td>
          <td>{{ number_format($row->jumlah_ajuan ?? 0, 0, ',', '.') }}</td>
          <td>{{ $row->lama_angsuran->lama_angsuran ?? '' }}</td>
          <td>{{ $row->keterangan ?? '' }}</td>
          <td>{{ $row->status_ajuan ?? '' }}</td>
          <td>{{ $row->sisa_pinjaman }}</td>
          <td class="actions">
            <a href="{{ route('pengajuan-pinjaman.disetujui', ['id' => $row->id]) }}" class="disetujui">✅ disetujui</a>
            <form action="{{ route('pengajuan-pinjaman.destroy', ['id' => $row->id]) }}" method="POST" style="display: inline;">
              @csrf
              @method('PATCH')
              <button type="submit" class="ditolak">❌ Hapus</button>
            </form>
          </td> 

      @empty
        <tr>
          <td colspan="10" class="empty-cell">Belum ada data pengajuan pinjaman</td>
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

  .pengajuan-pinjaman-table-wrap {
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

  .pengajuan-pinjaman-table {
    width: 870px;
    border-collapse: collapse;
    table-layout: fixed;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
    font-size: 13px;
    color: #222;
  }

  .pengajuan-pinjaman-table thead .head-group th {
    background: var(--head-dark);
    color: #fff;
    text-align: center;
    font-weight: 600;
    padding: 10px;
    border-bottom: 1px solid var(--grid);
    white-space: nowrap;
  }

  .pengajuan-pinjaman-table td {
    padding: 10px;
    border-bottom: 1px solid var(--grid)!important;
    border-right: 1px solid var(--grid)!important;
    background: #fff;
  }

  .pengajuan-pinjaman-table tbody td:last-child {
    border-right: 2px solid var(--grid)!important;
  }

  .pengajuan-pinjaman-table tbody tr td:nth-child(1) {
    border-right: 1.5px solid var(--line) !important;
  }

  .pengajuan-pinjaman-table tbody tr {
    background: #fff;
  }

  .pengajuan-pinjaman-table tbody tr:nth-child(even) {
    background: #fff;
  }

  .pengajuan-pinjaman-table tbody tr:hover {
    background: #fff;
  }

  .pengajuan-pinjaman-table .empty-cell {
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
    .pengajuan-pinjaman-table {
      font-size: 13px;
    }

    .pengajuan-pinjaman-table td,
    .pengajuan-pinjaman-table th {
      padding: 10px;
    }
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