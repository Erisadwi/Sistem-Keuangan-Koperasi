@extends('layouts.app-admin-add')

@section('title', 'Edit Data Anggota')
@section('back-url', url('admin/master_data/data-anggota')) 
@section('back-title', 'Master Data >')
@section('title-1', 'Data Anggota')
@section('sub-title', 'Edit Data Anggota')

@section('content')

<div class="form-container">
    <form id="formEditAnggota" action="{{ route('admin.anggota.update', $anggota->id_anggota) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

        <div class="form-grid">
             <div class="form-group">
                <label for="nama_anggota">Nama Lengkap</label>
                <input type="text" id="nama_anggota" name="nama_anggota" 
                       value="{{ old('nama_anggota', $anggota->nama_anggota ?? '') }}" required>
            </div>

            <div class="form-group">
                <label for="username_anggota">Username</label>
                <input type="text" id="username_anggota" name="username_anggota" 
                       value="{{ old('username_anggota', $anggota->username_anggota ?? '') }}" required>
            </div>

            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="L" {{ old('jenis_kelamin', $anggota->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin', $anggota->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="tempat_lahir">Tempat Lahir</label>
                <input type="text" id="tempat_lahir" name="tempat_lahir" 
                       value="{{ old('tempat_lahir', $anggota->tempat_lahir ?? '') }}" >
            </div>

            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" 
                       value="{{ old('tanggal_lahir', $anggota->tanggal_lahir ?? '') }}">
            </div>
        
            <div class="form-group">
                <label for="status_perkawinan">Status Perkawinan</label>
                <select id="status_perkawinan" name="status_perkawinan">
                    @foreach(['BELUM KAWIN','KAWIN','CERAI HIDUP','CERAI MATI','LAINNYA'] as $s)
                        <option value="{{ $s }}" {{ old('status_perkawinan', $anggota->status_perkawinan ?? '') == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="departemen">Departemen</label>
                <select id="departemen" name="departemen">
                    <option value="">-- Pilih Departemen --</option>
                    @foreach(['PRODUKSI BOPP','PRODUKSI SLITTING','WH','QA','HRD','GA','PURCHASING','ACCOUNTING','ENGINEERING'] as $d)
                        <option value="{{ $d }}" {{ old('departemen', $anggota->departemen ?? '') == $d ? 'selected' : '' }}>{{ $d }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="pekerjaan">Pekerjaan</label>
                <select id="pekerjaan" name="pekerjaan">
                    @foreach(['TNI','PNS','KARYAWAN SWASTA','GURU','BURUH','TANI','PEDAGANG','WIRASWASTA','MENGURUS RUMAH TANGGA','LAINNYA','PENSIUNAN','PENJAHIT'] as $p)
                        <option value="{{ $p }}" {{ old('pekerjaan', $anggota->pekerjaan ?? '') == $p ? 'selected' : '' }}>{{ $p }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="agama">Agama</label>
                <select id="agama" name="agama">
                    @foreach(['ISLAM','KATOLIK','PROTESTAN','HINDU','BUDHA','LAINNYA'] as $a)
                        <option value="{{ $a }}" {{ old('agama', $anggota->agama ?? '') == $a ? 'selected' : '' }}>{{ $a }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="alamat_anggota">Alamat</label>
                <input type="text" id="alamat_anggota" name="alamat_anggota" 
                       value="{{ old('alamat_anggota', $anggota->alamat_anggota ?? '') }}">
            </div>

            <div class="form-group">
                <label for="kota_anggota">Kota</label>
                <input type="text" id="kota_anggota" name="kota_anggota" 
                       value="{{ old('kota_anggota', $anggota->kota_anggota ?? '') }}">
            </div>

            <div class="form-group">
                <label for="no_telepon">No Telepon</label>
                <input type="text" id="no_telepon" name="no_telepon" 
                       value="{{ old('no_telepon', $anggota->no_telepon ?? '') }}">
            </div>

            <div class="form-group">
                <label for="tanggal_registrasi">Tanggal Registrasi</label>
                <input type="date" id="tanggal_registrasi" name="tanggal_registrasi" 
                       value="{{ old('tanggal_registrasi', $anggota->tanggal_registrasi ?? '') }}">
            </div>

            <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <select id="jabatan" name="jabatan">
                    @foreach(['KETUA','SEKRETARIS','BENDAHARA','PENGAWAS','KARYAWAN','PERUSAHAAN'] as $j)
                        <option value="{{ $j }}" {{ old('jabatan', $anggota->jabatan ?? '') == $j ? 'selected' : '' }}>{{ $j }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="password_anggota">Password (Opsional)</label>
                <input type="password" id="password_anggota" name="password_anggota" placeholder="Kosongkan jika tidak diubah">
            </div>

            <div class="form-group">
                <label for="tanggal_keluar">Tanggal Keluar</label>
                <input type="date" id="tanggal_keluar" name="tanggal_keluar" 
                       value="{{ old('tanggal_keluar', $anggota->tanggal_keluar ?? '') }}">
            </div>

            <div class="form-group">
                <label for="status_anggota">Aktif Keanggota</label>
                <select id="status_anggota" name="status_anggota" required>
                    <option value="AKTIF" {{ old('status_anggota', $anggota->status_anggota ?? '') == 'AKTIF' ? 'selected' : '' }}>AKTIF</option>
                    <option value="NON AKTIF" {{ old('status_anggota', $anggota->status_anggota ?? '') == 'NON AKTIF' ? 'selected' : '' }}>NON AKTIF</option>
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
    width: 98%;
    margin-left: 10px;
    margin-top: 40px;
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
    margin-top: 50px;
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
    const wajib = ['nama_anggota','username_anggota','jenis_kelamin','status_anggota'];

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

