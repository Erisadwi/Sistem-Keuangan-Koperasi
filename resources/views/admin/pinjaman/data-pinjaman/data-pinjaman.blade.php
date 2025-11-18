@extends('layouts.app-admin3')

@section('title', 'Pinjaman')
@section('title-1', 'Pinjaman')
@section('sub-title', 'Data Pinjaman')

@section('content')
<x-menu.toolbar-pinjaman
    addUrl="{{ route('pinjaman.create') }}"
    editUrl="{{ route('pinjaman.edit', '__ID__') }}"
    deleteUrl="{{ route('pinjaman.destroy', '__ID__') }}"
    exportUrl="{{ route('pinjaman.exportPdf') }}"
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
        <tr class="selectable-row" data-id="{{ $row->id_pinjaman }}">
          <td>{{ $index + 1 }}</td>
          <td>{{ $row->id_pinjaman }}</td>
          <td>{{ \Carbon\Carbon::parse($row->tanggal_pinjaman)->format('d-m-Y') }}</td>
          <td>{{ $row->anggota->nama_anggota }}</td>
 
          <td>
            <table class="sub-table">
              <tr><td>Jumlah Pinjaman</td><td>{{ number_format($row->jumlah_pinjaman ?? 0, 0, ',', '.') }}</td></tr>
              <tr><td>Lama Angsuran</td><td>{{ $row->lama_angsuran_text }}</td></tr>
              <tr><td>Pokok Angsuran</td><td>{{ number_format($row->pokok_angsuran ?? 0, 0, ',', '.') }}</td></tr>
              <tr><td>Bunga Pinjaman</td><td>{{ number_format($row->bunga_pinjaman ?? 0, 0, ',', '.') }}</td></tr>
              <tr><td>Biaya Admin</td><td>{{ number_format($row->biaya_admin ?? 0, 0, ',', '.') }}</td></tr>
            </table>
          </td>

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
                </a>

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

<div class="pagination-container">
      <x-menu.pagination1 :data="$pinjaman" />
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

  .selectable-row.selected td {
  background-color: #b6d8ff !important; 
  color: #000;
}


  .selectable-row:hover {
    background-color: #eaf3ff;
    cursor: pointer;
  }

</style>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {

    let selectedId = null;
    const rows = document.querySelectorAll(".selectable-row");

    const editBtn = document.querySelector("[data-action='edit']");
    const deleteBtn = document.querySelector("[data-action='delete']");

    rows.forEach(row => {
        row.addEventListener("click", function() {

            rows.forEach(r => r.classList.remove("selected"));
            this.classList.add("selected");

            selectedId = this.dataset.id;

            editBtn.disabled = false;
            deleteBtn.disabled = false;
        });
    });

    editBtn.addEventListener("click", function() {
        if (!selectedId) return alert("Pilih data dulu!");
        const url = this.dataset.url.replace("__ID__", selectedId);
        window.location.href = url;
    });

    deleteBtn.addEventListener("click", function() {
        if (!selectedId) return alert("Pilih data dulu!");
        if (!confirm("Yakin ingin menghapus data ini?")) return;

        const url = this.dataset.url.replace("__ID__", selectedId);

        const form = document.createElement("form");
        form.method = "POST";
        form.action = url;
        form.innerHTML = `@csrf @method('DELETE')`;
        document.body.appendChild(form);
        form.submit();
    });

    const codeInput = document.getElementById("transactionId");
    const nameInput = document.getElementById("memberName");
    const statusSelect = document.getElementById("statusPinjaman");
    const sortSelect   = document.getElementById("filterSort");

    const applyFilter = () => {
        let params = new URLSearchParams(window.location.search);

        if (codeInput.value) params.set("kode", codeInput.value);
        else params.delete("kode");

        if (nameInput.value) params.set("nama", nameInput.value);
        else params.delete("nama");

        if (statusSelect.value) params.set("status", statusSelect.value);
        else params.delete("status");

        if (sortSelect.value) {
            params.set("sort", sortSelect.value);
        } else {
            params.delete("sort");
        }

        window.location.search = params.toString();
    };

    statusSelect.addEventListener("change", applyFilter);
    sortSelect.addEventListener("change", applyFilter);
    document.getElementById("btnSearch").addEventListener("click", applyFilter);

    const btnTanggal = document.getElementById("btnTanggal");
    const popupTanggal = document.getElementById("popupTanggal");
    const tanggalMulai = document.getElementById("tanggalMulai");
    const tanggalAkhir = document.getElementById("tanggalAkhir");

    const btnSimpanTanggal = document.getElementById("btnSimpanTanggal");
    const btnBatalTanggal = document.getElementById("btnBatalTanggal");

    btnTanggal.addEventListener("click", function(e) {
        e.stopPropagation();
        popupTanggal.style.display =
            popupTanggal.style.display === "block" ? "none" : "block";
    });

    document.addEventListener("click", function(e) {
        if (!popupTanggal.contains(e.target) && !btnTanggal.contains(e.target)) {
            popupTanggal.style.display = "none";
        }
    });

    btnSimpanTanggal.addEventListener("click", function() {
        let params = new URLSearchParams(window.location.search);

        if (tanggalMulai.value) params.set("start", tanggalMulai.value);
        else params.delete("start");

        if (tanggalAkhir.value) params.set("end", tanggalAkhir.value);
        else params.delete("end");

        window.location.search = params.toString();
    });

    btnBatalTanggal.addEventListener("click", function() {
        tanggalMulai.value = "";
        tanggalAkhir.value = "";
        popupTanggal.style.display = "none";
    });

    const params = new URLSearchParams(window.location.search);

    if (params.get("kode")) codeInput.value = params.get("kode");
    if (params.get("nama")) nameInput.value = params.get("nama");
    if (params.get("status")) statusSelect.value = params.get("status");
    if (params.get("sort")) sortSelect.value = params.get("sort");
    if (params.get("start")) tanggalMulai.value = params.get("start");
    if (params.get("end")) tanggalAkhir.value = params.get("end");


});

function clearFilter() {

    document.getElementById('transactionId').value = '';
    document.getElementById('memberName').value = '';
    document.getElementById('statusPinjaman').selectedIndex = 0;
    document.getElementById('filterSort').selectedIndex = 0;
    document.getElementById('btnTanggal').value = '';
    document.getElementById('popupTanggal').value = '';
    document.getElementById('tanggalMulai').value = '';
    document.getElementById('tanggalAkhir').value = '';
    
    window.location.href = "{{ route('pinjaman.index') }}";
}

</script>
@endpush

@endsection
