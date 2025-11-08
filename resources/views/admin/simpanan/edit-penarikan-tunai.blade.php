@extends('layouts.app-admin-add')

@section('title', 'Penarikan Tunai')  
@section('back-url', url('admin/simpanan/penarikan-tunai')) 
@section('back-title', 'Transaksi Simpanan >')
@section('title-1', 'Penarikan Tunai')  
@section('sub-title', 'Edit Data Penarikan Tunai')  

@section('content')

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li style="color:red">{{ $error }}</li>
        @endforeach
    </ul>
@endif

<div class="form-container">
    <form id="formEditPenarikanTunai"
          action="{{ route('penarikan-tunai.update', $penarikanTunai->id_simpanan) }}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label for="tanggal_transaksi">Tanggal Transaksi</label>
        <input type="datetime-local" id="tanggal_transaksi" name="tanggal_transaksi"
               value="{{ \Carbon\Carbon::parse($penarikanTunai->tanggal_transaksi)->format('Y-m-d\TH:i') }}" required>

        <hr style="margin:20px 0; border:1px solid #ccc;">

        <h4 style="font-size:14px; margin-bottom:10px;">Identitas Penarikan</h4>

        <input type="hidden" id="id_anggota" name="id_anggota" value="{{ $penarikanTunai->id_anggota }}">
        <label for="nama_anggota">Nama Anggota</label>
        <input type="text" id="nama_anggota" name="id_anggota"
                value="{{ $penarikanTunai->anggota->nama_anggota ?? '' }}"
                readonly
                style="background-color:#f5f5f5; cursor:not-allowed;">

        <label for="id_jenis_simpanan">Jenis Simpanan</label>
        <select name="id_jenis_simpanan" id="id_jenis_simpanan" required>
            <option value="">-- Pilih Jenis Simpanan --</option>
            @foreach ($jenisSimpanan as $jenis)
                <option value="{{ $jenis->id_jenis_simpanan }}"
                        data-jumlah="{{ $jenis->jumlah_simpanan ?? 0 }}"
                        {{ $penarikanTunai->id_jenis_simpanan == $jenis->id_jenis_simpanan ? 'selected' : '' }}>
                    {{ $jenis->jenis_simpanan }}
                </option>
            @endforeach
        </select>

        <label for="jumlah_simpanan">Jumlah Penarikan</label>
        <input type="number" id="jumlah_simpanan" name="jumlah_simpanan"
               value="{{ $penarikanTunai->jumlah_simpanan }}" required>

        <label for="keterangan">Keterangan</label>
        <input type="text" id="keterangan" name="keterangan"
               value="{{ $penarikanTunai->keterangan ?? '' }}" placeholder="Opsional...">

        <label for="id_jenisAkunTransaksi_tujuan">Ambil dari Kas</label>
        <select name="id_jenisAkunTransaksi_tujuan" id="id_jenisAkunTransaksi_tujuan" required>
            <option value="">-- Pilih Kas --</option>
            @foreach ($akunTransaksi as $akun)
                <option value="{{ $akun->id_jenisAkunTransaksi }}"
                    {{ $penarikanTunai->id_jenisAkunTransaksi_tujuan == $akun->id_jenisAkunTransaksi ? 'selected' : '' }}>
                    {{ $akun->nama_AkunTransaksi }}
                </option>
            @endforeach
        </select>

        <label for="bukti_setoran">Bukti Setoran</label>
        <input type="file" id="bukti_setoran" name="bukti_setoran" accept="image/*,application/pdf"
               class="form-control">

        {{-- Tombol Simpan & Batal --}}
        <div class="form-buttons">
            <button type="submit" id="btnSimpan" class="btn btn-simpan">Simpan</button>
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
    color: #000000;
}

input[type="text"],
input[type="datetime-local"],
input[type="number"],
input[type="file"],
select,
textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #565656;
    border-radius: 5px;
    font-size: 13px;
    background-color: #fff;
}

input:focus,
select:focus,
textarea:focus {
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

<script>
document.getElementById('formEditPenarikanTunai').addEventListener('submit', function(e) {
    const wajib = [''];

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

    alert('✅ Data barang berhasil disimpan!');
});
</script>

@endsection
