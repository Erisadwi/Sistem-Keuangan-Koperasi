@extends('layouts.app-admin-add')

@section('title', 'Saldo Awal NonKas')  
@section('back-url', url('admin/master_data/saldo-awal-non-kas'))
@section('back-title', 'Master Data >')
@section('title-1', 'Saldo Awal Non Kas')  
@section('sub-title', 'Edit Data Saldo Awal Non Kas')  

@section('content')

<div class="form-container">
    <form id="saldoAwalNonKasForm" action="{{ route('saldo-awal-non-kas.update', $saldoAwalNonKas->id_transaksi) }}" method="POST">
        @csrf
        @method('PUT')

         <div class="form-group">
            <label for="tanggal_transaksi">Tanggal</label>
            <input 
                type="datetime-local" 
                id="tanggal_transaksi" 
                name="tanggal_transaksi"
                value="{{ old('tanggal_transaksi', isset($saldoAwalNonKas->tanggal_transaksi) ? \Carbon\Carbon::parse($saldoAwalNonKas->tanggal_transaksi)->format('Y-m-d\TH:i') : '') }}"
                required
            >
        </div>

        <label for="id_jenisAkunTransaksi_sumber">Dari Akun</label>
        <select name="id_jenisAkunTransaksi_sumber" id="id_jenisAkunTransaksi_sumber" class="form-control">
            <option value="" disabled {{ empty($transaksi->id_jenisAkunTransaksi_sumber) ? 'selected' : '' }}>Pilih Akun</option>
            <option value="10" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '10' ? 'selected' : '' }}>10 - Barang dlm Perjalanan</option>
            <option value="110" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '110' ? 'selected' : '' }}>110 - Transfer Antar Kas</option>
            <option value="111" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '111' ? 'selected' : '' }}>111 - Logam Mulia</option>
            <option value="113" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '113' ? 'selected' : '' }}>113 - Persediaan Konsinyasi / Barang titipan</option>
            <option value="114" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '114' ? 'selected' : '' }}>114 - Persediaan Alat Olah Raga</option>
            <option value="115" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '115' ? 'selected' : '' }}>115 - Persediaan Pulsa</option>
            <option value="116" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '116' ? 'selected' : '' }}>116 - Persediaan Rokok</option>
            <option value="117" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '117' ? 'selected' : '' }}>117 - Persediaan Keb. Rumah Tangga</option>
            <option value="118" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '118' ? 'selected' : '' }}>118 - Piutang Usaha Niaga</option>
            <option value="119" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '119' ? 'selected' : '' }}>119 - Piutang Usaha Kredit Barang</option>
            <option value="120" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '120' ? 'selected' : '' }}>120 - Piutang Usaha Simpan Pinjam</option>
            <option value="121" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '121' ? 'selected' : '' }}>121 - Piutang Usaha Pembiayaan</option>
            <option value="122" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '122' ? 'selected' : '' }}>122 - Piutang Usaha Pengurusan Surat</option>
            <option value="123" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '123' ? 'selected' : '' }}>123 - Persediaan Alat Tulis Kantor</option>
            <option value="124" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '124' ? 'selected' : '' }}>124 - Persediaan Minuman</option>
            <option value="125" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '125' ? 'selected' : '' }}>125 - Persediaan Makanan</option>
            <option value="126" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '126' ? 'selected' : '' }}>126 - Biaya Dibayar Dimuka</option>
            <option value="127" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '127' ? 'selected' : '' }}>127 - Biaya Dibayar Dimuka Tiket & Voucher Darmawisata</option>
            <option value="128" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '128' ? 'selected' : '' }}>128 - Biaya Dibayar Dimuka Tiket & Voucher</option>
            <option value="129" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '129' ? 'selected' : '' }}>129 - Uang Muka Pajak PPh 21</option>
            <option value="130" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '130' ? 'selected' : '' }}>130 - Uang Muka Pajak PPh 25</option>
            <option value="131" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '131' ? 'selected' : '' }}>131 - Uang Muka Pajak PPn Masukan</option>
            <option value="132" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '132' ? 'selected' : '' }}>132 - Nilai Perolehan Aktiva Tetap (Inventaris)</option>
            <option value="133" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '133' ? 'selected' : '' }}>133 - Nilai Perolehan Aktiva Tetap (Elektronik)</option>
            <option value="134" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '134' ? 'selected' : '' }}>134 - Akumulasi Penyusutan Aktiva Tetap (Kendaraan)</option>
            <option value="135" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '135' ? 'selected' : '' }}>135 - Akumulasi Penyusutan Aktiva Tetap (Inventaris)</option>
            <option value="136" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '136' ? 'selected' : '' }}>136 - Akumulasi Penyusutan Aktiva Tetap (Elektronik)</option>
            <option value="137" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '137' ? 'selected' : '' }}>137 - Non Usaha Hutang Rekening Titipan</option>
            <option value="138" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '138' ? 'selected' : '' }}>138 - Gaji Pegawai Tetap</option>
            <option value="139" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '139' ? 'selected' : '' }}>139 - Nilai Perolehan Aktiva Tetap Tak Berwujud Software</option>
            <option value="140" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '140' ? 'selected' : '' }}>140 - Amortisasi Aktiva Tetap Tak Berwujud Amor Software</option>
            <option value="141" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '141' ? 'selected' : '' }}>141 - Hutang Usaha ATK</option>
            <option value="142" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '142' ? 'selected' : '' }}>142 - Hutang Usaha Minuman</option>
            <option value="143" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '143' ? 'selected' : '' }}>143 - Hutang Usaha Makanan</option>
            <option value="144" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '144' ? 'selected' : '' }}>144 - Hutang Usaha Rokok</option>
            <option value="145" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '145' ? 'selected' : '' }}>145 - Hutang Usaha Konsinyasi</option>
            <option value="146" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '146' ? 'selected' : '' }}>146 - Hutang Usaha Keb. Rumah Tangga</option>
            <option value="147" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '147' ? 'selected' : '' }}>147 - Hutang Usaha Pulsa</option>
            <option value="148" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '148' ? 'selected' : '' }}>148 - Hutang Usaha Good Receive Not Invoice</option>
            <option value="149" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '149' ? 'selected' : '' }}>149 - Hutang Usaha Iklan</option>
            <option value="150" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '150' ? 'selected' : '' }}>150 - Hutang Usaha Kredit Barang</option>
            <option value="151" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '151' ? 'selected' : '' }}>151 - Hutang Usaha Pengurusan Surat</option>
            <option value="152" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '152' ? 'selected' : '' }}>152 - Hutang Usaha Pembiayaan</option>
            <option value="154" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '154' ? 'selected' : '' }}>154 - Hutang Pajak Penghasilan PPh Final</option>
            <option value="157" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '157' ? 'selected' : '' }}>157 - Laba/Rugi Periode Berjalan</option>
            <option value="158" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '158' ? 'selected' : '' }}>158 - Laba Ditahan (Defisit)</option>
            <option value="159" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '159' ? 'selected' : '' }}>159 - Pendapatan Usaha Niaga</option>
            <option value="160" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '160' ? 'selected' : '' }}>160 - Pendapatan Usaha Kredit Barang</option>
            <option value="161" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '161' ? 'selected' : '' }}>161 - Pendapatan Usaha Iklan</option>
            <option value="162" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '162' ? 'selected' : '' }}>162 - Pendapatan Usaha Foto Copy</option>
            <option value="163" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '163' ? 'selected' : '' }}>163 - Pendapatan Usaha Tiket & Voucher</option>
            <option value="164" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '164' ? 'selected' : '' }}>164 - Pendapatan Usaha Pengurusan Surat</option>
            <option value="165" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '165' ? 'selected' : '' }}>165 - Pendapatan Usaha Pembiayaan</option>
            <option value="167" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '167' ? 'selected' : '' }}>167 - Hutang Refund Tiket & Voucher</option>
            <option value="168" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '168' ? 'selected' : '' }}>168 - Pendapatan Lain Lain</option>
            <option value="169" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '169' ? 'selected' : '' }}>169 - Pendapatan Jasa Giro</option>
            <option value="17" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '17' ? 'selected' : '' }}>17 - Aktiva Tetap Berwujud</option>
            <option value="170" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '170' ? 'selected' : '' }}>170 - Biaya Administrasi Bank Lainnya</option>
            <option value="175" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '175' ? 'selected' : '' }}>175 - Beban Persewaan Bangunan</option>
            <option value="176" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '176' ? 'selected' : '' }}>176 - Biaya Penyusutan Aktiva Tetap (Inventaris)</option>
            <option value="177" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '177' ? 'selected' : '' }}>177 - Biaya Penyusutan Aktiva Tetap (Kendaraan)</option>
            <option value="178" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '178' ? 'selected' : '' }}>178 - Biaya Penyusutan Aktiva Tetap (Elektronik)</option>
            <option value="179" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '179' ? 'selected' : '' }}>179 - HPP Usaha Niaga</option>
            <option value="180" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '180' ? 'selected' : '' }}>180 - PPH 29/Badan</option>
            <option value="181" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '181' ? 'selected' : '' }}>181 - HPP Usaha Tiket dan Voucher</option>
            <option value="182" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '182' ? 'selected' : '' }}>182 - Investasi Jangka Panjang</option>
            <option value="183" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '183' ? 'selected' : '' }}>183 - Biaya BPJS</option>
            <option value="184" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '184' ? 'selected' : '' }}>184 - Pendapatan Sewa Lahan Koperasi</option>
            <option value="20" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '20' ? 'selected' : '' }}>20 - Nilai Perolehan Aktiva Tetap (Kendaraan)</option>
            <option value="28" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '28' ? 'selected' : '' }}>28 - Utang</option>
            <option value="29" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '29' ? 'selected' : '' }}>29 - Utang Usaha</option>
            <option value="31" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '31' ? 'selected' : '' }}>31 - Pengeluaran Lainnya</option>
            <option value="32" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '32' ? 'selected' : '' }}>32 - Simpanan Sukarela*</option>
            <option value="36" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '36' ? 'selected' : '' }}>36 - Utang Jangka Panjang</option>
            <option value="37" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '37' ? 'selected' : '' }}>37 - Utang Bank</option>
            <option value="39" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '39' ? 'selected' : '' }}>39 - Modal</option>
            <option value="40" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '40' ? 'selected' : '' }}>40 - Simpanan Pokok*</option>
            <option value="41" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '41' ? 'selected' : '' }}>41 - Simpanan Wajib*</option>
            <option value="42" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '42' ? 'selected' : '' }}>42 - Modal Awal</option>
            <option value="47" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '47' ? 'selected' : '' }}>47 - Pendapatan*</option>
            <option value="48" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '48' ? 'selected' : '' }}>48 - Pendapatan dari Pinjaman*</option>
            <option value="49" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '49' ? 'selected' : '' }}>49 - Pendapatan Lainnya</option>
            <option value="5" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '5' ? 'selected' : '' }}>5 - Persediaan Barang</option>
            <option value="50" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '50' ? 'selected' : '' }}>50 - Beban</option>
            <option value="52" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '52' ? 'selected' : '' }}>52 - Beban Telpon</option>
            <option value="53" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '53' ? 'selected' : '' }}>53 - Biaya Listrik dan Air</option>
            <option value="54" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '54' ? 'selected' : '' }}>54 - Biaya Transportasi</option>
            <option value="6" {{ ($transaksi->id_jenisAkunTransaksi_sumber ?? '') == '6' ? 'selected' : '' }}>6 - Pinjaman Karyawan</option>
        </select>


        <div class="form-group">
            <label for="ket_transaksi">Keterangan</label>
            <input type="text" id="ket_transaksi" name="ket_transaksi"
                   value="{{ old('ket_transaksi') }}" placeholder="Masukkan keterangan">
        </div>

        <div class="form-group">
            <label for="jumlah_transaksi">Saldo Awal</label>
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
document.getElementById('saldoAwalNonKasForm').addEventListener('submit', function(e) {
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
</script>

@endsection
