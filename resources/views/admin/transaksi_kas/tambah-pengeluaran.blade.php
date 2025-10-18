@extends('layouts.app-admin-add')

@section('title', 'Transaksi Kas')  
@section('back-title', 'Transaksi Kas >')
@section('title-1', 'Pengeluaran')  
@section('sub-title', 'Tambah Data Pengeluaran')  

@section('content')

<div class="form-container">
    <form id="formPengeluaranKas" action="# {{-- {{ route('tambah-pengeluaran-kas.store', $transaksi->id) }} --}}" method="POST">
        @csrf

        <label for="tanggal_transaksi">Tanggal Transaksi</label>
        <input type="datetime-local" id="tanggal_transaksi" name="tanggal_transaksi" 
                value="{{ isset($transaksi) ? \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('Y-m-d\TH:i') : '' }}" required>

        <label for="jumlah_transaksi">Jumlah</label>
        <input type="number" id="jumlah_transaksi" name="jumlah_transaksi" value="" required>

        <label for="keterangan">Keterangan</label>
        <input type="text" id="keterangan" name="keterangan" value="" required>

        <label for="akun_kredit">Dari Kas</label>
        <select name="akun_kredit" id="akun_kredit" required>
            <option value="" disabled selected>Pilih Kas</option>
            <option value="/">Kas Besar</option>
            <option value="/">Kas Kecil</option>
            <option value="/">Bank Mandiri</option>
            <option value="/">Kas Niaga</option>
            <option value="/">Bank BNI</option>
        </select>

        <label for="akun_debit">Untuk Akun</label>
        <select name="akun_debit" id="akun_debit" required>
            <option value="" disabled selected>-- Pilih Jenis Akun --</option>
            <option>Persediaan Barang</option>
            <option>Pinjaman Karyawan</option>
            <option>Biaya Lainnya</option>
            <option>Utang Usaha</option>
            <option>Simpanan Wajib</option>
            <option>Simpanan Pokok</option>
            <option>Laba/Rugi</option>
        </select>

        <div class="form-buttons">
            <button type="submit" class="btn btn-simpan">Simpan</button>
            <a href="#" id="btnBatal" class="btn btn-batal">Batal</a>
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
// === VALIDASI DAN NOTIFIKASI SIMPAN ===
document.getElementById('formPengeluaranKas').addEventListener('submit', function(e) {
    e.preventDefault();

    const requiredFields = this.querySelectorAll('[required]');
    let valid = true;

    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            valid = false;
            field.style.borderColor = 'red';
        } else {
            field.style.borderColor = '#565656';
        }
    });

    if (!valid) {
        alert('⚠️ Harap lengkapi semua data wajib sebelum menyimpan!');
        return;
    }

    if (confirm('Apakah Anda yakin ingin menyimpan data pengeluaran ini?')) {
        alert('✅ Data pengeluaran berhasil disimpan!');
        // this.submit(); // aktifkan kalau backend sudah siap
    }
});

// === TOMBOL BATAL ===
document.getElementById('btnBatal').addEventListener('click', function(e) {
    e.preventDefault();
    if (confirm('Apakah Anda yakin ingin membatalkan pengisian data?')) {
        alert('❌ Pengisian data dibatalkan.');
        window.history.back();
    }
});
</script>

@endsection
