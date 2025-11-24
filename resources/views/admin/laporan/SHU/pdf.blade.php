<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan SHU Anggota</title>
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

        .label {
            text-align: left !important;
            display: inline-block;
            width: 140px; 
        }

        .value {
            text-align: right !important;
            display: inline-block;
            width: 140px; 
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
        Laporan SHU Anggota<br>
        <small>Periode {{ $periodeText ?? '-' }}</small>
    </h3>

    <table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Identitas Anggota</th>
            <th>Jasa Usaha</th>
            <th>Modal Usaha</th>
        </tr>
    </thead>
    <tbody>
        @foreach($anggota as $index => $a)
        <tr>

            <td>{{ $index + 1 }}</td>

        <td style="text-align:left;">
            <span class="label">ID:</span>
            <span class="value">{{ $a->id_anggota }}</span><br>

            <span class="label">Nama:</span>
            <span class="value">{{ $a->nama_anggota }}</span><br>

            <span class="label" style="vertical-align: top;">Alamat:</span>
            <span class="value" style="white-space: normal; display:inline-block; width:140px; text-align:right;">
                {{ $a->alamat_anggota }}
            </span><br>

            <span class="label">No HP:</span>
            <span class="value">{{ $a->no_telepon }}</span>
        </td>


        <td style="text-align:left;">
            <span class="label">Laba Anggota:</span>
            <span class="value">{{ number_format($a->bunga_anggota, 2, ',', '.') }}</span><br>

            <span class="label">Total Laba:</span>
            <span class="value">{{ number_format($a->total_bunga, 2, ',', '.') }}</span><br>

            <span class="label">Jasa Usaha:</span>
            <span class="value">{{ number_format($total_shu_jasa_usaha, 2, ',', '.') }}</span><br>

            <span class="label">SHU Jasa Anggota:</span>
            <span class="value">
                {{ number_format($a->shu_jasa_usaha, 2, ',', '.') }}
            </span>
        </td>

        <td style="text-align:left;">
            <span class="label">Simpanan Anggota:</span>
            <span class="value">{{ number_format($a->simpanan_anggota, 2, ',', '.') }}</span><br>

            <span class="label">Total Simpanan:</span>
            <span class="value">{{ number_format($a->total_simpanan, 2, ',', '.') }}</span><br>

            <span class="label">Jasa Simpanan:</span>
            <span class="value">{{ number_format($total_shu_jasa_modal, 2, ',', '.') }}</span><br>

            <span class="label">SHU Jasa Modal:</span>
            <span class="value">
                {{ number_format($a->shu_jasa_modal, 2, ',', '.') }}
            </span>
        </td>
  
        </tr>
        <tr style="background:white !important;">
            <td colspan="2" class="no-border"></td>

            <td colspan="2" style="background:white !important; text-align:left; font-weight:bold;">
                <span class="label">Total SHU Diterima:</span>
                <span class="value">{{ number_format($a->total_shu, 2, ',', '.') }}</span>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


</body>
</html>
