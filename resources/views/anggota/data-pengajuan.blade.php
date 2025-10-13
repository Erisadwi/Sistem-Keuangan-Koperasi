@extends('layouts.app')

@push('styles')
  @vite('resources/css/components/tabel.css')
@endpush


@section('title', 'Data Pengajuan')  
@section('title-1', 'Data Pengajuan')  
@section('sub-title', 'Data Pengajuan')  

@section('content')

<x-menu.date-filter/>

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
              elseif ($status === 'Menunggu') $cls = 'menunggu';
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

@endsection
