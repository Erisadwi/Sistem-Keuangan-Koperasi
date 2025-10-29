@extends('layouts.app-admin3')

@section('title', 'Pemasukan')  
@section('title-1', 'Transaksi Kas')  
@section('sub-title', 'Pemasukan')  

@section('content')
<x-menu.tambah-edit-hapus
    :tambah="route('transaksi-pemasukan.create')" 
    :edit="'#'" 
    :hapus="'#'"
    id="action-buttons"
/>
<x-menu.toolbar-right :downloadFile="'data-pengajuan.pdf'"/>




<div class="pemasukan-table-wrap">
  <table class="pemasukan-table">
    <thead>
      <tr class="head-group">
        <th>Kode Transaksi</th>
        <th>Tanggal</th>
        <th>Keterangan</th>
        <th>Untuk Kas</th>
        <th>Dari Akun</th>
        <th>Jumlah</th>
        <th>User</th>
      </tr>
    </thead>

    <tbody>
      @forelse(($TransaksiPemasukan ?? collect()) as $idx => $row)
        <tr>
          <input type="hidden" name="selected_trx" value="{{ $row->id_transaksi }}">
          <td>{{ $row->id_transaksi ?? '' }}</td>
          <td>{{ \Carbon\Carbon::parse($row->tanggal_transaksi)->format('d-m-Y') ?? '' }}</td>
          <td>{{ $row->ket_transaksi ?? 'Nama tidak tersedia' }}</td>
          <td>{{ $row->id_jenisAkunTransaksi_tujuan ?? '' }}</td>
          <td>{{ $row->id_jenisAkunTransaksi_sumber ?? '' }}</td>
          <td>{{ number_format($row->jumlah_transaksi ?? 0, 0, ',', '.') }}</td>
          <td>{{ $row->data_user->nama_lengkap ?? '' }}</td>
      @empty
        <tr>
          <td colspan="7" class="empty-cell">Belum ada data pemasukan</td>
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

  .pemasukan-table-wrap {
    border: 1.5px solid var(--outer-border);
    border-radius: 0;
    background: var(--bg);
    width: 95%;
    margin-left: 25px;
    margin-top: 20px;
    padding: 0;
    box-shadow: none;
    overflow-x: visible;
  }

  .pemasukan-table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
    font-size: 13px;
    text-align: center;
    color: #222;
  }

  .pemasukan-table thead .head-group th {
    background: var(--head-dark);
    color: #fff;
    text-align: center;
    font-weight: 600;
    padding: 10px;
    border-bottom: 1px solid var(--grid);
    white-space: nowrap;
  }

  .pemasukan-table td {
    padding: 10px;
    border-bottom: 1px solid var(--grid)!important;
    border-right: 1px solid var(--grid)!important;
    background: #fff;
  }

  .pemasukan-table tbody td:last-child {
    border-right: 2px solid var(--grid)!important;
  }

  .pemasukan-table tbody tr td:nth-child(1) {
    border-right: 1.5px solid var(--line) !important;
  }

  .pemasukan-table tbody tr {
    background: #fff;
  }

  .pemasukan-table tbody tr:nth-child(even) {
    background: #fff;
  }

  .pemasukan-table tbody tr:hover {
    background: #fff;
  }

  .pemasukan-table .empty-cell {
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

    .pemasukan-table td,
    .pemasukan-table th {
      padding: 10px;
    }
  }

  @media (max-width: 768px) {
    .pemasukan-table thead .head-group th:nth-child(3),
    .pemasukan-table tbody td:nth-child(3),
    .pemasukan-table thead .head-group th:nth-child(4),
    .pemasukan-table tbody td:nth-child(4) {
      display: none;
    }
  }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const radios = document.querySelectorAll('input[name="selected_trx"]');
    const editButton = document.querySelector('.df-edit');
    const hapusButton = document.querySelector('.df-hapus');

document.querySelectorAll('.selectable-row').forEach(row => {
    row.addEventListener('click', function() {
        document.querySelector('input[name="selected_trx"]').value = this.dataset.id;
        document.querySelectorAll('.selectable-row').forEach(r => r.classList.remove('bg-blue-200'));
        this.classList.add('bg-blue-200');
    });
});
});
</script>


@endsection