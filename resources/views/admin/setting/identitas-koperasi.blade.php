@extends('layouts.app-admin3')

@section('title', 'Identitas Koperasi')  
@section('title-1', 'Identitas Koperasi')  
@section('sub-title', 'Data Koperasi')  

@section('content')

<div class="form-container">
    <form action="# {{-- {{ route('koperasi.update', $data_koperasi->id) }} --}}" method="POST">
        @csrf
        @method('PUT')

        <label for="namaKoperasi">Nama Koperasi</label>
        <input type="text" id="namaKoperasi" name="namaKoperasi" value=" {{-- {{ $data_koperasi->nama_koperasi }} --}}">

        <label for="npwp">NPWP</label>
        <input type="text" id="npwp" name="npwp" value=" {{-- {{ $data_koperasi->npwp }} --}}">

        <label for="namaPimpinan">Nama Pimpinan</label>
        <input type="text" id="namaPimpinan" name="namaPimpinan" value="{{-- {{ $data_koperasi->nama_pimpinan }} --}}">

        <label for="telepon">Telepon</label>
        <input type="tel" id="telepon" name="telepon" value="{{-- {{ $data_koperasi->telepon_koperasi }} --}}">

        <label for="alamat">Alamat</label>
        <input type="text" id="alamat" name="alamat" value="{{-- {{ $data_koperasi->alamat_koperasi }} --}}">

        <label for="kodePos">Kode Pos</label>
        <input type="number" id="kodePos" name="kodePos" value="{{-- {{ $data_koperasi->kode_pos }} --}}">

        <label for="fax">Fax</label>
        <input type="text" id="fax" name="fax" value="{{-- {{ $data_koperasi->fax_koperasi }} --}}">

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{-- {{ $data_koperasi->email_koperasi }} --}}">

        <label for="website">Website</label>
        <input type="url" id="website" name="website" value="{{-- {{ $data_koperasi->website }} --}}">

        <label for="logo">Logo</label>
        <input type="file" id="logo" name="logo" accept="image/*">

        <button type="submit">Update</button>
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
input[type="email"],
input[type="url"],
input[type="tel"],
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
input[type="email"]:focus,
input[type="tel"]:focus,
input[type="number"]:focus {
    border-color: #565656;
    outline: none;
}

button {
    width: auto;
    padding: 10px 30px; 
    background-color: #6D97C7;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px; 
    font-weight: bold; 
    cursor: pointer;
    box-shadow: 0 4px 8px rgba(82, 76, 76, 0.15);
    transition: background-color 0.3s;
    margin-left: 745px; 
    margin-top:15px;
    display: block; 
    text-align: center; 
}

button:hover {
    background-color: #5a7fa1;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.125);
}
</style>


@endsection