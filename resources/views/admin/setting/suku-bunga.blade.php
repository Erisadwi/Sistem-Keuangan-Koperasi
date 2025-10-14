@extends('layouts.app-admin4')

@section('title', 'Identitas Koperasi')  
@section('title-1', 'Identitas Koperasi')  
@section('sub-title', 'Data Koperasi')  

@section('content')

<div class="form-container">
    <form action="# {{-- {{ route('biaya_administrasi.update', $biaya_administrasi->id) }} --}}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-row-left">
                <label for="tipePinjamanBunga">Tipe Pinjaman Bunga</label>
                <select id="tipePinjamanBunga" name="tipePinjamanBunga">
                <option value="Persen Bunga Dikali Total Pinjaman">
                        Persen Bunga Dikali Angsuran Bulan
                </option>
                <option value="Jumlah Bunga Tetap">
                        Persen Bunga Dikali Total Pinjaman
                </option>
                </select>
            </div>

        <div class="form-row-right">
            <label for="sukuBungaPinjaman">Suku Bunga Pinjaman (%)</label>
            <input type="number" id="sukuBungaPinjaman" name="sukuBungaPinjaman" value="{{-- {{ $biaya_administrasi->suku_bunga_pinjaman }} --}}">
        </div>
        </div>

        <div class="form-row">
        <div class="form-row-left">
            <!-- Biaya Administrasi -->
            <label for="biayaAdministrasi">Biaya Administrasi (Rp)</label>
            <input type="number" id="biayaAdministrasi" name="biayaAdministrasi" value="{{-- {{ $biaya_administrasi->biaya_administrasi }} --}}">
        </div>

        <div class="form-row-right">
            <!-- Biaya Denda -->
            <label for="biayaDenda">Biaya Denda (Rp)</label>
            <input type="number" id="biayaDenda" name="biayaDenda" value="{{-- {{ $biaya_administrasi->biaya_denda }} --}}">
        </div>
        </div>

        <div class="form-row">
        <div class="form-row-left">
            <!-- Tempo Tanggal Pembayaran -->
            <label for="tempoTanggalPembayaran">Tempo Tanggal Pembayaran</label>
            <input type="number" id="tempoTanggalPembayaran" name="tempoTanggalPembayaran" value="{{-- {{ $biaya_administrasi->tempo_tanggal_pembayaran }} --}}">
        </div>

        <div class="form-row-right">
            <!-- Iuran Wajib -->
            <label for="iuranWajib">Iuran Wajib (Rp)</label>
            <input type="number" id="iuranWajib" name="iuranWajib" value="{{-- {{ $biaya_administrasi->iuran_wajib }} --}}">
        </div>
        </div>

        <div class="form-row">
        <div class="form-row-left">
            <!-- Dana Cadangan -->
            <label for="danaCadangan">Dana Cadangan (%)</label>
            <input type="number" id="danaCadangan" name="danaCadangan" value="{{-- {{ $biaya_administrasi->dana_cadangan }} --}}">
        </div>

        <div class="form-row-right">
            <!-- Jasa Anggota -->
            <label for="jasaAnggota">Jasa Anggota (%)</label>
            <input type="number" id="jasaAnggota" name="jasaAnggota" value="{{-- {{ $biaya_administrasi->jasa_anggota }} --}}">
        </div>
        </div>

        <div class="form-row">
        <div class="form-row-left">
            <!-- Dana Pengurus -->
            <label for="danaPengurus">Dana Pengurus (%)</label>
            <input type="number" id="danaPengurus" name="danaPengurus" value="{{-- {{ $biaya_administrasi->dana_pengurus }} --}}">
        </div>

        <div class="form-row-right">
            <!-- Dana Karyawan -->
            <label for="danaKaryawan">Dana Karyawan (%)</label>
            <input type="number" id="danaKaryawan" name="danaKaryawan" value="{{-- {{ $biaya_administrasi->dana_karyawan }} --}}">
        </div>
        </div>

        <div class="form-row">
        <div class="form-row-left">
            <!-- Dana Pendidikan -->
            <label for="danaPendidikan">Dana Pendidikan (%)</label>
            <input type="number" id="danaPendidikan" name="danaPendidikan" value="{{-- {{ $biaya_administrasi->dana_pendidikan }} --}}">
        </div>

        <div class="form-row-right">
            <!-- Dana Sosial -->
            <label for="danaSosial">Dana Sosial (%)</label>
            <input type="number" id="danaSosial" name="danaSosial" value="{{-- {{ $biaya_administrasi->dana_sosial }} --}}">
        </div>
        </div>

        <div class="form-row">
        <div class="form-row-left">
            <!-- Jasa Usaha -->
            <label for="jasaUsaha">Jasa Usaha (%)</label>
            <input type="number" id="jasaUsaha" name="jasaUsaha" value="{{-- {{ $biaya_administrasi->jasa_usaha }} --}}">
        </div>
        
        <div class="form-row-right">
            <!-- Jasa Modal Anggota -->
            <label for="jasaModalAnggota">Jasa Modal Anggota (%)</label>
            <input type="number" id="jasaModalAnggota" name="jasaModalAnggota" value="{{-- {{ $biaya_administrasi->jasa_modal_anggota }} --}}">
        </div>
        </div>

        <div class="form-row">
        <div class="form-row-left">
            <!-- Pajak Pph -->
            <label for="pajakPph">Pajak Pph (%)</label>
            <input type="number" id="pajakPph" name="pajakPph" value="{{-- {{ $biaya_administrasi->pajak_pph }} --}}">
        </div>
        </div>

        <button type="submit">Update</button>
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

.form-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
}

.form-row-left,
.form-row-right {
    display: flex;
    flex-direction: column;
    width: 48%;
}

label {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 5px;
    display: block;
    color: #000;
}

input[type="number"],
select {
    width: 100%;
    padding: 8px;
    border: 1px solid #565656;
    border-radius: 5px;
    font-size: 14px;
    background-color: #fff;
}

input[type="number"]:focus,
select:focus {
    border-color: #565656;
    outline: none;
}

button {
    width: auto;
    padding: 10px 30px;
    background-color: #6E9EB6;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    box-shadow: 0 4px 8px rgba(82, 76, 76, 0.15);
    transition: background-color 0.3s;
    margin-top: 40px;
    margin-left: 740px; 
    display: block;
    text-align: center;
}

button:hover {
    background-color: #5a7fa1;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.125);
}

</style>


@endsection