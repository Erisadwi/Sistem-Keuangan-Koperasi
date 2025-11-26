<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Kas Simpanan</title>
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
            text-align: center;
        }

        .merged-cell {
            text-align: center;
            font-weight: bold;
        }

        .kop-title {
            text-align: center;
            margin-top: 5px;
        }

        .total-row td {
        background-color: none;
        color: #000;
        font-weight: bold;
        text-align: center;   
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
    Laporan Kas Simpanan <br>
    <small>Periode {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }}
        s/d {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}</small>
</h3>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Jenis Akun</th>
            <th>Simpanan</th>
            <th>Penarikan</th>
            <th>Jumlah</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($data as $item)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $item->jenis_akun }}</td>
          <td>{{ number_format($item->simpanan, 0, ',', '.') }}</td>
          <td>{{ number_format($item->penarikan, 0, ',', '.') }}</td>
          <td>{{ number_format($item->jumlah, 0, ',', '.') }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="5">Tidak ada data</td>
        </tr>
        @endforelse

        <tr class="total-row">
          <td colspan="2"><strong>Jumlah Total</strong></td>
          <td><strong>{{ number_format($totalSimpanan, 0, ',', '.') }}</strong></td>
          <td><strong>{{ number_format($totalPenarikan, 0, ',', '.') }}</strong></td>
          <td><strong>{{ number_format($totalJumlah, 0, ',', '.') }}</strong></td>
        </tr>
      </tbody>
</table>

</body>
</html>
