@extends('layouts.app-admin-add')

@section('title', 'Simpanan Setoran Tunai')
@section('back-url', url('admin/simpanan/setoran-tunai'))
@section('back-title', 'Transaksi Simpanan >')
@section('title-1', 'Setoran Tunai')
@section('sub-title', 'Tambah Data Setoran Tunai')

@section('content')

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li style="color:red">{{ $error }}</li>
        @endforeach
    </ul>
@endif

<div class="form-container">
    <form id="formSetoranTunai" action="{{ route('setoran-tunai.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- =======================
             TANGGAL TRANSAKSI
        ======================== --}}
        <label for="tanggal_transaksi">Tanggal Transaksi</label>
        <input type="datetime-local" id="tanggal_transaksi" name="tanggal_transaksi"
            value="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" required>

        <hr style="margin:20px 0; border:1px solid #ccc;">

        {{-- =======================
             IDENTITAS PENYETOR
        ======================== --}}
        <h4 style="font-size:14px; margin-bottom:10px;">Identitas Penyetor</h4>

        <label for="nama_anggota">Nama Anggota</label>
        <small style="display:block;margin-bottom:5px;color:#555;">Ketik sebagian nama untuk memunculkan daftar.</small>
        <input list="daftar_anggota" id="nama_anggota" name="nama_anggota" placeholder="Ketik nama anggota..." required>
        <input type="hidden" id="id_anggota" name="id_anggota" value="{{ old('id_anggota') }}">
        <datalist id="daftar_anggota">
            @foreach ($anggota as $a)
                <option data-id="{{ $a->id_anggota }}" value="{{ $a->nama_anggota }}"></option>
            @endforeach
        </datalist>

        <label for="id_jenis_simpanan">Jenis Simpanan</label>
        <select name="id_jenis_simpanan" id="id_jenis_simpanan" required>
            <option value="">-- Pilih Jenis Simpanan --</option>
            @foreach ($jenisSimpanan as $jenis)
                <option value="{{ $jenis->id_jenis_simpanan }}"
                    data-jumlah="{{ $jenis->jumlah_simpanan ?? 0 }}"
                    {{ old('id_jenis_simpanan') == $jenis->id_jenis_simpanan ? 'selected' : '' }}>
                    {{ $jenis->nama_simpanan }}
                </option>
            @endforeach
        </select>

        <label for="jumlah_simpanan">Jumlah Simpanan</label>
        <small style="display:block;margin-bottom:5px;color:#555;">Akan otomatis terisi jika jenis simpanan Pokok/Wajib.</small>
        <input type="number" id="jumlah_simpanan" name="jumlah_simpanan" placeholder="Masukkan jumlah setoran"
            value="{{ old('jumlah_simpanan') }}" required>

        <label for="keterangan">Keterangan</label>
        <input type="text" id="keterangan" name="keterangan" value="{{ old('keterangan') }}" placeholder="Opsional...">

        <label for="tujuan">Simpan Ke Kas</label>
        <select name="id_jenisAkunTransaksi_tujuan" id="id_jenisAkunTransaksi_tujuan" required>
            <option value="">-- Pilih Kas --</option>
            @foreach ($akunTransaksi as $akun)
                <option value="{{ $akun->id_jenisAkunTransaksi }}">
                    {{ $akun->nama_AkunTransaksi }}
                </option>
            @endforeach
        </select>

        <label for="bukti_setoran">Bukti Setoran</label>
        <input type="file" id="bukti_setoran" name="bukti_setoran" accept="image/*,application/pdf">

        {{-- =======================
             TOMBOL
        ======================== --}}
        <div class="form-buttons">
            <button type="submit" id="btnSimpan" class="btn btn-simpan">Simpan</button>
            <a href="{{ route('setoran-tunai.index') }}" class="btn btn-batal">Batal</a>
        </div>
    </form>
</div>

{{-- =======================
     STYLE
======================= --}}
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

/* Hilangkan icon dropdown di datalist */
input[list]::-webkit-calendar-picker-indicator {
    display: none !important;
    -webkit-appearance: none;
}
</style>

{{-- =======================
     SCRIPT
======================= --}}
<script>
(function(){
    const optEls = document.querySelectorAll('#daftar_anggota option');
    const list = Array.from(optEls).map(o => ({name: o.value, id: o.dataset.id}));
    const input = document.getElementById('nama_anggota');
    const hidden = document.getElementById('id_anggota');

    input.addEventListener('input', function() {
        const found = list.find(x => x.name === this.value.trim());
        hidden.value = found ? found.id : '';
    });
})();

document.addEventListener('DOMContentLoaded', function () {
    const jenisSelect = document.querySelector('#id_jenis_simpanan');
    const jumlahInput = document.querySelector('#jumlah_simpanan');
    const jenisData = @json($jenisSimpanan);

    jenisSelect.addEventListener('change', function () {
        const selectedId = this.value;
        const jenis = jenisData.find(j => j.id_jenis_simpanan == selectedId);

        if (!jenis) {
            jumlahInput.value = '';
            jumlahInput.removeAttribute('readonly');
            return;
        }

        const nama = jenis.nama_simpanan.toLowerCase();

        if (nama.includes('wajib') || nama.includes('pokok')) {
            jumlahInput.value = jenis.jumlah_simpanan;
            jumlahInput.setAttribute('readonly', true);
        } else {
            jumlahInput.value = '';
            jumlahInput.removeAttribute('readonly');
        }
    });
});

document.getElementById('formSetoranTunai').addEventListener('submit', function(e) {
    const wajib = ['id_anggota', 'id_jenis_simpanan', 'jumlah_simpanan', 'id_jenisAkunTransaksi_tujuan'];
    for (let id of wajib) {
        const el = document.getElementById(id);
        if (!el || !el.value.trim()) {
            alert('⚠️ Mohon isi semua kolom wajib sebelum menyimpan.');
            e.preventDefault();
            return;
        }
    }

    if (!confirm('Apakah data sudah benar dan ingin disimpan?')) {
        e.preventDefault();
        alert('❌ Pengisian data dibatalkan.');
        return;
    }
});
</script>

@endsection
