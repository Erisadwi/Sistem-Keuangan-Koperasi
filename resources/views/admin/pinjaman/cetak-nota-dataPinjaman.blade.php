<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bukti Pencairan Dana Kredit</title>

  <style>
    @page {
      size: A5 portrait;
      margin: 10mm;
    }

    body {
      font-family: "Courier New", monospace;
      font-size: 12px;
      color: #000;
      margin: 0;
      padding: 0;
    }

    .nota {
      width: 100%;
      max-width: 580px;
      margin: 0 auto;
      padding: 10px 25px;
      border: 1px solid #000;
      box-sizing: border-box;
    }

    .kop {
      text-align: right;
      margin-bottom: 10px;
      border-bottom: 1px solid #000;
      padding-bottom: 3px;
    }

    .kop img {
      max-height: 55px;
      display: block;
      margin-left: auto;
      margin-bottom: 3px;
      object-fit: contain;
    }

    .kop small {
      font-size: 11px;
    }

    .title {
      text-align: center;
      margin-top: 5px;
      margin-bottom: 5px;
      font-weight: bold;
      text-decoration: underline;
    }

    .ref {
      text-align: center;
      margin-bottom: 10px;
      font-size: 12px;
    }

    .content {
      line-height: 1.4;
    }

    table.detail {
      width: 100%;
      border-collapse: collapse;
      margin-top: 8px;
    }

    .detail td {
      padding: 2px 0;
      vertical-align: top;
    }

    .detail td:first-child {
      width: 36%;
    }

    .detail td:last-child {
      text-align: left;
    }

    .section-total {
      margin-top: 8px;
    }

    .section-total table {
      width: 60%;
    }

    .section-total td {
      padding: 1px 0;
    }

    .section-total td:first-child {
      width: 55%;
    }

    .highlight {
      font-weight: bold;
    }

    .terbilang {
      margin-top: 12px;
      font-weight: bold;
    }

    .tanda-tangan {
    margin-top: 40px;
    font-size: 12px;
    }

    .tanda-tangan .tanggal {
    text-align: right;
    margin-right: 30px;
    margin-bottom: 50px;
    }

    .blok-container {
    display: flex;
    justify-content: space-between;
    text-align: center;
    margin: 0 40px;
    }

    .blok {
    width: 40%;
    }

    .nama {
    display: inline-block;
    border-top: 1px solid #000;
    padding-top: 3px;
    font-weight: bold;
    }

    .footer {
      text-align: center;
      margin-top: 50px;
      font-size: 11px;
      line-height: 1.4;
    }

    .buttons {
      text-align: center;
      margin-top: 30px;
    }

    .buttons button,
    .buttons a {
      background: #007bff;
      color: #fff;
      border: none;
      padding: 5px 10px;
      border-radius: 3px;
      text-decoration: none;
      font-size: 12px;
      margin: 0 3px;
    }

    .buttons a {
      background: #6c757d;
    }

    @media print {
      .buttons { display: none !important; }
      .nota { border: none; padding: 0; }
    }
  </style>
</head>

<body>
  <div class="nota">

    <div class="kop">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Koperasi">
        <h3>KOPERASI TUNAS SEJAHTERA MANDIRI</h3>
        <small>Jl. Karah Agung 45, Surabaya</small>
    </div>

    <div class="title">BUKTI PENCAIRAN DANA KREDIT</div>
    <div class="ref">Ref. {{ now()->format('Ymd_His') }}</div>

    <div class="content">
      Telah terima dari <b>KOPKAR TEMPRINA SEJAHTERA MANDIRI</b><br>
      Pada tanggal {{ \Carbon\Carbon::parse($pinjaman->tanggal_pinjaman)->translatedFormat('d F Y') }} untuk realisasi kredit sebesar
      <b>Rp. {{ number_format($pokok_pinjaman, 0, ',', '.') }}</b>
      ({{ strtoupper(terbilang($pokok_pinjaman)) }} RUPIAH)
      dengan rincian :
    </div>

    <table class="detail">
      <tr><td>Nomor Kontrak</td><td>: {{ $pinjaman->id_pinjaman }}</td></tr>
      <tr><td>Id Anggota</td><td>: {{ $pinjaman->anggota->id_anggota ?? '-' }}</td></tr>
      <tr><td>Nama Anggota</td><td>: {{ strtoupper($pinjaman->anggota->nama_anggota ?? '-') }}</td></tr>
      <tr><td>Dept</td><td>: -</td></tr>
      <tr><td>Alamat</td><td>: {{ $pinjaman->anggota->alamat_anggota ?? '-' }}</td></tr>
      <tr><td>Tanggal Pinjam</td><td>: {{ \Carbon\Carbon::parse($pinjaman->tanggal_pinjaman)->translatedFormat('d F Y') }}</td></tr>
      <tr><td>Tanggal Tempo</td><td>: {{ \Carbon\Carbon::parse($pinjaman->tanggal_pinjaman)->addMonths($pinjaman->lamaAngsuran->lama_angsuran)->translatedFormat('d F Y') }}</td></tr>
      <tr><td>Lama Pinjam</td><td>: {{ $pinjaman->lamaAngsuran->lama_angsuran ?? '-' }} Bulan</td></tr>
    </table>

    <div class="section-total">
      <table>
        <tr><td>Total Pinjaman</td><td>: Rp. {{ number_format($pokok_pinjaman + ($angsuran_bunga * ($pinjaman->lamaAngsuran->lama_angsuran ?? 0)), 0, ',', '.') }}</td></tr>
        <tr><td>Pokok Pinjaman</td><td>: Rp. {{ number_format($pokok_pinjaman, 0, ',', '.') }}</td></tr>
        <tr><td>Angsuran Pokok</td><td>: Rp. {{ number_format($angsuran_pokok, 0, ',', '.') }}</td></tr>
        <tr><td>Biaya Admin</td><td>: Rp. {{ number_format($pinjaman->biaya_admin ?? 0, 0, ',', '.') }}</td></tr>
        <tr><td>Angsuran Bunga</td><td>: Rp. {{ number_format($angsuran_bunga, 0, ',', '.') }}</td></tr>
        <tr class="highlight"><td>Jumlah Angsuran</td><td>: Rp. {{ number_format($jumlah_angsuran, 0, ',', '.') }}</td></tr>
      </table>
    </div>

    <div class="terbilang">
      TERBILANG : {{ strtoupper(terbilang($jumlah_angsuran)) }} RUPIAH
    </div>

        <div class="tanda-tangan">
    <div class="tanggal">
        Surabaya, {{ \Carbon\Carbon::parse($pinjaman->tanggal_pinjaman)->translatedFormat('d F Y') }}
    </div>

    <div class="blok-container">
        <div class="blok">
        <br><br><br><br>
        <span class="nama">IRMA</span>
        </div>

        <div class="blok">
        <br><br><br><br>
        <span class="nama">A. FERY ARDIANSAH</span>
        </div>
    </div>
    </div>

    <div class="footer">
      <p>** Tanda terima ini sah jika telah dibubuhi cap dan tanda tangan oleh Admin **</p>
    </div>

    <div class="buttons">
      <button onclick="window.print()">Cetak</button>
      <a href="{{ route('pinjaman.index') }}">Kembali</a>
    </div>
  </div>
</body>
</html>

@php
// Fungsi bantu ubah angka ke terbilang
function terbilang($angka) {
    $angka = abs($angka);
    $baca = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
    $temp = "";

    if ($angka < 12) {
        $temp = " " . $baca[$angka];
    } else if ($angka < 20) {
        $temp = terbilang($angka - 10) . " Belas";
    } else if ($angka < 100) {
        $temp = terbilang($angka / 10) . " Puluh" . terbilang($angka % 10);
    } else if ($angka < 200) {
        $temp = " Seratus" . terbilang($angka - 100);
    } else if ($angka < 1000) {
        $temp = terbilang($angka / 100) . " Ratus" . terbilang($angka % 100);
    } else if ($angka < 2000) {
        $temp = " Seribu" . terbilang($angka - 1000);
    } else if ($angka < 1000000) {
        $temp = terbilang($angka / 1000) . " Ribu" . terbilang($angka % 1000);
    } else if ($angka < 1000000000) {
        $temp = terbilang($angka / 1000000) . " Juta" . terbilang($angka % 1000000);
    }

    return trim($temp);
}
@endphp
