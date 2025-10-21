@extends('layouts.app')

@section('title', 'Data Pengajuan')  
@section('title-1', 'Data Pengajuan')  
@section('sub-title', 'Data Pengajuan')  

@section('content')

<div class="pengajuan-table-wrap">
  <table class="pengajuan-table">
    <thead>
      <tr class="head-group">
        <th>Tanggal</th>
        <th>Jenis</th>
        <th>Nominal</th>
        <th>Jml. Angsuran</th>
        <th>Ket</th>
        <th>Tanggal Update</th>
        <th>Status</th>
      </tr>
    </thead>

    <tbody>
      @forelse(($pengajuan ?? collect()) as $idx => $row)
        <tr>
          <td>
            {{-- Jika paginate, nomor urut mengikuti halaman --}}
            @if($pengajuan instanceof \Illuminate\Pagination\AbstractPaginator)
              {{ ($pengajuan->currentPage() - 1) * $pengajuan->perPage() + $loop->iteration }}
            @else
              {{ $idx + 1 }}
            @endif
          </td>

          <td>{{ $row->kode ?? '' }}</td>
          <td>{{ $row->tanggal ?? '' }}</td>
          <td>{{ $row->jenis ?? '' }}</td>

          <td>
            @php $nom = $row->nominal ?? null; @endphp
            {{ $nom !== null ? number_format($nom, 0, ',', '.') : '' }}
          </td>

          <td>
            @php
              $status = trim((string)($row->status ?? ''));
              $cls = '';
              if ($status === 'Disetujui') $cls = 'disetujui';
              elseif ($status === 'Ditolak') $cls = 'ditolak';
              elseif ($status === 'Menunggu konfirmasi') $cls = 'menunggu konfirmasi';
            @endphp
            <span class="badge {{ $cls }}">{{ $status }}</span>
          </td>

      @empty
        <tr>
          <td colspan="7" class="empty-cell">Belum ada data pengajuan.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<x-menu.pagination/>

<style>
  :root{
  --outer-border: #838383;      
  --head-dark:   #4a4a4a;       
  --head-mid:    #9a9a9a;       
  --line:        #fffafa;       
  --grid:        #fffcfc;      
  --bg:          #ffffff;
}

.pengajuan-table-wrap{
  border: 1.5px solid var(--outer-border);
  border-radius: 0;
  background: var(--bg);
  width: 860px;          
  margin-left: 25px;     
  margin-top: 75px;       
  padding: 0;             
  box-shadow: none;       
  overflow-x: visible; 
}

.pengajuan-table{
  width: 870px;         
  border-collapse: collapse;
  table-layout: fixed;
  font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
  font-size: 13px;
  color: #222;
}

.pengajuan-table thead .head-group th{
  background: var(--head-dark);
  color: #fff;
  text-align: center;
  font-weight: 600;
  padding: 10px;
  border-bottom: 1px solid var(--grid);
  white-space: nowrap;
}

.pengajuan-table td{
  padding: 10px;
  border-bottom: 1px solid var(--grid)!important;
  border-right: 1px solid var(--grid)!important;
  background: #fff;
}

.pengajuan-table tbody td:last-child{
  border-right: 2px solid var(--grid)!important;
}

.pengajuan-table tbody tr td:nth-child(1){
  border-right: 1.5px solid var(--line) !important;
}

.pengajuan-table tbody tr{ background: #fff; }
.pengajuan-table tbody tr:nth-child(even){ background: #fff; }
.pengajuan-table tbody tr:hover{ background: #fff; }

.pengajuan-table .empty-cell{
  text-align: center;
  padding: 8px 10px;
  color: #6b7280;
  font-style: italic;
}


.badge{
  display: inline-block;
  padding: 4px 8px;
  border-radius: 999px;
  font-size: .75rem;
  font-weight: 600;
  border: 1px solid var(--grid);
  color: #222;
  background: #f6f6f6;
}
.badge.disetujui{ background: #efefef; }
.badge.ditolak  { background: #f3f3f3; }
.badge.menunggu { background: #f9f9f9; }

@media (max-width: 640px){
  .pengajuan-table{ font-size: 13px; }
  .pengajuan-table td, .pengajuan-table th{ padding: 10px; }
}
@media (max-width: 768px){
  .pengajuan-table thead .head-group th:nth-child(3),  
  .pengajuan-table tbody td:nth-child(3),
  .pengajuan-table thead .head-group th:nth-child(5),  
  .pengajuan-table tbody td:nth-child(5){
    display: none;
  }
}
</style>

@endsection
