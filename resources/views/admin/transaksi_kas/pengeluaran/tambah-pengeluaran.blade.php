@extends('layouts.app-admin-add')

@section('title', 'Transaksi Kas')  
@section('back-url', route('pengeluaran.index'))
@section('back-title', 'Transaksi Kas >')
@section('title-1', 'Pengeluaran')  
@section('sub-title', 'Tambah Data Pengeluaran')  

@section('content')

<div class="form-container">
    <form id="formPengeluaranKas" action="{{ route('pengeluaran.store') }}" method="POST">
        @csrf
@if ($errors->any())
        <div style="color:red; margin-bottom:10px;">
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif
        <label for="tanggal_transaksi">Tanggal Transaksi*</label>
        <input type="datetime-local" id="tanggal_transaksi" name="tanggal_transaksi" 
               value="{{ old('tanggal_transaksi') }}" required>

       <label>Dari Kas*</label>
        <div id="detail-container">

            <div class="detail-row">
                <select name="sumber[0][id_jenisAkunTransaksi]" required>                 
                <option value="__placeholder" disabled selected>Pilih Kas</option>
                    @foreach ($akunSumber as $a)
                        <option value="{{ $a->id_jenisAkunTransaksi  }}">
                            {{ $a->kode_AkunTransaksi }} - {{ $a->nama_AkunTransaksi }}
                        </option>
                    @endforeach
                </select>

                <input type="number" name="sumber[0][jumlah]" class="input-number"
                    placeholder="Jumlah" required>

                <button type="button" class="btn btn-tambah" onclick="tambahBaris()">+</button>
                <button type="button" class="btn btn-hapus" onclick="hapusBaris(this)">x</button>
            </div>

        </div>

        <label>Untuk Akun*</label>
        <select name="id_akun_tujuan" required>
            <option value="__placeholder" disabled selected>Pilih Akun</option>
            @foreach ($akunTujuan as $a)
                <option value="{{ $a->id_jenisAkunTransaksi }}">
                    {{ $a->kode_AkunTransaksi }} - {{ $a->nama_AkunTransaksi }}
                </option>
            @endforeach
        </select>
        <label for="keterangan">Keterangan</label>
        <input type="text" id="keterangan" name="ket_transaksi" value="{{ old('ket_transaksi') }}">

        <div class="form-buttons">
            <button type="submit" class="btn btn-simpan">Simpan</button>
            <a href="{{ route('pengeluaran.index') }}" class="btn btn-batal">Batal</a>
        </div>
    </form>
</div>

<style>
.form-container {
    background-color: transparent;
    padding: 20px;
    border-radius: 10px;
    width: 98%;
    margin-left:10px;
    margin-top:40px;
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

.btn-simpan { background-color: #25E11B; color: #fff; }
.btn-batal  { background-color: #EA2828; color: #fff; }

.btn-tambah, .btn-hapus {
    width: 70px;
    height: 35px;
    font-size: 18px;
    font-weight: bold;
    border-radius: 50%;
    border: none;
    cursor: pointer;
    margin-left: 5px;
    color: white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.btn-tambah { background-color: #28a745; }
.btn-hapus  { background-color: #dc3545; }

.detail-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
}
</style>

<script>
function tambahBaris() {
    const container = document.getElementById('detail-container');
    const rows = container.querySelectorAll('.detail-row');
    const newIndex = rows.length;

    const selectPertama = rows[0].querySelector('select');
    const akunOptions = Array.from(selectPertama.options)
        .filter(o => o.value !== "__placeholder")
        .map(o => `<option value="${o.value}">${o.text}</option>`)
        .join('');

    const newRow = document.createElement('div');
    newRow.classList.add('detail-row');

    newRow.innerHTML = `
        <select name="sumber[${newIndex}][id_jenisAkunTransaksi]" required>
            <option value="__placeholder" disabled selected>Pilih Kas</option>
            ${akunOptions}
        </select>

        <input type="number" name="sumber[${newIndex}][jumlah]" 
               class="input-number" placeholder="Jumlah" required>

        <button type="button" class="btn btn-tambah" onclick="tambahBaris()">+</button>
        <button type="button" class="btn btn-hapus" onclick="hapusBaris(this)">x</button>
    `;

    container.appendChild(newRow);
}


function hapusBaris(button) {
    const container = document.getElementById('detail-container');
    if (container.querySelectorAll('.detail-row').length > 1) {
        button.closest('.detail-row').remove();
    } else {
        alert('⚠️ Minimal harus ada satu sumber kas.');
    }
}

document.getElementById('formPengeluaranKas').addEventListener('submit', function(e) {

    let error = false;

    // cek tanggal
    const tanggal = document.getElementById('tanggal_transaksi').value.trim();
    if (!tanggal) error = true;

    // cek sumber kas
    document.querySelectorAll('.detail-row').forEach((row) => {
        let akun = row.querySelector('select').value;
        let jumlah = row.querySelector('input[type="number"]').value.trim();

        if (akun === "__placeholder") error = true;
        if (jumlah === "" || Number(jumlah) <= 0) error = true;
    });

    // cek akun tujuan
    let akunTujuan = document.querySelector('select[name="id_akun_tujuan"]').value;
    if (akunTujuan === "__placeholder") error = true;

    if (error) {
        alert("⚠️ Mohon isi semua kolom wajib sebelum menyimpan.");
        e.preventDefault();
        return;
    }

    if (!confirm('Apakah data sudah benar dan ingin disimpan?')) {
        e.preventDefault();
    }
});
</script>




@endsection
