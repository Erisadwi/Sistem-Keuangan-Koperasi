@extends('layouts.app-admin-add')

@section('title', 'Saldo Awal Kas') 
@section('back-url', url('admin/master_data/saldo-awal-kas'))  
@section('back-title', 'Master Data >')
@section('title-1', 'Saldo Awal Kas')  
@section('sub-title', 'Edit Data Saldo Awal Kas')  

@section('content')

<div class="form-container">
    {{-- sementara action & route dikosongkan agar aman --}}
    <form id="saldoAwalKasForm" action="#" method="POST">
        @csrf
        {{-- nanti kalau sudah pakai controller: @method('PUT') --}}
        {{-- @method('PUT') --}}

        {{-- ======= Tanggal ======= --}}
        <div class="form-group">
            <label for="tanggal_transaksi">Tanggal</label>
            <input 
                type="datetime-local" 
                id="tanggal_transaksi" 
                name="tanggal_transaksi"
                {{-- jika nanti sudah ada data, bisa aktifkan ini --}}
                {{-- value="{{ old('tanggal_transaksi', isset($transaksi->tanggal_transaksi) ? \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('Y-m-d\TH:i') : '') }}" --}}
                required
            >
        </div>

        {{-- ======= Akun ======= --}}
        <div class="form-group">
            <label for="id_akun_transaksi">Akun</label>
            <select id="id_akun_transaksi" name="id_akun_transaksi" required>
                <option value="">-- Pilih Akun --</option>

                {{-- nanti kalau sudah terhubung DB bisa diaktifkan --}}
                {{-- 
                @if(isset($akunTransaksi) && count($akunTransaksi) > 0)
                    @foreach($akunTransaksi as $akun)
                        <option value="{{ $akun->id }}"
                            {{ isset($transaksi) && $transaksi->id_akun_transaksi == $akun->id ? 'selected' : '' }}>
                            {{ $akun->nama_akun }}
                        </option>
                    @endforeach
                @else
                    <option disabled>Tidak ada data akun</option>
                @endif 
                --}}
            </select>
        </div>

        {{-- ======= Keterangan ======= --}}
        <div class="form-group">
            <label for="ket_transaksi">Keterangan</label>
            <input 
                type="text" 
                id="ket_transaksi" 
                name="ket_transaksi"
                {{-- value="{{ old('ket_transaksi', $transaksi->ket_transaksi ?? '') }}" --}}
                placeholder="Masukkan keterangan"
            >
        </div>

        {{-- ======= Saldo Awal ======= --}}
        <div class="form-group">
            <label for="jumlah_transaksi">Saldo Awal</label>
            <input 
                type="number" 
                id="jumlah_transaksi" 
                name="jumlah_transaksi"
                {{-- value="{{ old('jumlah_transaksi', $transaksi->jumlah_transaksi ?? '') }}" --}}
                required 
                placeholder="Masukkan nominal saldo awal"
            >
        </div>

        {{-- ======= Tombol ======= --}}
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
input[type="number"],
input[type="datetime-local"],
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
    margin-top: 100px;
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
document.getElementById('saldoAwalKasForm').addEventListener('submit', function(event) {
    event.preventDefault(); // cegah submit langsung

    const tanggal = document.getElementById('tanggal_transaksi').value.trim();
    const akun = document.getElementById('id_akun_transaksi').value.trim();
    const keterangan = document.getElementById('ket_transaksi').value.trim();
    const jumlah = document.getElementById('jumlah_transaksi').value.trim();

    if (!tanggal || !akun || !jumlah) {
        alert('⚠️ Mohon isi semua kolom wajib sebelum menyimpan.');
        return;
    }

    const konfirmasi = confirm('Apakah Anda yakin ingin mengupdate data saldo awal kas ini?');
    if (konfirmasi) {
        alert('✅ Data saldo awal kas berhasil diperbarui!');
        this.reset();
    }
});

document.getElementById('btnBatal').addEventListener('click', function() {
    const batal = confirm('Apakah Anda yakin ingin membatalkan perubahan data?');
    if (batal) {
        alert('❌ Perubahan data dibatalkan.');
        window.history.back();
    }
});
</script>

@endsection
