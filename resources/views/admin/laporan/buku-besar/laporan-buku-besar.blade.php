@extends('layouts.laporan-admin3')

@push('styles')
@vite('resources/css/style-laporanBukuBesar.css')
@endpush

@section('title', 'Laporan Buku Besar')
@section('title-1', 'Buku Besar')
@section('title-content', 'Laporan Buku Besar')
@section('period', 'Periode ' . date('d M Y', strtotime($periode . '-01')))
@section('sub-title', 'Laporan Buku Besar')

@section('filter-area')
<div class="header-flex">
    <div class="left-tools">
        <x-menu.month-filter />
      <x-menu.unduh 
    :url="route('laporan-buku-besar.exportPdf', ['bulan' => $bulan, 'tahun' => $tahun])" 
    text="Unduh Laporan" 
/>
    </div>
</div>
@endsection

@section('content')

<div class="buku-besar-page">

    {{-- ISI TABEL PER AKUN --}}
    @foreach ($akunTransaksi as $i => $akun)
    <div class="akun-section">
    <h4 class="judul-section">
        {{ $i + 1 }}. {{ $akun->nama_AkunTransaksi }}
    </h4>

    {{-- ============================= --}}
    {{-- TABEL SALDO AWAL --}}
    {{-- ============================= --}}
    @php
    $saldoAwal = $akun->saldoAwal->sum('debit') - $akun->saldoAwal->sum('kredit');
    @endphp

    <table class="tabel-buku-besar saldo-box">
        <tr style="font-weight: 600; background: #f3f3f3;">
        <td style="text-align: left;">Saldo Awal</td>
            <td style="text-align: right;">
                {{ number_format($saldoAwal, 0, ',', '.') }}
            </td>
        </tr>
    </table>



    {{-- ============ TABEL TRANSAKSI ============ --}}
    <table class="tabel-buku-besar">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jenis Transaksi</th>
                <th>Debet</th>
                <th>Kredit</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($akun->buku_besar as $index => $bb)
            <tr>
                <td>{{ $index + 1 }}</td>

              <td>{{ date('d M Y', strtotime($bb['tanggal'])) }}</td>
              <td>{{ $bb['akun_lawan'] }}</td>
              <td>{{ number_format($bb['debit'], 0, ',', '.') }}</td>
              <td>{{ number_format($bb['kredit'], 0, ',', '.') }}</td>

            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted">Tidak ada transaksi pada periode ini</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ============ SALDO TOTAL ============ --}}
    @php
    $totalDebit = collect($akun->buku_besar)->sum('debit');
    $totalKredit = collect($akun->buku_besar)->sum('kredit');
    @endphp


    <table class="tabel-buku-besar saldo-box">
        <tr style="font-weight: 600; background: #f3f3f3;">
            <td style="text-align: left;">Saldo Total Debet</td>
            <td style="text-align: right;">{{ number_format($totalDebit, 0, ',', '.') }}</td>
        </tr>

        <tr style="font-weight: 600; background: #f3f3f3;">
            <td style="text-align: left;">Saldo Total Kredit</td>
            <td style="text-align: right;">{{ number_format($totalKredit, 0, ',', '.') }}</td>
        </tr>
    </table>


    {{-- SALDO KUMULATIF --}}
    <table class="tabel-buku-besar saldo-box">
    <tr style="font-weight: 600; background: #f3f3f3;">
         <td>Saldo Kumulatif</td>
        <td style="text-align: right;">
            {{ number_format($akun->saldo_kumulatif, 0, ',', '.') }}
        </td>
    </tr>
</table>
  </div> 

    @endforeach

</div>

@endsection