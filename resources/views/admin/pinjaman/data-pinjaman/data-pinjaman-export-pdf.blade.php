<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Data Pinjaman</title>
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
    Laporan Data Pinjaman<br>
    <small>Periode {{ $start }} - {{ $end }}</small>
</h3>

<table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Tanggal Pinjam</th>
                <th>Nama Anggota</th>
                <th>Hitungan</th>
                <th>Total Tagihan</th>
                <th>Keterangan</th>
                <th>Lunas</th>
                <th>User</th>
            </tr>
        </thead>

        <tbody>
            @php $no = 1; @endphp
            @foreach($data as $row)
            <tr>
                <td class="text-center">{{ $no++ }}</td>

                <td class="text-center">{{ $row->id_pinjaman }}</td>

                <td class="text-center">
                    {{ \Carbon\Carbon::parse($row->tanggal_pinjaman)->format('d-m-Y') }}
                </td>

                <td>{{ $row->anggota->nama_anggota ?? '-' }}</td>

                <td>
                    <div class="row-sub">
                        <span class="subcell-title">Jumlah Pinjaman:</span>
                        <span class="subcell-value">Rp {{ number_format($row->jumlah_pinjaman) }}</span>
                    </div>

                    <div class="row-sub">
                        <span class="subcell-title">Lama Angsuran:</span>
                        <span class="subcell-value">{{ $row->lama_angsuran_text }} Bulan</span>
                    </div>

                    <div class="row-sub">
                        <span class="subcell-title">Pokok Angsuran:</span>
                        <span class="subcell-value">Rp {{ number_format($row->pokok_angsuran) }}</span>
                    </div>

                    <div class="row-sub">
                        <span class="subcell-title">Bunga Pinjaman:</span>
                        <span class="subcell-value">{{ number_format($row->bunga_pinjaman) }}</span>
                    </div>

                    <div class="row-sub">
                        <span class="subcell-title">Biaya Admin:</span>
                        <span class="subcell-value">Rp {{ number_format($row->biaya_admin) }}</span>
                    </div>
                </td>

                <td>
                    <div class="row-sub">
                        <span class="subcell-title">Jumlah Angsuran:</span>
                        <span class="subcell-value">Rp {{ number_format($row->jumlah_angsuran_otomatis) }}</span>
                    </div>

                    <div class="row-sub">
                        <span class="subcell-title">Jumlah Denda:</span>
                        <span class="subcell-value">Rp {{ number_format($row->jumlah_denda) }}</span>
                    </div>

                    <div class="row-sub">
                        <span class="subcell-title">Total Tagihan:</span>
                        <span class="subcell-value">Rp {{ number_format($row->total_tagihan) }}</span>
                    </div>

                    <div class="row-sub">
                        <span class="subcell-title">Sudah Dibayar:</span>
                        <span class="subcell-value">Rp {{ number_format($row->sudah_dibayar) }}</span>
                    </div>

                    <div class="row-sub">
                        <span class="subcell-title">Sisa Angsuran:</span>
                        <span class="subcell-value">{{ $row->sisa_angsuran ?? '-' }}</span>
                    </div>

                    <div class="row-sub">
                        <span class="subcell-title">Sisa Tagihan:</span>
                        <span class="subcell-value">Rp {{ number_format($row->sisa_tagihan) }}</span>
                    </div>
                </td>

                <td class="text-center">{{ $row->keterangan ?? '-' }}</td>

                <td class="text-center">
                    {{ $row->status_lunas ?? '' }}
                </td>

                <td>{{ $row->user->nama_lengkap ?? '' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>