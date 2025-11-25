@extends('layouts.laporan-admin2')

@push('styles')
@vite('resources/css/style-laporanBukuBesar.css')
@endpush

@section('title', 'Laporan Buku Besar')
@section('title-1', 'Buku Besar')
@section('title-content', 'Laporan Buku Besar')
@section('sub-title', 'Laporan Buku Besar')

@section('content')

<div class="buku-besar-page">

    {{-- HEADER FILTER + TITLE --}}
    <div class="header-flex">
        <div class="left-tools">
            <x-menu.month-filter />
            <x-menu.unduh />
        </div>

        <div class="title-right">
            <div class="title-content">
                Laporan Buku Besar <br>
                Periode {{ date('F Y', strtotime($periode . '-01')) }}
            </div>
        </div>
    </div>

    {{-- ISI TABEL PER AKUN --}}
    @foreach ($akunTransaksi as $i => $akun)
    <h4 class="judul-section">
        {{ $i + 1 }}. {{ $akun->nama_AkunTransaksi }}
    </h4>

    {{-- ============================= --}}
    {{-- TABEL SALDO AWAL --}}
    {{-- ============================= --}}
    @php
    $saldoAwal = $akun->saldoAwal->sum('debit') - $akun->saldoAwal->sum('kredit');
    @endphp

    <table class="tabel-buku-besar" style="margin-bottom: 10px; width: 300px;">
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
            @forelse ($akun->bukuBesar as $index => $bb)
            <tr>
                <td>{{ $index + 1 }}</td>

                <td>{{ date('d M Y', strtotime($bb->tanggal_transaksi)) }}</td>

                {{-- Nama Akun Berkaitan --}}
                <td>{{ $bb->akunBerkaitan->nama_AkunTransaksi ?? '-' }}</td>

                <td>{{ number_format($bb->debit, 0, ',', '.') }}</td>
                <td>{{ number_format($bb->kredit, 0, ',', '.') }}</td>
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
    $totalDebit = $akun->bukuBesarTotal->sum('debit');
    $totalKredit = $akun->bukuBesarTotal->sum('kredit');
    $saldoTotal = $totalDebit - $totalKredit;
    @endphp

    <table class="tabel-buku-besar" style="margin-top: 6px; width: 300px;">
        <tr style="font-weight: 600; background: #f3f3f3;">
            <td style="text-align: left;">Saldo Total</td>
            <td style="text-align: right;">
                {{ number_format($saldoTotal, 0, ',', '.') }}
            </td>
        </tr>
    </table>

    {{-- SALDO KUMULATIF --}}
<table class="tabel-buku-besar" style="margin-top: 6px; width: 300px;">
    <tr style="font-weight: 600; background: #f3f3f3;">
        <td>Saldo Kumulatif</td>
        <td style="text-align: right;">
            {{ number_format($akun->saldo_kumulatif, 0, ',', '.') }}
        </td>
    </tr>
</table>


    @endforeach

</div>

@endsection