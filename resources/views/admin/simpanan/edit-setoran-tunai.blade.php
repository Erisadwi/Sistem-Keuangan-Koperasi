@extends('layouts.app-admin-add')

@section('title', 'Simpanan Setoran Tunai')  
@section('back-url', url('admin/simpanan/setoran-tunai')) 
@section('back-title', 'Transaksi Simpanan >')
@section('title-1', 'Setoran Tunai')  
@section('sub-title', 'Edit Setoran Tunai')  

@section('content')

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li style="color:red">{{ $error }}</li>
        @endforeach
    </ul>
@endif

<div class="form-container">
    <form id="formEditSetoranTunai"
          action="{{ route('setoran-tunai.update', $setoranTunai->id_simpanan) }}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Tanggal Transaksi --}}
        <label for="tanggal_transaksi">Tanggal Transaksi</label>
        <input type="datetime-local" id="tanggal_transaksi" name="tanggal_transaksi"
               value="{{ \Carbon\Carbon::parse($setoranTunai->tanggal_transaksi)->format('Y-m-d\TH:i') }}" required>

        {{-- Identitas Penyetor --}}
        <h4 style="font-size:14px; margin-bottom:10px;">Identitas Penyetor</h4>

        <input type="hidden" id="id_anggota" name="id_anggota" value="{{ $setoranTunai->id_anggota }}">
        <label for="nama_anggota">Nama Anggota</label>
        <input type="text" id="nama_anggota" name="nama_anggota"
                value="{{ $setoranTunai->anggota->nama_anggota ?? '' }}"
                readonly
                style="background-color:#f5f5f5; cursor:not-allowed;">

        {{-- Jenis Simpanan --}}
        <label for="id_jenis_simpanan">Jenis Simpanan</label>
        <select name="id_jenis_simpanan" id="id_jenis_simpanan" required>
            <option value="">-- Pilih Jenis Simpanan --</option>
            @foreach ($jenisSimpanan as $jenis)
                <option value="{{ $jenis->id_jenis_simpanan }}"
                        data-jumlah="{{ $jenis->jumlah_simpanan ?? 0 }}"
                        {{ $setoranTunai->id_jenis_simpanan == $jenis->id_jenis_simpanan ? 'selected' : '' }}>
                    {{ $jenis->jenis_simpanan }}
                </option>
            @endforeach
        </select>

        {{-- Jumlah Simpanan --}}
        <label for="jumlah_simpanan">Jumlah Simpanan</label>
        <input type="number" id="jumlah_simpanan" name="jumlah_simpanan"
               value="{{ $setoranTunai->jumlah_simpanan }}" required>

        {{-- Keterangan --}}
        <label for="keterangan">Keterangan</label>
        <input type="text" id="keterangan" name="keterangan"
               value="{{ $setoranTunai->keterangan ?? '' }}" placeholder="Opsional...">

        {{-- Simpan ke Kas --}}
        <label for="id_jenisAkunTransaksi_tujuan">Simpan Ke Kas</label>
        <select name="id_jenisAkunTransaksi_tujuan" id="id_jenisAkunTransaksi_tujuan" required>
            <option value="">-- Pilih Kas --</option>
            @foreach ($akunTransaksi as $akun)
                <option value="{{ $akun->id_jenisAkunTransaksi }}"
                    {{ $setoranTunai->id_jenisAkunTransaksi_tujuan == $akun->id_jenisAkunTransaksi ? 'selected' : '' }}>
                    {{ $akun->nama_AkunTransaksi }}
                </option>
            @endforeach
        </select>

        {{-- Bukti Setoran --}}
        <label for="bukti_setoran">Bukti Setoran</label>
        <input type="file" id="bukti_setoran" name="bukti_setoran" accept="image/*,application/pdf"
               class="form-control">

        @if($setoranTunai->bukti_setoran)
            <div style="margin-bottom:10px;">
                <img src="{{ asset('storage/' . $setoranTunai->bukti_setoran) }}" alt="Bukti Setoran" width="100" style="border-radius:5px;">
            </div>
        @endif

        {{-- Tombol --}}
        <div class="form-buttons">
            <button type="submit" class="btn btn-simpan">Simpan</button>
            <button type="button" id="btnBatal" class="btn btn-batal">Batal</button>
        </div>
    </form>
</div>

{{-- STYLE --}}
<style>
.form-container { background-color: transparent; padding:20px; border-radius:10px; width:98%; margin-left:10px; margin-top:40px; }
label { font-size:13px; font-weight:600; margin-bottom:5px; display:block; color:#000; }
input[type="text"],
input[type="datetime-local"],
input[type="number"],
input[type="file"],
select,
textarea,
.form-control {   /* input anggota ikut form-control */
    width:100%;
    padding:8px;
    margin-bottom:15px;
    border:1px solid #565656;
    border-radius:5px;
    font-size:13px;
    background-color:#fff;
}
.form-buttons { display:flex; justify-content:flex-end; gap:10px; margin-top:40px; }
.btn { padding:8px 0; font-size:16px; font-weight:bold; border-radius:7px; border:none; cursor:pointer; text-align:center; width:120px; box-shadow:0 4px 4px rgba(0,0,0,0.293); }
.btn-simpan { background-color:#25E11B; color:#fff; }
.btn-simpan:hover { background-color:#45a049; }
.btn-batal { background-color:#EA2828; color:#fff; }
.btn-batal:hover { background-color:#d73833; }
</style>

{{-- SCRIPT --}}
<script>
// Autofill anggota tanpa dropdown browser
(function(){
    const anggota = @json($anggota); 
    const input = document.getElementById('nama_anggota');
    const hidden = document.getElementById('id_anggota');

    input.addEventListener('input', function(){
        const found = anggota.find(a => a.nama_anggota.toLowerCase() === this.value.trim().toLowerCase());
        hidden.value = found ? found.id_anggota : '';
    });
})();

// Auto isi jumlah simpanan
document.addEventListener('DOMContentLoaded', function() {
    const jenisSelect = document.getElementById('id_jenis_simpanan');
    const jumlahInput = document.getElementById('jumlah_simpanan');
    if (jenisSelect && jumlahInput) {
        const setJumlah = () => {
            const selectedOption = jenisSelect.options[jenisSelect.selectedIndex];
            const jumlah = selectedOption.getAttribute('data-jumlah');
            if (jumlah && parseInt(jumlah) > 0) {
                jumlahInput.value = jumlah;
                jumlahInput.readOnly = true;
            } else {
                jumlahInput.readOnly = false;
            }
        };
        jenisSelect.addEventListener('change', setJumlah);
        setJumlah();
    }
});

// Validasi form
document.getElementById('formEditSetoranTunai').addEventListener('submit', function(e) {
    const wajib = ['id_anggota','id_jenis_simpanan','jumlah_simpanan','id_jenisAkunTransaksi_tujuan'];
    for (let id of wajib) {
        const el = document.getElementById(id);
        if (!el || !el.value.trim()) {
            alert('⚠️ Mohon isi semua kolom wajib sebelum menyimpan.');
            e.preventDefault(); return;
        }
    }
    if(!confirm('Apakah data sudah benar dan ingin disimpan?')){
        e.preventDefault(); alert('❌ Pengisian data dibatalkan.');
        return;
    }
    alert('✅ Data barang berhasil disimpan!');
});

// Tombol batal
document.getElementById('btnBatal').addEventListener('click', function(){
    window.location.href = "{{ route('setoran-tunai.index') }}";
});
</script>

@endsection
