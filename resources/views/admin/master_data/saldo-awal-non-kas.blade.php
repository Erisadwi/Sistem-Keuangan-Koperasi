@extends('layouts.app-admin3')

@section('title', 'Saldo Awal Non Kas')
@section('title-1', 'Master Data')
@section('sub-title', 'Saldo Awal Non Kas')

@section('content')

<x-menu.tambah-unduh 
    addUrl="{{ route('saldo-awal-non-kas.create') }}" 
    downloadFile="{{ route('saldo-awal-non-kas.export') }}"
/>

<div class="saldo-awal-non-kas-table-wrap">
  <table class="saldo-awal-non-kas-table">
    <thead>
      <tr>
        <th>Tanggal</th>
        <th>Akun</th>
        <th>Keterangan</th>
        <th>Saldo Awal</th>
        <th>Update Data</th>
        <th>Username</th>
        <th>Aksi</th>
      </tr>
    </thead>

    <tbody>
      @forelse(($saldoAwalNonKas ?? collect()) as $row)
        @php
            $detailKredit = $row->details->where('kredit', '>', 0)->first();
            $akunNama = $detailKredit?->akun?->nama_AkunTransaksi ?? '-';
            $jumlahSaldo = $detailKredit?->kredit ?? 0;
        @endphp
        <tr>
          <td>{{ \Carbon\Carbon::parse($row->tanggal_transaksi)->format('d/m/Y - H:i') }}</td>
          <td>{{ $akunNama }}</td>
          <td>{{ $row->ket_transaksi ?? '-' }}</td>
          <td>{{ number_format($jumlahSaldo, 0, ',', '.') }}</td>
          <td>-</td> <!-- ini untuk kolom Update Data -->
          <td>{{ $row->data_user->username ?? '-' }}</td>
          <td class="actions">
            <a href="{{ route('saldo-awal-non-kas.edit', $row->id_transaksi) }}" class="edit">✏️ Edit</a>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="7" class="empty-cell">Belum ada data saldo awal non kas</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="pagination-container">
      <x-menu.pagination :data="$saldoAwalNonKas" />
 </div>

<style>
  :root {
    --outer-border: #838383;
    --head-dark: #4a4a4a;
    --grid: #e5e5e5;
    --bg: #ffffff;
  }

  .saldo-awal-non-kas-table-wrap {
    border: 1.5px solid var(--outer-border);
    background: var(--bg);
    width: 100%;
    margin-left: 0px;
    margin-top: 20px;
    padding: 0;
    overflow-x: auto;
  }

  .saldo-awal-non-kas-table {
    width: 100%;
    border-collapse: collapse;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
    font-size: 13px;
    color: #222;
    text-align: center;
  }

  .saldo-awal-non-kas-table thead th {
    background: var(--head-dark);
    color: #fff;
    font-weight: 600;
    padding: 10px;
    border-bottom: 1px solid var(--grid);
  }

  .saldo-awal-non-kas-table td {
    padding: 10px;
    border-bottom: 1px solid var(--grid);
  }

  .saldo-awal-non-kas-table .empty-cell {
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
    .saldo-awal-non-kas-table {
      font-size: 12px;
    }
    .saldo-awal-non-kas-table th, .saldo-awal-non-kas-table td {
      padding: 8px;
    }
  }
  
.pagination {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  gap: 6px;
  margin-top: 15px;
  font-size: 14px;
}

.pagination select,
.pagination button {
  padding: 4px 6px;
  border-radius: 4px;
  border: 1px solid var(--border);
  background: white;
  cursor: pointer;
}

.pagination button {
  background: var(--primary);
  color: white;
  border: none;
}

.pagination button:hover {
  background: var(--primary-dark);
}
</style>

@endsection
