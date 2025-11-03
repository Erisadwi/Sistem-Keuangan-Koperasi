@extends('layouts.app-admin3')

@section('title', 'Transaksi Pengeluaran Kas')
@section('title-1', 'Transaksi Kas')
@section('sub-title', 'Data Pengeluaran Kas Tunai')

@section('content')

<x-menu.tambah-edit-hapus
    :tambah="'#'" 
    :edit="'#'" 
    :hapus="'#'"
    id="action-buttons"

/>

<x-menu.toolbar-right 
   
/>


<div class="content-inner">
  <div class="table-scroll-wrapper">
    <table class="table table-bordered table-striped pengeluaran-table">
      <thead class="table-primary text-center">
  <tr class="text-center">
    <th>No</th>
    <th>Kode Transaksi</th>
    <th>Tanggal Transaksi</th>
    <th>Uraian</th>
    <th>Dari Kas</th>
    <th>Untuk Akun</th>
    <th>Jumlah</th>
    <th>User</th>
  </tr>
</thead>

<tbody>
  @forelse(($TransaksiPengeluaran ?? collect()) as $index => $row)
    <tr class="selectable-row" data-id="{{ $row->id_transaski }}">
      <td><input type="checkbox" class="row-check" value="{{ $row->id_transaksi }}"></td>
      <td>{{ $index + 1 }}</td>
      <td>{{ $row->kode_transaksi ?? '-' }}</td>
      <td>{{ $row->tanggal_transaksi ?? '-' }}</td>
      <td>{{ $row->ket_transaksi ?? '-' }}</td>
      <td>{{ $row->jenisAkunTransaksi_sumber ?? '-' }}</td>
      <td>{{ $row->jenisAkunTransaksi_tujuan ?? '-' }}</td>
      <td>{{ number_format($row->jumlah_transaksi, 0, ',', '.') }}</td>
      <td>{{ $row->user ?? '-' }}</td>
    </tr>
  @empty
    <tr>
      <td colspan="9" class="empty-cell">Belum ada data transaksi pengeluaran kas.</td>
    </tr>
  @endforelse
</tbody>

    </table>
  </div>
</div>

 {{-- <div class="pagination-container">
      <x-menu.pagination :data="$TransaksiPengeluaran" />
    </div> --}}

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
document.addEventListener("DOMContentLoaded", function() {
  const checkboxes = document.querySelectorAll(".row-check");
  const btnEdit = document.querySelector(".df-edit");
  const btnHapus = document.querySelector(".df-hapus");

  checkboxes.forEach(chk => {
    chk.addEventListener("change", function() {
      const selected = Array.from(checkboxes).filter(c => c.checked);
      if (selected.length === 1) {
        const id = selected[0].value;
        btnEdit.href = `/pengeluaran/${id}/edit`;
        document.querySelector(".df-hapus").closest("form").action = `/pengeluaran/${id}`;
        btnEdit.removeAttribute("disabled");
        btnHapus.removeAttribute("disabled");
      } else {
        btnEdit.setAttribute("disabled", "true");
        btnHapus.setAttribute("disabled", "true");
      }
    });
  });

  // select all
  document.getElementById("selectAll").addEventListener("change", function(e) {
    checkboxes.forEach(c => c.checked = e.target.checked);
  });
});
</script>

@endsection
