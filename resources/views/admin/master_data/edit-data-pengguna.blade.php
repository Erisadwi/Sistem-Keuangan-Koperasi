@extends('layouts.app-admin-add')

@section('title', 'Data Pengguna')  
@section('back-url', url('admin/master_data/data-pengguna')) 
@section('back-title', 'Master Data >')
@section('title-1', 'Data Pengguna')  
@section('sub-title', 'Edit Data Pengguna')  

@section('content')

<div class="form-container">
    <div class="form-wrapper">
    <form id="formDataPengguna" action="# {{-- {{ route('Edit-data-pengguna.store', $data_pengguna->id) }} --}}" method="POST">
        @csrf

            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap*</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap">
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username">
            </div>

            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin*</label>
                <select id="jenis_kelamin" name="jenis_kelamin">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" id="alamat" name="alamat">
            </div>

            <div class="form-group">
                <label for="nomor_telepon">Nomor Telepon/HP</label>
                <input type="text" id="nomor_telepon" name="nomor_telepon">
            </div>

            <div class="form-group">
                <label for="tanggal_masuk">Tanggal Masuk</label>
                <input type="datetime-local" id="tanggal_masuk" name="tanggal_masuk">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
            </div>

            <div class="form-group">
                <label for="tanggal_keluar">Tanggal Keluar</label>
                <input type="datetime-local" id="tanggal_keluar" name="tanggal_keluar">
            </div>

            <div class="form-group">
                <label for="is_active">Status Keanggotaan*</label>
                <select id="is_active" name="is_active">
                    <option value="">Pilih Status Keanggotaan</option>
                    <option value="Aktif">Aktif</option>
                    <option value="Non Aktif">Non Aktif</option>
                </select>
            </div>

            <div class="form-group">
                <label for="foto">Foto Pengguna</label>
                <input type="file" id="foto" name="foto" accept="image/*">
            </div>

            <div class="form-buttons">
                <button type="submit" class="btn btn-simpan">Simpan</button>
                <a href="# {{-- {{ route('data-pengguna.index') }} --}}" class="btn btn-batal">Batal</a>
        </div>
        </form>
    </div>
</div>

<style>
.form-container {
    background-color: transparent;
    width: 98%;
    margin-left: 10px;
    margin-top: 40px;
}

.form-wrapper {
    background-color: #c7dbe6; /* tetap biru muda */
    border-radius: 8px;
    padding: 20px;
    box-sizing: border-box;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 5px;
    color: #000;
}

input[type="text"],
input[type="password"],
input[type="file"],
input[type="datetime-local"],
select {
    width: 100%;
    padding: 8px;
    border: 1px solid #565656;
    border-radius: 5px;
    font-size: 13px;
    background-color: #fff;
    box-sizing: border-box;
}

input:focus, select:focus {
    outline: none;
    border-color: #1976d2;
    box-shadow: 0 0 2px rgba(25, 118, 210, 0.5);
}

.form-buttons {
    display: flex;
    justify-content: flex-end; 
    gap: 10px;
    margin-top: 40px;
}

.btn {
    padding: 8px 0;
    width: 110px;
    font-size: 14px;
    font-weight: bold;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    color: #fff;
    box-shadow: 0 3px 4px rgba(0, 0, 0, 0.2);
    text-align: center;
}

.btn-simpan {
    background-color: #25E11B;
}

.btn-simpan:hover {
    background-color: #1db115;
}

.btn-batal {
    background-color: #EA2828;
}

.btn-batal:hover {
    background-color: #c71e1e;
}

.form-wrapper::-webkit-scrollbar {
    width: 8px;
}
.form-wrapper::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 5px;
}
.form-wrapper::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>

<script>
document.getElementById(''formDataPengguna').addEventListener('submit', function(e) {
    const wajib = ['username'];

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
<script>

@endsection