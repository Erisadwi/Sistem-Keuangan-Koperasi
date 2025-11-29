@extends('layouts.app-admin-add')

@section('title', 'Tambah Bayar Angsuran')
@section('back-url', url('admin/pinjaman/bayar-angsuran')) 
@section('back-title', 'Bayar Angsuran >')
@section('title-1', 'Tambah Pelunasan Pinjaman')
@section('sub-title', 'Tambah Pelunasan Pinjaman')

@section('content')

<div class="form-container">
    <form action="{{ route('angsuran.storePelunasan', ['id_pinjaman' => $pinjaman->id_pinjaman]) }}" id="formbayar-angsuran" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="tanggal_bayar">Tanggal Transaksi*</label>
        <input type="datetime-local" id="tanggal_bayar" name="tanggal_bayar" 
        value="{{ isset($angsuran) ? \Carbon\Carbon::parse($angsuran->tanggal_bayar)->format('Y-m-d\TH:i') : '' }}">


        <label for="id_pinjaman">Nomor Pinjaman*</label>
        <input type="text" id="type_barang" name="id_pinjaman" value="{{ $pinjaman->id_pinjaman }}"readonly>
        
        <label for="sisaTagihan">Sisa Tagihan*</label>
        <input type="number" id="sisaTagihan" name="sisaTagihan" value="{{ $sisaTagihan }}"readonly>

        <label for="jumlah_angsuran">Jumlah Bayar*</label>
        <input type="number" id="jumlah_angsuran" name="angsuran_per_bulan" value="{{ $jumlahBayar ?? 0 }}">
        
        <label for="pokok_angsuran">Angsuran Pokok*</label>
        <input type="number" id="pokok_angsuran" name="angsuran_pokok" value="{{ $angsuranPokok ?? 0 }}"readonly>

        <label for="pendapatan">Pendapatan*</label>
        <input type="number" id="pendapatan" name="bunga_angsuran" value="{{ $bungaAngsuran ?? 0 }}"readonly>

        <label for="id_jenisAkunPendapatan">Akun Pendapatan*</label>
            <select name="id_jenisAkunPendapatan" id="id_jenisAkunPendapatan">
            <option value="" disabled {{ old('id_jenisAkunPendapatan') ? '' : 'selected' }}>Pilih Akun Pendapatan</option>
            @foreach ($akunPendapatan as $a)
                <option value="{{ $a->id_jenisAkunTransaksi }}"
                {{ (string)old('id_jenisAkunPendapatan', $Angsuran->id_jenisAkunPendapatan ?? '') === (string)$a->id_jenisAkunTransaksi ? 'selected' : '' }}>
                {{ $a->kode_AkunTransaksi }} - {{ $a->nama_AkunTransaksi }}
                </option>
            @endforeach
            </select>

        <label for="denda">Denda</label>
        <input type="number" id="denda" name="denda" value="{{ $denda }}"readonly>

        <label for="id_jenisAkunTransaksi_tujuan">Simpan ke Kas*</label>
            <select name="id_jenisAkunTransaksi_tujuan" id="id_jenisAkunTransaksi_tujuan">
            <option value="" disabled {{ old('id_jenisAkunTransaksi_tujuan') ? '' : 'selected' }}>Pilih Kas</option>
            @foreach ($akunTujuan as $a)
                <option value="{{ $a->id_jenisAkunTransaksi }}"
                {{ (string)old('id_jenisAkunTransaksi_tujuan', $Angsuran->id_jenisAkunTransaksi_tujuan ?? '') === (string)$a->id_jenisAkunTransaksi ? 'selected' : '' }}>
                {{ $a->kode_AkunTransaksi }} - {{ $a->nama_AkunTransaksi }}
                </option>
            @endforeach
            </select>

        <label for="keterangan">Keterangan</label>
        <input 
            type="text" 
            id="keterangan" 
            name="keterangan" 
            value="{{ old('keterangan', $keteranganDefault) }}" 
            class="form-control"
            @if($keteranganDefault == 'Pelunasan') readonly @endif>

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
    display: block;
    color: #000;
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

<script>
document.getElementById('formbayar-angsuran').addEventListener('submit', function(e) {
    const wajib = ['tanggal_bayar', 'id_jenisAkunTransaksi_tujuan', 'id_jenisAkunPendapatan'];

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

    alert('✅ Data pembayaran berhasil disimpan!');
});
</script>

@endsection
