@extends('layouts.app-admin-add3')

@section('title', 'Simpanan Setoran Tunai')  
@section('back-title', 'Transaksi Simpanan >')
@section('title-1', 'Setoran Tunai')  
@section('sub-title', 'Edit Data Setoran Tunai')  

@section('content')

<div class="form-container">
    <form id="formEditSetoranTunai"
          action="#" {{-- nanti diganti route('simpanan.update', $data->id) --}}
          method="POST" enctype="multipart/form-data">
        @csrf
        {{-- @method('PUT') --}}

        {{-- Bagian Tanggal Transaksi --}}
        <label for="tanggal_transaksi">Tanggal Transaksi</label>
        <input type="datetime-local" id="tanggal_transaksi" name="tanggal_transaksi"
            value="{{ isset($data->tanggal_transaksi) ? \Carbon\Carbon::parse($data->tanggal_transaksi)->format('Y-m-d\TH:i') : '' }}" required>

        <hr style="margin:20px 0; border:1px solid #ccc;">

        {{-- Identitas Penyetor --}}
        <h4 style="font-size:14px; margin-bottom:10px;">Identitas Penyetor</h4>

        <label for="nama_penyetor">Nama Penyetor</label>
        <input type="text" id="nama_penyetor" name="nama_penyetor"
            value="{{ $data->nama_penyetor ?? '' }}" required>

        <label for="nomor_identitas">Nomor Identitas</label>
        <input type="text" id="nomor_identitas" name="nomor_identitas"
            value="{{ $data->nomor_identitas ?? '' }}" required>

        <label for="alamat">Alamat</label>
        <textarea id="alamat" name="alamat" rows="2" required
            style="width:100%; padding:8px; border:1px solid #565656; border-radius:5px;
                   font-size:13px; background-color:#fff; margin-bottom:15px;">{{ $data->alamat ?? '' }}</textarea>

        <hr style="margin:20px 0; border:1px solid #ccc;">

        {{-- Identitas Penerima --}}
        <h4 style="font-size:14px; margin-bottom:10px;">Identitas Penerima</h4>

        <label for="nama_anggota">Nama Anggota</label>
        <input type="text" id="nama_anggota" name="nama_anggota"
            value="{{ $data->nama_anggota ?? '' }}" required>

        <label for="jenis_simpanan">Jenis Simpanan</label>
        <select name="jenis_simpanan" id="jenis_simpanan" required>
            <option value="" disabled {{ !isset($data->jenis_simpanan) ? 'selected' : '' }}>-- Pilih Jenis Simpanan --</option>
            <option value="wajib" {{ (isset($data->jenis_simpanan) && $data->jenis_simpanan == 'wajib') ? 'selected' : '' }}>Simpanan Wajib</option>
            <option value="pokok" {{ (isset($data->jenis_simpanan) && $data->jenis_simpanan == 'pokok') ? 'selected' : '' }}>Simpanan Pokok</option>
            <option value="sukarela" {{ (isset($data->jenis_simpanan) && $data->jenis_simpanan == 'sukarela') ? 'selected' : '' }}>Simpanan Sukarela</option>
        </select>

        <label for="jumlah_simpanan">Jumlah Simpanan</label>
        <input type="number" id="jumlah_simpanan" name="jumlah_simpanan"
            value="{{ $data->jumlah_simpanan ?? '' }}" required>

        <label for="keterangan">Keterangan</label>
        <input type="text" id="keterangan" name="keterangan"
            value="{{ $data->keterangan ?? '' }}" placeholder="Opsional...">

        <label for="simpan_ke_kas">Simpan Ke Kas</label>
        <select name="simpan_ke_kas" id="simpan_ke_kas" required>
            <option value="" disabled {{ !isset($data->simpan_ke_kas) ? 'selected' : '' }}>-- Pilih Kas --</option>
            <option value="kas_besar" {{ (isset($data->simpan_ke_kas) && $data->simpan_ke_kas == 'kas_besar') ? 'selected' : '' }}>Kas Besar</option>
            <option value="bank_mandiri" {{ (isset($data->simpan_ke_kas) && $data->simpan_ke_kas == 'bank_mandiri') ? 'selected' : '' }}>Bank Mandiri</option>
            <option value="kas_kecil" {{ (isset($data->simpan_ke_kas) && $data->simpan_ke_kas == 'kas_kecil') ? 'selected' : '' }}>Kas Kecil</option>
            <option value="kas_niaga" {{ (isset($data->simpan_ke_kas) && $data->simpan_ke_kas == 'kas_niaga') ? 'selected' : '' }}>Kas Niaga</option>
            <option value="bank_bri" {{ (isset($data->simpan_ke_kas) && $data->simpan_ke_kas == 'bank_bri') ? 'selected' : '' }}>Bank BRI</option>
        </select>

        <label for="photo">Photo</label>
        <input type="file" id="photo" name="photo" accept="image/*"
               style="border:1px solid #565656; border-radius:5px; padding:6px; width:100%; font-size:13px; margin-bottom:20px;">

        {{-- tampilkan jika photo sudah ada --}}
        @if(isset($data->photo) && $data->photo)
            <div style="margin-bottom:10px;">
                <img src="{{ asset('storage/' . $data->photo) }}" alt="Foto Bukti" width="100" style="border-radius:5px;">
            </div>
        @endif

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
    width: 900px;
    margin-left: 10px;
    margin-top: 55px;
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
// Validasi dan konfirmasi simpan
document.getElementById('formEditSetoranTunai').addEventListener('submit', function(e) {
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

    if (confirm('Apakah Anda yakin ingin menyimpan perubahan data setoran tunai ini?')) {
        alert('✅ Data setoran tunai berhasil diperbarui!');
        // this.submit(); // aktifkan kalau sudah ada route
    }
});

// Tombol batal
document.getElementById('btnBatal').addEventListener('click', function() {
    if (confirm('Apakah Anda yakin ingin membatalkan perubahan?')) {
        alert('❌ Perubahan dibatalkan.');
        window.history.back();
    }
});
</script>

@endsection
