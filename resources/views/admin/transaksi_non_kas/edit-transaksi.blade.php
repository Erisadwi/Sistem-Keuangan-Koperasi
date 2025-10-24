@extends('layouts.app-admin-add')

@section('title', 'Transaksi Non Kas')  
@section('back-url', url('admin/transaksi_non_kas/transaksi'))
@section('back-title', 'Transaksi Non Kas >')
@section('title-1', 'Transaksi')  
@section('sub-title', 'Edit Data Transaksi')  

@section('content')

<div class="form-container">
    <form action="# {{-- {{ route('tambah-transaksi-nonkas.update', $transaksi->id) }} --}}" method="POST">
        @csrf
        @method('PUT')

        <label for="tanggal_transaksi">Tanggal Transaksi</label>
        <input type="datetime-local" id="tanggal_transaksi" name="tanggal_transaksi" 
                value="{{ isset($transaksi) ? \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('Y-m-d\TH:i') : '' }}">

        <label for="jumlah_transaksi">Jumlah</label>
        <input type="text" id="jumlah_transaksi" name="jumlah_transaksi" value=" {{-- {{ isset($transaksi) ? number_format($transaksi->jumlah_transaksi, 0, ',', '.') : '' }} --}}">

        <label for="keterangan">Keterangan</label>
        <input type="text" id="keterangan" name="keterangan" value="{{-- {{ $transaksi->keterangan }} --}}">

        <label for="akun_debit">Akun Debit</label>
            <select name="akun_debit" id="akun_debit">
                <option value="" disabled selected>Pilih Akun Debit</option>
                <option value="A5">A5-Persediaan Barang</option>
                <option value="A6">A6-Pinjaman Karyawan</option>
                <option value="A7">A7-Pinjaman</option>
                <option value="A8">A8-Darmawisata</option>
                <option value="A10">A10-Barang dalam Perjalanan</option>
                <option value="C">C-Aktiva Tetap Berwujud</option>
                <option value="C01.01">C01.01-Nilai Perolehan Aktiva Tetap(Kendaraan)</option>
                <option value="F">F-Utang</option>
                <option value="F1">F1-Utang Usaha</option>
                <option value="K5">K5-Pengeluaran Lainnya</option>
                <option value="F4">F4-Simpanan Sukarela</option>
                <option value="H">H-Utang Jangka Panjang</option>
                <option value="H1">H1-Utang Bank</option>
                <option value="I">I-Modal</option>
                <option value="I1">I1-Simpanan Pokok</option>
                <option value="I2">I2-Simpanan Wajib</option>
                <option value="I3">I3-Modal Awal</option>
                <option value="J">J-Pendapatan</option>
                <option value="J1">J1-Pendapatan dari Pinjaman</option>
                <option value="J2">J2-Pendapatan Lainnya</option>
                <option value="K">K-Beban</option>
                <option value="K2">K2-Beban Telfon</option>
                <option value="K3">K3-Biaya Listrik dan Air</option>
                <option value="K4">K4-Biaya Transportasi</option>
                <option value="K10">K10-Biaya Lainnya</option>
                <option value="TRF">TRF-Transfer Antar Kas</option>
                <option value="B01.01">B01.01-Logam Mulia</option>
                <option value="B03.05">B03.05-Persediaan Konsinyasi / Barang Titipan</option>
                <option value="B03.06">B03.06-Persediaan Alat Olah Raga</option>
                <option value="B03.08">B03.08-Persediaan Pulsa</option>
                <option value="B03.04">B03.04-Persediaan Rokok</option>
                <option value="B03.07">B03.07-Persediaan Keb. Rumah Tangga</option>
                <option value="B02.01">B02.01-Piutang Usaha Niaga</option>
                <option value="B02.02">B02.02-Piutang Usaha Kredit Barang</option>
                <option value="B02.03">B02.03-Piutang Usaha Simpan Pinjam</option>
                <option value="B02.04">B02.04-Piutang Usaha Pembiayaan</option>
                <option value="B02.05">B02.05-Piutang Usaha Pengurusan Surat</option>
                <option value="B03.01">B03.01-Persediaan Alat Tulis Kantor</option>
                <option value="B03.02">B03.02-Persediaan Minuman</option>
                <option value="B03.03">B03.03-Persediaan Makanan</option>
                <option value="B04.01">B04.01-Biaya Dibayar Dimuka</option>
                <option value="B04.02">B04.02-Biaya Dibayar Dimuka Tiket & Voucher Darmawisata</option>
                <option value="B04.03">B04.03-Biaya Dibayar Dimuka Tiket & Voucher</option>
                <option value="B05.01">B05.01-Uang Muka Pajak PPh 21</option>
                <option value="B05.02">B05.02-Uang Muka Pajak PPh 25</option>
                <option value="B05.03">B05.03-Uang Muka Pajak PPn Masukan</option>
                <option value="C01.02">C01.02-Nilai Perolehan Aktiva Tetap (Inventaris)</option>
                <option value="C01.03">C01.03-Nilai Perolehan Aktiva Tetap (Elektronik)</option>
                <option value="C02.01">C02.01-Akumulasi Penyusutan Aktiva Tetap (Kendaraan)</option>
                <option value="C02.02">C02.02-Akumulasi Penyusutan Aktiva Tetap (Inventaris)</option>
                <option value="C02.03">C02.03-Akumulasi Penyusutan Aktiva Tetap (Elektronik)</option>
                <option value="F02.01">F02.01-Non Usaha Hutang Rekening Titipan</option>
                <option value="K01.01">K01.01-Gaji Pegawai Tetap</option>
                <option value="C03.01">C03.01-Nilai Perolehan Aktiva Tetap Tak Berwujud Software</option>
                <option value="C03.02">C03.02-Amortisasi Aktiva Tetap Tak Berwujud Amor Software</option>
                <option value="F01.01">F01.01-Hutang Usaha ATK</option>
                <option value="F01.02">F01.02-Hutang Usaha Minuman</option>
                <option value="F01.03">F01.03-Hutang Usaha Makanan</option>
                <option value="F01.04">F01.04-Hutang Usaha Rokok</option>
                <option value="F01.05">F01.05-Hutang Usaha Konsinyasi</option>
                <option value="F01.06">F01.06-Hutang Usaha Keb. Rumah Tangga</option>
                <option value="F01.07">F01.07-Hutang Usaha Pulsa</option>
                <option value="F01.08">F01.08-Hutang Usaha Iklan</option>
                <option value="F01.09">F01.09-Hutang Usaha Good Receive Not Invoice</option>
                <option value="F01.10">F01.10-Hutang Usaha Kredit Barang</option>
                <option value="F01.11">F01.11-Hutang Usaha Pengurusan Surat</option>
                <option value="F01.12">F01.12-Hutang Usaha Pembiayaan</option>
                <option value="F03.01">F03.01-Hutang Pajak Penghasilan PPh Final</option>
                <option value="I02.01">I02.01-Laba/Rugi Periode Berjalan</option>
                <option value="I03.01">I03.01-Laba Ditahan (Difisit)</option>
                <option value="J01.01">J01.01-Pendapatan Usaha Niaga</option>
                <option value="J01.02">J01.02-Pendapatan Usaha Kredit Barang</option>
                <option value="J01.03">J01.03-Pendapatan Usaha Iklan</option>
                <option value="J01.04">J01.04-Pendapatan Usaha Foto Copy</option>
                <option value="J01.05">J01.05-Pendapatan Usaha Tiket & Voucher</option>
                <option value="J01.06">J01.06-Pendapatan Usaha Pengurusan Surat</option>
                <option value="J01.07">J01.07-Pendapatan Usaha Pembiayaan</option>
                <option value="F01.13">F01.13-Hutang Refund Tiket & Voucher</option>
                <option value="J01.08">J01.08-Pendapatan Lain - lain</option>
                <option value="J01.09">J01.09-Pendapatan Jasa Giro</option>
                <option value="K6">K6-Biaya Administrasi Bank Lainnya</option>
                <option value="A11">A11-Pinjaman Perusahaan</option>
                <option value="K7">K7-Pemeliharaan Bangunan</option>
                <option value="K01.02">K01.02-Tunjangan Karyawan</option>
                <option value="H3">H3-Hutang Modal Pinjaman</option>
                <option value="K9">K9-Beban Persewaaan Bangunan</option>
                <option value="K11">K11-Biaya Penyusutan Aktiva Tetap (Inventaris)</option>
                <option value="K12">K12-Biaya Penyusutan Aktiva Tetap (Kendaraan)</option>
                <option value="K13">K13-Biaya Penyusutan Aktiva Tetap (Elektronik)</option>
                <option value="K14">K14-HPP Usaha Niaga</option>
                <option value="K15">K15-PPH 29/Badan</option>
                <option value="K16">K16-HPP Usaha Tiket dan Voucher</option>
                <option value="B06.01">B06.01-Investasi Jangka Panjang</option>
                <option value="K17">K17-Biaya BPJS</option>
                <option value="J01.10">J01.10-Pendapatan Sewa Lahan Koperasi</option>
            </select>

        <label for="akun_kredit">Akun Kredit</label>
            <select name="akun_kredit" id="akun_kredit">
                <option value="" disabled selected>Pilih Akun Kredit</option>
                <option value="A5">A5-Persediaan Barang</option>
                <option value="A6">A6-Pinjaman Karyawan</option>
                <option value="A7">A7-Pinjaman</option>
                <option value="A8">A8-Darmawisata</option>
                <option value="A10">A10-Barang dalam Perjalanan</option>
                <option value="C">C-Aktiva Tetap Berwujud</option>
                <option value="C01.01">C01.01-Nilai Perolehan Aktiva Tetap(Kendaraan)</option>
                <option value="F">F-Utang</option>
                <option value="F1">F1-Utang Usaha</option>
                <option value="K5">K5-Pengeluaran Lainnya</option>
                <option value="F4">F4-Simpanan Sukarela</option>
                <option value="H">H-Utang Jangka Panjang</option>
                <option value="H1">H1-Utang Bank</option>
                <option value="I">I-Modal</option>
                <option value="I1">I1-Simpanan Pokok</option>
                <option value="I2">I2-Simpanan Wajib</option>
                <option value="I3">I3-Modal Awal</option>
                <option value="J">J-Pendapatan</option>
                <option value="J1">J1-Pendapatan dari Pinjaman</option>
                <option value="J2">J2-Pendapatan Lainnya</option>
                <option value="K">K-Beban</option>
                <option value="K2">K2-Beban Telfon</option>
                <option value="K3">K3-Biaya Listrik dan Air</option>
                <option value="K4">K4-Biaya Transportasi</option>
                <option value="K10">K10-Biaya Lainnya</option>
                <option value="TRF">TRF-Transfer Antar Kas</option>
                <option value="B01.01">B01.01-Logam Mulia</option>
                <option value="B03.05">B03.05-Persediaan Konsinyasi / Barang Titipan</option>
                <option value="B03.06">B03.06-Persediaan Alat Olah Raga</option>
                <option value="B03.08">B03.08-Persediaan Pulsa</option>
                <option value="B03.04">B03.04-Persediaan Rokok</option>
                <option value="B03.07">B03.07-Persediaan Keb. Rumah Tangga</option>
                <option value="B02.01">B02.01-Piutang Usaha Niaga</option>
                <option value="B02.02">B02.02-Piutang Usaha Kredit Barang</option>
                <option value="B02.03">B02.03-Piutang Usaha Simpan Pinjam</option>
                <option value="B02.04">B02.04-Piutang Usaha Pembiayaan</option>
                <option value="B02.05">B02.05-Piutang Usaha Pengurusan Surat</option>
                <option value="B03.01">B03.01-Persediaan Alat Tulis Kantor</option>
                <option value="B03.02">B03.02-Persediaan Minuman</option>
                <option value="B03.03">B03.03-Persediaan Makanan</option>
                <option value="B04.01">B04.01-Biaya Dibayar Dimuka</option>
                <option value="B04.02">B04.02-Biaya Dibayar Dimuka Tiket & Voucher Darmawisata</option>
                <option value="B04.03">B04.03-Biaya Dibayar Dimuka Tiket & Voucher</option>
                <option value="B05.01">B05.01-Uang Muka Pajak PPh 21</option>
                <option value="B05.02">B05.02-Uang Muka Pajak PPh 25</option>
                <option value="B05.03">B05.03-Uang Muka Pajak PPn Masukan</option>
                <option value="C01.02">C01.02-Nilai Perolehan Aktiva Tetap (Inventaris)</option>
                <option value="C01.03">C01.03-Nilai Perolehan Aktiva Tetap (Elektronik)</option>
                <option value="C02.01">C02.01-Akumulasi Penyusutan Aktiva Tetap (Kendaraan)</option>
                <option value="C02.02">C02.02-Akumulasi Penyusutan Aktiva Tetap (Inventaris)</option>
                <option value="C02.03">C02.03-Akumulasi Penyusutan Aktiva Tetap (Elektronik)</option>
                <option value="F02.01">F02.01-Non Usaha Hutang Rekening Titipan</option>
                <option value="K01.01">K01.01-Gaji Pegawai Tetap</option>
                <option value="C03.01">C03.01-Nilai Perolehan Aktiva Tetap Tak Berwujud Software</option>
                <option value="C03.02">C03.02-Amortisasi Aktiva Tetap Tak Berwujud Amor Software</option>
                <option value="F01.01">F01.01-Hutang Usaha ATK</option>
                <option value="F01.02">F01.02-Hutang Usaha Minuman</option>
                <option value="F01.03">F01.03-Hutang Usaha Makanan</option>
                <option value="F01.04">F01.04-Hutang Usaha Rokok</option>
                <option value="F01.05">F01.05-Hutang Usaha Konsinyasi</option>
                <option value="F01.06">F01.06-Hutang Usaha Keb. Rumah Tangga</option>
                <option value="F01.07">F01.07-Hutang Usaha Pulsa</option>
                <option value="F01.08">F01.08-Hutang Usaha Iklan</option>
                <option value="F01.09">F01.09-Hutang Usaha Good Receive Not Invoice</option>
                <option value="F01.10">F01.10-Hutang Usaha Kredit Barang</option>
                <option value="F01.11">F01.11-Hutang Usaha Pengurusan Surat</option>
                <option value="F01.12">F01.12-Hutang Usaha Pembiayaan</option>
                <option value="F03.01">F03.01-Hutang Pajak Penghasilan PPh Final</option>
                <option value="I02.01">I02.01-Laba/Rugi Periode Berjalan</option>
                <option value="I03.01">I03.01-Laba Ditahan (Difisit)</option>
                <option value="J01.01">J01.01-Pendapatan Usaha Niaga</option>
                <option value="J01.02">J01.02-Pendapatan Usaha Kredit Barang</option>
                <option value="J01.03">J01.03-Pendapatan Usaha Iklan</option>
                <option value="J01.04">J01.04-Pendapatan Usaha Foto Copy</option>
                <option value="J01.05">J01.05-Pendapatan Usaha Tiket & Voucher</option>
                <option value="J01.06">J01.06-Pendapatan Usaha Pengurusan Surat</option>
                <option value="J01.07">J01.07-Pendapatan Usaha Pembiayaan</option>
                <option value="F01.13">F01.13-Hutang Refund Tiket & Voucher</option>
                <option value="J01.08">J01.08-Pendapatan Lain - lain</option>
                <option value="J01.09">J01.09-Pendapatan Jasa Giro</option>
                <option value="K6">K6-Biaya Administrasi Bank Lainnya</option>
                <option value="A11">A11-Pinjaman Perusahaan</option>
                <option value="K7">K7-Pemeliharaan Bangunan</option>
                <option value="K01.02">K01.02-Tunjangan Karyawan</option>
                <option value="H3">H3-Hutang Modal Pinjaman</option>
                <option value="K9">K9-Beban Persewaaan Bangunan</option>
                <option value="K11">K11-Biaya Penyusutan Aktiva Tetap (Inventaris)</option>
                <option value="K12">K12-Biaya Penyusutan Aktiva Tetap (Kendaraan)</option>
                <option value="K13">K13-Biaya Penyusutan Aktiva Tetap (Elektronik)</option>
                <option value="K14">K14-HPP Usaha Niaga</option>
                <option value="K15">K15-PPH 29/Badan</option>
                <option value="K16">K16-HPP Usaha Tiket dan Voucher</option>
                <option value="B06.01">B06.01-Investasi Jangka Panjang</option>
                <option value="K17">K17-Biaya BPJS</option>
                <option value="J01.10">J01.10-Pendapatan Sewa Lahan Koperasi</option>
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


@endsection