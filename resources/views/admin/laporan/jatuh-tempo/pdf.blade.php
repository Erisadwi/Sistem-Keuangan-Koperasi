<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Jatuh Tempo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .header img {
            width: 80px;
            height: auto;
            position: absolute;
            top: 20px;
            left: 50px;
        }
        .kop {
            text-align: center;
        }
        .kop h2 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
        }
        .kop p {
            margin: 0;
            font-size: 11px;
        }
        hr {
            border: 1px solid #000;
            margin-top: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px 4px;
            text-align: center;
        }
        th {
            background-color: #e6f2ff;
        }
        .right {
            text-align: right;
        }
    </style>
</head>
<body>

{{-- HEADER --}}
<div class="header">
    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo.png'))) }}" alt="Logo">
    <div class="kop">
        <h2>KOPERASI TUNAS SEJAHTERA MANDIRI</h2>
        <p>Jl. Karah Agung 45</p>
        <p>Tel. 031-8290002 Email : koperasitsm@gmail.com</p>
        <p>Web : www.koperasitsm.com</p>
    </div>
</div>

<hr>

{{-- PERIODE --}}
<h3 style="text-align:center; margin-top:5px;">
    Laporan Jatuh Tempo Pembayaran Kredit<br>
    <small>Periode {{ $periode }}</small>
</h3>

{{-- TABEL DATA --}}
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Pinjam</th>
            <th>Nama Anggota</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Tempo</th>
            <th>Lama Pinjam</th>
            <th>Jumlah Tagihan</th>
            <th>Dibayar</th>
            <th>Sisa Tagihan</th>
        </tr>
    </thead>

    <tbody>
        @forelse($dataPinjaman as $index => $row)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $row->kode_pinjam }}</td>
            <td>{{ $row->nama_anggota }}</td>
            <td>{{ \Carbon\Carbon::parse($row->tanggal_pinjam)->format('d-m-Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($row->tanggal_tempo)->format('d-m-Y') }}</td>
            <td>{{ $row->lama_pinjam }} bulan</td>
            <td class="right">Rp {{ number_format($row->jumlah_tagihan, 0, ',', '.') }}</td>
            <td class="right">Rp {{ number_format($row->dibayar, 0, ',', '.') }}</td>
            <td class="right">Rp {{ number_format($row->sisa_tagihan, 0, ',', '.') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="9">Belum ada data jatuh tempo.</td>
        </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>
