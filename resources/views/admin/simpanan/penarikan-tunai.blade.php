@extends('layouts.app-admin3')

@section('title', 'Transaksi Simpanan')
@section('title-1', 'Simpanan')
@section('sub-title', 'Penarikan Tunai')

@section('content')

<x-menu.toolbar-simpanan 
    addUrl="{{ route('penarikan-tunai.create') }}"
    editUrl="{{ route('penarikan-tunai.edit', '__ID__') }}"
    deleteUrl="{{ route('penarikan-tunai.destroy', '__ID__') }}"
    exportUrl="{{ route('penarikan-tunai.exportPdf') }}"
/>

<div class="content-inner">
  <div class="table-scroll-wrapper">
    <table class="table table-bordered table-striped penarikan-table">
      <thead class="table-primary text-center">
        <tr>
          <th>No</th>
          <th>Kode Transaksi</th>
          <th>Tanggal Transaksi</th>
          <th>ID Anggota</th>
          <th>Nama Anggota</th>
          <th>Jenis Penarikan</th>
          <th>Jumlah</th>
          <th>User</th>
          <th>Cetak Nota</th>
        </tr>
      </thead>
      <tbody>
        @forelse($penarikanTunai ?? collect() as $index => $simpanan)
          <tr class="text-center selectable-row" data-id="{{ $simpanan->id_simpanan }}">
            <td>{{ $index + 1 }}</td>
            <td>{{ $simpanan->kode_simpanan ?? '-' }}</td>
            <td>{{ $simpanan->tanggal_transaksi ? \Carbon\Carbon::parse($simpanan->tanggal_transaksi)->format('d-m-Y H:i') : '-' }}</td>
            <td>{{ $simpanan->anggota->id_anggota ?? '-' }}</td>
            <td>{{ $simpanan->anggota->nama_anggota ?? '-' }}</td>
            <td>{{ $simpanan->jenisSimpanan->jenis_simpanan ?? '-' }}</td>
            <td>{{ isset($simpanan->jumlah_simpanan) ? number_format($simpanan->jumlah_simpanan, 0, ',', '.') : '-' }}</td>
            <td>{{ $simpanan->user->nama_lengkap ?? '-' }}</td>
            <td>
              <a href="{{ route('penarikan-tunai.cetak', $simpanan->id_simpanan ?? 0) }}" 
                 class="btn-nota"> 🖨️</a>
            </td>
          </tr>  
        @empty
          <tr>
            <td colspan="9" class="empty-cell">Belum ada data penarikan tunai.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- <div class="pagination-container">
      <x-menu.pagination :data="$penarikanTunai" />
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

.content-inner {
  padding-left: 25px;
  padding-right: 25px;
  margin-top: 25px;
}

.table-scroll-wrapper {
  overflow-x: auto;
  overflow-y: auto;
  max-height: 400px;
  width: 100%;
  background: transparent;
  border-radius: 4px;
  padding-bottom: 8px;
}

.table-scroll-wrapper table {
  margin-bottom: 0;
  background: white;
}

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

.penarikan-table {
  width: 100%;
  border-collapse: collapse;
  font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
  font-size: 14px;
  color: var(--text);
}

.penarikan-table thead {
  background: var(--header-bg);
  color: var(--header-text);
  position: sticky;
  top: 0;
  z-index: 2;
}

.penarikan-table th,
.penarikan-table td {
  text-align: center;
  padding: 10px 14px;
  border: 1px solid var(--border);
  white-space: nowrap;
}

.penarikan-table tbody tr:nth-child(even) {
  background-color: #f9f9f9;
}

.penarikan-table tbody tr:hover {
  background-color: #eef7ff;
}

.penarikan-table .empty-cell {
  text-align: center;
  padding: 8px 10px;
  color: #6b7280;
  font-style: italic;
}

/* Tombol Nota */
.btn-nota {
  display: inline-block;
  background-color: #0099cc;
  color: #fff;
  padding: 4px 10px;
  border-radius: 4px;
  text-decoration: none;
  font-size: 13px;
  transition: background 0.2s;
}
.btn-nota:hover {
  background-color: #0077aa;
}

@media (max-width: 640px) {
  .simpanan-table {
    font-size: 12px;
  }
  .simpanan-table th,
  .simpanan-table td {
    padding: 8px;
  }
}

.selected-row {
  background-color: #cce8ff !important;
}
.disabled {
  opacity: 0.5;
  pointer-events: none;
}

.pagination-container {
  margin-top: auto;        
  display: flex;
  justify-content: flex-end;
  align-items: center;
  padding: 12px 16px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const rows = document.querySelectorAll('.selectable-row');
  const editBtn = document.querySelector('.btn-edit');
  const deleteBtn = document.querySelector('.btn-delete');

  let selectedId = null;

  rows.forEach(row => {
    row.addEventListener('click', () => {
      // Hapus highlight dari baris lain
      rows.forEach(r => r.classList.remove('selected-row'));
      
      // Tambahkan highlight ke baris yang diklik
      row.classList.add('selected-row');
      
      // Simpan ID dari baris yang dipilih
      selectedId = row.dataset.id;
      
      // Aktifkan tombol Edit & Hapus
      editBtn.classList.remove('disabled');
      deleteBtn.classList.remove('disabled');

      // Update URL tombol edit & hapus (gantikan __ID__)
      editBtn.setAttribute('data-url', editBtn.dataset.base.replace('__ID__', selectedId));
      deleteBtn.setAttribute('data-url', deleteBtn.dataset.base.replace('__ID__', selectedId));
    });
  });

  // Aksi ketika tombol Edit diklik
  editBtn.addEventListener('click', function () {
    const url = this.getAttribute('data-url');
    if (!url || this.classList.contains('disabled')) return;
    window.location.href = url;
  });

  // Aksi ketika tombol Hapus diklik
  deleteBtn.addEventListener('click', function () {
    const url = this.getAttribute('data-url');
    if (!url || this.classList.contains('disabled')) return;

    if (confirm('Yakin ingin menghapus data ini?')) {
      fetch(url, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
      })
      .then(res => {
        if (res.ok) {
          alert('Data berhasil dihapus');
          location.reload();
        } else {
          alert('Gagal menghapus data');
        }
      });
    }
  });
});
</script>

@endsection