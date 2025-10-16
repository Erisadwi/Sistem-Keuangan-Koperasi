@extends('layouts.app-admin-add3')

@section('title', 'Jenis Akun Transaksi')
@section('back-title', 'Master Data >')
@section('title-1', 'Jenis Akun Transaksi')
@section('sub-title', 'Tambah Jenis Akun Transaksi')

@section('content')

<div class="form-container">
    <form id="jenisAkunTransaksiForm" action="#" method="POST">
        @csrf

        <div class="form-group">
            <label for="kode_aktiva">Kode Aktiva</label>
            <input type="text" id="kode_aktiva" name="kode_aktiva" placeholder="Masukkan kode aktiva" required>
        </div>

        <div class="form-group">
            <label for="jenis_transaksi">Jenis Transaksi</label>
            <input type="text" id="jenis_transaksi" name="jenis_transaksi" placeholder="Masukkan jenis transaksi" required>
        </div>

        <div class="form-group">
            <label for="akun">Akun</label>
            <select id="akun" name="akun" required>
                <option value="">-- Pilih Akun --</option>
                <option value="Aktiva">Aktiva</option>
                <option value="Pasiva">Pasiva</option>
            </select>
        </div>

        <div class="form-group">
            <label for="pemasukan">Pemasukan</label>
            <select id="pemasukan" name="pemasukan" required>
                <option value="">-- Pilih --</option>
                <option value="Y">Ya</option>
                <option value="T">Tidak</option>
            </select>
        </div>

        <div class="form-group">
            <label for="pengeluaran">Pengeluaran</label>
            <select id="pengeluaran" name="pengeluaran" required>
                <option value="">-- Pilih --</option>
                <option value="Y">Ya</option>
                <option value="T">Tidak</option>
            </select>
        </div>

        <div class="form-group">
            <label for="aktif">Aktif</label>
            <select id="aktif" name="aktif" required>
                <option value="">-- Pilih --</option>
                <option value="Y">Ya</option>
                <option value="T">Tidak</option>
            </select>
        </div>

        <div class="form-group">
            <label for="laba_rugi">Laba Rugi</label>
            <select id="laba_rugi" name="laba_rugi">
                <option value="">-- Pilih --</option>
                <option value="Pendapatan">Pendapatan</option>
                <option value="Biaya">Biaya</option>
            </select>
        </div>

        <div class="form-group">
            <label for="non_kas">Non Kas</label>
            <select id="non_kas" name="non_kas">
                <option value="">-- Pilih --</option>
                <option value="Y">Ya</option>
                <option value="T">Tidak</option>
            </select>
        </div>

        <div class="form-group">
            <label for="simpanan">Simpanan</label>
            <select id="simpanan" name="simpanan">
                <option value="">-- Pilih --</option>
                <option value="Y">Ya</option>
                <option value="T">Tidak</option>
            </select>
        </div>

        <div class="form-group">
            <label for="pinjaman">Pinjaman</label>
            <select id="pinjaman" name="pinjaman">
                <option value="">-- Pilih --</option>
                <option value="Y">Ya</option>
                <option value="T">Tidak</option>
            </select>
        </div>

        <div class="form-group">
            <label for="pinjam_dari">Pinjaman Dari</label>
            <select id="pinjam_dari" name="pinjam_dari">
                <option value="">-- Pilih --</option>
                <option value="Y">Ya</option>
                <option value="T">Tidak</option>
            </select>
        </div>

        <div class="form-group">
            <label for="angsuran">Angsuran</label>
            <select id="angsuran" name="angsuran">
                <option value="">-- Pilih --</option>
                <option value="Y">Ya</option>
                <option value="T">Tidak</option>
            </select>
        </div>

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
    width: 900px;
    margin-left: 10px;
    margin-top: 55px;
}

.form-group {
    margin-bottom: 15px;
}

label {
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 5px;
    display: block;
    color: #000000;
}

input[type="text"],
select {
    width: 100%;
    padding: 10px;
    border: 1px solid #565656;
    border-radius: 5px;
    font-size: 13px;
    background-color: #fff;
    box-sizing: border-box;
}

input:focus,
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

{{-- ======== SCRIPT POP-UP VALIDASI DAN KONFIRMASI ======== --}}
<script>
document.getElementById('jenisAkunTransaksiForm').addEventListener('submit', function(event) {
    event.preventDefault(); // cegah submit langsung

    const kode = document.getElementById('kode_aktiva').value.trim();
    const jenis = document.getElementById('jenis_transaksi').value.trim();
    const akun = document.getElementById('akun').value.trim();
    const pemasukan = document.getElementById('pemasukan').value.trim();
    const pengeluaran = document.getElementById('pengeluaran').value.trim();
    const aktif = document.getElementById('aktif').value.trim();

    if (!kode || !jenis || !akun || !pemasukan || !pengeluaran || !aktif) {
        alert('⚠️ Mohon isi semua kolom wajib sebelum menyimpan.');
        return;
    }

    const konfirmasi = confirm('Apakah data sudah benar dan ingin disimpan?');
    if (konfirmasi) {
        alert('✅ Data Jenis Akun Transaksi berhasil disimpan!');
        this.reset();
    }
});

document.getElementById('btnBatal').addEventListener('click', function() {
    const batal = confirm('Apakah Anda yakin ingin membatalkan pengisian data?');
    if (batal) {
        alert('❌ Pengisian data dibatalkan.');
        window.history.back();
    }
});
</script>

@endsection
