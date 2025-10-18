@extends('layouts.app-admin-add')

@section('title', 'Transaksi Kas')  
@section('back-title', 'Transaksi Kas >')
@section('title-1', 'Transfer')  
@section('sub-title', 'Tambah Data Transfer')  

@section('content')

<div class="form-container">
    <form action="# {{-- {{ route('tambah-transfer-kas.store', $transaksi->id) }} --}}" method="POST">
        @csrf

        <label for="tanggal_transaksi">Tanggal Transaksi</label>
        <input type="datetime-local" id="tanggal_transaksi" name="tanggal_transaksi" 
                value="{{ isset($transaksi) ? \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('Y-m-d\TH:i') : '' }}">

        <label for="jumlah_transaksi">Jumlah</label>
        <input type="number" id="jumlah_transaksi" name="jumlah_transaksi" value=" {{-- {{ isset($transaksi) ? number_format($transaksi->jumlah_transaksi, 0, ',', '.') : '' }} --}}">

        <label for="keterangan">Keterangan</label>
        <input type="text" id="keterangan" name="keterangan" value="{{-- {{ $transaksi->keterangan }} --}}">

         <label for="dari_kas">Dari Kas</label>
            <select name="dari_kas" id="dari_kas">
                <option value="" disabled selected>Pilih Jenis Kas</option>
                <option value="/">Kas Besar</option>
                <option value="/">Bank Mandiri</option>
                <option value="/">Kas Kecil</option>
                <option value="/">Kas Niaga</option>
                <option value="/">Bank BNI</option>
            </select>

        <label for="untuk_kas">Untuk Kas</label>
            <select name="dari_kas" id="dari_kas">
                <option value="" disabled selected>Pilih Jenis Kas</option>
                <option value="/">Kas Besar</option>
                <option value="/">Bank Mandiri</option>
                <option value="/">Kas Kecil</option>
                <option value="/">Kas Niaga</option>
                <option value="/">Bank BNI</option>
            </select>

        <div class="form-buttons">
            <button type="submit" class="btn btn-simpan">Simpan</button>
            <a href="# {{-- {{ route('transaksi.index') }} --}}" class="btn btn-batal">Batal</a>
        </div>

    </form>
</div>

<style>
.form-container {
    background-color: transparent;
    padding: 20px;
    border-radius: 10px;
    width: 900px;
    margin-left:10px;
    margin-top:55px;
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