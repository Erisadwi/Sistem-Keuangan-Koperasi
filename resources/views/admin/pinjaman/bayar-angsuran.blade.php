@extends('layouts.coba')

@section('title', 'Pembayaran Angsuran')
@section('title-1', 'Pinjaman')
@section('sub-title', 'Data Bayar Angsuran')

@section('content')

@php
    $anggota = $anggota ?? null;
    $pinjaman = $pinjaman ?? null;
    $payments = $payments ?? [];
@endphp

<div class="content-wrapper">
  <h2 class="page-title">
    <a href="{{ url('#') }}" class="breadcrumb-link">Data Bayar Angsuran</a>
    &nbsp; &gt; &nbsp;
    <span>Bayar Angsuran</span>
</h2>



    <div class="card-biru">
        <div class="card-header">
            <h3>Detail Pinjaman</h3>
        </div>

        {{-- CARD PUTIH --}}
        <div class="card-putih">
            <div class="data-anggota">
                @php
                    $fotoPath = (!empty($anggota) && !empty($anggota->foto))
                        ? asset('storage/'.$anggota->foto)
                        : asset('images/default.jpeg');
                @endphp
                <img src="{{ $fotoPath }}" alt="Foto Anggota" class="foto-anggota">

                <div class="info">
                    <div class="left">
                        <h4>Data Anggota</h4>
                        <p>ID Anggota: <span>{{ $anggota->id_anggota ?? '-' }}</span></p>
                        <p>Nama Anggota: <span>{{ $anggota->nama ?? '-' }}</span></p>
                        <p>Departemen: <span>{{ $anggota->departemen ?? '-' }}</span></p>
                        <p>Tempat, Tanggal Lahir: 
                            <span>
                                @if(!empty($anggota?->tempat_lahir) || !empty($anggota?->tgl_lahir))
                                    {{ $anggota->tempat_lahir ?? '-' }}, {{ $anggota->tgl_lahir ?? '-' }}
                                @else
                                    -
                                @endif
                            </span>
                        </p>
                        <p>Kota Tinggal: <span>{{ $anggota->kota ?? '-' }}</span></p>
                    </div>

                    <div class="right">
                        <h4>Data Pinjaman</h4>
                        <p>Kode Pinjam: <span>{{ $pinjaman->kode_pinjam ?? '-' }}</span></p>
                        <p>Tanggal Pinjam: <span>{{ $pinjaman->tgl_pinjam ?? '-' }}</span></p>
                        <p>Tanggal Tempo: <span>{{ $pinjaman->tgl_tempo ?? '-' }}</span></p>
                        <p>Lama Pinjaman: <span>{{ $pinjaman->lama_pinjaman ?? '-' }}</span></p>
                    </div>

                    <div class="center">
                        <p>Pokok Pinjaman: <span>{{ $pinjaman->kode_pinjam ?? '-' }}</span></p>
                        <p>Angsuran Pokok: <span>{{ $pinjaman->tgl_pinjam ?? '-' }}</span></p>
                        <p>Biaya & Bunga: <span>{{ $pinjaman->tgl_tempo ?? '-' }}</span></p>
                        <p>Jumlah Angsuran: <span>{{ $pinjaman->lama_pinjaman ?? '-' }}</span></p>
                    </div>
                </div>
            </div>
        </div>

        {{-- INFO BIRU BAWAH --}}
        <div class="info-biru-bawah">
            <span>Rangkuman &raquo;</span>
            <span>Sisa Angsuran: 
                <b>{{ isset($pinjaman->sisa_angsuran) ? 'Rp. ' . number_format($pinjaman->sisa_angsuran, 0, ',', '.') : '-' }}</b>
            </span>
            <span>Dibayar: 
                <b>{{ isset($pinjaman->sudah_dibayar) ? 'Rp. ' . number_format($pinjaman->sudah_dibayar, 0, ',', '.') : '-' }}</b>
            </span>
            <span>Denda: 
                <b>{{ isset($pinjaman->denda) ? 'Rp. ' . number_format($pinjaman->denda, 0, ',', '.') : '-' }}</b>
            </span>
            <span>Sisa Tagihan: 
                <b>{{ isset($pinjaman->sisa_tagihan) ? 'Rp. ' . number_format($pinjaman->sisa_tagihan, 0, ',', '.') : '-' }}</b>
            </span>
            <span>Status Pelunasan: 
                <b class="status-lunas">{{ $pinjaman->status ?? '-' }}</b>
            </span>
        </div>

        {{-- SECTION PEMBAYARAN --}}
        <div class="section-pembayaran">
            <h4 class="section-title">Data Pembayaran Angsuran:</h4>

            {{-- TOOLBAR --}}
            <div class="toolbar">
                <div class="left-buttons">
                    <button class="filter-button">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                            <path d="M12 5v14M5 12h14" stroke="#2563eb" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Tambah
                    </button>

                    <button class="filter-button hapus">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                            <path d="M3 6h18M8 6v14a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V6m-5-3h2a1 1 0 0 1 1 1v2H9V4a1 1 0 0 1 1-1h2z" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Hapus
                    </button>

                    {{-- Tombol Tanggal --}}
                    <div class="tanggal-wrapper" style="position: relative;">
                        <button id="btnTanggal" class="filter-button" onclick="toggleTanggalPopup()">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <path d="M8 7V3M16 7V3M4 11h16M5 5h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2z"
                                  stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Tanggal
                        </button>

                        <!-- Pop-up filter tanggal -->
                        <div id="tanggalPopup" class="tanggal-popup">
                            <h4>Pilih Tanggal</h4>
                            <div class="tanggal-inputs">
                                <label>Dari:</label>
                                <input type="date" id="tanggalMulai">
                                <label>Sampai:</label>
                                <input type="date" id="tanggalAkhir">
                            </div>
                            <div class="popup-actions">
                                <button class="btn-simpan" onclick="simpanTanggal()">Simpan</button>
                                <button class="btn-batal" onclick="closeTanggalPopup()">Batal</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="filter">
                    <label for="kode">Cari:</label>
                    <input type="text" id="kode" placeholder="Kode Transaksi">
                    <button class="filter-button" onclick="hapusFilter()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                            <path d="M6 6l12 12M6 18L18 6" stroke="#2563eb" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Hapus Filter
                    </button>
                </div>
            </div>

            <div class="table-wrapper">
                <table class="tabel-pembayaran">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Bayar</th>
                            <th>Tanggal Bayar</th>
                            <th>Tanggal Tempo</th>
                            <th>Angsuran ke-</th>
                            <th>Jumlah Bayar</th>
                            <th>Denda</th>
                            <th>Terlambat</th>
                            <th>Unduh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $i => $pay)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $pay->kode_bayar ?? '-' }}</td>
                                <td>{{ $pay->tgl_bayar ?? '-' }}</td>
                                <td>{{ $pay->tgl_tempo ?? '-' }}</td>
                                <td>{{ $pay->angsuran_ke ?? '-' }}</td>
                                <td>{{ isset($pay->jumlah) ? number_format($pay->jumlah, 0, ',', '.') : '-' }}</td>
                                <td>{{ $pay->denda ?? '-' }}</td>
                                <td>{{ $pay->terlambat ?? '-' }}</td>
                                <td>
                                    @if(!empty($pay->file_path))
                                        <a href="{{ asset('storage/'.$pay->file_path) }}" class="download" download>⬇</a>
                                    @else
                                        <span class="download">⬇</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="no-data">Belum ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.content-wrapper {
    padding: 18px 22px;
    font-family: "Segoe UI", Tahoma, Arial, sans-serif;
    color: #222;
    margin-top:-70px;
}
.page-title {
    font-size: 24px;
    color: #9aa3ad;
    margin-bottom: 15px;
    margin-top: -2px;
}
.page-title span {
    color: #000;
    font-weight: 700;
}

.card-biru {
    background-color: #C4DAE5;
    border-radius: 12px;
    overflow: visible; 
    box-shadow: 0 4px 12px rgba(0,0,0,0.07);
}

.card-header {
    background-color: #6E9EB6;
    color: #fff;
    padding: 14px 18px;
}
.card-header h3 {
    margin: 0;
    font-size: 22px;
    font-weight: 700;
}

.breadcrumb-link {
  color: #9aa3ad;           
  text-decoration: none;   
  cursor: pointer;   
  font-weight:500;
  font-size: 20px;    
}

.breadcrumb-link:hover {
  color: #6b7280;          
  text-decoration: none;    
}

.card-putih {
    background-color: #fff;
    margin: 16px;
    padding: 16px;
    border-radius: 8px;
    display: flex;
    gap: 20px;
    align-items: flex-start;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.data-anggota {
    display: flex;
    width: 100%;
}
.foto-anggota {
    width: 84px;
    height: 100px;
    object-fit: cover;
    border: 1px solid #d6d6d6;
    border-radius: 6px;
    margin-right: 14px;
}
.info {
    display: flex;
    justify-content: space-between;
    width: calc(100% - 100px);
}
.info .left, .info .right, .info.center {
    width: 40%;
}
.info h4 {
    color: #6E9EB6;
    margin: 0 0 8px 0;
    font-size: 15px;
}
.info p {
    margin: 4px 0;
    font-size: 13px;
    color: #222;
}
.info p span {
    font-weight: 600;
}

.info-biru-bawah {
    background-color: #6E9EB6;
    color: #fff;
    padding: 9px 16px;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 8px;
    font-size: 14px;
}
.status-lunas {
    color: #d7f1d9;
    font-weight: 700;
}

.section-pembayaran {
    padding: 16px;
}
.section-title {
    margin: 0 0 8px 0;
    color: #fff;
    font-size: 16px;
    font-weight: 650;
}
.left-buttons {
    display: flex;
    gap: 8px;
}

.table-wrapper {
    margin-top: 6px;
    background: transparent;
    padding: 10px 13px 22px 13px;
}
.tabel-pembayaran {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    box-shadow: 0 1px 2px rgba(0,0,0,0.03);
}
.tabel-pembayaran th {
    background: #4a4a4a;
    color: #fff;
    padding: 10px;
    text-align: center;
    font-weight: 600;
    font-size: 13px;

}
.tabel-pembayaran td {
    border: 1px solid #d6d6d6;
    padding: 10px;
    text-align: center;
    font-size: 13px;
}
.tabel-pembayaran tr:nth-child(even) td {
    background: #fafafa;
}
.no-data {
    text-align: center;
    padding: 18px;
    color: #666;
}
.download {
    color: #2b80a2;
    text-decoration: none;
    font-size: 18px;
}

.toolbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 10px;
}
.filter {
  display: flex;
  align-items: center;
  gap: 8px;
}
.filter input {
  padding: 6px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 12px;
}

/* ====== KHUSUS BUTTON HAPUS ====== */
.filter-button.hapus svg path {
  stroke: #ef4444;
}

.filter-button {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  background: #fff;
  border: none;
  border-radius: 8px;
  padding: 7px 10px;
  font-size: 12px;
  cursor: pointer;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  transition: all 0.2s ease;
}
.filter-button:hover, .filter-button:focus {
  border: 1px solid #1e3a8a;
  box-shadow: 0 2px 6px rgba(30,58,138,0.2);
}

/* === Pop-up tanggal kecil === */
.tanggal-popup {
  display: none;
  position: absolute;
  top: 45px;
  left: 0;
  background: #fff;
  border: 1px solid #ccc;
  border-radius: 8px;
  box-shadow: 0 3px 10px rgba(0,0,0,0.15);
  padding: 12px;
  width: 220px;
  z-index: 999;
}
.tanggal-popup h4 {
  margin: 0 0 8px 0;
  font-size: 13px;
  color: #2563eb;
}
.tanggal-inputs {
  display: flex;
  flex-direction: column;
  gap: 6px;
  margin-bottom: 8px;
}
.popup-actions {
  display: flex;
  justify-content: flex-end;
  gap: 6px;
}
.btn-simpan {
  background: #22c55e;
  color: #fff;
  border: none;
  border-radius: 5px;
  padding: 4px 10px;
  cursor: pointer;
}
.btn-batal {
  background: #ef4444;
  color: #fff;
  border: none;
  border-radius: 5px;
  padding: 4px 10px;
  cursor: pointer;
}
</style>

<script>
function toggleTanggalPopup() {
  const popup = document.getElementById('tanggalPopup');
  popup.style.display = popup.style.display === 'block' ? 'none' : 'block';
}

function closeTanggalPopup() {
  document.getElementById('tanggalPopup').style.display = 'none';
}

function simpanTanggal() {
  const mulai = document.getElementById('tanggalMulai').value;
  const akhir = document.getElementById('tanggalAkhir').value;
  if (mulai && akhir) {
    document.getElementById('btnTanggal').innerHTML = `
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
        <path d="M8 7V3M16 7V3M4 11h16M5 5h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2z"
          stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      ${mulai} → ${akhir}`;
  }
  closeTanggalPopup();
}

function hapusFilter(){
  document.getElementById('kode').value = '';
  document.getElementById('btnTanggal').innerHTML = `
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
      <path d="M8 7V3M16 7V3M4 11h16M5 5h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2z"
        stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    Tanggal`;
  closeTanggalPopup();
}
</script>

@endsection