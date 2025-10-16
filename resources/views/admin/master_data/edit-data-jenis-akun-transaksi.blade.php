@extends('layouts.app-admin-add3')

@section('title', 'Edit Jenis Akun Transaksi')
@section('back-title', 'Master Data >')
@section('title-1', 'Jenis Akun Transaksi')
@section('sub-title', 'Edit Jenis Akun Transaksi')

@section('content')

<div class="form-container">
    {{-- FORM EDIT --}}
    <form id="editJenisAkunTransaksiForm" action="#" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="kode_aktiva">Kode Aktiva</label>
            <input type="text" id="kode_aktiva" name="kode_aktiva" 
                value="{{ $jenisAkunTransaksi->kode_aktiva ?? '' }}" required>
        </div>

        <div class="form-group">
            <label for="jenis_transaksi">Jenis Transaksi</label>
            <input type="text" id="jenis_transaksi" name="jenis_transaksi" 
                value="{{ $jenisAkunTransaksi->jenis_transaksi ?? '' }}" required>
        </div>

        <div class="form-group">
            <label for="akun">Akun</label>
            <select id="akun" name="akun" required>
                <option value="">-- Pilih Akun --</option>
                <option value="Aktiva" {{ (isset($jenisAkunTransaksi) && $jenisAkunTransaksi->akun == 'Aktiva') ? 'selected' : '' }}>Aktiva</option>
                <option value="Pasiva" {{ (isset($jenisAkunTransaksi) && $jenisAkunTransaksi->akun == 'Pasiva') ? 'selected' : '' }}>Pasiva</option>
            </select>
        </div>

        <div class="form-group">
            <label for="pemasukan">Pemasukan</label>
            <select id="pemasukan" name="pemasukan" required>
                <option value="">-- Pilih --</option>
                <option value="Y" {{ (isset($jenisAkunTransaksi) && $jenisAkunTransaksi->pemasukan == 'Y') ? 'selected' : '' }}>Ya</option>
                <option value="T" {{ (isset($jenisAkunTransaksi) && $jenisAkunTransaksi->pemasukan == 'T') ? 'selected' : '' }}>Tidak</option>
            </select>
        </div>

        <div class="form-group">
            <label for="pengeluaran">Pengeluaran</label>
            <select id="pengeluaran" name="pengeluaran" required>
                <option value="">-- Pilih --</option>
                <option value="Y" {{ (isset($jenisAkunTransaksi) && $jenisAkunTransaksi->pengeluaran == 'Y') ? 'selected' : '' }}>Ya</option>
                <option value="T" {{ (isset($jenisAkunTransaksi) && $jenisAkunTransaksi->pengeluaran == 'T') ? 'selected' : '' }}>Tidak</option>
            </select>
        </div>

        <div class="form-group">
            <label for="aktif">Aktif</label>
            <select id="aktif" name="aktif" required>
                <option value="">-- Pilih --</option>
                <option value="Y" {{ (isset($jenisAkunTransaksi) && $jenisAkunTransaksi->aktif == 'Y') ? 'selected' : '' }}>Ya</option>
                <option value="T" {{ (isset($jenisAkunTransaksi) && $jenisAkunTransaksi->aktif == 'T') ? 'selected' : '' }}>Tidak</option>
            </select>
        </div>

        <div class="form-group">
            <label for="laba_rugi">Laba Rugi</label>
            <select id="laba_rugi" name="laba_rugi">
                <option value="">-- Pilih --</option>
                <option value="Pendapatan" {{ (isset($jenisAkunTransaksi) && $jenisAkunTransaksi->laba_rugi == 'Pendapatan') ? 'selected' : '' }}>Pendapatan</option>
                <option value="Biaya" {{ (isset($jenisAkunTransaksi) && $jenisAkunTransaksi->laba_rugi == 'Biaya') ? 'selected' : '' }}>Biaya</option>
            </select>
        </div>

        <div class="form-group">
            <label for="non_kas">Non Kas</label>
            <select id="non_kas" name="non_kas">
                <option value="">-- Pilih --</option>
                <option value="Y" {{ (isset($jenisAkunTransaksi) && $jenisAkunTransaksi->non_kas == 'Y') ? 'selected' : '' }}>Ya</option>
                <option value="T" {{ (isset($jenisAkunTransaksi) && $jenisAkunTransaksi->non_kas == 'T') ? 'selected' : '' }}>Tidak</option>
            </select>
        </div>

        <div class="form-group">
            <label for="simpanan">Simpanan</label>
            <select id="simpanan" name="simpanan">
                <option value="">-- Pilih --</option>
                <option value="Y" {{ (isset($jenisAkunTransaksi) && $jenisAkunTransaksi->simpanan == 'Y') ? 'selected' : '' }}>Ya</option>
                <option value="T" {{ (isset($jenisAkunTransaksi) && $jenisAkunTransaksi->simpanan == 'T') ? 'selected' : '' }}>Tidak</option>
            </select>
        </div>

        <div class="form-group">
            <label for="pinjaman">Pinjaman</label>
            <select id="pinjaman" name="pinjaman">
                <option value="">-- Pilih --</option>
                <option value="Y" {{ (isset($jenisAkunTransaksi) && $jenisAkunTransaksi->pinjaman == 'Y') ? 'selected' : '' }}>Ya</option>
                <option value="T" {{ (isset($jenisAkunTransaksi) && $jenisAkunTransaksi->pinjaman == 'T') ? 'selected' : '' }}>Tidak</option>
            </select>
        </div>

        <div class="form-group">
            <label for="pinjam_dari">Pinjaman Dari</label>
            <select id="pinjam_dari" name="pinjam_dari">
                <option value="">-- Pilih --</option>
                <option value="Y" {{ (isset($jenisAkunTransaksi) && $jenisAkunTransaksi->pinjam_dari == 'Y') ? 'selected' : '' }}>Ya</option>
                <option value="T" {{ (isset($jenisAkunTransaksi) && $jenisAkunTransaksi->pinjam_dari == 'T') ? 'selected' : '' }}>Tidak</option>
            </select>
        </div>

        <div class="form-group">
            <label for="angsuran">Angsuran</label>
            <select id="angsuran" name="angsuran">
                <option value="">-- Pilih --</option>
                <option value="Y" {{ (isset($jenisAkunTransaksi) && $jenisAkunTransaksi->angsuran == 'Y') ? 'selected' : '' }}>Ya</option>
                <option value="T" {{ (isset($jenisAkunTransaksi) && $jenisAkunTransaksi->angsuran == 'T') ? 'selected' : '' }}>Tidak</option>
            </select>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn btn-simpan">Update</button>
            <button type="button" id="btnBatal" class="btn btn-batal">Batal</button>
        </div>
    </form>
</div>

{{-- === STYLE SAMA DENGAN HALAMAN TAMBAH === --}}
<style>
.form-container {
    background-color: transparent;
    padding: 20px;
    border-radius: 10px;
    width: 900px;
    margin-left: 10px;
    margin-top: 55px;
}
.form-group { margin-bottom: 15px; }
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
    width: 120px;
    text-align: center;
    box-shadow: 0 4px 4px rgba(0, 0, 0, 0.293);
}
.btn-simpan { background-color: #25E11B; color: #fff; }
.btn-simpan:hover { background-color: #45a049; }
.btn-batal { background-color: #EA2828; color: #fff; }
.btn-batal:hover { background-color: #d73833; }
</style>

{{-- ======== SCRIPT POP-UP VALIDASI DAN KONFIRMASI ======== --}}
<script>
document.getElementById('editJenisAkunTransaksiForm').addEventListener('submit', function(event) {
    event.preventDefault();

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

    const konfirmasi = confirm('Apakah Anda yakin ingin memperbarui data ini?');
    if (konfirmasi) {
        alert('✅ Data Jenis Akun Transaksi berhasil diperbarui!');
        this.reset(); // sementara reset, nanti ganti dengan redirect setelah tersambung DB
    }
});

document.getElementById('btnBatal').addEventListener('click', function() {
    const batal = confirm('Apakah Anda yakin ingin membatalkan perubahan?');
    if (batal) {
        alert('❌ Perubahan dibatalkan.');
        window.history.back();
    }
});
</script>

@endsection
