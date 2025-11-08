@extends('layouts.app-admin-add')

@section('title', 'Transaksi Kas')  
@section('back-url', route('pengeluaran.index'))
@section('back-title', 'Transaksi Kas >')
@section('title-1', 'Pengeluaran')  
@section('sub-title', 'Tambah Data Pengeluaran')  

@section('content')

<div class="form-container">
    <form id="formPengeluaranKas" action="{{ route('pengeluaran.store') }}" method="POST">
        @csrf

        <label for="tanggal_transaksi">Tanggal Transaksi*</label>
        <input type="datetime-local" id="tanggal_transaksi" name="tanggal_transaksi" 
                value="{{ old('tanggal_transaksi') }}">

        <label for="jumlah_transaksi">Jumlah*</label>
        <input type="number" id="jumlah_transaksi" name="jumlah_transaksi" value=" {{ old('jumlah_transaksi') }}">

        <label for="keterangan">Keterangan</label>
        <input type="text" id="keterangan" name="ket_transaksi" value="{{ old('ket_transaksi') }}">

       <label for="id_jenisAkunTransaksi_tujuan">Dari Kas*</label>
            <select name="id_jenisAkunTransaksi_tujuan" id="id_jenisAkunTransaksi_tujuan">
            <option value="" disabled {{ old('id_jenisAkunTransaksi_tujuan') ? '' : 'selected' }}>Pilih Kas</option>
            @foreach ($akunTujuan as $a)
                <option value="{{ $a->id_jenisAkunTransaksi }}"
                {{ (string)old('id_jenisAkunTransaksi_tujuan', $Transaksi->id_jenisAkunTransaksi_tujuan ?? '') === (string)$a->id_jenisAkunTransaksi ? 'selected' : '' }}>
                {{ $a->kode_AkunTransaksi }} - {{ $a->nama_AkunTransaksi }}
                </option>
            @endforeach
            </select>

        <label for="id_jenisAkunTransaksi_sumber">Untuk Akun*</label>
            <select name="id_jenisAkunTransaksi_sumber" id="id_jenisAkunTransaksi_sumber">
                <option value="" disabled {{ old('id_jenisAkunTransaksi_sumber') ? '' : 'selected' }}>Pilih Akun</option>
                @foreach ($akunSumber as $a)
                    <option value="{{ $a->id_jenisAkunTransaksi }}"
                    {{ (string)old('id_jenisAkunTransaksi_sumber', $Transaksi->id_jenisAkunTransaksi_sumber ?? '') === (string)$a->id_jenisAkunTransaksi ? 'selected' : '' }}>
                    {{ $a->kode_AkunTransaksi }} - {{ $a->nama_AkunTransaksi }}
                    </option>
                @endforeach
            </select>

        <div class="form-buttons">
            <button type="submit" class="btn btn-simpan">Simpan</button>
            <a href="{{ route('pengeluaran.index') }}" class="btn btn-batal">Batal</a>
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
input[type="number"],
select {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #565656;
    border-radius: 5px;
    font-size: 13px;
    background-color: #fff;
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
document.getElementById('formPengeluaranKas').addEventListener('submit', function(e) {
    const wajib = ['tanggal_transaksi','jumlah_transaksi','id_jenisAkunTransaksi_sumber','id_jenisAkunTransaksi_tujuan'];

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
