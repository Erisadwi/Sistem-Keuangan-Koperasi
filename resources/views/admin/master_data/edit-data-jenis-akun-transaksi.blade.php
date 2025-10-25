@extends('layouts.app-admin-add')

@section('title', 'Edit Jenis Akun Transaksi')
@section('back-url', url('admin/master_data/jenis-akun-transaksi')) 
@section('back-title', 'Master Data >')
@section('title-1', 'Jenis Akun Transaksi')
@section('sub-title', 'Edit Jenis Akun Transaksi')

@section('content')

<div class="form-container">
    <form id="editJenisAkunTransaksiForm" action="{{ route('jenis-akun-transaksi.update', $jenis_akun_transaksi->id_jenisAkunTransaksi) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="kode_aktiva">Kode Aktiva</label>
            <input type="text" id="kode_aktiva" name="kode_aktiva" 
                value="{{ old('kode_aktiva', $jenis_akun_transaksi->kode_aktiva ?? '') }}" required>
        </div>
          
        <div class="form-group">
            <label for="nama_AkunTransaksi">Jenis Transaksi</label>
            <input type="text" id="nama_AkunTransaksi" name="nama_AkunTransaksi" 
                value="{{ old('nama_AkunTransaksi', $jenis_akun_transaksi->nama_AkunTransaksi ?? '') }}" required>
        </div>
      
        <div class="form-group">
            <label for="type_akun">Tipe Akun</label>
            <select id="type_akun" name="type_akun" required>
                <option value="">-- Pilih Akun --</option>
                <option value="ACTIVA" {{ old('type_akun', $jenis_akun_transaksi->type_akun ?? '') == 'ACTIVA' ? 'selected' : '' }}>ACTIVA</option>
                <option value="PASIVA" {{ old('type_akun', $jenis_akun_transaksi->type_akun ?? '') == 'PASIVA' ? 'selected' : '' }}>PASIVA</option>
            </select>
        </div>

        <div class="form-group">
            <label for="pemasukan">Pemasukan</label>
            <select id="pemasukan" name="pemasukan" required>
                <option value="">-- Pilih --</option>
                <option value="Y" {{ old('pemasukan', $jenis_akun_transaksi->pemasukan ?? '') == 'Y' ? 'selected' : '' }}>Ya</option>
                <option value="N" {{ old('pemasukan', $jenis_akun_transaksi->pemasukan ?? '') == 'N' ? 'selected' : '' }}>Tidak</option>
            </select>
        </div>
       
        <div class="form-group">
            <label for="pengeluaran">Pengeluaran</label>
            <select id="pengeluaran" name="pengeluaran" required>
                <option value="">-- Pilih --</option>
                <option value="Y" {{ old('pengeluaran', $jenis_akun_transaksi->pengeluaran ?? '') == 'Y' ? 'selected' : '' }}>Ya</option>
                <option value="N" {{ old('pengeluaran', $jenis_akun_transaksi->pengeluaran ?? '') == 'N' ? 'selected' : '' }}>Tidak</option>
            </select>
        </div>

        <div class="form-group">
            <label for="status_akun">Aktif</label>
            <select id="status_akun" name="status_akun" required>
                <option value="">-- Pilih --</option>
                <option value="Y" {{ old('status_akun', $jenis_akun_transaksi->status_akun ?? '') == 'Y' ? 'selected' : '' }}>Ya</option>
                <option value="N" {{ old('status_akun', $jenis_akun_transaksi->status_akun ?? '') == 'N' ? 'selected' : '' }}>Tidak</option>
            </select>
        </div>

        <div class="form-group">
            <label for="labarugi">Laba Rugi</label>
            <select id="labarugi" name="labarugi">
                <option value="">-- Pilih --</option>
                <option value="PENDAPATAN" {{ old('labarugi', $jenis_akun_transaksi->labarugi ?? '') == 'PENDAPATAN' ? 'selected' : '' }}>Pendapatan</option>
                <option value="BIAYA" {{ old('labarugi', $jenis_akun_transaksi->labarugi ?? '') == 'BIAYA' ? 'selected' : '' }}>Biaya</option>
            </select>
        </div>

        <div class="form-group">
            <label for="nonkas">Non Kas</label>
            <select id="nonkas" name="nonkas">
                <option value="">-- Pilih --</option>
                <option value="Y" {{ old('nonkas', $jenis_akun_transaksi->nonkas ?? '') == 'Y' ? 'selected' : '' }}>Ya</option>
                <option value="N" {{ old('nonkas', $jenis_akun_transaksi->nonkas ?? '') == 'N' ? 'selected' : '' }}>Tidak</option>
            </select>
        </div>

        <div class="form-group">
            <label for="simpanan">Simpanan</label>
            <select id="simpanan" name="simpanan">
                <option value="">-- Pilih --</option>
                <option value="Y" {{ old('simpanan', $jenis_akun_transaksi->simpanan ?? '') == 'Y' ? 'selected' : '' }}>Ya</option>
                <option value="N" {{ old('simpanan', $jenis_akun_transaksi->simpanan ?? '') == 'N' ? 'selected' : '' }}>Tidak</option>
            </select>
        </div>

        <div class="form-group">
            <label for="pinjaman">Pinjaman</label>
            <select id="pinjaman" name="pinjaman">
                <option value="">-- Pilih --</option>
                <option value="Y" {{ old('pinjaman', $jenis_akun_transaksi->pinjaman ?? '') == 'Y' ? 'selected' : '' }}>Ya</option>
                <option value="N" {{ old('pinjaman', $jenis_akun_transaksi->pinjaman ?? '') == 'N' ? 'selected' : '' }}>Tidak</option>
            </select>
        </div>

        <div class="form-group">
            <label for="pinjam_dari">Pinjaman Dari</label>
            <select id="pinjam_dari" name="pinjam_dari">
                <option value="">-- Pilih --</option>
                <option value="Y" {{ old('pinjaman_dari', $jenis_akun_transaksi->pinjaman_dari ?? '') == 'Y' ? 'selected' : '' }}>Ya</option>
                <option value="N" {{ old('pinjaman_dari', $jenis_akun_transaksi->pinjaman_dari ?? '') == 'N' ? 'selected' : '' }}>Tidak</option>
            </select>
        </div>

        <div class="form-group">
            <label for="angsuran">Angsuran</label>
            <select id="angsuran" name="angsuran">
                <option value="">-- Pilih --</option>
                <option value="Y" {{ old('angsuran', $jenis_akun_transaksi->angsuran ?? '') == 'Y' ? 'selected' : '' }}>Ya</option>
                <option value="N" {{ old('angsuran', $jenis_akun_transaksi->angsuran ?? '') == 'N' ? 'selected' : '' }}>Tidak</option>
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
    width: 98%;
    margin-left: 10px;
    margin-top: 40px;
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
    margin-top: 50px;
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
document.getElementById('editJenisAkunTransaksiForm').addEventListener('submit', function(e) {
    const wajib = ['kode_aktiva', 'nama_AkunTransaksi', 'type_akun', 'pemasukan', 'pengeluaran', 'status_akun'];

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

    alert('✅ Data berhasil disimpan!');
});

@endsection
