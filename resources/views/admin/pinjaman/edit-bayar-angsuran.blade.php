@extends('layouts.app-admin-add')

@section('title', 'Edit Bayar Angsuran')
@section('back-url', url('admin/pinjaman/bayar-angsuran')) 
@section('back-title', 'Bayar Angsuran >')
@section('title-1', 'Edit Pembayaran Angsuran')
@section('sub-title', 'Edit Pembayaran Angsuran')

@section('content')




<div class="form-container">
    <form id="formBayarAngsuran" action="{{ route('angsuran.update', $angsuran->id_bayar_angsuran) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label for="tanggal_bayar">Tanggal Transaksi*</label>
        <input type="datetime-local" id="tanggal_bayar" name="tanggal_bayar" 
        value="{{ isset($angsuran) ? \Carbon\Carbon::parse($angsuran->tanggal_bayar)->format('Y-m-d\TH:i') : '' }}">


        <label for="id_pinjaman">Nomor Pinjaman*</label>
        <input type="text" id="id_pinjaman" name="id_pinjaman" value="{{ $pinjaman->id_pinjaman }}" readonly>

        <label for="angsuran_ke">Angsuran ke-*</label>
        <input type="text" id="angsuran_ke" name="angsuran_ke" value="{{ old('angsuran_ke', $angsuran->angsuran_ke) }}" readonly>

        <label for="sisa_angsuran">Sisa Angsuran*</label>
        <input type="text" id="sisa_angsuran" name="sisa_angsuran" value="{{ old('sisa_angsuran', $sisaAngsuran ?? 0) }}" readonly>

        <label for="angsuran_per_bulan">Jumlah Angsuran*</label>
        <input type="number" id="angsuran_per_bulan" name="angsuran_per_bulan" value="{{ old('angsuran_per_bulan', number_format($angsuran->angsuran_per_bulan, 0, '.', '')) }}" readonly>

        <label for="pokok_angsuran">Angsuran Pokok*</label>
        <input type="number" id="pokok_angsuran" name="angsuran_pokok" value="{{ old('angsuran_pokok', number_format($angsuran->angsuran_pokok, 0, '.', '')) }}" readonly>

        <label for="bunga_angsuran">Pendapatan*</label>
        <input type="number" id="bunga_angsuran" name="bunga_angsuran" value="{{ old('bunga_angsuran', number_format($angsuran->bunga_angsuran, 0, '.', '')) }}" readonly>

        <label for="id_jenisAkunPendapatan">Akun Pendapatan*</label>
            <select name="id_jenisAkunPendapatan" id="id_jenisAkunPendapatan">
            <option value="" disabled {{ old('id_jenisAkunPendapatan') ? '' : 'selected' }}>Pilih Akun Pendapatan</option>
            @foreach ($akunPendapatan as $a)
                <option value="{{ $a->id_jenisAkunTransaksi }}"
                    {{ (string)old('id_jenisAkunPendapatan', $angsuran->id_jenisAkunPendapatan ?? '') === (string)$a->id_jenisAkunTransaksi ? 'selected' : '' }}>
                    {{ $a->kode_AkunTransaksi }} - {{ $a->nama_AkunTransaksi }}
                </option>
            @endforeach
            </select>

        <label for="sisaTagihan">Sisa Tagihan*</label>
        <input type="number" id="sisaTagihan" name="sisa_tagihan" value="{{ old('sisaTagihan', $angsuran->sisaTagihan ?? $sisaTagihan ?? 0) }}" readonly>

        <label for="denda">Denda</label>
        <input type="number" id="denda" name="denda" value="{{ old('denda', number_format($angsuran->denda, 0, '.', '')) }}" readonly>

        <label for="id_jenisAkunTransaksi_tujuan">Simpan ke Kas*</label>
            <select name="id_jenisAkunTransaksi_tujuan" id="id_jenisAkunTransaksi_tujuan">
            <option value="" disabled {{ old('id_jenisAkunTransaksi_tujuan') ? '' : 'selected' }}>Pilih Kas</option>
            @foreach ($akunTujuan as $a)
                <option value="{{ $a->id_jenisAkunTransaksi }}"
                    {{ (string)old('id_jenisAkunTransaksi_tujuan', $angsuran->id_jenisAkunTransaksi_tujuan ?? '') === (string)$a->id_jenisAkunTransaksi ? 'selected' : '' }}>
                    {{ $a->kode_AkunTransaksi }} - {{ $a->nama_AkunTransaksi }}
                </option>
            @endforeach
            </select>

        <label for="keterangan">Keterangan</label>
        <input type="text" id="keterangan" name="keterangan" value="{{ old('keterangan', $angsuran->keterangan ?? '') }}" placeholder="Isi keterangan (opsional)">

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


label {
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 5px;
    color: #000;
    display: block;
}

input[type="text"],
input[type="number"],
input[type="datetime-local"],
select,
input[type="file"] {
    width: 100%;
    padding: 9px;
    border: 1px solid #565656;
    border-radius: 5px;
    font-size: 13px;
    background-color: #fff;
    margin-bottom: 15px;
}

.form-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 50px;
}

.btn {
    padding: 8px 0;
    font-size: 16px;
    font-weight: bold;
    border-radius: 7px;
    border: none;
    width: 120px;
    cursor: pointer;
    color: #fff;
    box-shadow: 0 4px 4px rgba(0,0,0,0.3);
}

.btn-simpan { background-color: #25E11B; }
.btn-batal { background-color: #EA2828; }

.btn-simpan:hover { background-color: #45a049; }
.btn-batal:hover { background-color: #d73833; }
</style>

{{-- ========== VALIDASI JS ========== --}}
<script>
document.getElementById('formBayarAngsuran').addEventListener('submit', function(e) {
    const wajib = [
        'tanggal_bayar','id_pinjaman','angsuran_ke','sisa_angsuran','angsuran_per_bulan',
        'pokok_angsuran','bunga_angsuran','id_jenisAkunPendapatan','sisaTagihan','id_jenisAkunTransaksi_tujuan'
    ];

    for (let id of wajib) {
        const el = document.getElementById(id);
        if (!el) {
            e.preventDefault(); 
            alert('⚠️ Field wajib tidak ditemukan: ' + id);
            return;
        }

        if ((el.tagName === 'INPUT' && el.value.trim() === '') ||
            (el.tagName === 'SELECT' && el.selectedIndex === 0)) {
            e.preventDefault(); 
            alert('⚠️ Mohon isi semua kolom wajib sebelum menyimpan.');
            return;
        }
    }

    if (!confirm('Apakah data sudah benar dan ingin disimpan?')) {
        e.preventDefault(); 
        return;
    }

});

document.getElementById('btnBatal').addEventListener('click', function() {
    window.history.back();
});


</script>

@endsection
