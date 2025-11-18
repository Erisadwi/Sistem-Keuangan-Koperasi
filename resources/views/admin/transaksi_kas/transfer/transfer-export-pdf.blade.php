<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi Kas Transfer</title>
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
        ul {
            margin: 0;
            padding-left: 12px;
            text-align: left;
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
    Laporan Transaksi Kas Transfer<br>
    <small>Periode {{ $start }} - {{ $end }}</small>
</h3>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Transaksi</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Jumlah</th>
            <th>Dari Kas</th>
            <th>Untuk Kas</th>
            <th>User</th>
        </tr>
    </thead>
    <tbody>

    @forelse($data as $row)
        @php
            $akunTujuan = $row->details->firstWhere('debit', '>', 0)?->akun;
            $akunSumberList = $row->details->where('kredit', '>', 0);
            $jumlah = $row->total_debit ?? 0;
        @endphp
        
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $row->kode_transaksi }}</td>
            <td>{{ \Carbon\Carbon::parse($row->tanggal_transaksi)->format('d-m-Y') }}</td>
            <td>{{ $row->ket_transaksi ?? '-' }}</td>

            <td>{{ $akunTujuan->nama_AkunTransaksi ?? '-' }}</td>

            <td>
                <ul>
                    @foreach($akunSumberList as $s)
                        <li>{{ $s->akun->nama_AkunTransaksi ?? '-' }}</li>
                    @endforeach
                </ul>
            </td>

            <td class="right">{{ number_format($jumlah, 0, ',', '.') }}</td>
            <td>{{ $row->data_user->nama_lengkap ?? '-' }}</td>
        </tr>

    @empty
        <tr>
            <td colspan="7" align="center"><em>Tidak ada data transaksi</em></td>
        </tr>
    @endforelse

    </tbody>
</table>

</body>
</html>
