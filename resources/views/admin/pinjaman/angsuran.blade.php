@extends('layouts.app-admin3')

@section('title', 'Pembayaran Angsuran')  
@section('title-1', 'Pinjaman')  
@section('sub-title', 'Data Bayar Angsuran')  

@section('content')

<x-menu.toolbar-filter/>


<div class="pengajuan-pinjaman-table-wrap">
  <table class="pengajuan-pinjaman-table">
    <thead>
      <tr class="head-group">
        <th>No</th>
        <th>Kode</th>
        <th>Tanggal Pinjam</th>
        <th>ID Anggota</th>
        <th>Nama Anggota</th>
        <th>Pokok Pinjaman</th>
        <th>Lama Pinjam</th>
        <th>Angsuran Pokok</th>
        <th>Bunga Angsuran</th>
        <th>Biaya Admin</th>
        <th>Angsuran Per Bulan</th>
        <th>Bayar</th>
      </tr>
    </thead>

    <tbody>
      @forelse(($dataAngsuran ?? collect()) as $idx => $row)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $row->kode ?? '' }}</td>
          <td>{{ $row->tanggal_pinjam ?? '' }}</td>
          <td>{{ $row->id_anggota ?? '' }}</td>
          <td>{{ $row->nama_anggota ?? '' }}</td>
          <td>{{ number_format($row->pokok_pinjaman ?? 0, 0, ',', '.') }}</td>
          <td>{{ $row->lama_pinjam ?? '' }}</td>
          <td>{{ number_format($row->angsuran_pokok ?? 0, 0, ',', '.') }}</td>
          <td>{{ number_format($row->bunga_angsuran ?? 0, 0, ',', '.') }}</td>
          <td>{{ number_format($row->biaya_admin ?? 0, 0, ',', '.') }}</td>
          <td>{{ number_format($row->angsuran_per_bulan ?? 0, 0, ',', '.') }}</td>
          <td class="actions">
            <a href="{{ route('bayar.angsuran', ['id' => $row->id]) }}" class="btn-bayar">
              💳 Bayar
            </a>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="12" class="empty-cell">Belum ada data angsuran</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<style>
:root {
  --border: #d1d5db;
  --header-bg: #111827; /* hitam tua */
  --header-text: #ffffff;
  --body-bg: #ffffff;
  --body-text: #000000;
}

.pengajuan-pinjaman-table-wrap {
  border: 1.5px solid var(--border);
  background: var(--body-bg);
  width: 100%;
  max-width: 1200px;
  margin-left: 25px;
  margin-top: 20px;
  overflow-x: auto;
  border-radius: 4px;
}

.pengajuan-pinjaman-table {
  width: 100%;
  border-collapse: collapse;
  font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
  font-size: 13px;
  color: var(--body-text);
  text-align: center;
}

.pengajuan-pinjaman-table thead .head-group th {
  background: var(--header-bg);
  color: var(--header-text);
  padding: 10px;
  font-weight: 600;
  border: 1px solid var(--border);
}

.pengajuan-pinjaman-table tbody tr {
  background: var(--body-bg);
  border-bottom: 1px solid var(--border);
}

.pengajuan-pinjaman-table td {
  padding: 8px;
  border: 1px solid var(--border);
  color: var(--body-text);
}

.actions {
  display: flex;
  justify-content: center;
  align-items: center;
}

.btn-bayar {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  background: #0ea5e9;
  color: #fff;
  padding: 4px 8px;
  border-radius: 5px;
  text-decoration: none;
  font-size: 12px;
  font-weight: 500;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.btn-bayar:hover {
  background: #0284c7;
}

.empty-cell {
 padding: 8px 10px;
 color: #6b7280;
 font-style: italic;
}
</style>

@endsection
