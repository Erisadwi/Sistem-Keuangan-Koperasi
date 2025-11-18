<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Ajuan Pinjaman</title>
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
        ul {
            margin: 0;
            padding-left: 12px;
            text-align: left;
        }
        .right {
            text-align: right;
        }
    </style>
</head>
<body>

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

@php
    $start = \Carbon\Carbon::parse($periodStart)->translatedFormat('d F Y');
    $end   = \Carbon\Carbon::parse($periodEnd)->translatedFormat('d F Y');
@endphp

<h3 style="text-align:center; margin-top:5px;">
    Laporan Ajuan Pinjaman<br>
    <small>Periode {{ $start }} - {{ $end }}</small>
</h3>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Ajuan</th>
            <th>Nama Anggota</th>
            <th>Jenis Ajuan</th>
            <th>Jumlah Ajuan</th>
            <th>Lama Angsuran</th>
            <th>Tanggal Pengajuan</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
    @forelse($data as $i => $row)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $row->id_ajuanPinjaman }}</td>
            <td>{{ $row->anggota->nama_anggota ?? '-' }}</td>
            <td>{{ $row->jenis_ajuan }}</td>
            <td class="right">Rp{{ number_format($row->jumlah_ajuan, 0, ',', '.') }}</td>
            <td>{{ $row->lama_angsuran->lama_angsuran ?? '-' }} bulan</td>
            <td>{{ \Carbon\Carbon::parse($row->tanggal_pengajuan)->format('d-m-Y') }}</td>
            <td>{{ $row->status_ajuan }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="7"><em>Tidak ada data pengajuan</em></td>
        </tr>
    @endforelse
    </tbody>
</table>

</body>
</html>
