@extends('layouts.app-admin3')

@section('title', 'Suku Bunga')  
@section('title-1', 'Suku Bunga')  
@section('sub-title', 'Biaya & Administrasi')  

@section('content')

<div class="form-container">
    <form action="{{ route ('suku-bunga.updateSingle') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-row-left">
                <label for="tipePinjamanBunga">Tipe Pinjaman Bunga</label>
                <select id="tipe_pinjaman_bunga" name="tipe_pinjaman_bunga">
                <option value="A: Persen Bunga dikali angsuran bln"
                        {{ old('tipe_pinjaman_bunga', $suku_bunga->tipe_pinjaman_bunga) == 'A: Persen Bunga dikali angsuran bln' ? 'selected' : '' }}>
                        Persen Bunga Dikali Angsuran Bulan
                </option>
                <option value="B: Persen Bunga dikali total pinjaman"
                        {{ old('tipe_pinjaman_bunga', $suku_bunga->tipe_pinjaman_bunga) == 'B: Persen Bunga dikali total pinjaman' ? 'selected' : '' }}>
                        Persen Bunga Dikali Total Pinjaman
                </option>
                </select>
            </div>

        <div class="form-row-right">
            <label for="sukuBungaPinjaman">Suku Bunga Pinjaman (%)</label>
            <input type="number" id="sukuBungaPinjaman" name="suku_bunga_pinjaman" value="{{ number_format($suku_bunga->suku_bunga_pinjaman, 0, '.', '') }}">
        </div>
        </div>

        <div class="form-row">
        <div class="form-row-left">
            <!-- Biaya Administrasi -->
            <label for="biayaAdministrasi">Biaya Administrasi (Rp)</label>
            <input type="number" id="biayaAdministrasi" name="biaya_administrasi" value="{{ number_format($suku_bunga->biaya_administrasi, 0, '.', '') }}">
        </div>

        <div class="form-row-right">
            <!-- Biaya Denda -->
            <label for="biayaDenda">Biaya Denda (Rp)</label>
            <input type="number" id="biayaDenda" name="biaya_denda" value="{{ number_format($suku_bunga->biaya_denda, 0, '.', '') }}">
        </div>
        </div>

        <div class="form-row">
        <div class="form-row-left">
            <!-- Tempo Tanggal Pembayaran -->
            <label for="tempoTanggalPembayaran">Tempo Tanggal Pembayaran</label>
            <input type="number" id="tempoTanggalPembayaran" name="tempo_tanggal_pembayaran" value="{{ $suku_bunga->tempo_tanggal_pembayaran }}">
        </div>

        <div class="form-row-right">
            <!-- Iuran Wajib -->
            <label for="iuranWajib">Iuran Wajib (Rp)</label>
            <input type="number" id="iuranWajib" name="iuran_wajib" value="{{ number_format($suku_bunga->iuran_wajib, 0, '.', '') }}">
        </div>
        </div>

        <div class="form-row">
        <div class="form-row-left">
            <!-- Dana Cadangan -->
            <label for="danaCadangan">Dana Cadangan (%)</label>
            <input type="number" id="danaCadangan" name="dana_cadangan" value="{{ number_format($suku_bunga->dana_cadangan, 0, '.', '') }}">
        </div>

        <div class="form-row-right">
            <!-- Jasa Anggota -->
            <label for="jasaAnggota">Jasa Anggota (%)</label>
            <input type="number" id="jasaAnggota" name="jasa_anggota" value="{{ number_format($suku_bunga->jasa_anggota, 0, '.', '') }}">
        </div>
        </div>

        <div class="form-row">
        <div class="form-row-left">
            <!-- Dana Pengurus -->
            <label for="danaPengurus">Dana Pengurus (%)</label>
            <input type="number" id="danaPengurus" name="dana_pengurus" value="{{ number_format($suku_bunga->dana_pengurus, 0, '.', '') }}">
        </div>

        <div class="form-row-right">
            <!-- Dana Karyawan -->
            <label for="danaKaryawan">Dana Karyawan (%)</label>
            <input type="number" id="danaKaryawan" name="dana_karyawan" value="{{ number_format($suku_bunga->dana_karyawan, 0, '.', '') }}">
        </div>
        </div>

        <div class="form-row">
        <div class="form-row-left">
            <!-- Dana Pendidikan -->
            <label for="danaPendidikan">Dana Pendidikan (%)</label>
            <input type="number" id="danaPendidikan" name="dana_pendidikan" value="{{ number_format($suku_bunga->dana_pendidikan, 0, '.', '') }}">
        </div>

        <div class="form-row-right">
            <!-- Dana Sosial -->
            <label for="danaSosial">Dana Sosial (%)</label>
            <input type="number" id="danaSosial" name="dana_sosial" value="{{ number_format($suku_bunga->dana_sosial, 0, '.', '') }}">
        </div>
        </div>

        <div class="form-row">
        <div class="form-row-left">
            <!-- Jasa Usaha -->
            <label for="jasaUsaha">Jasa Usaha (%)</label>
            <input type="number" id="jasaUsaha" name="jasa_usaha" value="{{ number_format($suku_bunga->jasa_usaha, 0, '.', '') }}">
        </div>
        
        <div class="form-row-right">
            <!-- Jasa Modal Anggota -->
            <label for="jasaModalAnggota">Jasa Modal Anggota (%)</label>
            <input type="number" id="jasaModalAnggota" name="jasa_modal_anggota" value="{{ number_format($suku_bunga->jasa_modal_anggota, 0, '.', '') }}">
        </div>
        </div>

        <div class="form-row">
        <div class="form-row-left">
            <!-- Pajak Pph -->
            <label for="pajakPph">Pajak Pph (%)</label>
            <input type="number" id="pajakPph" name="pajak_pph" value="{{ $suku_bunga->pajak_pph }}">
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
    width: 100%;
    margin-left:0px;
    margin-top:40px;
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
    box-shadow: 0 4px 4px rgba(0, 0, 0, 0.519);
    transition: background-color 0.3s;
    margin-top: 40px;
    display: block;
    text-align: center;
    justify-content: flex-start;
}

button:hover {
    background-color: #5a7fa1;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.125);
}

</style>


@endsection