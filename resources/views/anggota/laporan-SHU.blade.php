@extends('layouts.laporan')

@section('title', 'Laporan Sisa Hasil Usaha')  
@section('title-1', 'Laporan')  
@section('title-content', 'Laporan SHU Anggota')  
@section('period')
    {{ $periodeText }}
@endsection  
@section('sub-title', 'Laporan Sisa Hasil Usaha (SHU)')  

@section('content')

<x-menu.date-filter/>

<div class="shu-table-wrap">
  <table class="shu-table">
    <thead>
      <tr class="head-title">
        <th colspan="4">Pembagian SHU</th>
      </tr>
      <tr class="head-group">
        <th colspan="2" class="group-left">Jasa Usaha</th>
        <th colspan="2" class="group-right">Modal Usaha</th>
      </tr>
    </thead>

    <tbody>
      <tr>
        <td class="label">Laba Anggota</td>
        <td class="value">{{ number_format($anggota->bunga_anggota, 0, ',', '.') }}</td>
        <td class="label">Simpanan Anggota</td>
        <td class="value">{{ number_format($anggota->simpanan_anggota, 0, ',', '.') }}</td>
      </tr>

      <tr>
        <td class="label">Total Laba</td>
        <td class="value">{{ number_format($anggota->total_bunga, 0, ',', '.') }}</td>
        <td class="label">Total Simpanan</td>
        <td class="value">{{ number_format($anggota->total_simpanan, 0, ',', '.') }}</td>
      </tr>

      <tr>
        <td class="label">Jasa Usaha</td>
        <td class="value negative">{{ number_format($total_shu_jasa_usaha, 0, ',', '.') }}</td>
        <td class="label">Jasa Simpanan</td>
        <td class="value negative">{{ number_format($total_shu_jasa_modal, 2, ',', '.') }}</td>
      </tr>

      <tr>
        <td class="label">SHU Jasa Usaha</td>
        <td class="value negative">{{ number_format($anggota->shu_jasa_usaha, 0, ',', '.') }}</td>
        <td class="label">SHU Jasa Modal</td>
        <td class="value negative">{{ number_format($anggota->shu_jasa_modal, 0, ',', '.') }}</td>
      </tr>
    </tbody>
  </table>
</div>

@endsection

<style>
:root{
  --outer-border: #838383;      
  --head-dark:   #4a4a4a;       
  --head-mid:    #9a9a9a;       
  --line:        #7f7f7f;       
  --grid:        #bdbdbd;      
  --bg:          #ffffff;
}

.shu-table-wrap{
  border: 1.5px solid var(--outer-border);
  border-radius: 0px;
  background: var(--bg);
  width: 95%;
  margin-left: 30px;
  margin-top: 75px;
}

.shu-table{
  width: 100%;
  border-collapse: collapse;
  table-layout: fixed;
  font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
  font-size: 12px;
  color: #222;
}

.shu-table .head-title th{
  background: var(--head-dark);
  color: #fff;
  text-align: center;
  font-weight: 700;
  padding: 10px 8px;
  border-bottom: 1px solid var(--grid);
}

.shu-table .head-group th{
  background: var(--head-mid);
  color: #fff;
  text-align: left;
  font-weight: 600;
  padding: 8px;
  border-bottom: 1px solid var(--grid);
}

.shu-table .head-group .group-left{
  border-right: 1.5px solid var(--line);
}

.shu-table td{
  padding: 8px;
  border-bottom: 1px solid var(--grid);
  border-right: 1px solid var(--grid);
  background: #fff;
}

.shu-table tbody td:last-child { 
  border-right: 2px solid var(--grid);
}

.shu-table tbody tr td:nth-child(2){
  border-right: 1.5px solid var(--line);
}

.shu-table td.label{ 
  font-weight: 500; 
}
.shu-table td.value{ 
  text-align: right; 
  font-variant-numeric: tabular-nums; 
}

.shu-table td.value.negative{ 
  color: #333;              
}

.shu-table tbody tr:last-child td{
  border-bottom: 0;
}

@media (max-width: 640px){
  .shu-table{ font-size: 13px; }
  .shu-table td, .shu-table th{ padding: 10px; }
}
</style>
