@extends('layouts.app-admin-add')

@section('title', 'Transaksi Kas')  
@section('back-url', url('admin/transaksi_kas/transfer')) 
@section('back-title', 'Transaksi Kas >')
@section('title-1', 'Transfer')  
@section('sub-title', 'Tambah Data Transfer')  

@section('content')

<div class="form-container">
    <form action="{{ route('transaksi-transfer.store') }}" id="form-transfer" method="POST">
        @csrf

        <label for="tanggal_transaksi">Tanggal Transaksi*</label>
        <input type="datetime-local" id="tanggal_transaksi" name="tanggal_transaksi" 
                value="{{ old('tanggal_transaksi') }}">

        <label>Dari Kas*</label>
                <div id="detail-container">
                    <div class="detail-row">
                        <select name="sumber[0][id_jenisAkunTransaksi]" class="input-select">
                            <option value="" disabled selected>Pilih Akun</option>
                            @foreach ($akunSumber as $a)
                                <option value="{{ $a->id_jenisAkunTransaksi }}">
                                    {{ $a->kode_AkunTransaksi }} - {{ $a->nama_AkunTransaksi }}
                                </option>
                            @endforeach
                        </select>
                        <input type="number" name="sumber[0][jumlah]" class="input-number" placeholder="Jumlah">
                        <button type="button" class="btn btn-tambah" onclick="tambahBaris()">+</button>
                        <button type="button" class="btn btn-hapus" onclick="hapusBaris(this)">x</button>
                    </div>
                </div>

        <label for="id_jenisAkunTransaksi_tujuan">Untuk Kas*</label>
        <select name="id_akun_tujuan" id="id_akun_tujuan" required>
            <option value="" disabled selected>Pilih Kas</option>
            @foreach ($akunTujuan as $a)
                <option value="{{ $a->id_jenisAkunTransaksi }}"
                    {{ old('id_akun_tujuan') == $a->id_jenisAkunTransaksi ? 'selected' : '' }}>
                    {{ $a->kode_AkunTransaksi }} - {{ $a->nama_AkunTransaksi }}
                </option>
            @endforeach
        </select>

        <label for="keterangan">Keterangan</label>
        <input type="text" id="keterangan" name="ket_transaksi" value="{{ old('ket_transaksi') }}">


        <div class="form-buttons">
            <button type="submit" class="btn btn-simpan">Simpan</button>
            <a href="# {{-- {{ route('transaksi.index') }} --}}" class="btn btn-batal">Batal</a>
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
input[type="number"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #565656;
    border-radius: 5px;
    font-size: 13px;
    background-color: #fff;
}

input[type="text"]:focus,
input[type="datetime-local"]:focus,
input[type="number"]:focus {
    border-color: #565656;
    outline: none;
}

select {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #565656;
    border-radius: 5px;
    font-size: 13px;
    background-color: #fff;
}

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

.btn-tambah {
    background-color: #28a745;
}

.btn-hapus {
    background-color: #dc3545;
}

.btn-tambah:hover {
    background-color: #218838;
}

.btn-hapus:hover {
    background-color: #c82333;
}

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

    const akunOptions = rows[0].querySelector('select').innerHTML;

    const newRow = document.createElement('div');
    newRow.classList.add('detail-row');

    newRow.innerHTML = `
        <select name="sumber[${newIndex}][id_jenisAkunTransaksi]" class="input-select">
            ${akunOptions}
        </select>
        <input type="number" name="sumber[${newIndex}][jumlah]" class="input-number" placeholder="Jumlah">
        <button type="button" class="btn btn-tambah" onclick="tambahBaris()">+</button>
        <button type="button" class="btn btn-hapus" onclick="hapusBaris(this)">x</button>
    `;

    container.appendChild(newRow);
}

function hapusBaris(button) {
    const container = document.getElementById('detail-container');
    const row = button.closest('.detail-row');

    if (container.querySelectorAll('.detail-row').length > 1) {
        row.remove();
    } else {
        alert('⚠️ Minimal harus ada satu akun sumber.');
    }
}
document.getElementById('form-transfer').addEventListener('submit', function(e) {

    const tanggal = document.getElementById('tanggal_transaksi');
    const tujuan = document.getElementById('id_akun_tujuan');
    const detailRows = document.querySelectorAll('#detail-container .detail-row');

    if (!tanggal.value.trim()) {
        alert('⚠️ Mohon isi tanggal transaksi.');
        e.preventDefault();
        return;
    }

    if (detailRows.length === 0) {
        alert('⚠️ Minimal harus ada satu akun sumber.');
        e.preventDefault();
        return;
    }

    for (let i = 0; i < detailRows.length; i++) {
        const akun = detailRows[i].querySelector('select');
        const jumlah = detailRows[i].querySelector('input[type="number"]');

        if (!akun.value || !jumlah.value.trim()) {
            alert(`⚠️ Mohon lengkapi akun dan jumlah pada baris ke-${i + 1}.`);
            e.preventDefault();
            return;
        }
    }

    if (!tujuan.value.trim()) {
        alert('⚠️ Mohon pilih kas tujuan.');
        e.preventDefault();
        return;
    }

    const yakin = confirm('Apakah data sudah benar dan ingin disimpan?');

    if (!yakin) {
        e.preventDefault();
        alert('❌ Pengisian data dibatalkan.');
        return;
    }

    alert('✅ Data berhasil disimpan!');
});
</script>

@endsection