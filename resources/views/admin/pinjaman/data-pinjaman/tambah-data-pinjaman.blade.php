@extends('layouts.app-admin-add')

@section('title', 'Data Pinjaman')  
@section('back-url', url('admin/pinjaman/data-pinjaman')) 
@section('back-title', 'Pinjaman >')
@section('title-1', 'Data Pinjaman')  
@section('sub-title', 'Tambah Data Pinjaman')  

@section('content')

<div class="form-container">
    <div class="form-wrapper"> 
    <form id="formDataPinjaman" action="{{ route('pinjaman.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

        <div class="form-group">
            <label for="tanggal_pinjaman">Tanggal Pinjaman</label>
            <input type="datetime-local" id="tanggal_pinjaman" name="tanggal_pinjaman">
        </div>

        <div class="form-group">
            <label for="nama_anggota">Nama Anggota</label>
            <div class="anggota-input-wrapper">
                <input list="daftar_anggota" id="nama_anggota" name="nama_anggota" 
                       placeholder="" required>
                <input type="hidden" id="id_anggota" name="id_anggota" value="{{ old('id_anggota') }}">
                <datalist id="daftar_anggota">
                    @foreach ($anggota as $a)
                    <option data-id="{{ $a->id_anggota }}" value="{{ $a->nama_anggota }}"></option>
                    @endforeach
                </datalist>
                <span class="anggota-icon"><i class="fa fa-user"></i></span>
            </div>
        </div>

        <div class="form-group">
            <label for="jumlah_pinjaman">Jumlah Pinjaman*</label>
            <input type="number" id="jumlah_pinjaman" name="jumlah_pinjaman">
        </div>

        <div class="form-group">
            <label for="lama_angsuran">Lama Angsuran (Bulan)*</label>
            <select id="id_lamaAngsuran" name="id_lamaAngsuran" class="form-input" required>
                <option value="">Pilih Lama Angsuran</option>
                @foreach ($lamaAngsuran as $item)
                    <option value="{{ $item->id_lamaAngsuran }}">{{ $item->lama_angsuran }} bulan</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="pokok_angsuran">Pokok Angsuran (Rp)</label>
            <input type="text" id="pokok_angsuran" name="pokok_angsuran" readonly>
        </div>

        <div class="form-group">
            <label for="suku_bunga_pinjaman">Bunga (Rp)*</label>
            <input type="text" id="suku_bunga_pinjaman" name="suku_bunga_pinjaman" readonly>
        </div>

        <div class="form-group">
            <label for="biaya_administrasi">Biaya Admin (Rp)*</label>
            <input type="text" id="biaya_administrasi" name="biaya_administrasi" readonly>
        </div>

        <div class="form-group">
            <label for="id_jenisAkunTransaksi_tujuan">Pilih akun*</label>
            <select name="id_jenisAkunTransaksi_tujuan" id="id_jenisAkunTransaksi_tujuan">
            <option value="" disabled {{ old('id_jenisAkunTransaksi_tujuan') ? '' : 'selected' }}>Pilih Akun</option>
            @foreach ($akunTujuan as $a)
                <option value="{{ $a->id_jenisAkunTransaksi }}"
                {{ (string)old('id_jenisAkunTransaksi_tujuan', $TransaksiTransfer->id_jenisAkunTransaksi_tujuan ?? '') === (string)$a->id_jenisAkunTransaksi ? 'selected' : '' }}>
                {{ $a->kode_AkunTransaksi }} - {{ $a->nama_AkunTransaksi }}
                </option>
            @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="id_jenisAkunTransaksi_sumber">Ambil dari Kas*</label>
            <select name="id_jenisAkunTransaksi_sumber" id="id_jenisAkunTransaksi_sumber">
            <option value="" disabled {{ old('id_jenisAkunTransaksi_sumber') ? '' : 'selected' }}>Pilih Kas</option>
            @foreach ($akunSumber as $a)
                <option value="{{ $a->id_jenisAkunTransaksi }}"
                {{ (string)old('id_jenisAkunTransaksi_sumber', $TransaksiTransfer->id_jenisAkunTransaksi_sumber ?? '') === (string)$a->id_jenisAkunTransaksi ? 'selected' : '' }}>
                {{ $a->kode_AkunTransaksi }} - {{ $a->nama_AkunTransaksi }}
                </option>
            @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <input type="text" id="keterangan" name="keterangan"
                   value="{{ old('keterangan') }}" placeholder="Masukkan keterangan">
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn btn-simpan">Simpan</button>
            <a href="#" class="btn btn-batal">Batal</a>
        </div>
    </form>
    </div>
</div>

<style>
.form-container {
    background-color: transparent;
    width: 98%;
    margin-left: 10px;
    margin-top: 40px;
}

.form-wrapper {
    background-color: #c7dbe6;
    border-radius: 8px;
    padding: 20px;
    box-sizing: border-box;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 5px;
    color: #000;
}

input[type="text"],
input[type="number"],
input[type="file"],
input[type="datetime-local"],
select {
  width: 100%;
  padding: 8px;
  border: 1px solid #565656;
  border-radius: 5px;
  font-size: 13px;
  background-color: #fff;
  box-sizing: border-box;
}

input:focus, select:focus {
    outline: none;
    border-color: #1976d2;
    box-shadow: 0 0 2px rgba(25, 118, 210, 0.5);
}

/* === Revisi Khusus Nama Anggota === */
.anggota-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

#nama_anggota {
    width: 100%;
    padding: 8px 35px 8px 10px;
    border: 1px solid #565656;
    border-radius: 5px;
    font-size: 13px;
    background-color: #fff;
    box-sizing: border-box;
}

.anggota-icon {
    position: absolute;
    right: 10px;
    color: #1976d2;
    font-size: 15px;
}

.form-buttons {
    display: flex;
    justify-content: flex-end; 
    gap: 10px;
    margin-top: 50px;
}

.btn {
    padding: 8px 0;
    width: 110px;
    font-size: 14px;
    font-weight: bold;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    color: #fff;
    box-shadow: 0 3px 4px rgba(0, 0, 0, 0.2);
    text-align: center;
}

.btn-simpan {
    background-color: #25E11B;
}

.btn-simpan:hover {
    background-color: #1db115;
}

.btn-batal {
    background-color: #EA2828;
}

.btn-batal:hover {
    background-color: #c71e1e;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const jumlahInput = document.getElementById('jumlah_pinjaman');
    const lamaSelect = document.getElementById('id_lamaAngsuran');
    const bungaInput = document.getElementById('suku_bunga_pinjaman');
    const adminInput = document.getElementById('biaya_administrasi');
    const pokokInput = document.getElementById('pokok_angsuran');

    const bungaRate = parseFloat(@json(\App\Models\SukuBunga::first()->suku_bunga_pinjaman ?? 0));
    const adminRate = parseFloat(@json(\App\Models\SukuBunga::first()->biaya_administrasi ?? 0));

    function hitungOtomatis() {
        const jumlah = parseFloat(jumlahInput.value) || 0;
        const lamaValue = parseFloat(lamaSelect.options[lamaSelect.selectedIndex]?.text.replace('bulan', '').trim()) || 0;

        if (jumlah > 0 && lamaValue > 0) {
            const pokok = jumlah / lamaValue;
            const bunga = ((bungaRate / 100) * jumlah) / lamaValue; 
            const admin = (adminRate / 100) * jumlah;

            pokokInput.value = pokok.toFixed(2);
            bungaInput.value = bunga.toFixed(2);
            adminInput.value = admin.toFixed(2);
        } else {
            pokokInput.value = '';
            bungaInput.value = '';
            adminInput.value = '';
        }
    }

    jumlahInput.addEventListener('input', hitungOtomatis);
    lamaSelect.addEventListener('change', hitungOtomatis);

    // === Script untuk otomatis set ID anggota ===
    const namaInput = document.getElementById('nama_anggota');
    const idHidden = document.getElementById('id_anggota');
    const dataList = document.getElementById('daftar_anggota').options;

    namaInput.addEventListener('input', function() {
        const val = this.value;
        idHidden.value = '';
        for (let i = 0; i < dataList.length; i++) {
            if (dataList[i].value === val) {
                idHidden.value = dataList[i].dataset.id;
                break;
            }
        }
    });
});
</script>

@endsection
