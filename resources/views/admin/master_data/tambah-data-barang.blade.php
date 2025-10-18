@extends('layouts.app-admin-add')

@section('title', 'Data Barang Inventaris')  
@section('back-title', 'Master Data >')
@section('title-1', 'Data Barang')  
@section('sub-title', 'Tambah Data Barang')  

@section('content')

<div class="form-container">
    <form id="formDataBarang" action="# {{-- {{ route('tambah-data-barang.store', $barang_inventaris->id) }} --}}" method="POST">
        @csrf

        <label for="nama_barang">Nama Barang*</label>
        <input type="text" id="nama_barang" name="nama_barang" value="{{-- {{ $barang_inventaris->nama_barang }} --}}">

        <label for="type_barang">Type</label>
        <input type="text" id="type_barang" name="type_barang" value="{{-- {{ $barang_inventaris->type_barang }} --}}">

        <label for="jumlah_barang">Jumlah*</label>
        <input type="text" id="jumlah_barang" name="jumlah_barang" value=" {{-- {{ $barang_inventaris)->jumlah_barang }} --}}">

        <label for="keterangan_barang">Keterangan</label>
        <input type="text" id="keterangan_barang" name="keterangan_barang" value="{{-- {{ $barang_inventaris->keterangan_barang }} --}}">

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
    e.preventDefault();

    const wajib = ['nama_barang','jumlah_barang'];

    for (let id of wajib) {
        if (!document.getElementById(id).value.trim()) {
            alert('⚠️ Mohon isi semua kolom wajib sebelum menyimpan.');
            return;
        }
    }

    if (confirm('Apakah data sudah benar dan ingin disimpan?')) {
        alert('✅ Data barang berhasil disimpan!');
        this.reset();
    }
});

document.getElementById('btnBatal').addEventListener('click', function() {
    if (confirm('Apakah Anda yakin ingin membatalkan pengisian data?')) {
        alert('❌ Pengisian data dibatalkan.');
        window.history.back();
    }
});
</script>

@endsection