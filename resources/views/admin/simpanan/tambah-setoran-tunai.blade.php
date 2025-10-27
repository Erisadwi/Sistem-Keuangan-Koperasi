@extends('layouts.app-admin-add')

@section('title', 'Simpanan Setoran Tunai')  
@section('back-url', url('admin/simpanan/setoran-tunai')) 
@section('back-title', 'Transaksi Simpanan >')
@section('title-1', 'Setoran Tunai')  
@section('sub-title', 'Tambah Data Setoran Tunai')  

@section('content')

<div class="form-container">
    <form id="formSetoranTunai" action="#" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Bagian Tanggal Transaksi --}}
        <label for="tanggal_transaksi">Tanggal Transaksi</label>
        <input type="datetime-local" id="tanggal_transaksi" name="tanggal_transaksi" 
            value="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" required>

        <hr style="margin:20px 0; border:1px solid #ccc;">

        {{-- Identitas Penyetor --}}
        <h4 style="font-size:14px; margin-bottom:10px;">Identitas Penyetor</h4>

        <label for="nama_penyetor">Nama Penyetor</label>
        <input type="text" id="nama_penyetor" name="nama_penyetor" placeholder="Masukkan nama penyetor" 
            value="{{ $simpanan->nama_anggota ?? '' }}" required>

        <label for="nomor_identitas">Nomor Identitas</label>
        <input type="text" id="nomor_identitas" name="nomor_identitas" placeholder="Masukkan nomor identitas" 
            value="{{ $simpanan->nomor_identitas ?? '' }}" required>

        <label for="alamat">Alamat</label>
        <textarea id="alamat" name="alamat" rows="2" placeholder="Masukkan alamat penyetor"
            required
            style="width:100%; padding:8px; border:1px solid #565656; border-radius:5px;
                   font-size:13px; background-color:#fff; margin-bottom:15px;"></textarea>

        <hr style="margin:20px 0; border:1px solid #ccc;">

        {{-- Identitas Penerima --}}
        <h4 style="font-size:14px; margin-bottom:10px;">Identitas Penerima</h4>

        <label for="nama_anggota">Nama Anggota</label>
        <input type="text" id="nama_anggota" name="nama_anggota" placeholder="Masukkan nama anggota"
            value="{{ $simpanan->nama_anggota ?? '' }}" required>

        <label for="jenis_simpanan">Jenis Simpanan</label>
        <select name="jenis_simpanan" id="jenis_simpanan" required>
            <option value="" disabled {{ !isset($simpanan->jenis_simpanan) ? 'selected' : '' }}>-- Pilih Jenis Simpanan --</option>
            <option value="wajib" {{ (isset($simpanan->jenis_simpanan) && $simpanan->jenis_simpanan == 'wajib') ? 'selected' : '' }}>Simpanan Wajib</option>
            <option value="pokok" {{ (isset($simpanan->jenis_simpanan) && $simpanan->jenis_simpanan == 'pokok') ? 'selected' : '' }}>Simpanan Pokok</option>
            <option value="sukarela" {{ (isset($simpanan->jenis_simpanan) && $simpanan->jenis_simpanan == 'sukarela') ? 'selected' : '' }}>Simpanan Sukarela</option>
        </select>

        <label for="jumlah_simpanan">Jumlah Simpanan</label>
        <input type="number" id="jumlah_simpanan" name="jumlah_simpanan" placeholder="Masukkan jumlah setoran" 
            value="{{ $simpanan->jumlah_simpanan ?? '' }}" required>

        <label for="keterangan">Keterangan</label>
        <input type="text" id="keterangan" name="keterangan" 
            value="{{ $simpanan->keterangan ?? '' }}" placeholder="Opsional...">

        <label for="jenisAkunTransaksi_tujuan">Simpan Ke Kas</label>
        <select name="jenisAkunTransaksi_tujuan" id="jenisAkunTransaksi_tujuan" required>
            <option value="" disabled {{ !isset($simpanan->jenisAkunTransaksi_tujuan) ? 'selected' : '' }}>-- Pilih Kas --</option>
            <option value="kas_besar" {{ (isset($simpanan->jenisAkunTransaksi_tujuan) && $simpanan->jenisAkunTransaksi_tujuan == 'kas_besar') ? 'selected' : '' }}>Kas Besar</option>
            <option value="bank_mandiri" {{ (isset($simpanan->jenisAkunTransaksi_tujuan) && $simpanan->jenisAkunTransaksi_tujuan == 'bank_mandiri') ? 'selected' : '' }}>Bank Mandiri</option>
            <option value="kas_kecil" {{ (isset($simpanan->jenisAkunTransaksi_tujuan) && $simpanan->jenisAkunTransaksi_tujuan == 'kas_kecil') ? 'selected' : '' }}>Kas Kecil</option>
            <option value="kas_niaga" {{ (isset($simpanan->jenisAkunTransaksi_tujuan) && $simpanan->jenisAkunTransaksi_tujuan == 'kas_niaga') ? 'selected' : '' }}>Kas Niaga</option>
            <option value="bank_bri" {{ (isset($simpanan->jenisAkunTransaksi_tujuan) && $simpanan->jenisAkunTransaksi_tujuan == 'bank_bri') ? 'selected' : '' }}>Bank BRI</option>
        </select>

        <label for="photo">Photo</label>
        <input type="file" id="photo" name="photo" accept="image/*" required
            style="border:1px solid #565656; border-radius:5px; padding:6px; width:100%; font-size:13px; margin-bottom:20px;">

        {{-- tampilkan jika photo sudah ada --}}
        @if(isset($simpanan->photo) && $simpanan->photo)
            <div style="margin-bottom:10px;">
                <img src="{{ asset('storage/' . $simpanan->photo) }}" alt="Foto Bukti" width="100" style="border-radius:5px;">
            </div>
        @endif
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
document.getElementById('formSetoranTunai').addEventListener('submit', function(e) {
    const wajib = ['nama_anggota', 'jenis_simpanan', 'jumlah_simpanan', 'jenisAkunTransaksi_tujuan'];

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
