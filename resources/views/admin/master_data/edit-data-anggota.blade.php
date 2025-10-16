@extends('layouts.app-admin-add4')

@section('title', 'Edit Data Anggota')
@section('back-title', 'Master Data >')
@section('title-1', 'Data Anggota')
@section('sub-title', 'Edit Data Anggota')

@section('content')

<div class="form-container">
    <form id="formEditAnggota" action="#" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" 
                       value="{{ old('nama_lengkap', $anggota->nama_lengkap ?? '') }}" required>
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" 
                       value="{{ old('username', $anggota->username ?? '') }}" required>
            </div>

            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="Laki-laki" {{ old('jenis_kelamin', $anggota->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin', $anggota->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    <option value="Lainnya" {{ old('jenis_kelamin', $anggota->jenis_kelamin ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <div class="form-group">
                <label for="tempat_lahir">Tempat Lahir</label>
                <input type="text" id="tempat_lahir" name="tempat_lahir" 
                       value="{{ old('tempat_lahir', $anggota->tempat_lahir ?? '') }}" required>
            </div>

            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" 
                       value="{{ old('tanggal_lahir', $anggota->tanggal_lahir ?? '') }}" required>
            </div>

            <div class="form-group">
                <label for="status">Status Perkawinan</label>
                <select id="status" name="status" required>
                    <option value="">-- Pilih Status --</option>
                    @foreach(['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati','Lainnya'] as $s)
                        <option value="{{ $s }}" {{ old('status', $anggota->status ?? '') == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="departemen">Departemen</label>
                <select id="departemen" name="departemen" required>
                    @php
                        $departemenList = ['Produksi BOPP','Produksi Slitting','WH','QA','HRD','GA','Purchasing','Accounting','Engineering','Lainnya'];
                    @endphp
                    <option value="">-- Pilih Departemen --</option>
                    @foreach($departemenList as $d)
                        <option value="{{ $d }}" {{ old('departemen', $anggota->departemen ?? '') == $d ? 'selected' : '' }}>{{ $d }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="pekerjaan">Pekerjaan</label>
                <select id="pekerjaan" name="pekerjaan" required>
                    @php
                        $pekerjaanList = ['TNI','PNS','Karyawan','Guru','Buruh','Mengurus Rumah Tangga','Lainnya'];
                    @endphp
                    <option value="">-- Pilih Pekerjaan --</option>
                    @foreach($pekerjaanList as $p)
                        <option value="{{ $p }}" {{ old('pekerjaan', $anggota->pekerjaan ?? '') == $p ? 'selected' : '' }}>{{ $p }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="agama">Agama</label>
                <select id="agama" name="agama" required>
                    @php
                        $agamaList = ['Islam','Kristen Protestan','Katolik','Hindu','Buddha','Konghucu','Lainnya'];
                    @endphp
                    <option value="">-- Pilih Agama --</option>
                    @foreach($agamaList as $a)
                        <option value="{{ $a }}" {{ old('agama', $anggota->agama ?? '') == $a ? 'selected' : '' }}>{{ $a }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" id="alamat" name="alamat" 
                       value="{{ old('alamat', $anggota->alamat ?? '') }}" required>
            </div>

            <div class="form-group">
                <label for="kota">Kota</label>
                <input type="text" id="kota" name="kota" 
                       value="{{ old('kota', $anggota->kota ?? '') }}" required>
            </div>

            <div class="form-group">
                <label for="no_telp">No. Telp / HP</label>
                <input type="text" id="no_telp" name="no_telp" 
                       value="{{ old('no_telp', $anggota->no_telp ?? '') }}" required>
            </div>

            <div class="form-group">
                <label for="tgl_registrasi">Tanggal Registrasi</label>
                <input type="date" id="tgl_registrasi" name="tgl_registrasi" 
                       value="{{ old('tgl_registrasi', $anggota->tgl_registrasi ?? '') }}" required>
            </div>

            <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <select id="jabatan" name="jabatan" required>
                    @php
                        $jabatanList = ['Ketua','Sekretaris','Bendahara','Anggota','Karyawan','Pengawas','Perusahaan','Lainnya'];
                    @endphp
                    <option value="">-- Pilih Jabatan --</option>
                    @foreach($jabatanList as $j)
                        <option value="{{ $j }}" {{ old('jabatan', $anggota->jabatan ?? '') == $j ? 'selected' : '' }}>{{ $j }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="password">Password (Opsional)</label>
                <input type="password" id="password" name="password" placeholder="Kosongkan jika tidak diubah">
            </div>

            <div class="form-group">
                <label for="tgl_keluar">Tanggal Keluar</label>
                <input type="date" id="tgl_keluar" name="tgl_keluar" 
                       value="{{ old('tgl_keluar', $anggota->tgl_keluar ?? '') }}">
            </div>

            <div class="form-group">
                <label for="aktif_keanggotaan">Aktif Keanggotaan</label>
                <select id="aktif_keanggotaan" name="aktif_keanggotaan" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="Aktif" {{ old('aktif_keanggotaan', $anggota->aktif_keanggotaan ?? '') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Non Aktif" {{ old('aktif_keanggotaan', $anggota->aktif_keanggotaan ?? '') == 'Non Aktif' ? 'selected' : '' }}>Non Aktif</option>
                </select>
            </div>

            <div class="form-group">
                <label for="foto">Foto (Opsional, maks. 5MB)</label>
                <input type="file" id="foto" name="foto" accept="image/*">
                @if(!empty($anggota->foto))
                    <small>Foto saat ini:</small><br>
                    <img src="{{ asset($anggota->foto) }}" alt="Foto" width="80" class="mt-1 rounded border">
                @endif
            </div>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn btn-simpan">Simpan</button>
            <button type="button" id="btnBatal" class="btn btn-batal">Batal</button>
        </div>
    </form>
</div>

{{-- Gunakan CSS yang sama persis --}}
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

<script>
document.getElementById('formEditAnggota').addEventListener('submit', function(e) {
    e.preventDefault();
    if (confirm('Apakah Anda yakin ingin menyimpan perubahan data ini?')) {
        alert('✅ Data anggota berhasil diperbarui!');
        this.submit();
    }
});

document.getElementById('btnBatal').addEventListener('click', function() {
    if (confirm('Apakah Anda yakin ingin membatalkan perubahan?')) {
        window.history.back();
    }
});
</script>

@endsection

