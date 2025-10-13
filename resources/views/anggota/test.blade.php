@extends('layouts.app')

@push('styles')
  @vite('resources/css/components/tabel.css')
@endpush


@section('title', 'TEST')  
@section('title-1', 'TEST')  
@section('sub-title', 'TEST')  

@section('content')

<x-menu.date-filter/>

<div class="pengajuan-table-wrap">
  <table class="pengajuan-table">
    <thead>
      <tr class="head-group">
        <th>Tanggal</th> <!-- nama row sesuaikan dengan kebutuhan -->
        <th>Jenis</th> <!-- nama row sesuaikan dengan kebutuhan -->
        <th>Nominal</th> <!-- nama row sesuaikan dengan kebutuhan -->
        <th>Jml. Angsuran</th> <!-- nama row sesuaikan dengan kebutuhan -->
        <th>Ket</th> <!-- nama row sesuaikan dengan kebutuhan -->
        <th>Tanggal Update</th> <!-- nama row sesuaikan dengan kebutuhan -->
        <th>Status</th> <!-- nama row sesuaikan dengan kebutuhan -->
      </tr>
    </thead>

    <tbody>
      @forelse(($pengajuan ?? collect()) as $idx => $row) {{-- -$pengajuan sesuaikan dengan setiap data masing masing untuk backend --}}
        <tr>
      <td>
        {{-- Jika paginate, nomor urut mengikuti halaman --}}
        @if($pengajuan instanceof \Illuminate\Pagination\AbstractPaginator)
          {{ ($pengajuan->currentPage() - 1) * $pengajuan->perPage() + $loop->iteration }}
        @else
          {{ $idx + 1 }}
        @endif
      </td>

      {{-- Kolom Tanggal --}}
      <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y') ?? '' }}</td> <!-- Menampilkan tanggal dengan format d/m/Y -->

      {{-- Kolom Jenis Pengajuan --}}
      <td>{{ $row->jenis ?? '' }}</td> <!-- nama row sesuaikan dengan kebutuhan -->

      {{-- Kolom Nominal --}} <!-- nama row sesuaikan dengan kebutuhan -->
      <td>
        @php 
          $nominal = $row->nominal ?? null; 
        @endphp
        {{ $nominal !== null ? number_format($nominal, 0, ',', '.') : '' }} <!-- Format nominal menjadi uang -->
      </td>

      {{-- Kolom Jumlah Angsuran --}} <!-- nama row sesuaikan dengan kebutuhan -->
      <td>{{ $row->jumlah_angsuran ?? '' }}</td> <!-- Menampilkan jumlah angsuran -->

      {{-- Kolom Keterangan --}} <!-- nama row sesuaikan dengan kebutuhan -->
      <td>{{ $row->keterangan ?? '' }}</td> <!-- Menampilkan keterangan pengajuan -->

      {{-- Kolom Tanggal Update --}} <!-- nama row sesuaikan dengan kebutuhan -->
      <td>{{ \Carbon\Carbon::parse($row->updated_at)->format('d/m/Y H:i:s') ?? '' }}</td> <!-- Menampilkan tanggal update dengan format d/m/Y H:i:s -->

      {{-- Kolom Status --}} <!-- nama row sesuaikan dengan kebutuhan -->
      <td>
        @php
          $status = trim((string)($row->status ?? ''));
          $cls = '';
          if ($status === 'Disetujui') $cls = 'disetujui';
          elseif ($status === 'Ditolak') $cls = 'ditolak';
          elseif ($status === 'Menunggu') $cls = 'menunggu';
        @endphp
        <span class="badge {{ $cls }}">{{ $status }}</span> <!-- Badge untuk status pengajuan -->
      </td>
      </tr>
      @empty
        <tr>
          <td colspan="7" class="empty-cell">Belum ada data pengajuan.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

@endsection