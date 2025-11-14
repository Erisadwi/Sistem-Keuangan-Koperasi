@extends('layouts.app-admin3')

@section('title', 'Transaksi Pengeluaran Kas')
@section('title-1', 'Transaksi Kas')
@section('sub-title', 'Data Pengeluaran Kas Tunai')

@section('content')

<x-menu.tambah-edit-hapus
    :tambah="route('pengeluaran.create')" 
    :edit="'#'" 
    :hapus="'#'"
/>

<x-menu.toolbar-right 
  searchPlaceholder="Cari Kode Transaksi"
  searchName="kode_transaksi"
  :downloadRoute="route('pengeluaran.export-pdf')"
/>



<div class="content-inner">
  <div class="table-scroll-wrapper">
    <table class="table table-bordered table-striped pengeluaran-table">
      <thead class="table-primary text-center">
        <tr>
          <th>No</th>
          <th>Kode Transaksi</th>
          <th>Tanggal Transaksi</th>
          <th>Dari Kas</th>
          <th>Untuk Akun</th>
          <th>Jumlah</th>
          <th>Uraian</th>
          <th>User</th>
        </tr>
      </thead>

      <tbody>
        @forelse(($TransaksiPengeluaran ?? collect()) as $index => $row)
         @php
            // akun tujuan = baris dengan debit > 0 (kas masuk)
            $akunTujuan = $row->details->firstWhere('debit', '>', 0)?->akun;
            // akun sumber = semua baris dengan kredit > 0
            $akunSumberList = $row->details->where('kredit', '>', 0);
            // total jumlah = ambil total debit (pasti sama dengan total kredit)
            $jumlah = $row->total_debit ?? 0;
        @endphp
        <tr class="selectable-row" data-id="{{ $row->id_transaksi }}">
          <td>{{ $index + 1 }}</td>
          <td>{{ $row->kode_transaksi ?? '-' }}</td>
          <td>{{ \Carbon\Carbon::parse($row->tanggal_transaksi)->format('d-m-Y') }}</td>
          <td>
                <ul style="margin:0; padding-left:16px; text-align:left;">
                    @foreach($akunSumberList as $s)
                        <li>{{ $s->akun->nama_AkunTransaksi ?? '-' }}</li>
                    @endforeach
                </ul>
            </td>
          <td>{{ $akunTujuan->nama_AkunTransaksi ?? '' }}</td>
          <td>{{ number_format($jumlah, 0, ',', '.') }}</td>
          <td>{{ $row->ket_transaksi ?? '-' }}</td>
          <td>{{ $row->data_user->nama_lengkap ?? '-' }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="8" class="empty-cell">Belum ada data transaksi pengeluaran kas.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

 <div class="pagination-container">
      <x-menu.pagination :data="$TransaksiPengeluaran" />
    </div> 

{{-- STYLE --}}
<style>
:root {
  --primary: #6ba1be;
  --primary-dark: #558ca3;
  --header-bg: #4a4a4a;
  --header-text: #ffffff;
  --border: #c0c0c0;
  --text: #222;
}

/* Wrapper utama agar sejajar dengan tombol */
.content-inner {
  padding-left: 25px;
  padding-right: 60px;
  margin-top: 25px;
}

/* Scroll area tabel */
.table-scroll-wrapper {
  overflow-x: auto;
  overflow-y: auto;
  max-height: 380px;
  width: 100%;
  background: transparent;
  border-radius: 4px;
  padding-bottom: 8px;
}

/* Pastikan tabel tetap putih */
.table-scroll-wrapper table {
  margin-bottom: 0;
  background: white;
}

/* Scrollbar styling */
.table-scroll-wrapper::-webkit-scrollbar {
  height: 8px;
}
.table-scroll-wrapper::-webkit-scrollbar-thumb {
  background: var(--primary);
  border-radius: 4px;
}
.table-scroll-wrapper::-webkit-scrollbar-track {
  background: #f0f0f0;
}

/* Tabel */
.pengeluaran-table {
  width: 100%;
  min-width: 1000px;
  border-collapse: collapse;
  font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
  font-size: 14px;
  color: var(--text);
}

.pengeluaran-table thead {
  background: var(--header-bg);
  color: var(--header-text);
  position: sticky;
  top: 0;
  z-index: 2;
}

.pengeluaran-table th,
.pengeluaran-table td {
  text-align: center;
  padding: 10px 14px;
  border: 1px solid var(--border);
  white-space: nowrap;
}

.pengeluaran-table tbody tr:nth-child(even) {
  background-color: #f9f9f9;
}

.pengeluaran-table tbody tr:hover {
  background-color: #eef7ff;
}

.pengeluaran-table .empty-cell {
    text-align: center;
    padding: 8px 10px;
    color: #6b7280;
    font-style: italic;
  }

.pagination-container {
  margin-top: auto;        
  display: flex;
  justify-content: flex-end;
  align-items: center;
  padding: 12px 16px;
}

@media (max-width: 640px) {
  .pengeluaran-table {
    font-size: 12px;
  }
  .pengeluaran-table th,
  .pengeluaran-table td {
    padding: 8px;
  }
}

.selectable-row.selected td{
  background-color: #b6d8ff !important;
  color: #000;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const rows = document.querySelectorAll(".selectable-row");
    const btnEdit = document.querySelector(".df-edit");
    const btnHapus = document.querySelector(".df-hapus");

    rows.forEach(row => {
        row.addEventListener("click", function () {
            rows.forEach(r => r.classList.remove("selected"));
            this.classList.add("selected");

            const id = this.getAttribute("data-id");

            if (btnEdit) {
                btnEdit.href = `/admin/pengeluaran/${id}/edit`;
                btnEdit.removeAttribute("disabled");
            }
            if (btnHapus) {
                btnHapus.closest("form").action = `/admin/pengeluaran/${id}`;
                btnHapus.removeAttribute("disabled");
            }
        });
    });
});
</script>

@endsection
