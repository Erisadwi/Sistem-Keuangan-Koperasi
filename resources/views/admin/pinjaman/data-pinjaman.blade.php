@extends('layouts.app-admin3')

@section('title', 'Pinjaman')
@section('title-1', 'Pinjaman')
@section('sub-title', 'Data Pinjaman')

@section('content')
<x-menu.toolbar-pinjaman
    addUrl="{{ route('pinjaman.create') }}"
    editUrl="{{ route('pinjaman.edit', '__ID__') }}"
    deleteUrl="{{ route('pinjaman.destroy', '__ID__') }}"
    exportUrl="#"
/>

<div class="data-pinjaman-table-wrap">
  <table class="data-pinjaman-table">
    <thead>
      <tr class="head-group">
        <th>No</th>
        <th>Kode</th>
        <th>Tanggal Pinjam</th>
        <th>Nama Anggota</th>
        <th>Hitungan</th>
        <th>Total Tagihan</th>
        <th>Keterangan</th>
        <th>Lunas</th>
        <th>User</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @if(isset($pinjaman) && count($pinjaman) > 0)
        @foreach ($pinjaman as $index => $row)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $row->kode }}</td>
          <td>{{ \Carbon\Carbon::parse($row->tanggal_pinjaman)->format('d-m-Y') }}</td>
          <td>{{ $row->nama_anggota }}</td>

          <!-- === Kolom HITUNGAN === -->
          <td>
            <table class="sub-table">
              <tr><td>Nama Barang</td><td>{{ $row->nama_barang ?? '-' }}</td></tr>
              <tr><td>Harga Barang</td><td>{{ number_format($row->harga_barang ?? 0, 0, ',', '.') }}</td></tr>
              <tr><td>Lama Angsuran</td><td>{{ $row->lama_angsuran ?? '-' }}</td></tr>
              <tr><td>Pokok Angsuran</td><td>{{ number_format($row->pokok_angsuran ?? 0, 0, ',', '.') }}</td></tr>
              <tr><td>Bunga Pinjaman</td><td>{{ number_format($row->bunga_pinjaman ?? 0, 0, ',', '.') }}</td></tr>
              <tr><td>Biaya Admin</td><td>{{ number_format($row->biaya_admin ?? 0, 0, ',', '.') }}</td></tr>
            </table>
          </td>

          <!-- === Kolom TOTAL TAGIHAN === -->
          <td>
            <table class="sub-table">
              <tr><td>Jumlah Angsuran</td><td>{{ number_format($row->jumlah_angsuran ?? 0, 0, ',', '.') }}</td></tr>
              <tr><td>Jumlah Denda</td><td>{{ number_format($row->jumlah_denda ?? 0, 0, ',', '.') }}</td></tr>
              <tr><td>Total Tagihan</td><td>{{ number_format($row->total_tagihan ?? 0, 0, ',', '.') }}</td></tr>
              <tr><td>Sudah Dibayar</td><td>{{ number_format($row->sudah_dibayar ?? 0, 0, ',', '.') }}</td></tr>
              <tr><td>Sisa Angsuran</td><td>{{ $row->sisa_angsuran ?? '-' }}</td></tr>
              <tr><td>Sisa Tagihan</td><td>{{ number_format($row->sisa_tagihan ?? 0, 0, ',', '.') }}</td></tr>
            </table>
          </td>

          <td>{{ $row->keterangan }}</td>
          <td>{{ $row->lunas }}</td>
          <td>{{ $row->user }}</td>
          <td><button class="btn-aksi">Detail</button></td>
          <td><button class="btn-nota">🧾 Nota</button></td>
        </tr>
        @endforeach
      @else
      <tr>
        <td colspan="10" class="empty-cell">Belum ada data pinjaman.</td>
      </tr>
      @endif
    </tbody>
  </table>
</div>

<style>
  :root {
    --outer-border: #838383;
    --head-dark: #4a4a4a;
    --grid: #fffcfc;
    --bg: #ffffff;
  }

  .data-pinjaman-table-wrap {
    border: 1.5px solid var(--outer-border);
    background: var(--bg);
    width: 95%;
    margin-left: 25px;
    margin-top: 30px;
  }

  .data-pinjaman-table {
    width: 100%;
    border-collapse: collapse;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
    font-size: 13px;
    color: #222;
  }

  .data-pinjaman-table thead .head-group th {
    background: var(--head-dark);
    color: #fff;
    text-align: center;
    font-weight: 600;
    padding: 10px;
    border-bottom: 1px solid var(--grid);
  }

  .data-pinjaman-table td {
    padding: 8px;
    border: 1px solid #e6e6e6;
    vertical-align: top;
  }

  /* === Subtable styling agar persis seperti contoh === */
  .sub-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
  }

  .sub-table td {
    border: 1px solid #d1d1d1;
    padding: 4px 6px;
  }

  .sub-table tr td:first-child {
    width: 60%;
    background: #f8f8f8;
    font-weight: 500;
  }

  .sub-table tr td:last-child {
    text-align: right;
    font-weight: 500;
  }

  .btn-aksi, .btn-nota {
    background: #1976d2;
    color: #fff;
    border: none;
    padding: 6px 10px;
    border-radius: 6px;
    cursor: pointer;
  }

  .btn-aksi:hover, .btn-nota:hover {
    background: #125ea3;
  }

  .empty-cell {
    text-align: center;
    padding: 8px 10px;
    color: #6b7280;
    font-style: italic;
  }
</style>

@endsection
