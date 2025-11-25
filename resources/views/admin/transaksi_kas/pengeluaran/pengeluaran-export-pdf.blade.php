<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi Kas Pengeluaran</title>
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
        <h2>KOPERASI TUNAS SEJAHTERA MANDIRI</h2>
        <p>Jl. Karah Agung 45</p>
        <p>Tel. 031-8290002 Email : koperasitsm@gmail.com</p>
        <p>Web : www.koperasitsm.com</p>
    </div>
</div>

<hr>

@php
    $start = \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y');
    $end = \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y');
@endphp


<h3 style="text-align:center; margin-top:5px;">
    Laporan Transaksi Kas Pengeluaran<br>
    <small>Periode {{ $start }} - {{ $end }}</small>
</h3>


  <table>
  <thead>
    <tr>
      <th>No</th>
      <th>Kode Transaksi</th>
      <th>Tanggal Transaksi</th>
      <th>Dari Kas</th>
      <th>Untuk Akun</th>
      <th>Jumlah</th>
      <th>Uraian</th>
      <th>User</th>
    </tr>
  </thead>
 <tbody>
    @forelse(($data ?? collect()) as $index => $row)

        @php
            $akunSumberList = $row->details->where('kredit', '>', 0);
            $akunTujuan = $row->details->firstWhere('debit', '>', 0)?->akun;
            $jumlah = $row->details->where('debit', '>', 0)->sum('debit');
        @endphp

        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $row->kode_transaksi }}</td>
            <td>{{ \Carbon\Carbon::parse($row->tanggal_transaksi)->format('d-m-Y') }}</td>

            <td style="text-align:left">
                <ul style="margin:0; padding-left:16px;">
                    @foreach($akunSumberList as $s)
                        <li>{{ $s->akun->nama_AkunTransaksi ?? '-' }}</li>
                    @endforeach
                </ul>
            </td>

            <td>{{ $akunTujuan->nama_AkunTransaksi ?? '-' }}</td>

            <td>{{ number_format($jumlah, 0, ',', '.') }}</td>
            <td>{{ $row->ket_transaksi ?? '-' }}</td>
            <td>{{ $row->data_user->nama_lengkap ?? '-' }}</td>
        </tr>

    @empty
        <tr>
            <td colspan="8">Belum ada data</td>
        </tr>
    @endforelse
</tbody>

</html>
