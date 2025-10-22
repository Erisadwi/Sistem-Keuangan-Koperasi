@extends('layouts.app-admin-add3')

@section('title', 'Penarikan Tunai')  
@section('back-title', 'Transaksi Simpanan >')
@section('title-1', 'Penarikan Tunai')  
@section('sub-title', 'Edit Data Penarikan Tunai')  

@section('content')

<div class="form-container">
    <form id="formPenarikanTunai" action="#" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- @method('PUT') --}}

        {{-- Bagian Tanggal Transaksi --}}
        <label for="tanggal_transaksi">Tanggal Transaksi</label>
        <input type="datetime-local" id="tanggal_transaksi" name="tanggal_transaksi" 
            value="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" required>

        <hr style="margin:20px 0; border:1px solid #ccc;">

        {{-- Identitas Anggota --}}
        <h4 style="font-size:14px; margin-bottom:10px;">Identitas Anggota</h4>

        <label for="nama_anggota">Nama Anggota</label>
        <input type="text" id="nama_anggota" name="nama_anggota" placeholder="Masukkan nama anggota" required>

        <label for="jenis_simpanan">Jenis Simpanan</label>
        <select name="jenis_simpanan" id="jenis_simpanan" required>
            <option value="" disabled selected>-- Pilih Jenis Simpanan --</option>
            <option value="wajib">Simpanan Wajib</option>
            <option value="pokok">Simpanan Pokok</option>
            <option value="sukarela">Simpanan Sukarela</option>
        </select>

        <label for="jumlah_penarikan">Jumlah Penarikan</label>
        <input type="number" id="jumlah_penarikan" name="jumlah_penarikan" placeholder="Masukkan jumlah penarikan" required>

        <label for="keterangan">Keterangan</label>
        <input type="text" id="keterangan" name="keterangan" placeholder="Masukkan keterangan (opsional)">

        <label for="ambil_dari_kas">Ambil Dari Kas</label>
        <select name="ambil_dari_kas" id="ambil_dari_kas" required>
            <option value="" disabled selected>-- Pilih Kas --</option>
            <option value="kas_besar">Kas Besar</option>
            <option value="bank_mandiri">Bank Mandiri</option>
            <option value="kas_kecil">Kas Kecil</option>
            <option value="kas_niaga">Kas Niaga</option>
            <option value="bank_bri">Bank BRI</option>
        </select>

        <hr style="margin:20px 0; border:1px solid #ccc;">

        {{-- Identitas Penerima --}}
        <h4 style="font-size:14px; margin-bottom:10px;">Identitas Penerima</h4>

        <label for="nama_kuasa">Nama Kuasa</label>
        <input type="text" id="nama_kuasa" name="nama_kuasa" placeholder="Masukkan nama kuasa" required>

        <label for="nomor_id_kuasa">Nomor ID Kuasa</label>
        <input type="text" id="nomor_id_kuasa" name="nomor_id_kuasa" placeholder="Masukkan nomor identitas" required>

        <label for="alamat_kuasa">Alamat Kuasa</label>
        <textarea id="alamat_kuasa" name="alamat_kuasa" rows="2" placeholder="Masukkan alamat kuasa"
            required
            style="width:100%; padding:8px; border:1px solid #565656; border-radius:5px;
                   font-size:13px; background-color:#fff; margin-bottom:15px;"></textarea>

        <label for="photo">Photo</label>
        <input type="file" id="photo" name="photo" accept="image/*" required
            style="border:1px solid #565656; border-radius:5px; padding:6px; width:100%; font-size:13px; margin-bottom:20px;">

        {{-- Tombol Simpan & Batal --}}
        <div class="form-buttons">
            <button type="submit" id="btnSimpan" class="btn btn-simpan">Simpan</button>
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

label {
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 5px;
    display: block;
    color: #000000;
}

input[type="text"],
input[type="datetime-local"],
input[type="number"],
input[type="file"],
select,
textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #565656;
    border-radius: 5px;
    font-size: 13px;
    background-color: #fff;
}

input:focus,
select:focus,
textarea:focus {
    border-color: #565656;
    outline: none;
}

.form-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 40px;
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
// Validasi form & konfirmasi simpan
document.getElementById('formPenarikanTunai').addEventListener('submit', function(e) {
    e.preventDefault();

    const requiredFields = this.querySelectorAll('[required]');
    let valid = true;

    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            valid = false;
            field.style.borderColor = 'red';
        } else {
            field.style.borderColor = '#565656';
        }
    });

    if (!valid) {
        alert('⚠️ Harap lengkapi semua data wajib sebelum menyimpan!');
        return;
    }

    if (confirm('Apakah Anda yakin ingin menyimpan data penarikan tunai ini?')) {
        alert('✅ Data penarikan tunai berhasil disimpan!');
        // this.submit(); // aktifkan jika ingin kirim ke backend
    }
});

// Tombol batal
document.getElementById('btnBatal').addEventListener('click', function() {
    if (confirm('Apakah Anda yakin ingin membatalkan pengisian data?')) {
        alert('❌ Pengisian data dibatalkan.');
        window.history.back();
    }
});
</script>

@endsection
