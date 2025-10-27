@extends('layouts.app-admin-add')

@section('title', 'Penarikan Tunai')  
@section('back-url', url('admin/simpanan/penarikan-tunai')) 
@section('back-title', 'Transaksi Simpanan >')
@section('title-1', 'Penarikan Tunai')  
@section('sub-title', 'Edit Data Penarikan Tunai')  

@section('content')

<div class="form-container">
    <form id="formEditSetoranTunai"
          action="#" {{-- nanti diganti route('simpanan.update', $simpanan->id) --}}
          method="POST" enctype="multipart/form-simpanan">
        @csrf
        {{-- @method('PUT') --}}

        {{-- Bagian Tanggal Transaksi --}}
        <label for="tanggal_transaksi">Tanggal Transaksi</label>
        <input type="datetime-local" id="tanggal_transaksi" name="tanggal_transaksi"
            value="{{ isset($simpanan->tanggal_transaksi) ? \Carbon\Carbon::parse($simpanan->tanggal_transaksi)->format('Y-m-d\TH:i') : '' }}" required>

        <hr style="margin:20px 0; border:1px solid #ccc;">

        {{-- Identitas Anggota --}}
        <h4 style="font-size:14px; margin-bottom:10px;">Identitas Anggota</h4>

        <label for="nama_anggota">Nama Anggota</label>
        <input type="text" id="nama_anggota" name="nama_anggota"
            value="{{ $simpanan->nama_anggota ?? '' }}" required>

        <label for="jenis_simpanan">Jenis Simpanan</label>
        <select name="jenis_simpanan" id="jenis_simpanan" required>
            <option value="" disabled {{ !isset($simpanan->jenis_simpanan) ? 'selected' : '' }}>-- Pilih Jenis Simpanan --</option>
            <option value="wajib" {{ (isset($simpanan->jenis_simpanan) && $simpanan->jenis_simpanan == 'wajib') ? 'selected' : '' }}>Simpanan Wajib</option>
            <option value="pokok" {{ (isset($simpanan->jenis_simpanan) && $simpanan->jenis_simpanan == 'pokok') ? 'selected' : '' }}>Simpanan Pokok</option>
            <option value="sukarela" {{ (isset($simpanan->jenis_simpanan) && $simpanan->jenis_simpanan == 'sukarela') ? 'selected' : '' }}>Simpanan Sukarela</option>
        </select>

        <label for="jumlah_penarikan">Jumlah Penarikan</label>
        <input type="number" id="jumlah_penarikan" name="jumlah_penarikan"
            value="{{ $simpanan->jumlah_penarikan ?? '' }}" required>

        <label for="keterangan">Keterangan</label>
        <input type="text" id="keterangan" name="keterangan"
            value="{{ $simpanan->keterangan ?? '' }}" placeholder="Opsional...">

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
    width: 98%;
    margin-left: 10px;
    margin-top: 40px;
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
document.getElementById('formPenarikanTunai').addEventListener('submit', function(e) {
    const wajib = [''];

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
