@extends('layouts.laporan-admin2')

@push('styles')
  @vite('resources/css/style-laporanNeraca.css')
@endpush

@section('title', 'Laporan Neraca')
@section('title-1', 'Neraca')
@section('title-content', 'Laporan Neraca')

@section('period')
    Per Tanggal {{ \Carbon\Carbon::create($tahun, $bulan, 1)->endOfMonth()->translatedFormat('d M Y') }}
@endsection

@section('sub-title', 'Laporan Neraca')

@section('content')

<x-menu.month-filter/>
<x-menu.unduh 
    :url="route('laporan-neraca.exportPdf', ['bulan' => $bulan, 'tahun' => $tahun])" 
    text="Unduh PDF" 
/>

<div class="laporan-neraca-wrap">
  <div class="table-scroll-wrapper">
    <table class="laporan-neraca-table">
      <thead>
        <tr class="head-group">
          <th class="nama-akun">Nama Akun</th>
          <th class="debet">Debet</th>
          <th class="kredit">Kredit</th>
        </tr>
      </thead>

      <tbody>

      @forelse ($neracaGrouped as $groupName => $items)

          <tr class="group-header">
              <td colspan="3" style="text-align:left;">
                  <b>{{ strtoupper($groupName) }}</b>
              </td>
          </tr>

         @foreach ($items as $item)
              <tr>
                  <td style="text-align:left;">
                      {{ $item->kode_aktiva }}. {{ $item->nama_akun }}
                  </td>

                <td style="text-align:center;">
                  @if ($item->kode_aktiva == 'I02.01')
                      {{-- kalau rugi tampil di debit --}}
                      {{ $laba_bersih < 0 ? number_format(abs($laba_bersih), 0, ',', '.') : '-' }}
                  @else
                      {{ $item->total_debit > 0 ? number_format($item->total_debit, 0, ',', '.') : '-' }}
                  @endif
              </td>

              <td style="text-align:center;">
                  @if ($item->kode_aktiva == 'I02.01')
                      {{-- kalau laba tampil di kredit --}}
                      {{ $laba_bersih > 0 ? number_format($laba_bersih, 0, ',', '.') : '-' }}
                  @else
                      {{ $item->total_kredit > 0 ? number_format($item->total_kredit, 0, ',', '.') : '-' }}
                  @endif
              </td>
              </tr>
          @endforeach

      @empty
          <tr>
              <td colspan="3" class="empty-cell">Belum ada data neraca.</td>
          </tr>
      @endforelse
      
      <tr class="final-total">
          <td class="nama-akun-item text-end text-primary"><b>JUMLAH</b></td>
          <td class="debet text-primary">
              <b>{{ number_format($totalDebit, 0, ',', '.') }}</b>
          </td>
          <td class="kredit text-primary">
              <b>{{ number_format($totalKredit, 0, ',', '.') }}</b>
          </td>
      </tr>

      </tbody>
    </table>

  </div>
</div>

@endsection
