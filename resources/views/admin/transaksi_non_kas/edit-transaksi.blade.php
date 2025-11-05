@extends('layouts.app-admin-add')

@section('title', 'Transaksi Non Kas')  
@section('back-url', url('admin/transaksi_non_kas/transaksi'))
@section('back-title', 'Transaksi Non Kas >')
@section('title-1', 'Transaksi')  
@section('sub-title', 'Edit Data Transaksi')  

@section('content')

<div class="form-container">
    <form action="{{ route('transaksi-non-kas.update', $TransaksiNonKas->id_transaksi) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="tanggal_transaksi">Tanggal Transaksi</label>
        <input type="datetime-local" id="tanggal_transaksi" name="tanggal_transaksi" 
                value="{{ old('tanggal_transaksi', isset($TransaksiNonKas->tanggal_transaksi) ? \Carbon\Carbon::parse($TransaksiNonKas->tanggal_transaksi)->format('Y-m-d\TH:i') : '') }}">


        <label for="jumlah_transaksi">Jumlah</label>
        <input type="text" id="jumlah_transaksi" name="jumlah_transaksi" value="{{ $TransaksiNonKas->jumlah_transaksi }}">

        <label for="keterangan">Keterangan</label>
        <input type="text" id="keterangan" name="ket_transaksi" value="{{ old('keterangan', $TransaksiPemasukan->ket_transaksi ?? '') }}">

        <label for="id_jenisAkunTransaksi_tujuan">Akun Debit</label>
            <select name="id_jenisAkunTransaksi_tujuan" id="id_jenisAkunTransaksi_tujuan">
            <option value="" disabled {{ empty($TransaksiNonKas->id_jenisAkunTransaksi_tujuan) ? 'selected' : '' }}>Pilih Kas</option>
            @foreach ($akunTujuan as $a)
                <option value="{{ $a->id_jenisAkunTransaksi }}"
                {{ (string)$TransaksiNonKas->id_jenisAkunTransaksi_tujuan === (string)$a->id_jenisAkunTransaksi ? 'selected' : '' }}>
                {{ $a->kode_AkunTransaksi }} - {{ $a->nama_AkunTransaksi }}
                </option>
            @endforeach
            </select>

        <label for="id_jenisAkunTransaksi_sumber">Akun Kredit</label>
            <select name="id_jenisAkunTransaksi_sumber" id="id_jenisAkunTransaksi_sumber">
            <option value="" disabled {{ empty($TransaksiNonKas->id_jenisAkunTransaksi_sumber) ? 'selected' : '' }}>Pilih Kas</option>
            @foreach ($akunSumber as $a)
                <option value="{{ $a->id_jenisAkunTransaksi }}"
                {{ (string)$TransaksiNonKas->id_jenisAkunTransaksi_sumber === (string)$a->id_jenisAkunTransaksi ? 'selected' : '' }}>
                {{ $a->kode_AkunTransaksi }} - {{ $a->nama_AkunTransaksi }}
                </option>
            @endforeach
            </select>

        <div class="form-buttons">
            <button type="submit" class="btn btn-simpan">Simpan</button>
            <a href="{{ route('transaksi-non-kas.index') }}" class="btn btn-batal">Batal</a>
        </div>

    </form>
</div>

<style>
.form-container {
    background-color: transparent;
    padding: 20px;
    border-radius: 10px;
    width: 98%;
    margin-left:10px;
    margin-top:40px;
}

label {
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 5px;
    display: block;
    color: #000000;
}

input[type="text"],
input[type="datetime-local"], 
input[type="number"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #565656;
    border-radius: 5px;
    font-size: 13px;
    background-color: #fff;
}

input[type="text"]:focus,
input[type="datetime-local"]:focus,
input[type="number"]:focus {
    border-color: #565656;
    outline: none;
}

select {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #565656;
    border-radius: 5px;
    font-size: 13px;
    background-color: #fff;
}

select:focus {
    border-color: #565656;
    outline: none;
}

.form-buttons {
    display: flex;
    justify-content: flex-end; 
    gap: 10px;                  
    margin-top: 40px; 
}

.btn {
    padding: 8px 0;             
    font-size: 16px;
    font-weight: bold;
    border-radius: 7px;
    border: none;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    width: 120px;               
    text-align: center;         
    box-shadow: 0 4px 4px rgba(0, 0, 0, 0.293);
}

.btn-simpan {
    background-color: #25E11B; 
    color: #fff;
}

.btn-simpan:hover {
    background-color: #45a049;
}

.btn-batal {
    background-color: #EA2828; 
    color: #fff;
}

.btn-batal:hover {
    background-color: #d73833;
}
</style>


@endsection