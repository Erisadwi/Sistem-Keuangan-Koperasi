@extends('layouts.app-admin-add')

@section('title', 'Tambah Data Pengguna')
@section('back-url', url('admin/master_data/data-pengguna'))
@section('back-title', 'Master Data >')
@section('title-1', 'Data Pengguna')
@section('sub-title', 'Tambah Data Pengguna')

@section('content')

<div class="form-container">
    <form id="formTambahPengguna" action="{{ route('anggota.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-grid">
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
            <label for="id_role">Role</label>
            <select id="id_role" name="id_role" required>
                <option value="">-- Pilih Role --</option>
                <option value="1" {{ old('id_role') == '1' ? 'selected' : '' }}>Admin Simpanan</option>
                <option value="2" {{ old('id_role') == '2' ? 'selected' : '' }}>Admin Pinjaman</option>
                <option value="3" {{ old('id_role') == '3' ? 'selected' : '' }}>Admin Accounting</option>
                <option value="4" {{ old('id_role') == '4' ? 'selected' : '' }}>Pengurus</option>
            </select>
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
                       value="{{ old('alamat_user') }}">
            </div>

            <div class="form-group">
                <label for="telepon">No Telepon</label>
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
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>
            </div>

            <div class="form-group">
                <label for="tanggal_keluar">Tanggal Keluar</label>
                <input type="date" id="tanggal_keluar" name="tanggal_keluar" 
                        value="{{ old('tanggal_keluar') }}">
            </div>

            <div class="form-group">
                <label for="status">Status Keanggotaan</label>
                <select id="status" name="status">
                    <option value="">-- Aktif --</option>
                    @foreach(['aktif','nonaktif'] as $s)
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
            <a href="{{ route('anggota.index') }}" class="btn btn-batal">Batal</a>
        </div>
    </form>
</div>

<style>
.form-container {
    background-color: transparent;
    padding: 20px;
    border-radius: 10px;
    width: 98%;
    margin-left: 10px;
    margin-top: 40px;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 15px 25px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

label {
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
    width: 120px;
    cursor: pointer;
    color: #fff;
    box-shadow: 0 4px 4px rgba(0,0,0,0.3);
    text-align: center;
    text-decoration: none;
}

.btn-simpan { background-color: #25E11B; }
.btn-batal { background-color: #EA2828; }

.btn-simpan:hover { background-color: #45a049; }
.btn-batal:hover { background-color: #d73833; }
</style>

{{-- ========== VALIDASI JS ========== --}}
<script>
document.getElementById('formDataAnggota').addEventListener('submit', function(e) {
    const wajib = ['nama_anggota','username_anggota','password_anggota','jenis_kelamin','status_anggota','alamat_anggota','kota_anggota','tempat_lahir','tanggal_lahir','jabatan','tanggal_registrasi''status_anggota'];


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
</script>

@endsection
