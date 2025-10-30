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
<x-menu.toolbar-right 
  searchPlaceholder="Cari Kode Transaksi"
  searchName="kode_transaksi"
  :downloadRoute="route('transaksi-pemasukan.download', request()->query())"
/>


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
        <tr class="selectable-row" data-id="{{ $row->id_transaksi }}">
          <td>{{ $row->kode_transaksi ?? '' }}</td>
          <td>{{ \Carbon\Carbon::parse($row->tanggal_transaksi)->format('d-m-Y') ?? '' }}</td>
          <td>{{ $row->ket_transaksi ?? '-' }}</td>
          <td>{{ $row->tujuan->nama_AkunTransaksi ?? '' }}</td>
          <td>{{ $row->sumber->nama_AkunTransaksi ?? '' }}</td>
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

    <div class="pagination-container">
      <x-menu.pagination :data="$TransaksiPemasukan" />
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

  .pagination-container {
  margin-top: auto;        
  display: flex;
  justify-content: flex-end;
  align-items: center;
  padding: 12px 16px;
}

.selectable-row.selected td {
  background-color: #b6d8ff !important; 
  color: #000;
}


  .selectable-row:hover {
    background-color: #eaf3ff;
    cursor: pointer;
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const editButton = document.querySelector('.df-edit');
    const hapusButton = document.querySelector('.df-hapus');
    let selectedId = null;

    // saat baris diklik
    document.querySelectorAll('.selectable-row').forEach(row => {
        row.addEventListener('click', function() {
            // hapus highlight dari semua baris
            document.querySelectorAll('.selectable-row').forEach(r => r.classList.remove('selected'));

            // tambahkan highlight ke baris ini
            this.classList.add('selected');
            selectedId = this.dataset.id;

            // ubah tombol edit & hapus agar aktif ke id terpilih
            if (editButton) editButton.href = `/admin/transaksi-pemasukan/${selectedId}/edit`;
            if (hapusButton) hapusButton.dataset.id = selectedId;
        });
    });

    // aksi hapus
    if (hapusButton) {
        hapusButton.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.dataset.id;
            if (!id) {
                alert('Pilih data terlebih dahulu');
                return;
            }

            if (confirm('Yakin ingin menghapus data ini?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/transaksi-pemasukan/${id}`;
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
});
</script>
@endpush



@endsection