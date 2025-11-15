<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Laba Rugi</title>
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
            border-collapse: collapse;
            background-color: #a7c7d9;
            border-radius: 8px;
            width: 98%;
            margin-left: 10px;
            margin-top: 30px;
        }


        th {
            background-color: #4c4c4c;
            color: white;
            font-size: 12px;
            padding: 6px;
            text-align: center;
            border: 1px solid #ccc;
        }

        td {
            background-color: white;
            font-size: 12px;
            padding: 6px;
            text-align: left;
            border: 1px solid #ccc;
        }

        .header-row {
            font-weight: bold;
        }

        .merged-cell {
            text-align: center;
            font-weight: bold;
        }

        .kop-title {
            text-align: center;
            margin-top: 5px;
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

<h3 class="kop-title">
    Laporan Laba Rugi<br>
    <small>Periode {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }}
        s/d {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}</small>
</h3>


{{-- PINJAMAN --}}
<table>
    <thead>
        <tr>
            <th colspan="2">Ringkasan Pinjaman</th>
        </tr>
        <tr>
            <th>Keterangan</th>
            <th>Nominal</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Total Pinjaman</td>
            <td>{{ number_format($pinjaman->pinjaman_jumlah ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Total Angsuran</td>
            <td>{{ number_format($pinjaman->pinjaman_angsuran ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Pendapatan Pinjaman</strong></td>
            <td>
                <strong>{{ number_format(($pinjaman->pinjaman_angsuran ?? 0) - ($pinjaman->pinjaman_jumlah ?? 0), 0, ',', '.') }}</strong>
            </td>
        </tr>


    </tbody>
</table>



{{-- PENDAPATAN --}}
<table>
    <thead>
        <tr>
            <th colspan="3">Pendapatan</th>
        </tr>
        <tr>
            <th>No</th>
            <th>Nama Akun</th>
            <th>Nominal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pendapatan as $p)
        <tr>
            <td>{{ $loop->iteration }}</td> <!-- otomatis 1,2,3 -->
            <td>{{ $p->keterangan }}</td>
            <td>{{ number_format($p->jumlah, 0, ',', '.') }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="2" class="header-row"><strong>Total Pendapatan</strong></td>
            <td><strong>{{ number_format($totalPendapatan, 0, ',', '.') }}</strong></td>
        </tr>
    </tbody>
</table>

{{-- BIAYA --}}
<table>
    <thead>
        <tr>
            <th colspan="3">Biaya</th>
        </tr>
        <tr>
            <th>No</th>
            <th>Nama Akun</th>
            <th>Nominal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($biaya as $b)
        <tr>
            <td>{{ $loop->iteration }}</td> 
            <td>{{ $b->keterangan }}</td>
            <td>{{ number_format($b->jumlah, 0, ',', '.') }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="2" class="header-row"><strong>Total Biaya</strong></td>
            <td><strong>{{ number_format($totalBiaya, 0, ',', '.') }}</strong></td>
        </tr>
    </tbody>
</table>


<table>
    <thead>
        <tr>
            <th colspan="3">Laba Bersih</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" class="merged-cell">Laba Bersih</td>
            <td class="saldo">{{ number_format($labaBersih, 0, ',', '.') }}</td>
        </tr>
    </tbody>
</table>

</body>
</html>
