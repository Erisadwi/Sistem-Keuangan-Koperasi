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
          <td>{{ $row->anggota->id_anggota }}</td>
          <td>{{ \Carbon\Carbon::parse($row->tanggal_pinjaman)->format('d-m-Y') }}</td>
          <td>{{ $row->anggota->nama_anggota }}</td>

          <!-- === Kolom HITUNGAN === -->
          <td>
            <table class="sub-table">
              <tr><td>Jumlah Pinjaman</td><td>{{ number_format($row->jumlah_pinjaman ?? 0, 0, ',', '.') }}</td></tr>
              <tr><td>Lama Angsuran</td><td>{{ $row->lama_angsuran_text }}</td></tr>
              <tr><td>Pokok Angsuran</td><td>{{ number_format($row->pokok_angsuran ?? 0, 0, ',', '.') }}</td></tr>
              <tr><td>Bunga Pinjaman</td><td>{{ number_format($row->bunga_pinjaman ?? 0, 0, ',', '.') }}</td></tr>
              <tr><td>Biaya Admin</td><td>{{ number_format($row->biaya_admin ?? 0, 0, ',', '.') }}</td></tr>
            </table>
          </td>

          <!-- === Kolom TOTAL TAGIHAN === -->
          <td>
            <table class="sub-table">
              <tr><td>Jumlah Angsuran</td><td>{{ number_format($row->jumlah_angsuran_otomatis, 0, ',', '.') }}</td></tr>
              <tr><td>Jumlah Denda</td><td>{{ number_format($row->jumlah_denda ?? 0, 0, ',', '.') }}</td></tr>
              <tr><td>Total Tagihan</td><td>{{ number_format($row->total_tagihan ?? 0, 0, ',', '.') }}</td></tr>
              <tr><td>Sudah Dibayar</td><td>{{ number_format($row->sudah_dibayar ?? 0, 0, ',', '.') }}</td></tr>
              <tr><td>Sisa Angsuran</td><td>{{ $row->sisa_angsuran ?? '-' }}</td></tr>
              <tr><td>Sisa Tagihan</td><td>{{ number_format($row->sisa_tagihan ?? 0, 0, ',', '.') }}</td></tr>
            </table>
          </td>

          <td>{{ $row->keterangan }}</td>
          <td>{{ $row->status_lunas ?? '' }}</td>
          <td>{{ $row->user->nama_lengkap ?? '' }}</td>
          <td class="text-center">
            <div class="aksi-btn-container">
              <a href="{{ route('pinjaman.show', $row->id_pinjaman) }}" class="aksi-btn detail-btn" title="Lihat Detail">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <circle cx="11" cy="11" r="8" stroke-width="2"/>
                  <line x1="21" y1="21" x2="16.65" y2="16.65" stroke-width="2"/>
                </svg>
              </button>

              <a href="{{ route('pinjaman.cetak-nota', $row->id_pinjaman) }}" class="aksi-btn nota-btn" title="Cetak Nota">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <rect x="6" y="9" width="12" height="11" stroke-width="2"/>
                  <path d="M6 9V4h12v5" stroke-width="2"/>
                  <line x1="8" y1="13" x2="16" y2="13" stroke-width="2"/>
                  <line x1="8" y1="17" x2="12" y2="17" stroke-width="2"/>
                </svg>
              </a>
            </div>
          </td>
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

  /* === Subtable styling === */
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

  .aksi-btn-container {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 6px;
  }

  .aksi-btn {
    width: 30px;
    height: 30px;
    border: 1px solid #b4b4b4;
    border-radius: 6px;
    background-color: white;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    transition: 0.2s;
  }

  .aksi-btn svg {
    stroke: #1e90ff;
  }

  .aksi-btn.detail-btn:hover svg {
    stroke: #0056b3;
  }

  .aksi-btn.nota-btn svg {
    stroke: #007b8f;
  }

  .aksi-btn.nota-btn:hover svg {
    stroke: #004e5a;
  }

  .empty-cell {
    text-align: center;
    padding: 8px 10px;
    color: #6b7280;
    font-style: italic;
  }

</style>
@endsection
