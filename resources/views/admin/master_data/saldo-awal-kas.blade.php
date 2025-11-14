@extends('layouts.app-admin3')

@section('title', 'Saldo Awal Kas')
@section('title-1', 'Master Data')
@section('sub-title', 'Saldo Awal Kas')

@section('content')

<x-menu.tambah-unduh 
    addUrl="{{ route('saldo-awal-kas.create') }}" 
    downloadFile="{{ route('saldo-awal-kas.export') }}" 
/>

<div class="saldo-awal-kas-table-wrap">
  <table class="saldo-awal-kas-table">
    <thead>
      <tr>
        <th>Tanggal</th>
        <th>Akun</th>
        <th>Keterangan</th>
        <th>Saldo Awal</th>
        <th>Username</th>
        <th>Aksi</th>
      </tr>
    </thead>

    <tbody>
      @forelse(($saldoAwalKas ?? collect()) as $row)
        @php
            $detailDebit = $row->details->where('debit', '>', 0)->first();
            $akunNama = $detailDebit?->akun?->nama_AkunTransaksi ?? '-';
            $jumlahSaldo = $detailDebit?->debit ?? 0;
        @endphp

        <tr>
          <td>{{ \Carbon\Carbon::parse($row->tanggal_transaksi)->format('d/m/Y - H:i') }}</td>
          <td>{{ $akunNama }}</td>
          <td>{{ $row->ket_transaksi ?? '-' }}</td>
          <td>{{ number_format($jumlahSaldo, 0, ',', '.') }}</td>
          <td>{{ $row->data_user->username ?? '-' }}</td>
          <td class="actions">
            <a href="{{ route('saldo-awal-kas.edit', $row->id_transaksi) }}" class="edit">✏️ Edit</a>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" class="empty-cell">Belum ada data saldo awal kas</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="pagination-container">
  <x-menu.pagination :data="$saldoAwalKas" />
</div>

<style>
  :root {
    --outer-border: #838383;
    --head-dark: #4a4a4a;
    --grid: #e5e5e5;
    --bg: #ffffff;
  }

  .saldo-awal-kas-table-wrap {
    border: 1.5px solid var(--outer-border);
    background: var(--bg);
    width: 96%;
    margin-left: 25px;
    margin-top: 20px;
    padding: 0;
    overflow-x: auto;
  }

  .saldo-awal-kas-table {
    width: 100%;
    border-collapse: collapse;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
    font-size: 13px;
    color: #222;
    text-align: center;
  }

  .saldo-awal-kas-table thead th {
    background: var(--head-dark);
    color: #fff;
    font-weight: 600;
    padding: 10px;
    border: 1px solid var(--grid);
  }

  .saldo-awal-kas-table td {
    padding: 10px;
    border: 1px solid var(--grid);
  }

  .saldo-awal-kas-table .empty-cell {
    text-align: center;
    padding: 15px;
    color: #6b7280;
    font-style: italic;
  }

  .actions {
    display: flex;
    justify-content: center;
    gap: 8px;
  }

  .edit {
    background-color: #25E11B;
    color: white;
    text-decoration: none;
    padding: 6px 10px;
    border-radius: 5px;
    font-size: 13px;
  }

  .edit:hover {
    background-color: #1da213;
  }

  @media (max-width: 640px) {
    .saldo-awal-kas-table {
      font-size: 12px;
    }
    .saldo-awal-kas-table th, .saldo-awal-kas-table td {
      padding: 8px;
    }
  }

  .pagination-container {
    margin-top: auto;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    padding: 12px 16px;
  }
</style>

@endsection
