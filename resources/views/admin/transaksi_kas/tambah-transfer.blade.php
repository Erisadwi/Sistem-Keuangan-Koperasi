@extends('layouts.app-admin-add')

@section('title', 'Transaksi Kas')  
@section('back-url', url('admin/transaksi_kas/transfer')) 
@section('back-title', 'Transaksi Kas >')
@section('title-1', 'Transfer')  
@section('sub-title', 'Tambah Data Transfer')  

@section('content')

<div class="form-container">
    <form action="# {{-- {{ route('tambah-transfer-kas.store', $transaksi->id) }} --}}" method="POST">
        @csrf

        <label for="tanggal_transaksi">Tanggal Transaksi</label>
        <input type="datetime-local" id="tanggal_transaksi" name="tanggal_transaksi" 
                value="{{ isset($transaksi) ? \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('Y-m-d\TH:i') : '' }}">

        <label for="jumlah_transaksi">Jumlah</label>
        <input type="number" id="jumlah_transaksi" name="jumlah_transaksi" value=" {{-- {{ isset($transaksi) ? number_format($transaksi->jumlah_transaksi, 0, ',', '.') : '' }} --}}">

        <label for="ket_transaksi">Keterangan</label>
        <input type="text" id="ket_transaksi" name="ket_transaksi" value="{{-- {{ $transaksi->keterangan }} --}}">

        <label for="id_jenisAkunTransaksi_sumber">Dari Kas</label>
            <select name="id_jenisAkunTransaksi_sumber" id="id_jenisAkunTransaksi_sumber">
                <option value="" disabled {{ empty($transaksi->id_jenisAkunTransaksi_sumber) ? 'selected' : '' }}>Pilih Jenis Kas</option>
                <option value="kas_besar" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == 'kas_besar' ? 'selected' : '' }}>Kas Besar</option>
                <option value="bank_mandiri" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == 'bank_mandiri' ? 'selected' : '' }}>Bank Mandiri</option>
                <option value="kas_kecil" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == 'kas_kecil' ? 'selected' : '' }}>Kas Kecil</option>
                <option value="kas_niaga" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == 'kas_niaga' ? 'selected' : '' }}>Kas Niaga</option>
                <option value="bank_bni" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == 'bank_bni' ? 'selected' : '' }}>Bank BNI</option>
            </select>


        <label for="id_jenisAkunTransaksi_tujuan">Untuk Kas</label>
            <select name="id_jenisAkunTransaksi_tujuan" id="id_jenisAkunTransaksi_tujuan">
                <option value="" disabled {{ empty($transaksi->id_jenisAkunTransaksi_tujuan) ? 'selected' : '' }}>Pilih Jenis Kas</option>
                <option value="kas_besar"{{ ($transaksi->id_jenisAkunTransaksi_tujuan ?? '') == 'kas_besar' ? 'selected' : '' }}>Kas Besar</option>
                <option value="bank_mandiri"{{ ($transaksi->id_jenisAkunTransaksi_tujuan ?? '') == 'bank_mandiri' ? 'selected' : '' }}>Bank Mandiri</option>
                <option value="kas_kecil"{{ ($transaksi->id_jenisAkunTransaksi_tujuan ?? '') == 'kas_kecil' ? 'selected' : '' }}>Kas Kecil</option>
                <option value="kas_niaga"{{ ($transaksi->id_jenisAkunTransaksi_tujuan ?? '') == 'kas_niaga' ? 'selected' : '' }}>Kas Niaga</option>
                <option value="bank_bni"{{ ($transaksi->id_jenisAkunTransaksi_tujuan ?? '') == 'bank_bni' ? 'selected' : '' }}>Bank BNI</option>
            </select>

        <div class="form-buttons">
            <button type="submit" class="btn btn-simpan">Simpan</button>
            <a href="# {{-- {{ route('transaksi.index') }} --}}" class="btn btn-batal">Batal</a>
        </div>

    </form>
</div>

<style>
.form-container {
    background-color: transparent;
    padding: 20px;
    border-radius: 10px;
    width: 98%;
    margin-left:10px;
    margin-top:40px;
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
input[type="number"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #565656;
    border-radius: 5px;
    font-size: 13px;
    background-color: #fff;
}

input[type="text"]:focus,
input[type="datetime-local"]:focus,
input[type="number"]:focus {
    border-color: #565656;
    outline: none;
}

select {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #565656;
    border-radius: 5px;
    font-size: 13px;
    background-color: #fff;
}

select:focus {
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
document.getElementById('form-container').addEventListener('submit', function(e) {
    const wajib = ['jumlah_transaksi'];

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