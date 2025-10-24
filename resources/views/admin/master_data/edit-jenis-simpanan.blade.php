@extends('layouts.app-admin-add')

@section('title', 'Jenis Simpanan')  
@section('back-url', url('admin/master_data/jenis-simpanan')) 
@section('back-title', 'Master Data >')
@section('title-1', 'Jenis Simpanan')  
@section('sub-title', 'Edit Jenis Simpanan')  

@section('content')

<div class="form-container">
    <form action="# {{-- {{ route('edit-jenis-simpanan.update', $jenis_simpanan->id) }} --}}" method="POST">
        @csrf
        @method('PUT')

        <label for="jenis_simpanan">Jenis Simpanan*</label>
        <input type="text" id="jenis_simpanan" name="jenis_simpanan" value="{{-- {{ $jenis_simpanan->jenis_simpanan }} --}}">

        <label for="jumlah_simpanan">Jumlah*</label>
        <input type="number" id="jumlah_simpanan" name="jumlah_simpanan" value=" {{-- {{ isset($jenis_simpanan) ? number_format($jenis_simpanan->jumlah_simpanan, 0, ',', '.') : '' }} --}}">

        <label for="tampil_simpanan">Tampil*</label>
            <select name="tampil_simpanan" id="tampil_simpanan">
                <option value="" disabled selected>Y/N</option>
                <option value="Y">Y</option>
                <option value="N">N</option>
            </select>

        <div class="form-buttons">
            <button type="submit" class="btn btn-simpan">Simpan</button>
            <a href="# {{-- {{ route('data-barang.index') }} --}}" class="btn btn-batal">Batal</a>
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
    margin-top: 170px; 
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