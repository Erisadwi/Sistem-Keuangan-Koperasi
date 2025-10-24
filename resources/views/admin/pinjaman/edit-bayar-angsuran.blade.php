@extends('layouts.app-admin-add')

@section('title', 'Edit Bayar Angsuran')
@section('back-url', url('admin/pinjaman/bayar-angsuran')) 
@section('back-title', 'Bayar Angsuran >')
@section('title-1', 'Edit Pembayaran Angsuran')
@section('sub-title', 'Edit Pembayaran Angsuran')

@section('content')

<div class="form-container">
    <form id="formBayarAngsuran" action="# {{-- {{ route('edit-bayar-angsuran.update', $angsuran->id_angsuran) }} --}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label for="tanggal_bayar">Tanggal Transaksi*</label>
        <input type="datetime-local" id="tanggal_bayar" name="tanggal_transaksi" 
        value="{{ isset($angsuran) ? \Carbon\Carbon::parse($angsuran->tanggal_bayar)->format('Y-m-d\TH:i') : '' }}">


        <label for="id_pinjaman">Nomor Pinjaman*</label>
        <input type="text" id="type_barang" name="id_pinjaman" value="{{-- {{ $pinjaman->id_pinjaman }} --}}">

        <label for="angsuran_ke">Angsuran ke-*</label>
        <input type="text" id="angsuran_ke" name="angsuran_ke" value=" {{-- {{ $angsuran)->angsuran_ke }} --}}">

        <label for="sisa_angsuran">Sisa Angsuran*</label>
        <input type="text" id="sisa_angsuran" name="sisa_angsuran" value="{{-- {{ $pinjaman->sisa_angsuran }} --}}">

        <label for="jumlah_angsuran">Jumlah Angsuran*</label>
        <input type="number" id="jumlah_angsuran" name="jumlah_angsuran" value=" {{-- {{ isset($pinjaman) ? number_format($pinjaman->jumlah_angsuran, 0, ',', '.') : '' }} --}}">

        <label for="pokok_angsuran">Angsuran Pokok*</label>
        <input type="number" id="pokok_angsuran" name="pokok_angsuran" value="{{-- {{ isset($pinjaman) ? number_format ($pinjaman->pokok_angsuran, 0, ',', '.') : '' }} --}}">

        <label for="pendapatan">Pendapatan*</label>
        <input type="number" id="pendapatan" name="pendapatan" value="{{-- {{ isset($angsuran) ? number_format ($angsuran->pendapatan, 0, ',', '.') : '' }} --}}">

        <label for="akun_kredit">Akun Pendapatan*</label>
            <select name="akun_kredit" id="akun_kredit">
                <option value="" disabled selected>--- Pilih Akun Pendapatan ---</option>
                <option value="Y">Pendapatan dari Pinjaman</option>
            </select>

        <label for="sisa_tagihan">Sisa Tagihan*</label>
        <input type="number" id="sisa_tagihan" name="sisa_tagihan" value="{{-- {{ isset($pinjaman) ? number_format ($pinjaman->sisa_tagihan, 0, ',', '.') : '' }} --}}">

        <label for="denda">Denda</label>
        <input type="number" id="denda" name="denda" value="{{-- {{ isset($angsuran) ? number_format ($angsuran->denda, 0, ',', '.') : '' }} --}}">

        <label for="akun_debit">Simpan ke Kas*</label>
            <select name="akun_debit" id="akun_debit">
                <option value="" disabled selected>--- Pilih Kas ---</option>
                <option value="Y">Kas Besar</option>
                <option value="N">Kas Mandiri</option>
                <option value="Y">Kas Kecil</option>
                <option value="N">Kas Niaga</option>
                <option value="N">Bank BNI</option>
            </select>

        <label for="keterangan">Keterangan</label>
        <input type="text" id="keterangan" name="keterangan" value="{{-- {{ $angsuran->keterangan }} --}}">

        <div class="form-buttons">
            <button type="submit" class="btn btn-simpan">Simpan</button>
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
    color: #000;
    display: block;
}

input[type="text"],
input[type="number"],
input[type="datetime-local"],
select,
input[type="file"] {
    width: 100%;
    padding: 9px;
    border: 1px solid #565656;
    border-radius: 5px;
    font-size: 13px;
    background-color: #fff;
    margin-bottom: 15px;
}

.form-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 50px;
}

.btn {
    padding: 8px 0;
    font-size: 16px;
    font-weight: bold;
    border-radius: 7px;
    border: none;
    width: 120px;
    cursor: pointer;
    color: #fff;
    box-shadow: 0 4px 4px rgba(0,0,0,0.3);
}

.btn-simpan { background-color: #25E11B; }
.btn-batal { background-color: #EA2828; }

.btn-simpan:hover { background-color: #45a049; }
.btn-batal:hover { background-color: #d73833; }
</style>

{{-- ========== VALIDASI JS ========== --}}
<script>
document.getElementById('formBayarAngsuran').addEventListener('submit', function(e) {
    e.preventDefault();

    const wajib = ['tanggal_bayar','id_pinjaman','angsuran_ke','sisa_angsuran','jumlah_angsuran','pokok_angsuran',
                   'pendapatan','akun_kredit','sisa_tagihan','akun_debit'];

    for (let id of wajib) {
        if (!document.getElementById(id).value.trim()) {
            alert('⚠️ Mohon isi semua kolom wajib sebelum menyimpan.');
            return;
        }
    }

    if (confirm('Apakah data sudah benar dan ingin disimpan?')) {
        alert('✅ Data bayar berhasil disimpan!');
        this.reset();
    }
});

document.getElementById('btnBatal').addEventListener('click', function() {
    if (confirm('Apakah Anda yakin ingin membatalkan pengisian data?')) {
        alert('❌ Pengisian data dibatalkan.');
        window.history.back();
    }
});
</script>

@endsection
