@extends('layouts.app-admin-add')

@section('title', 'Transaksi Non Kas')  
@section('back-url', url('admin/transaksi_non_kas/transaksi'))
@section('back-title', 'Transaksi Non Kas >')
@section('title-1', 'Transaksi')  
@section('sub-title', 'Edit Data Transaksi')  

@section('content')

@if ($errors->any())
  <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
@endif

<div class="form-container">
    <form action="{{ route('transaksi-non-kas.update', $TransaksiNonKas->id_transaksi) }}" 
          method="POST" id="form-edit">
        @csrf
        @method('PUT')

        <label for="tanggal_transaksi">Tanggal Transaksi</label>
        <input type="datetime-local" id="tanggal_transaksi" name="tanggal_transaksi"
            value="{{ old('tanggal_transaksi', \Carbon\Carbon::parse($TransaksiNonKas->tanggal_transaksi)->format('Y-m-d\TH:i')) }}">

        <label for="id_akun_tujuan">Akun Debit</label>
        <select name="id_akun_tujuan" id="id_akun_tujuan" required>
            <option value="" disabled>Pilih Kas</option>
            @foreach ($akunTujuan as $a)
                <option value="{{ $a->id_jenisAkunTransaksi }}"
                    {{ old('id_akun_tujuan', optional($akun_tujuan)->id_jenisAkunTransaksi) == $a->id_jenisAkunTransaksi ? 'selected' : '' }}>
                    {{ $a->kode_AkunTransaksi }} - {{ $a->nama_AkunTransaksi }}
                </option>
            @endforeach
        </select>

        <label for="id_jenisAkunTransaksi_sumber">Akun Kredit</label>

        <div id="detail-container">
            @foreach ($akun_sumber as $i => $detail)
            <div class="detail-row">

                <select name="sumber[{{ $i }}][id_jenisAkunTransaksi]" class="input-select">
                    <option value="" disabled>Pilih Akun</option>
                    @foreach ($akunSumber as $a)
                        <option value="{{ $a->id_jenisAkunTransaksi }}"
                            {{ $detail->id_jenisAkunTransaksi == $a->id_jenisAkunTransaksi ? 'selected' : '' }}>
                            {{ $a->kode_AkunTransaksi }} - {{ $a->nama_AkunTransaksi }}
                        </option>
                    @endforeach
                </select>

                <input type="number" name="sumber[{{ $i }}][jumlah]" 
                       class="input-number" 
                       value="{{ old('sumber.'.$i.'.jumlah', $detail->kredit) }}"
                       placeholder="Jumlah">

                <button type="button" class="btn btn-tambah" onclick="tambahBaris()">+</button>
                <button type="button" class="btn btn-hapus" onclick="hapusBaris(this)">x</button>

            </div>
            @endforeach
        </div>

        <label for="keterangan">Keterangan</label>
        <input type="text" id="keterangan" name="ket_transaksi"
               value="{{ old('ket_transaksi', $TransaksiNonKas->ket_transaksi) }}">

        <div class="form-buttons">
            <button type="submit" class="btn btn-simpan">Simpan</button>
            <a href="{{ route('transaksi-non-kas.index') }}" class="btn btn-batal">Batal</a>
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
        alert('⚠️ Minimal harus ada satu akun kredit.');
    }
}
</script>

@endsection
