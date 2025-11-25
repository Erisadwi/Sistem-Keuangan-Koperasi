@extends('layouts.app-admin-add')

@section('title', 'Transaksi Kas')  
@section('back-url', route('pengeluaran.index'))
@section('back-title', 'Transaksi Kas >')
@section('title-1', 'Pengeluaran')  
@section('sub-title', 'Edit Data Pengeluaran')  

@section('content')

<div class="form-container">
    <form id="formEditPengeluaranKas" 
          action="{{ route('pengeluaran.update', $TransaksiPengeluaran->id_transaksi) }}"
          method="POST">
        @csrf
        @method('PUT')

        {{-- ============================
             TANGGAL TRANSAKSI
        ============================= --}}
        <label for="tanggal_transaksi">Tanggal Transaksi*</label>
        <input type="datetime-local" id="tanggal_transaksi" name="tanggal_transaksi" 
               value="{{ old('tanggal_transaksi', \Carbon\Carbon::parse($TransaksiPengeluaran->tanggal_transaksi)->format('Y-m-d\TH:i')) }}"
               required>

        {{-- ============================
             SUMBER KAS (MULTIPLE)
        ============================= --}}
        <label>Dari Kas*</label>
        <div id="detail-container">
            @foreach ($akun_sumber as $i => $detail)
            <div class="detail-row">
                <select name="sumber[{{ $i }}][id_jenisAkunTransaksi]" required>
                    <option value="" disabled>Pilih Akun</option>
                    @foreach ($akunSumber as $a)
                        <option value="{{ $a->id_jenisAkunTransaksi  }}"
                            {{ $detail->id_jenisAkunTransaksi == $a->id_jenisAkunTransaksi  ? 'selected' : '' }}>
                            {{ $a->kode_AkunTransaksi }} - {{ $a->nama_AkunTransaksi }}
                        </option>
                    @endforeach
                </select>

                <input type="number" 
                       name="sumber[{{ $i }}][jumlah]" 
                       value="{{ old('sumber.'.$i.'.jumlah', $detail->kredit) }}" 
                       placeholder="Jumlah" required>

                <button type="button" class="btn btn-tambah" onclick="tambahBaris()">+</button>
                <button type="button" class="btn btn-hapus" onclick="hapusBaris(this)">x</button>
            </div>
            @endforeach
        </div>

        {{-- ============================
             AKUN TUJUAN
        ============================= --}}
        <label>Untuk Akun*</label>
        <select name="id_akun_tujuan" required>
            <option value="" disabled>Pilih Akun</option>
            @foreach ($akunTujuan as $a)
                <option value="{{ $a->id_jenisAkunTransaksi  }}"
                    {{ old('id_akun_tujuan', optional($akun_tujuan)->id_jenisAkunTransaksi) == $a->id_jenisAkunTransaksi  ? 'selected' : '' }}>
                    {{ $a->kode_AkunTransaksi }} - {{ $a->nama_AkunTransaksi }}
                </option>
            @endforeach
        </select>


        {{-- ============================
             KETERANGAN
        ============================= --}}
        <label for="keterangan">Keterangan</label>
        <input type="text" id="keterangan" name="ket_transaksi" 
               value="{{ old('ket_transaksi', $TransaksiPengeluaran->ket_transaksi) }}">

        <div class="form-buttons">
            <button type="submit" class="btn btn-simpan">Simpan</button>
            <a href="{{ route('pengeluaran.index') }}" class="btn btn-batal">Batal</a>
        </div>
    </form>
</div>

{{-- =============================
      STYLE
============================= --}}
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

.btn-tambah, 
.btn-hapus {
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

{{-- =============================
      SCRIPT
============================= --}}
<script>
function tambahBaris() {
    const container = document.getElementById('detail-container');
    const rows = container.querySelectorAll('.detail-row');
    const newIndex = rows.length;

    const akunOptions = rows[0].querySelector('select').innerHTML;

    const newRow = document.createElement('div');
    newRow.classList.add('detail-row');

    newRow.innerHTML = `
        <select name="sumber[${newIndex}][id_jenisAkunTransaksi]" required>
            ${akunOptions}
        </select>

        <input type="number" name="sumber[${newIndex}][jumlah]" 
               placeholder="Jumlah" required>

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

document.getElementById('formEditPengeluaranKas')
.addEventListener('submit', function(e){
    if (!confirm("Apakah data sudah benar dan ingin disimpan?")) {
        e.preventDefault();
        alert("❌ Pengisian data dibatalkan.");
    }
});
</script>

@endsection
