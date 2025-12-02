<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Neraca</title>

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
            border: 1px solid #ccc;
        }

        th {
            background-color: #4c4c4c;
            color: white;
            text-align: center;
        }

        td {
            background-color: white;
        }

        .group-header {
            background-color: #e8e8e8;
            font-weight: bold;
            text-transform: uppercase;
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
        <b>LAPORAN NERACA</b><br>
        <small>Per Tanggal {{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth()->translatedFormat('d F Y') }}</small>
    </h3>

    <table>
        <thead>
            <tr>
                <th style="width: 60%">Nama Akun</th>
                <th style="width: 20%">Debet</th>
                <th style="width: 20%">Kredit</th>
            </tr>
        </thead>

      <tbody>

      @forelse ($neracaGrouped as $groupName => $items)

          <tr class="akun-header">
              <td colspan="3" style="text-align:left;">
                  <b>{{ strtoupper($groupName) }}</b>
              </td>
          </tr>

          @foreach ($items as $item)
              <tr class="akun-item">
                  
                  <td class="nama-akun-item">
                      {{ $item->kode_aktiva }}. {{ $item->nama_AkunTransaksi }}
                  </td>

                  <td style="text-align:center;">
                      {{ $item->total_debit_display > 0 ? number_format($item->total_debit_display, 0, ',', '.') : '-' }}
                  </td>

                  <td style="text-align:center;">
                      {{ $item->total_kredit_display > 0 ? number_format($item->total_kredit_display, 0, ',', '.') : '-' }}
                  </td>

              </tr>
          @endforeach

      @empty
          <tr>
              <td colspan="3" class="empty-cell">Belum ada data neraca.</td>
          </tr>
      @endforelse
      
      <tr class="total-row final-total">
          <td class="nama-akun-item text-primary"
              style="text-align:center !important; padding-left:0 !important;">
              <b>JUMLAH</b>
          </td>

          <td class="debet text-primary" style="text-align:center;">
                <b>{{ number_format($totalDebit, 0, ',', '.') }}</b>
            </td>

            <td class="kredit text-primary" style="text-align:center;">
                <b>{{ number_format($totalKredit, 0, ',', '.') }}</b>
            </td>
      </tr>
      </tbody>
    </table>

</body>
</html>
