@extends('layouts.app-admin-add')

@section('title', 'Data Pengguna')  
@section('back-url', url('admin/master_data/data-pengguna'))
@section('back-title', 'Master Data >')
@section('title-1', 'Data Pengguna')  
@section('sub-title', 'Tambah Data Pengguna')  

@section('content')

<div class="form-container">
    <form id="formTambahUsers" action="{{--{{ route('users.store') }}--}}" method="POST" enctype="multipart/form-data">
        @csrf

            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" 
                       value="{{ old('nama_lengkap') }}" required>
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" 
                       value="{{ old('username') }}" required>
            </div>

            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="alamat_user">Alamat</label>
                <input type="text" id="alamat_user" name="alamat_user" 
                       value="{{ old('alamat_anggota') }}">
            </div>

             <div class="form-group">
                <label for="telepon">No Telepon/HP</label>
                <input type="text" id="telepon" name="telepon" 
                       value="{{ old('telepon') }}">
            </div>

            <div class="form-group">
                <label for="tanggal_masuk">Tanggal Masuk</label>
                <input type="date" id="tanggal_masuk" name="tanggal_masuk" 
                       value="{{ old('tanggal_masuk', date('Y-m-d')) }}">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="tanggal_keluar">Tanggal Keluar</label>
                <input type="date" id="tanggal_keluar" name="tanggal_keluar" 
                       value="{{ old('tanggal_keluar', date('Y-m-d')) }}">
            </div>

            <div class="form-group">
                <label for="status">Status Keanggotaan</label>
                <select id="status" name="status">
                    <option value="">-- Aktif --</option>
                    @foreach(['Aktif','Non Aktif'] as $s)
                        <option value="{{ $s }}" {{ old('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="foto_user">Foto Pengguna</label>
                <input type="file" id="foto_user" name="foto_user" accept="image/*">
            </div>

            <div class="form-buttons">
            <button type="submit" class="btn btn-simpan">Simpan</button>
            <button type="button" id="btnBatal" class="btn btn-batal">Batal</button>
        </div>
        </form>
    </div>

<style>
.form-container {
    background-color: transparent;
    padding: 20px;
    border-radius: 10px;
    width: 100%;
    margin-left: 10px;
    margin-top: 40px;
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
input[type="date"],
input[type="password"],
select,
input[type="file"] {
    width: 100%;
    padding: 9px;
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
    margin-top: 30px; 
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

    alert('✅ Data berhasil disimpan!');
});
<script>

@endsection