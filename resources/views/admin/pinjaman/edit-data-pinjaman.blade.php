@extends('layouts.app-admin-add')

@section('title', 'Data Pinjaman') 
@section('back-url', url('admin/pinjaman/data-pinjaman'))  
@section('back-title', 'Pinjaman >')
@section('title-1', 'Data Pinjaman')  
@section('sub-title', 'Tambah Data Pinjaman')  

@section('content')

<div class="form-container">
    <div class="form-wrapper">
    <form id="formDataPinjaman" action="#" method="POST">
        @csrf

        <div class="form-group">
            <label for="tanggal_pinjaman">Tanggal Pinjaman</label>
            <input type="datetime-local" id="tanggal_pinjaman" name="tanggal_pinjaman">
        </div>

        <div class="form-group">
            <label for="nama_anggota">Nama Anggota*</label>
            <input type="text" id="nama_anggota" name="nama_anggota">
        </div>

        <div class="form-group">
            <label for="nama_barang">Nama Barang*</label>
            <select id="nama_barang" name="nama_barang" required>
                <option value="" disabled selected>-- Pilih Barang --</option>
                <option value="Air Minum Axo">Air Minum Axo, stok :9999, harga beli Rp 1,500</option>
                <option value="Air Minum Club">Air Minum Club, stok :9990, harga beli Rp 1,500</option>
                <option value="Air Minum Pocari Sweet">Air Minum Pocari Sweet, stok :9996, harga beli Rp 5,025</option>
                <option value="IKLAN JAWA POS">IKLAN JAWA POS, stok :997, harga beli Rp 37,879</option>
                <option value="IKLAN MEMORANDUM">IKLAN MEMORANDUM, stok :972, harga beli Rp 15,000</option>
                <option value="Kebutuhan Rumah Tangga">Kebutuhan Rumah Tangga, stok :9818, harga beli Rp 1</option>
                <option value="MILTON">MILTON, stok :999, harga beli Rp 3,500</option>
                <option value="Roko GAJAH BARU">Roko GAJAH BARU, stok :989, harga beli Rp 17,800</option>
                <option value="Rokok">Rokok, stok :9990, harga beli Rp 1</option>
                <option value="Rokok (stok 0)">Rokok, stok :0, harga beli Rp 76,256</option>
                <option value="ROKOK CLASS MILD">ROKOK CLASS MILD, stok :907, harga beli Rp 27,450</option>
                <option value="ROKOK GAJAH BARU">ROKOK GAJAH BARU, stok :0, harga beli Rp 15,900</option>
                <option value="ROKOK MILD 16">ROKOK MILD 16, stok :9947, harga beli Rp 32,600</option>
                <option value="ROKOK PRIMA">ROKOK PRIMA, stok :996, harga beli Rp 14,500</option>
                <option value="ROKOK SURYA 12">ROKOK SURYA 12, stok :9862, harga beli Rp 24,200</option>
                <option value="Voucher">Voucher, stok :9999719, harga beli Rp 13,750</option>
            </select>
        </div>

        <div class="form-group">
            <label for="harga_satuan">Harga Satuan*</label>
            <input type="text" id="harga_satuan" name="harga_satuan">
        </div>

        <div class="form-group">
            <label for="jumlah_barang">Jumlah Barang*</label>
            <input type="text" id="jumlah_barang" name="jumlah_barang">
        </div>

        <div class="form-group">
            <label for="harga_barang">Harga Barang*</label>
            <input type="text" id="harga_barang" name="harga_barang">
        </div>

    <div class="form-group">
    <label for="lama_angsuran">Lama Angsuran (Bulan)*</label>
    <input 
        type="number" 
        id="lama_angsuran" 
        name="lama_angsuran" 
        class="form-control" 
        placeholder="Masukkan lama angsuran dalam bulan" 
        min="1" 
        required>
    </div>

        <div class="form-group">
            <label for="bunga">Bunga*</label>
            <input type="text" id="bunga" name="bunga">
        </div>

        <div class="form-group">
            <label for="biaya_admin">Biaya Admin*</label>
            <input type="text" id="biaya_admin" name="biaya_admin">
        </div>

        <div class="form-group">
            <label for="pilih_akun">Pilih Akun</label>
            <select name="pilih_akun" id="pilih_akun" required>
                <option value="" disabled selected>-- Pilih Akun --</option>
                <option value="karyawan">Pinjaman Karyawan</option>
                <option value="pinjaman">Pinjaman</option>
                <option value="perusahaan">Pinjaman Perusahaan</option>
            </select>
        </div>

        <div class="form-group">
            <label for="ambil_dari_kas">Ambil Dari Kas</label>
            <select name="ambil_dari_kas" id="ambil_dari_kas" required>
                <option value="" disabled selected>-- Pilih Kas --</option>
                <option value="kas_besar">Kas Besar</option>
                <option value="bank_mandiri">Bank Mandiri</option>
                <option value="kas_kecil">Kas Kecil</option>
                <option value="kas_niaga">Kas Niaga</option>
                <option value="bank_bri">Bank BRI</option>
            </select>
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <input type="text" id="keterangan" name="keterangan">
        </div>

        <div class="form-group">
            <label for="foto">Foto</label>
            <input type="file" id="foto" name="foto" accept="image/*">
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn btn-simpan">Simpan</button>
            <a href="#" class="btn btn-batal">Batal</a>
        </div>
    </form>
    </div>
</div>

<style>
.form-container {
    background-color: transparent;
    width: 98%;
    margin-left: 10px;
    margin-top: 40px;
}

.form-wrapper {
    background-color: #c7dbe6;
    border-radius: 8px;
    padding: 20px;
    box-sizing: border-box;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 5px;
    color: #000;
}

input[type="text"],
input[type="number"],
input[type="file"],
input[type="datetime-local"],
select {
  width: 100%;
  padding: 8px;
  border: 1px solid #565656;
  border-radius: 5px;
  font-size: 13px;
  background-color: #fff;
  box-sizing: border-box;
}

input:focus, select:focus {
    outline: none;
    border-color: #1976d2;
    box-shadow: 0 0 2px rgba(25, 118, 210, 0.5);
}

.form-buttons {
    display: flex;
    justify-content: flex-end; 
    gap: 10px;
    margin-top: 50px;
}

.btn {
    padding: 8px 0;
    width: 110px;
    font-size: 14px;
    font-weight: bold;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    color: #fff;
    box-shadow: 0 3px 4px rgba(0, 0, 0, 0.2);
    text-align: center;
}

.btn-simpan {
    background-color: #25E11B;
}

.btn-simpan:hover {
    background-color: #1db115;
}

.btn-batal {
    background-color: #EA2828;
}

.btn-batal:hover {
    background-color: #c71e1e;
}

.form-wrapper::-webkit-scrollbar {
    width: 8px;
}
.form-wrapper::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 5px;
}
.form-wrapper::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>
@endsection
