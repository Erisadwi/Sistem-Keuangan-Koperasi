@extends('layouts.app-admin-add')

@section('title', 'Saldo Awal Kas')  
@section('back-url', url('admin/master_data/saldo-awal-kas'))
@section('back-title', 'Master Data >')
@section('title-1', 'Saldo Awal Kas')  
@section('sub-title', 'Tambah Data Saldo Awal Kas')  

@section('content')

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li style="color:red">{{ $error }}</li>
        @endforeach
    </ul>
@endif

<div class="form-container">
    <form id="saldoAwalKasForm"  action="{{ route('saldo-awal-kas.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="tanggal_transaksi">Tanggal*</label>
            <input type="datetime-local" id="tanggal_transaksi" name="tanggal_transaksi"
                   value="{{ old('tanggal_transaksi') }}" required>
        </div>

        <div class="form-group">
            <label for="id_jenisAkunTransaksi_tujuan">Akun*</label>
            <select id="id_jenisAkunTransaksi_tujuan" name="id_jenisAkunTransaksi_tujuan" required>
                <option value="">-- Pilih Akun Kas --</option>
                        @foreach ($akunKas as $akun)
                            <option value="{{ $akun->id_jenisAkunTransaksi }}">
                                {{ $akun->nama_AkunTransaksi }}
                            </option>
                        @endforeach
            </select>
        </div>
        

        <div class="form-group">
            <label for="ket_transaksi">Keterangan</label>
            <input type="text" id="ket_transaksi" name="ket_transaksi"
                   value="{{ old('ket_transaksi') }}" placeholder="Masukkan keterangan">
        </div>

        <div class="form-group">
            <label for="jumlah_transaksi">Saldo Awal*</label>
            <input type="number" id="jumlah_transaksi" name="jumlah_transaksi"
                   value="{{ old('jumlah_transaksi') }}" step="0.01" required
                   placeholder="Masukkan nominal saldo awal">
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
document.getElementById('saldoAwalKasForm').addEventListener('submit', function(e) {
    const wajib = ['tanggal_transaksi', 'id_jenisAkunTransaksi_tujuan', 'jumlah_transaksi'];

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

    const btnBatal = document.getElementById('btnBatal');
    if (btnBatal) {
        btnBatal.addEventListener('click', function() {
            window.location.href = "{{ route('saldo-awal-kas.index') }}";
        });
    }
</script>

@endsection