<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cetak Nota Setoran Tunai</title>

  <style>
    @page {
      size: A5 portrait;
      margin: 8mm; 
    }

    body {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 12px;
      color: #000;
      margin: 0;
      padding: 0;
      background: #fff;
    }

    .nota {
      width: 100%;
      max-width: 540px; 
      margin: 0 auto;
      padding: 15px 20px;
      border: 1px solid #000;
      border-radius: 5px;
      box-sizing: border-box;
      page-break-inside: avoid;
    }

    .header {
      text-align: center;
      border-bottom: 1px solid #000;
      margin-bottom: 10px;
      padding-bottom: 5px;
    }

    .header h2 {
      margin: 0;
      font-size: 16px;
      text-transform: uppercase;
    }

    .header small {
      font-size: 11px;
      color: #555;
    }

    .info {
      margin-bottom: 15px;
    }

    .info table {
      width: 100%;
      border-collapse: collapse;
    }

    .info td {
      padding: 3px 0;
      vertical-align: top;
      line-height: 1.4;
    }

    .info td:first-child {
      width: 35%;
      font-weight: bold;
    }

    .total {
      text-align: right;
      font-size: 14px;
      font-weight: bold;
      margin-top: 10px;
    }

    .footer {
      margin-top: 25px;
      text-align: center;
      font-size: 11px;
      border-top: 1px dashed #000;
      padding-top: 5px;
      line-height: 1.4;
    }

    .buttons {
      margin-top: 15px;
      text-align: center;
    }

    .buttons button,
    .buttons a {
      background: #007bff;
      color: #fff;
      border: none;
      padding: 6px 12px;
      border-radius: 4px;
      text-decoration: none;
      font-size: 12px;
      cursor: pointer;
    }

    .buttons a {
      background: #6c757d;
    }

    @media print {
      body {
        background: #fff !important;
        margin: 0 !important;
      }

      .nota {
        border: none; 
        box-shadow: none;
        width: 100%;
        max-width: none;
        padding: 10mm;
      }

      .buttons {
        display: none !important;
      }

      html, body {
        height: auto;
        overflow: visible;
      }
    }
  </style>
</head>

<body>
  <div class="nota">
    <div class="header">
      <h2>KOPERASI TUNAS SEJAHTERA MANDIRI</h2>
      <small>Jl. Karah Agung 45, Surabaya | Telp: 031-8290002</small>
      <h3 style="margin-top:10px;">BUKTI SETORAN TUNAI</h3>
    </div>

    <div class="info">
      <table>
        <tr>
          <td>Kode Transaksi</td>
          <td>: {{ $setoran->kode_simpanan ?? '-' }}</td>
        </tr>
        <tr>
          <td>Tanggal</td>
          <td>: {{ \Carbon\Carbon::parse($setoran->tanggal_transaksi)->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
          <td>Nama Anggota</td>
          <td>: {{ $setoran->anggota->nama_anggota ?? '-' }}</td>
        </tr>
        <tr>
          <td>Jenis Simpanan</td>
          <td>: {{ $setoran->jenisSimpanan->jenis_simpanan ?? '-' }}</td>
        </tr>
        <tr>
          <td>Kas Tujuan</td>
          <td>: {{ $setoran->tujuan->nama_AkunTransaksi ?? '-' }}</td>
        </tr>
        <tr>
          <td>Keterangan</td>
          <td>: {{ $setoran->keterangan ?? '-' }}</td>
        </tr>
      </table>
    </div>

    <div class="total">
      Jumlah Setoran: Rp {{ number_format($setoran->jumlah_simpanan, 0, ',', '.') }}
    </div>

    <div class="footer">
      <p>Terima kasih telah melakukan setoran simpanan di Koperasi Tunas Sejahtera Mandiri</p>
      <p><i>Disetujui oleh,</i></p>
      <br><br>
      <p><b>{{ $setoran->data_user->nama_lengkap ?? 'Petugas Koperasi' }}</b></p>
    </div>

    <div class="buttons">
      <button onclick="window.print()">Cetak</button>
      <a href="{{ route('setoran-tunai.index') }}">Kembali</a>
    </div>
  </div>
</body>
</html>
