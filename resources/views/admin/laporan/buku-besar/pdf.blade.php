<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Buku Besar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
            position: relative;
        }
        .header img {
            width: 80px;
            position: absolute;
            left: 40px;
            top: 10px;
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
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px 4px;
            text-align: center;
        }
        th {
            background-color: #e6f2ff;
        }
        .right {
            text-align: right;
        }
        .section-title {
            font-weight: bold;
            margin-top: 15px;
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
    Laporan Buku Besar<br>
    <small>Periode {{ date('F Y', strtotime($periode . '-01')) }}</small>
</h3>

{{-- ISI TABEL PER AKUN --}}
@foreach ($akunTransaksi as $i => $akun)

<p class="section-title">{{ $i + 1 }}. {{ $akun->nama_AkunTransaksi }}</p>

{{-- SALDO AWAL --}}
@php
$saldoAwal = $akun->saldoAwal->sum('debit') - $akun->saldoAwal->sum('kredit');
@endphp

<table>
    <tr>
        <th style="text-align:left;">Saldo Awal</th>
        <td class="right">{{ number_format($saldoAwal, 0, ',', '.') }}</td>
    </tr>
</table>

{{-- TABEL TRANSAKSI --}}
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Jenis Transaksi</th>
            <th>Debet</th>
            <th>Kredit</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($akun->bukuBesar as $index => $bb)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ date('d M Y', strtotime($bb->tanggal_transaksi)) }}</td>
            <td>{{ $bb->akunBerkaitan->nama_AkunTransaksi ?? '-' }}</td>
            <td class="right">{{ number_format($bb->debit, 0, ',', '.') }}</td>
            <td class="right">{{ number_format($bb->kredit, 0, ',', '.') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="5">Tidak ada transaksi</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{-- SALDO TOTAL --}}
@php
$totalDebit = $akun->bukuBesarTotal->sum('debit');
$totalKredit = $akun->bukuBesarTotal->sum('kredit');
@endphp

<table>
    <tr>
        <th style="text-align:left;">Total Debet</th>
        <td class="right">{{ number_format($totalDebit, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th style="text-align:left;">Total Kredit</th>
        <td class="right">{{ number_format($totalKredit, 0, ',', '.') }}</td>
    </tr>
</table>

{{-- SALDO KUMULATIF --}}
<table>
    <tr>
        <th style="text-align:left;">Saldo Kumulatif</th>
        <td class="right">{{ number_format($akun->saldo_kumulatif, 0, ',', '.') }}</td>
    </tr>
</table>

@endforeach

</body>
</html>
