@extends('layouts.app-admin-add')

@section('title', 'Data Barang Inventaris')  
@section('back-url', url('admin/master_data/jenis-barang'))
@section('back-title', 'Master Data >')
@section('title-1', 'Data Barang')  
@section('sub-title', 'Tambah Data Barang')  

@section('content')

<div class="form-container">
    <form id="formDataBarang" action="{{ route('jenis-barang.store') }}" method="POST">
        @csrf

        <label for="nama_barang">Nama Barang*</label>
        <input type="text" id="nama_barang" name="nama_barang" value="{{ old('nama_barang') }}">

        <label for="type_barang">Type</label>
        <input type="text" id="type_barang" name="type_barang" value="{{ old('type_barang') }}">

        <label for="jumlah_barang">Jumlah*</label>
        <input type="text" id="jumlah_barang" name="jumlah_barang" value=" {{ old('jumlah_barang') }}">

        <label for="keterangan_barang">Keterangan</label>
        <input type="text" id="keterangan_barang" name="keterangan_barang" value="{{ old('keterangan_barang') }}">
        

        <div class="form-buttons">
            <button type="submit" class="btn btn-simpan">Simpan</button>
            <a href="{{ route('jenis-barang.index') }}" class="btn btn-batal">Batal</a>
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

input[type="text"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #565656;
    border-radius: 5px;
    font-size: 13px;
    background-color: #fff;
}

input[type="text"]:focus {
    border-color: #565656;
    outline: none;
}

.form-buttons {
    display: flex;
    justify-content: flex-end; 
    gap: 10px;                  
    margin-top: 110px; 
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

<script>
document.getElementById('formDataBarang').addEventListener('submit', function(e) {
    const wajib = ['nama_barang', 'jumlah_barang'];

    for (let id of wajib) {
        const el = document.getElementById(id);
        if (!el || !el.value.trim()) {
            alert('⚠️ Mohon isi semua kolom wajib sebelum menyimpan.');
            e.preventDefault(); 
            return;
        }
    }

    const yakin = confirm('Apakah data sudah benar dan ingin disimpan?');

    if (!yakin) {
        e.preventDefault(); 
        alert('❌ Pengisian data dibatalkan.');
        return;
    }

    alert('✅ Data barang berhasil disimpan!');
});
</script>




@endsection