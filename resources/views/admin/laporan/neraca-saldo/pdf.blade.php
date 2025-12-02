<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Neraca Saldo</title>

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
            margin-top: 8px;
            margin-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px 4px;
            text-align: center;
        }
        th {
            background-color: #e6f2ff;
            font-weight: bold;
        }

        .akun-header td {
            background: #e5e5e5;
            font-weight: bold;
            text-align: left;
        }

        .nama-akun-item {
            text-align: left;
        }

        .right {
            text-align: right;
        }
    </style>
</head>
<body>

{{-- HEADER --}}
<div class="header">
    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo.png'))) }}" alt="Logo">

    <div class="kop">
        <h2>KOPERASI TUNAS SEJAHTERA MANDIRI</h2>
        <p>Jl. Karah Agung 45</p>
        <p>Tel. 031-8290002 &nbsp; Email: koperasitsm@gmail.com</p>
        <p>Web: www.koperasitsm.com</p>
    </div>
</div>

<hr>

{{-- PERIODE --}}
@php
    $tahun = $tahun ?? date('Y');
    $awal = "01 Jan $tahun";
    $akhir = "31 Des $tahun";
@endphp

<h3 style="text-align:center; margin-top:5px;">
    LAPORAN NERACA SALDO<br>
    <small>Periode {{ $awal }} - {{ $akhir }}</small>
</h3>

{{-- TABEL --}}
<table>
    <thead>
        <tr class="head-group">
          <th class="nama-akun">Nama Akun</th>
          <th class="debet">Debet</th>
          <th class="kredit">Kredit</th>
        </tr>
      </thead>

      <tbody>
{{-- ===================== --}}
{{--     Group Akun        --}}
{{-- ===================== --}}
@forelse($neracaKelompok as $judul => $list)

  {{-- Sub Judul Kelompok --}}
  <tr class="akun-header">
    <td colspan="3" style="font-weight:600; background:#e5e5e5;">
      {{ $judul }}
    </td>
  </tr>

  {{-- Daftar Akun --}}
  @foreach($list as $item)
  <tr class="akun-item">
    <td class="nama-akun-item">
      {{ $item['kode'] }}. {{ $item['nama'] }}
    </td>
    <td class="debet">
      {{ $item['debet'] > 0 ? number_format($item['debet'], 0, ',', '.') : '-' }}
    </td>
    <td class="kredit">
      {{ $item['kredit'] > 0 ? number_format($item['kredit'], 0, ',', '.') : '-' }}
    </td>
  </tr>
  @endforeach

@empty
  <tr>
    <td colspan="3" class="empty-cell">Belum ada data neraca saldo.</td>
  </tr>
@endforelse

{{-- =========================== --}}
{{-- TOTAL DEBET & KREDIT       --}}
{{-- =========================== --}}
<tr class="total-row final-total" style="background:#f2faff; font-weight:700;">
  <td class="text-end text-primary" style="padding-right:20px;">JUMLAH</td>
  <td class="debet text-primary">{{ number_format($totalDebet, 0, ',', '.') }}</td>
  <td class="kredit text-primary">{{ number_format($totalKredit, 0, ',', '.') }}</td>
</tr>

</tbody>
</table>

</body>
</html>
