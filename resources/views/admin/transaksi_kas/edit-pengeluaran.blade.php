@extends('layouts.app-admin-add')

@section('title', 'Edit Data Pengeluaran')
@section('back-title', 'Transaksi Kas >')
@section('title-1', 'Pengeluaran')
@section('sub-title', 'Edit Data Pengeluaran')

@section('content')

<div class="form-container">
    <form id="formEditPengeluaran" 
          action="#" {{-- {{ route('pengeluaran.update', $transaksi->id ?? '#') }} --}}
          method="POST">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="form-group">
                <label for="tanggal_transaksi">Tanggal Transaksi</label>
                <input type="datetime-local" id="tanggal_transaksi" name="tanggal_transaksi"
                       value="{{ old('tanggal_transaksi', isset($transaksi->tanggal_transaksi) ? \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('Y-m-d\TH:i') : '') }}" 
                       required>
            </div>

            <div class="form-group">
                <label for="jumlah_transaksi">Jumlah Transaksi</label>
                <input type="number" id="jumlah_transaksi" name="jumlah_transaksi" 
                       value="{{ old('jumlah_transaksi', $transaksi->jumlah_transaksi ?? '') }}" required>
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <input type="text" id="keterangan" name="keterangan" 
                       value="{{ old('keterangan', $transaksi->keterangan ?? '') }}" required>
            </div>

            <div class="form-group">
                <label for="akun_debit">Dari Kas</label>
                <select id="akun_debit" name="akun_debit" required>
                    @php
                        $kasList = ['Kas Besar', 'Kas Kecil', 'Bank Mandiri', 'Kas Niaga', 'Bank BNI'];
                    @endphp
                    <option value="">-- Pilih Kas --</option>
                    @foreach($kasList as $k)
                        <option value="{{ $k }}" {{ old('akun_debit', $transaksi->akun_debit ?? '') == $k ? 'selected' : '' }}>
                            {{ $k }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="akun_kredit">Untuk Akun</label>
                <select id="akun_kredit" name="akun_kredit" required>
                    @php
                        $akunList = [
                            'Persediaan Barang','Pinjaman Karyawan','Pinjaman','Darmawisata',
                            'Barang dlm Perjalanan','Nilai Perolehan Aktiva Tetap (Kendaraan)',
                            'Utang Usaha','Pengeluaran Lainnya','Utang Bank','Simpanan Pokok*',
                            'Simpanan Wajib*','Modal Awal','Pendapatan dari Pinjaman*',
                            'Beban Telpon','Biaya Listrik dan Air','Biaya Transportasi','Biaya Lainnya',
                            'Logam Mulia','Persediaan Konsinyasi / Barang titipan','Persediaan Alat Olah Raga',
                            'Persediaan Pulsa','Persediaan Rokok','Persediaan Keb. Rumah Tangga',
                            'Piutang Usaha Niaga','Piutang Usaha Simpan Pinjam','Piutang Usaha Pembiayaan',
                            'Piutang Usaha Pengurusan Surat','Persediaan Alat Tulis Kantor',
                            'Persediaan Minuman','Persediaan Makanan','BIAYA DIBAYAR DIMUKA',
                            'BIAYA DIBAYAR DIMUKA TIKET & VOUCHER DARMAWISATA',
                            'BIAYA DIBAYAR DIMUKA TIKET & VOUCHER','Uang Muka Pajak PPh 21',
                            'Uang Muka Pajak PPh 25','Uang Muka Pajak PPn Masukan',
                            'Nilai Perolehan Aktiva Tetap (Inventaris)',
                            'Nilai Perolehan Aktiva Tetap (Elektronik)',
                            'Akumulasi Penyusutan Aktiva Tetap (Kendaraan)',
                            'Akumulasi Penyusutan Aktiva Tetap (Inventaris)',
                            'Akumulasi Penyusutan Aktiva Tetap (Elektronik)',
                            'Non Usaha Hutang Rekening Titipan','Gaji Pegawai Tetap',
                            'Nilai Perolehan Aktiva Tetap Tak Berwujud Software',
                            'Amortisasi Aktiva Tetap Tak Berwujud Amor Software',
                            'Hutang Usaha ATK','Hutang Usaha Minuman','Hutang Usaha Makanan',
                            'Hutang Usaha Rokok','Hutang Usaha Konsinyasi','Hutang Usaha Keb. Rumah Tangga',
                            'Hutang Usaha Pulsa','Hutang Usaha Good Receive Not Invoice','Hutang Usaha Iklan',
                            'Hutang Usaha Kredit Barang','Hutang Usaha Pengurusan Surat','Hutang Usaha Pembiayaan',
                            'Hutang Pajak Penghasilan PPh Final','Laba/Rugi Periode Berjalan',
                            'Laba Ditahan (Defisit)','Pendapatan Usaha Niaga','Pendapatan Usaha Kredit Barang',
                            'Pendapatan Usaha Iklan','Pendapatan Usaha Foto Copy',
                            'Pendapatan Usaha Tiket & Voucher','Pendapatan Usaha Pengurusan Surat',
                            'Pendapatan Usaha Pembiayaan','Hutang Refund Tiket & Voucher',
                            'Pendapatan Lain - Lain','PENDAPATAN JASA GIRO','BIAYA ADMINISTRASI BANK LAINNYA',
                            'Pinjaman Perusahaan','Pemeliharaan Bangunan','Tunjangan Karyawan',
                            'Hutang Modal Pinjaman','Beban Persewaan Bangunan','HPP Usaha Niaga',
                            'PPH 29/Badan','HPP Usaha Tiket dan Voucher','Investasi Jangka Panjang',
                            'Biaya BPJS','Pendapatan Sewa Lahan Koperasi','Lainnya'
                        ];
                    @endphp
                    <option value="">-- Pilih Jenis Akun --</option>
                    @foreach($akunList as $a)
                        <option value="{{ $a }}" {{ old('akun_kredit', $transaksi->akun_kredit ?? '') == $a ? 'selected' : '' }}>
                            {{ $a }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn btn-simpan">Simpan</button>
            <button type="button" id="btnBatal" class="btn btn-batal">Batal</button>
        </div>
    </form>
</div>

{{-- CSS --}}
<style>
.form-container {
    background-color: transparent;
    padding: 20px;
    border-radius: 10px;
    width: 900px;
    margin-left: 10px;
    margin-top: 55px;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 15px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

label {
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 5px;
    color: #000;
}

input[type="text"],
input[type="number"],
input[type="datetime-local"],
select {
    width: 100%;
    padding: 9px;
    border: 1px solid #565656;
    border-radius: 5px;
    font-size: 13px;
    background-color: #fff;
}

.form-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 30px;
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

<script>
// Validasi form & konfirmasi simpan
document.getElementById('formEditPengeluaran').addEventListener('submit', function(e) {
    e.preventDefault();

    const requiredFields = this.querySelectorAll('[required]');
    let valid = true;

    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            valid = false;
            field.style.borderColor = 'red';
        } else {
            field.style.borderColor = '#565656';
        }
    });

    if (!valid) {
        alert('⚠️ Harap lengkapi semua data wajib sebelum menyimpan!');
        return;
    }

    if (confirm('Apakah Anda yakin ingin menyimpan perubahan data pengeluaran ini?')) {
        alert('✅ Data pengeluaran berhasil diperbarui!');
        // this.submit(); // Uncomment kalau backend sudah siap
    }
});

// Tombol batal
document.getElementById('btnBatal').addEventListener('click', function() {
    if (confirm('Apakah Anda yakin ingin membatalkan perubahan data?')) {
        alert('❌ Perubahan data dibatalkan.');
        window.history.back();
    }
});
</script>

@endsection
