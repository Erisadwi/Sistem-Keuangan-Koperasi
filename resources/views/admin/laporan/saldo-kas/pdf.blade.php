<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Saldo Kas</title>
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

        th, td {
            font-size: 12px;
            padding: 6px;
            text-align: center;
            border: 1px solid #ccc;
        }

        th {
            background-color: #4c4c4c;
            color: white;
        }

        td {
            background-color: white;
        }

        .header-row {
            font-weight: bold;
        }

        th:first-child, td:first-child {
            width: 50px;
        }

        .saldo {
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
        Laporan Saldo Kas<br>
        <small>Periode {{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y') }}</small>
    </h3>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Kas</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="2" class="merged-cell">Saldo Periode Sebelumnya</td>
                <td class="saldo">{{ number_format($saldo_periode_sebelumnya ?? 0, 0, ',', '.') }}</td>
            </tr>

            @foreach($data as $index => $kas)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $kas->nama_kas }}</td>
                    <td class="saldo">{{ number_format($kas->total_saldo ?? 0, 0, ',', '.') }}</td>
                </tr>
            @endforeach

            <tr>
                <td colspan="2" class="header-row">Jumlah</td>
                <td class="saldo">{{ number_format($jumlah_kas ?? 0, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

</body>
</html>
