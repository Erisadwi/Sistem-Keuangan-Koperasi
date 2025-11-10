@extends('layouts.coba')

@section('title', 'Data Pinjaman')
@section('title-1', 'Pinjaman')
@section('sub-title', 'Detail Peminjam')

@section('content')

@php
    $anggota = $anggota ?? null;
    $pinjaman = $pinjaman ?? null;
    $payments = $payments ?? collect();
    $bayar_angsuran = $bayar_angsuran ?? collect(); 
    $sisaAngsuran = $sisaAngsuran ?? 0;
    $totalBayar = $totalBayar ?? 0;
    $denda = $denda ?? 0;
    $sisaTagihan = $sisaTagihan ?? 0;
    $status = $status ?? '-';
@endphp

<div class="content-wrapper">
  <h2 class="page-title">
    <a href="{{ route('pinjaman.index') }}" class="breadcrumb-link">Data Pinjaman</a>
    &nbsp; &gt; &nbsp;
    <span>Detail Pinjaman</span>
  </h2>

  <div class="card-biru">
    <div class="card-header">
      <h3>Detail Pinjaman</h3>
    </div>

        {{-- CARD PUTIH --}}
        <div class="card-putih">
            <div class="data-anggota">
                @php
                $fotoPath = (!empty($pinjaman) && $pinjaman->anggota && !empty($pinjaman->anggota->foto))
                        ? asset(''.$pinjaman->anggota->foto)
                        : asset('images/default.jpeg');
                @endphp
                <img src="{{ $fotoPath }}" alt="Foto Anggota" class="foto-anggota">

                <div class="info">
                    <div class="left">
                        <h4>Data Anggota</h4>
                        <p>ID Anggota: <span>{{ $anggota->id_anggota ?? '-' }}</span></p>
                        <p>Nama Anggota: <span>{{ $anggota->nama_anggota ?? '-' }}</span></p>
                        <p>Departemen: <span>{{ $anggota->departemen ?? '-' }}</span></p>
                        <p>Tempat, Tanggal Lahir: 
                            <span>
                                @if(!empty($anggota->tempat_lahir) || !empty($anggota->tanggal_lahir))
                                    {{ $anggota->tempat_lahir ?? '-' }}, {{ $anggota->tanggal_lahir ?? '-' }}
                                @else
                                    -
                                @endif
                            </span>
                        </p>
                        <p>Kota Tinggal: <span>{{ $anggota->kota_anggota ?? '-' }}</span></p>
                    </div>


                    <div class="right">
                        <h4>Data Pinjaman</h4>
                        <p>Kode Pinjam: <span>{{ $pinjaman->id_pinjaman ?? '-' }}</span></p>
                        <p>Tanggal Pinjam: <span>{{ $pinjaman->tanggal_pinjaman?? '-' }}</span></p>
                        <p>Tanggal Tempo: <span>{{ $tanggalTempo ?? '-' }}</span></p>
                        <p>Lama Pinjaman: <span>{{ $pinjaman->lamaAngsuran->lama_angsuran ?? '-' }}</span></p>
                    </div>
                    <div class="center">
                        <p>Pokok Pinjaman: <span>{{ number_format($pinjaman->jumlah_pinjaman ?? 0, 0, ',', '.') }}</span></p>
                       <p>Angsuran Pokok: <span>{{ number_format($pinjaman->jumlah_pinjaman / ($pinjaman->lamaAngsuran->lama_angsuran ?? 1), 0, ',', '.') }}</span></p>
                        <p>Biaya & Bunga: <span>{{ number_format($pinjaman->bunga_pinjaman ?? 0, 0, ',', '.') }}</span></p>
                        <p>Jumlah Angsuran: <span>{{ number_format($pinjaman->total_tagihan / ($pinjaman->lamaAngsuran->lama_angsuran ?? 1), 0, ',', '.') }}</span></p>
                    </div>
                </div>
            </div>
        </div>

        {{-- INFO BIRU BAWAH --}}
        <div class="info-biru-bawah">
          <span>Detail Pembayaran &raquo;</span>
          <span>Sisa Angsuran: 
              <b>{{ $pinjaman->sisa_angsuran ?? 0 }}</b>
          </span>
          <span>Dibayar: 
              <b>{{ 'Rp. ' . number_format($pinjaman->sudah_dibayar ?? 0, 0, ',', '.') }}</b>
          </span>
          <span>Denda: 
              <b>{{ 'Rp. ' . number_format($pinjaman->denda ?? 0, 0, ',', '.') }}</b>
          </span>
          <span>Sisa Tagihan: 
              <b>{{ 'Rp. ' . number_format($pinjaman->sisa_tagihan ?? 0, 0, ',', '.') }}</b>
          </span>
          <span>Status Pelunasan: 
              <b class="status-lunas">{{ $pinjaman->status ?? '-' }}</b>
          </span>
      </div>

    {{-- SECTION SIMULASI TAGIHAN --}}
    <div class="section-detail-pinjaman">
      <h4 class="section-title">Simulasi Tagihan :</h4>

      <div class="table-wrapper">
        <table class="tabel-detail-pinjaman">
          <thead>
            <tr>
              <th>Bulan Ke-</th>
              <th>Angsuran Pokok</th>
              <th>Angsuran Bunga</th>
              <th>Biaya Admin</th>
              <th>Jumlah Angsuran</th>
              <th>Tanggal Tempo</th>
            </tr>
          </thead>
          <tbody>
            @forelse($payments as $pay)
              <tr>
                <td>{{ $pay->bulan_ke ?? '-' }}</td>
                <td>{{ number_format($pay->angsuran_pokok ?? 0, 0, ',', '.') }}</td>
                <td>{{ number_format($pay->angsuran_bunga ?? 0, 0, ',', '.') }}</td>
                <td>{{ number_format($pay->biaya_admin ?? 0, 0, ',', '.') }}</td>
                <td>{{ number_format($pay->jumlah_angsuran ?? 0, 0, ',', '.') }}</td>
                <td>{{ $pay->tanggal_tempo ?? '-' }}</td>
              </tr>
            @empty
              <tr><td colspan="6" class="no-data">Belum ada data</td></tr>
            @endforelse

            @if($payments->count() > 0)
              <tr style="background-color:#dfe9f3; font-weight:bold;">
                <td>Jumlah</td>
                <td>{{ number_format($payments->sum('angsuran_pokok'), 0, ',', '.') }}</td>
                <td>{{ number_format($payments->sum('angsuran_bunga'), 0, ',', '.') }}</td>
                <td>{{ number_format($payments->sum('biaya_admin'), 0, ',', '.') }}</td>
                <td>{{ number_format($payments->sum('jumlah_angsuran'), 0, ',', '.') }}</td>
                <td>-</td>
              </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>

    {{-- TABEL DETAIL PEMBAYARAN ANGSURAN --}}
    <div class="section-detail-pinjaman">
      <h4 class="section-title">Detail Pembayaran Angsuran :</h4>

      <div class="table-wrapper">
        <table class="tabel-detail-pinjaman">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode Bayar</th>
              <th>Tanggal Bayar</th>
              <th>Angsuran Ke-</th>
              <th>Jenis Pembayaran</th>
              <th>Jumlah Bayar</th>
              <th>Pembayaran Pokok</th>
              <th>Pendapatan</th>
              <th>Denda</th>
              <th>User</th>
            </tr>
          </thead>
          <tbody>
            @forelse($bayar_angsuran as $i => $trx)
              <tr>
                <td>{{ $i + 1 }}</td>
                 <td>{{ $trx->id_bayar_angsuran }}</td>
                <td>{{ $trx->tanggal_bayar ?? '-' }}</td>
                <td>{{ $trx->angsuran_ke ?? '-' }}</td>
                <td>{{ $trx->jenis_pembayaran ?? '-' }}</td>
                <td>{{ number_format($trx->jumlah_bayar ?? 0, 0, ',', '.') }}</td>
                <td>{{ number_format($trx->pembayaran_pokok ?? 0, 0, ',', '.') }}</td>
                <td>{{ number_format($trx->pendapatan ?? 0, 0, ',', '.') }}</td>
                <td>{{ number_format($trx->denda ?? 0, 0, ',', '.') }}</td>
                <td>{{ $trx->user ?? '-' }}</td>
              </tr>
            @empty
              <tr><td colspan="10" class="no-data">Belum ada transaksi pembayaran</td></tr>
            @endforelse

            @if($bayar_angsuran->count() > 0)
              <tr style="background-color:#dfe9f3; font-weight:bold;">
                <td colspan="5">Jumlah</td>
                <td>{{ number_format($bayar_angsuran->sum('jumlah_bayar'), 0, ',', '.') }}</td>
                <td>{{ number_format($bayar_angsuran->sum('pembayaran_pokok'), 0, ',', '.') }}</td>
                <td>{{ number_format($bayar_angsuran->sum('pendapatan'), 0, ',', '.') }}</td>
                <td>{{ number_format($bayar_angsuran->sum('denda'), 0, ',', '.') }}</td>
                <td>-</td>
              </tr>
            @endif
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

.section-detail-pinjaman {
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
.tabel-detail-pinjaman {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    box-shadow: 0 1px 2px rgba(0,0,0,0.03);
}
.tabel-detail-pinjaman th {
    background: #4a4a4a;
    color: #fff;
    padding: 10px;
    text-align: center;
    font-weight: 600;
    font-size: 13px;

}
.tabel-detail-pinjaman td {
    border: 1px solid #d6d6d6;
    padding: 10px;
    text-align: center;
    font-size: 13px;
}
.tabel-detail-pinjaman tr:nth-child(even) td {
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
</style>

@endsection
