<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bukti Pelunasan Pinjaman</title>

  <style>
    @page {
      size: A5 portrait;
      margin: 8mm;
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
      max-width: 540px;
      margin: 0 auto;
      padding: 10px 20px;
      border: 1px solid #000;
      box-sizing: border-box;
      page-break-inside: avoid;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 10px;
      border-bottom: 1px solid #000;
      padding-bottom: 5px;
    }

    .kop-kiri h3, .kop-kanan h3 {
      margin: 0;
      font-size: 13px;
      font-weight: bold;
    }

    .kop-kanan {
      text-align: right;
    }

    .kop-kanan img {
      max-height: 55px;
      display: block;
      margin-left: auto;
      margin-bottom: 3px;
      object-fit: contain;
    }

    .info {
      display: flex;
      justify-content: space-between;
      margin-top: 10px;
    }

    .kiri, .kanan {
      width: 48%;
    }

    .info table {
      width: 100%;
    }

    .info td {
      padding: 2px 0;
      vertical-align: top;
    }

    .info td:first-child {
      width: 40%;
    }

    /* Paraf adjustment */
    .paraf {
      text-align: center;
      padding-top: 30px;
    }

    .paraf .garis {
      margin-top: 50px; 
      display: inline-block;
      border-top: 1px solid #000;
      width: 80%;
    }

    .footer {
      margin-top: 15px;
      text-align: center;
      font-size: 11px;
      border-top: 1px dashed #000;
      padding-top: 5px;
      line-height: 1.4;
    }

    .footer small {
      display: block;
      margin-top: 3px;
    }

    .buttons {
      text-align: center;
      margin-top: 10px;
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
    }

    .buttons a {
      background: #6c757d;
    }

    .info table {
  width: 100%;
  border-collapse: collapse;
}

.info td {
  padding: 2px 0;
  vertical-align: top;
  font-size: 12px;
}

.info td:first-child {
  width: 45%;
  white-space: nowrap;
}

.info td:nth-child(2) {
  width: 55%;
}

.right {
  float: right;
  text-align: right;
  display: inline-block;
  min-width: 100px;
}


    @media print {
      .buttons { display: none !important; }
      .nota { border: none; padding: 0; }
    }
  </style>
</head>

<body>
  <div class="nota">
    <div class="header">
      <div class="kop-kiri">
        <h3>BUKTI PELUNASAN PINJAMAN</h3>
      </div>
      <div class="kop-kanan">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Koperasi">
        <h3>KOPERASI TUNAS SEJAHTERA MANDIRI</h3>
        <small>Jl. Karah Agung 45, Surabaya</small>
      </div>
    </div>

    <div class="info">
      <div class="kiri">
       <table>
  <tr><td>Nomor Pinjaman</td><td>: {{ $pinjaman->id_pinjaman ?? '-' }}</td></tr>
  <tr><td>Tanggal Pinjam</td><td>: {{ $pinjaman->tanggal_pinjaman ? \Carbon\Carbon::parse($pinjaman->tanggal_pinjaman)->format('Y-m-d') : '-' }}</td></tr>
  <tr><td>Tanggal Tempo</td><td>: {{ $view->tanggal_jatuh_tempo ?? '-' }}</td></tr>
  <tr><td>Lama Pinjaman</td><td>: {{ $view->lama_angsuran ?? '-' }}</td></tr>
  <tr><td>Pokok Pinjaman</td><td>: <span class="right">Rp. {{ number_format($pinjaman->jumlah_pinjaman ?? 0, 0, ',', '.') }}</span></td></tr>
  <tr><td>Total Bayar</td><td>: <span class="right">Rp. {{ number_format($totalBayar ?? 0, 0, ',', '.') }}</span></td></tr>
  <tr><td>Denda</td><td>: <span class="right">Rp. {{ number_format($totalDenda ?? 0, 0, ',', '.') }}</span></td></tr>
  <tr><td>Total Tagihan</td><td>: <span class="right">Rp. {{ number_format($totalBayar ?? 0, 0, ',', '.') }}</span></td></tr>
  <tr><td>Sisa Tagihan</td><td>: <span class="right">Rp. {{ number_format($sisaTagihan ?? 0, 0, ',', '.') }}</span></td></tr>
  <tr><td>Status Pelunasan</td><td>: <span class="right">{{ strtoupper($statusPelunasan) }}</span></td></tr>
</table>


      </div>

      <div class="kanan">
        <table>
          <tr><td>Tanggal Cetak</td><td>: {{ \Carbon\Carbon::now()->format('d F Y / H:i') }}</td></tr>
          <tr>
            <td>User Akun</td>
            <td>:
              @if(Auth::check())
                {{ Auth::user()->nama_lengkap ?? Auth::user()->name }}
              @else
                -
              @endif
            </td>
          </tr>
          <tr><td>Status</td><td>: SUKSES</td></tr>
        </table>

        <div class="paraf">
          <div>Paraf,</div>
          <div class="garis"></div>
        </div>
      </div>
    </div>

    <div class="footer">
      <p>Ref: {{ now()->format('YmdHis') }}</p>
      <small>Informasi hubungi Call Center: 031-8290002<br>atau kunjungi: www.koperasitsm.com</small>
      <p><b>** Tanda terima ini sah jika telah dibubuhi cap dan tanda tangan Admin **</b></p>
    </div>

    <div class="buttons">
      <button onclick="window.print()">Cetak</button>
      <a href="{{ route('detail.pelunasan', ['kode_transaksi' => $view->kode_transaksi]) }}">Kembali</a>
    </div>
  </div>
</body>
</html>
