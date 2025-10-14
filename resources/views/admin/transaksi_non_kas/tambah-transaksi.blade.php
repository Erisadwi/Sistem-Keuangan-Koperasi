@extends('layouts.app-admin-add')

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

</style>


@endsection