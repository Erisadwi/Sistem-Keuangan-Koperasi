@extends('layouts.app-admin-add4')

@section('title', 'Tambah Data Anggota')
@section('back-title', 'Master Data >')
@section('title-1', 'Data Anggota')
@section('sub-title', 'Tambah Data Anggota')

@section('content')

<div class="form-container">
    <form id="formDataAnggota" action="#" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-grid">
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan nama lengkap" required>
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username" required>
            </div>

            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <div class="form-group">
                <label for="tempat_lahir">Tempat Lahir</label>
                <input type="text" id="tempat_lahir" name="tempat_lahir" placeholder="Masukkan tempat lahir" required>
            </div>

            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" required>
            </div>

            <div class="form-group">
                <label for="status">Status Perkawinan</label>
                <select id="status" name="status" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="Belum Kawin">Belum Kawin</option>
                    <option value="Kawin">Kawin</option>
                    <option value="Cerai Hidup">Cerai Hidup</option>
                    <option value="Cerai Mati">Cerai Mati</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <div class="form-group">
                <label for="departemen">Departemen</label>
                <select id="departemen" name="departemen" required>
                    <option value="">-- Pilih Departemen --</option>
                    <option value="Produksi BOPP">Produksi BOPP</option>
                    <option value="Produksi Slitting">Produksi Slitting</option>
                    <option value="WH">WH</option>
                    <option value="QA">QA</option>
                    <option value="HRD">HRD</option>
                    <option value="GA">GA</option>
                    <option value="Purchasing">Purchasing</option>
                    <option value="Accounting">Accounting</option>
                    <option value="Engineering">Engineering</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <div class="form-group">
                <label for="pekerjaan">Pekerjaan</label>
                <select id="pekerjaan" name="pekerjaan" required>
                    <option value="">-- Pilih Pekerjaan --</option>
                    <option value="TNI">TNI</option>
                    <option value="PNS">PNS</option>
                    <option value="Karyawan">Karyawan</option>
                    <option value="Guru">Guru</option>
                    <option value="Buruh">Buruh</option>
                    <option value="Mengurus Rumah Tangga">Mengurus Rumah Tangga</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <div class="form-group">
                <label for="agama">Agama</label>
                <select id="agama" name="agama" required>
                    <option value="">-- Pilih Agama --</option>
                    <option value="Islam">Islam</option>
                    <option value="Kristen Protestan">Kristen Protestan</option>
                    <option value="Katolik">Katolik</option>
                    <option value="Hindu">Hindu</option>
                    <option value="Buddha">Buddha</option>
                    <option value="Konghucu">Konghucu</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" id="alamat" name="alamat" placeholder="Masukkan alamat" required>
            </div>

            <div class="form-group">
                <label for="kota">Kota</label>
                <input type="text" id="kota" name="kota" placeholder="Masukkan kota" required>
            </div>

            <div class="form-group">
                <label for="no_telp">No. Telp / HP</label>
                <input type="text" id="no_telp" name="no_telp" placeholder="Masukkan nomor telepon" required>
            </div>

            <div class="form-group">
                <label for="tgl_registrasi">Tanggal Registrasi</label>
                <input type="date" id="tgl_registrasi" name="tgl_registrasi" required>
            </div>

            <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <select id="jabatan" name="jabatan" required>
                    <option value="">-- Pilih Jabatan --</option>
                    <option value="Ketua">Ketua</option>
                    <option value="Sekretaris">Sekretaris</option>
                    <option value="Bendahara">Bendahara</option>
                    <option value="Anggota">Anggota</option>
                    <option value="Karyawan">Karyawan</option>
                    <option value="Pengawas">Pengawas</option>
                    <option value="Perusahaan">Perusahaan</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>
            </div>

            <div class="form-group">
                <label for="tgl_keluar">Tanggal Keluar</label>
                <input type="date" id="tgl_keluar" name="tgl_keluar">
            </div>

            <div class="form-group">
                <label for="aktif_keanggotaan">Aktif Keanggotaan</label>
                <select id="aktif_keanggotaan" name="aktif_keanggotaan" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="Aktif">Aktif</option>
                    <option value="Non Aktif">Non Aktif</option>
                </select>
            </div>

            <div class="form-group">
                <label for="foto">Foto (Opsional, maks. 5MB)</label>
                <input type="file" id="foto" name="foto" accept="image/*">
            </div>
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
    width: 900px;
    margin-left: 10px;
    margin-top: 55px;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
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
}

.btn-simpan { background-color: #25E11B; }
.btn-batal { background-color: #EA2828; }

.btn-simpan:hover { background-color: #45a049; }
.btn-batal:hover { background-color: #d73833; }
</style>

{{-- ========== VALIDASI JS ========== --}}
<script>
document.getElementById('formDataAnggota').addEventListener('submit', function(e) {
    e.preventDefault();

    const wajib = ['nama_lengkap','username','jenis_kelamin','tempat_lahir','tanggal_lahir','status',
                   'departemen','pekerjaan','agama','alamat','kota','no_telp','tgl_registrasi',
                   'jabatan','password','aktif_keanggotaan'];

    for (let id of wajib) {
        if (!document.getElementById(id).value.trim()) {
            alert('⚠️ Mohon isi semua kolom wajib sebelum menyimpan.');
            return;
        }
    }

    const foto = document.getElementById('foto').files[0];
    if (foto && foto.size > 5 * 1024 * 1024) {
        alert('⚠️ Ukuran foto melebihi 5MB.');
        return;
    }

    if (confirm('Apakah data sudah benar dan ingin disimpan?')) {
        alert('✅ Data anggota berhasil disimpan!');
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
