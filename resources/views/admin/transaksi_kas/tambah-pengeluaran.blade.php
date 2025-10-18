@extends('layouts.app-admin-add')

@section('title', 'Transaksi Kas')  
@section('back-title', 'Transaksi Kas >')
@section('title-1', 'Pengeluaran')  
@section('sub-title', 'Tambah Data Pengeluaran')  

@section('content')

<div class="form-container">
    <form action="# {{-- {{ route('tambah-pengeluaran-kas.store', $transaksi->id) }} --}}" method="POST">
        @csrf

        <label for="tanggal_transaksi">Tanggal Transaksi</label>
        <input type="datetime-local" id="tanggal_transaksi" name="tanggal_transaksi" 
                value="{{ isset($transaksi) ? \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('Y-m-d\TH:i') : '' }}">

        <label for="jumlah_transaksi">Jumlah</label>
        <input type="number" id="jumlah_transaksi" name="jumlah_transaksi" value=" {{-- {{ isset($transaksi) ? number_format($transaksi->jumlah_transaksi, 0, ',', '.') : '' }} --}}">

        <label for="keterangan">Keterangan</label>
        <input type="text" id="keterangan" name="keterangan" value="{{-- {{ $transaksi->keterangan }} --}}">

        <label for="akun_kredit">Dari Kas</label>
        <select name="akun_kredit" id="akun_kredit">
            <option value="" disabled selected>Pilih Kas</option>
            <option value="/">Kas Besar</option>
            <option value="/">Kas Kecil</option>
            <option value="/">Bank Mandiri</option>
            <option value="/">Kas Niaga</option>
            <option value="/">Bank BNI</option>
        </select>

        <label for="akun_debit">Untuk Akun</label>
        <select name="akun_debit" id="akun_debit">
            <option value="" disabled selected>-- Pilih Jenis Akun --</option>
            <option>Persediaan Barang</option>
            <option>Pinjaman Karyawan</option>
            <option>Pinjaman</option>
            <option>Darmawisata</option>
            <option>Barang dlm Perjalanan</option>
            <option>Nilai Perolehan Aktiva Tetap (Kendaraan)</option>
            <option>Utang Usaha</option>
            <option>Pengeluaran Lainnya</option>
            <option>Utang Bank</option>
            <option>Simpanan Pokok*</option>
            <option>Simpanan Wajib*</option>
            <option>Modal Awal</option>
            <option>Pendapatan dari Pinjaman*</option>
            <option>Beban Telpon</option>
            <option>Biaya Listrik dan Air</option>
            <option>Biaya Transportasi</option>
            <option>Biaya Lainnya</option>
            <option>Logam Mulia</option>
            <option>Persediaan Konsinyasi / Barang Titipan</option>
            <option>Persediaan Alat Olah Raga</option>
            <option>Persediaan Pulsa</option>
            <option>Persediaan Rokok</option>
            <option>Persediaan Keb. Rumah Tangga</option>
            <option>Piutang Usaha Niaga</option>
            <option>Piutang Usaha Simpan Pinjam</option>
            <option>Piutang Usaha Pembiayaan</option>
            <option>Piutang Usaha Pengurusan Surat</option>
            <option>Persediaan Alat Tulis Kantor</option>
            <option>Persediaan Minuman</option>
            <option>Persediaan Makanan</option>
            <option>BIAYA DIBAYAR DIMUKA</option>
            <option>BIAYA DIBAYAR DIMUKA TIKET & VOUCHER DARMAWISATA</option>
            <option>BIAYA DIBAYAR DIMUKA TIKET & VOUCHER</option>
            <option>Uang Muka Pajak PPh 21</option>
            <option>Uang Muka Pajak PPh 25</option>
            <option>Uang Muka Pajak PPn Masukan</option>
            <option>Nilai Perolehan Aktiva Tetap (Inventaris)</option>
            <option>Nilai Perolehan Aktiva Tetap (Elektronik)</option>
            <option>Akumulasi Penyusutan Aktiva Tetap (Kendaraan)</option>
            <option>Akumulasi Penyusutan Aktiva Tetap (Inventaris)</option>
            <option>Akumulasi Penyusutan Aktiva Tetap (Elektronik)</option>
            <option>Non Usaha Hutang Rekening Titipan</option>
            <option>Gaji Pegawai Tetap</option>
            <option>Nilai Perolehan Aktiva Tetap Tak Berwujud Software</option>
            <option>Amortisasi Aktiva Tetap Tak Berwujud Amor Software</option>
            <option>Hutang Usaha ATK</option>
            <option>Hutang Usaha Minuman</option>
            <option>Hutang Usaha Makanan</option>
            <option>Hutang Usaha Rokok</option>
            <option>Hutang Usaha Konsinyasi</option>
            <option>Hutang Usaha Keb. Rumah Tangga</option>
            <option>Hutang Usaha Pulsa</option>
            <option>Hutang Usaha Good Receive Not Invoice</option>
            <option>Hutang Usaha Iklan</option>
            <option>Hutang Usaha Kredit Barang</option>
            <option>Hutang Usaha Pengurusan Surat</option>
            <option>Hutang Usaha Pembiayaan</option>
            <option>Hutang Pajak Penghasilan PPh Final</option>
            <option>Laba/Rugi Periode Berjalan</option>
            <option>Laba Ditahan (Defisit)</option>
            <option>Pendapatan Usaha Niaga</option>
            <option>Pendapatan Usaha Kredit Barang</option>
            <option>Pendapatan Usaha Iklan</option>
            <option>Pendapatan Usaha Foto Copy</option>
            <option>Pendapatan Usaha Tiket & Voucher</option>
            <option>Pendapatan Usaha Pengurusan Surat</option>
            <option>Pendapatan Usaha Pembiayaan</option>
            <option>Hutang Refund Tiket & Voucher</option>
            <option>Pendapatan Lain - Lain</option>
            <option>PENDAPATAN JASA GIRO</option>
            <option>BIAYA ADMINISTRASI BANK LAINNYA</option>
            <option>Pinjaman Perusahaan</option>
            <option>Pemeliharaan Bangunan</option>
            <option>Tunjangan Karyawan</option>
            <option>Hutang Modal Pinjaman</option>
            <option>Beban Persewaan Bangunan</option>
            <option>HPP Usaha Niaga</option>
            <option>PPH 29/Badan</option>
            <option>HPP Usaha Tiket dan Voucher</option>
            <option>Investasi Jangka Panjang</option>
            <option>Biaya BPJS</option>
            <option>Pendapatan Sewa Lahan Koperasi</option>
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
    width: 900px;
    margin-left:10px;
    margin-top:55px;
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

@endsection
