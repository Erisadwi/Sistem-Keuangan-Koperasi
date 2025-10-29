@extends('layouts.app-admin-add')

@section('title', 'Tambah Data Pengguna')
@section('back-url', url('admin/master_data/data-pengguna'))
@section('back-title', 'Master Data >')
@section('title-1', 'Data Pengguna')
@section('sub-title', 'Edit Data Pengguna')

@section('content')

<div class="form-container">
        <form id="formTambahUsers" action="{{ route('data-user.update', $user->id_user) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" 
                       value="{{ old('nama_lengkap', $user->nama_lengkap ?? '') }}" required>
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" 
                       value="{{ old('username', $user->username ?? '') }}" required>
            </div>

            <div class="form-group">
            <label>Role</label>
                <select name="id_role" required>
                        <option value="">-- Pilih Role --</option>
                @foreach($roles as $role)
                        <option value="{{ $role->id_role }}" {{ old('id_role', $user->id_role) == $role->id_role ? 'selected' : '' }}>
                        {{ $role->nama_role }}
                        </option>
                @endforeach
                </select>
            </div>

           <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="L" {{ old('jenis_kelamin', $user->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin', $user->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="alamat_user">Alamat</label>
                <input type="text" id="alamat_user" name="alamat_user" 
                       value="{{ old('alamat_user', $user->alamat_user ?? '') }}" required>
            </div>

             <div class="form-group">
                <label for="telepon">No Telepon</label>
                <input type="text" id="telepon" name="telepon" 
                       value="{{ old('telepon', $user->telepon ?? '') }}" required>
            </div>

            <div class="form-group">
                <label for="tanggal_masuk">Tanggal Masuk</label>
                <input type="date" id="tanggal_masuk" name="tanggal_masuk" 
                       value="{{ old('tanggal_masuk', $user->tanggal_masuk ?? '') }}">
            </div>


           <div class="form-group">
                <label for="password">Password (kosongkan jika tidak ingin diubah)</label>
                <input type="password" id="password" name="password" class="form-control">
            </div>

            <div class="form-group">
                <label for="tanggal_keluar">Tanggal Keluar</label>
                <input type="date" id="tanggal_keluar" name="tanggal_keluar" 
                       value="{{ old('tanggal_keluar', $user->tanggal_keluar ?? '') }}">
            </div>

            <div class="form-group">
                <label for="status">Status Keanggotaan</label>
                <select id="status" name="status" required>
                    <option value="aktif" {{ old('status', $user->status ?? '') == 'aktif' ? 'selected' : '' }}>aktif</option>
                    <option value="nonaktif" {{ old('status', $user->status ?? '') == 'nonaktif' ? 'selected' : '' }}>nonaktif</option>
                </select>
            </div>

            <div class="form-group">
                <label for="foto_user">Foto Pengguna</label>
                    @if (!empty($user->foto_user))
                    <div style="margin-bottom: 10px;">
                    <img src="{{ asset('storage/foto_user/' . $user->foto_user) }}" 
                    alt="Foto pengguna" 
                    width="120" 
                    style="border-radius: 8px;">
                    </div>
                    @endif
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
document.getElementById('formTambahUsers').addEventListener('submit', function(e) {
    const wajib = ['nama_lengkap','username','id_role','jenis_kelamin','alamat_user','telepon','tanggal_masuk','password','tanggal_keluar','status''foto_user'];

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
