<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Setoran Tunai</title>
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

   <div class="header">
    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo.png'))) }}" alt="Logo">
    <div class="kop">
        <h2>KOPKAR TUNAS SEJAHTERA MANDIRI</h2>
        <p>Jl. Karah Agung 45</p>
        <p>Tel. 031-8290002 Email : koperasitsm@gmail.com</p>
        <p>Web : www.koperasitsm.com</p>
    </div>
</div>

<hr>

@php
    $start = $data->min('tanggal_transaksi') ? \Carbon\Carbon::parse($data->min('tanggal_transaksi'))->translatedFormat('d F Y') : '-';
    $end = $data->max('tanggal_transaksi') ? \Carbon\Carbon::parse($data->max('tanggal_transaksi'))->translatedFormat('d F Y') : '-';
@endphp

<h3 style="text-align:center; margin-top:5px;">
    Laporan Data Setoran Tunai<br>
    <small>Periode {{ $start }} - {{ $end }}</small>
</h3>


    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Transaksi</th>
                <th>Tanggal</th>
                <th>ID Anggota</th>
                <th>Nama Anggota</th>
                <th>Jenis Simpanan</th>
                <th>Jumlah</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->kode_simpanan }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d-m-Y') }}</td>
                    <td>{{ $item->anggota->id_anggota ?? '-' }}</td>
                    <td>{{ $item->anggota->nama_anggota ?? '-' }}</td>
                    <td>{{ $item->jenisSimpanan->jenis_simpanan ?? '-' }}</td>
                    <td class="right">{{ number_format($item->jumlah_simpanan, 0, ',', '.') }}</td>
                    <td>{{ $item->user->nama_lengkap ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Tidak ada data setoran tunai.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
