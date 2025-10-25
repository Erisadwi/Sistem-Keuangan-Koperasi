@extends('layouts.app-admin3')

@section('title', 'Identitas Koperasi')  
@section('title-1', 'Identitas Koperasi')  
@section('sub-title', 'Data Koperasi')  

@section('content')

<div class="form-container">
    <form action="{{ route('identitas-koperasi.update', $identitas_koperasi ->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="namaKoperasi">Nama Koperasi</label>
        <input type="text" id="namaKoperasi" name="nama_koperasi" value="{{ $identitas_koperasi->nama_koperasi }}">

        <label for="npwp">NPWP</label>
        <input type="text" id="npwp" name="npwp" value="{{ $identitas_koperasi->npwp }}">

        <label for="namaPimpinan">Nama Pimpinan</label>
        <input type="text" id="namaPimpinan" name="nama_pimpinan" value="{{ $identitas_koperasi->nama_pimpinan }}">

        <label for="telepon">Telepon</label>
        <input type="tel" id="telepon" name="telepon_koperasi" value="{{ $identitas_koperasi->telepon_koperasi }}">

        <label for="alamat">Alamat</label>
        <input type="text" id="alamat" name="alamat_koperasi" value="{{ $identitas_koperasi->alamat_koperasi }}">

        <label for="kodePos">Kode Pos</label>
        <input type="number" id="kodePos" name="kode_pos" value="{{ $identitas_koperasi->kode_pos }}">

        <label for="fax">Fax</label>
        <input type="text" id="fax" name="fax_koperasi" value="{{ $identitas_koperasi->fax_koperasi }}">

        <label for="email">Email</label>
        <input type="email" id="email" name="email_koperasi" value="{{ $identitas_koperasi->email_koperasi }}">

        <label for="website">Website</label>
        <input type="url" id="website" name="website" value="{{ $identitas_koperasi->website }}">

        <label for="logo">Logo</label>
        <input type="file" id="logo" name="logo_koperasi" accept="image/*">

        <button type="submit">Update</button>
    </form>
</div>

<style>
.form-container {
    background-color: transparent;
    padding: 20px;
    border-radius: 10px;
    width: 100%;
    margin-left:0px;
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
    background-color: #6E9EB6;
    color: white;
    border: none;
    border-radius: 7px;
    font-size: 16px; 
    font-weight: bold; 
    cursor: pointer;
    box-shadow: 0 4px 8px rgba(82, 76, 76, 0.15);
    transition: background-color 0.3s; 
    margin-top:30px;
    display: block; 
    text-align: center; 
}

button:hover {
    background-color: #5a7fa1;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.125);
}
</style>


@endsection