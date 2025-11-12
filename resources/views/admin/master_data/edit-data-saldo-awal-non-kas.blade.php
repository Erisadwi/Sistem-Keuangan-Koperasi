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

        
       <label for="id_jenisAkunTransaksi_tujuan">Dari Akun</label>
        <select name="id_jenisAkunTransaksi_tujuan" id="id_jenisAkunTransaksi_tujuan" class="form-control">
            <option value="" disabled {{ empty($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan) ? 'selected' : '' }}>Pilih Akun</option>
            <option value="11" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '11' ? 'selected' : '' }}>11 - Barang dlm Perjalanan</option>
            <option value="110" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '110' ? 'selected' : '' }}>110 - Transfer Antar Kas</option>
            <option value="111" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '111' ? 'selected' : '' }}>111 - Logam Mulia</option>
            <option value="113" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '113' ? 'selected' : '' }}>113 - Persediaan Konsinyasi / Barang titipan</option>
            <option value="114" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '114' ? 'selected' : '' }}>114 - Persediaan Alat Olah Raga</option>
            <option value="115" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '115' ? 'selected' : '' }}>115 - Persediaan Pulsa</option>
            <option value="116" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '116' ? 'selected' : '' }}>116 - Persediaan Rokok</option>
            <option value="117" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '117' ? 'selected' : '' }}>117 - Persediaan Keb. Rumah Tangga</option>
            <option value="118" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '118' ? 'selected' : '' }}>118 - Piutang Usaha Niaga</option>
            <option value="119" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '119' ? 'selected' : '' }}>119 - Piutang Usaha Kredit Barang</option>
            <option value="120" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '120' ? 'selected' : '' }}>120 - Piutang Usaha Simpan Pinjam</option>
            <option value="121" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '121' ? 'selected' : '' }}>121 - Piutang Usaha Pembiayaan</option>
            <option value="122" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '122' ? 'selected' : '' }}>122 - Piutang Usaha Pengurusan Surat</option>
            <option value="123" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '123' ? 'selected' : '' }}>123 - Persediaan Alat Tulis Kantor</option>
            <option value="124" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '124' ? 'selected' : '' }}>124 - Persediaan Minuman</option>
            <option value="125" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '125' ? 'selected' : '' }}>125 - Persediaan Makanan</option>
            <option value="126" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '126' ? 'selected' : '' }}>126 - Biaya Dibayar Dimuka</option>
            <option value="127" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '127' ? 'selected' : '' }}>127 - Biaya Dibayar Dimuka Tiket & Voucher Darmawisata</option>
            <option value="128" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '128' ? 'selected' : '' }}>128 - Biaya Dibayar Dimuka Tiket & Voucher</option>
            <option value="129" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '129' ? 'selected' : '' }}>129 - Uang Muka Pajak PPh 21</option>
            <option value="130" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '130' ? 'selected' : '' }}>130 - Uang Muka Pajak PPh 25</option>
            <option value="131" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '131' ? 'selected' : '' }}>131 - Uang Muka Pajak PPn Masukan</option>
            <option value="132" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '132' ? 'selected' : '' }}>132 - Nilai Perolehan Aktiva Tetap (Inventaris)</option>
            <option value="133" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '133' ? 'selected' : '' }}>133 - Nilai Perolehan Aktiva Tetap (Elektronik)</option>
            <option value="134" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '134' ? 'selected' : '' }}>134 - Akumulasi Penyusutan Aktiva Tetap (Kendaraan)</option>
            <option value="135" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '135' ? 'selected' : '' }}>135 - Akumulasi Penyusutan Aktiva Tetap (Inventaris)</option>
            <option value="136" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '136' ? 'selected' : '' }}>136 - Akumulasi Penyusutan Aktiva Tetap (Elektronik)</option>
            <option value="137" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '137' ? 'selected' : '' }}>137 - Non Usaha Hutang Rekening Titipan</option>
            <option value="138" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '138' ? 'selected' : '' }}>138 - Gaji Pegawai Tetap</option>
            <option value="139" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '139' ? 'selected' : '' }}>139 - Nilai Perolehan Aktiva Tetap Tak Berwujud Software</option>
            <option value="140" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '140' ? 'selected' : '' }}>140 - Amortisasi Aktiva Tetap Tak Berwujud Amor Software</option>
            <option value="141" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '141' ? 'selected' : '' }}>141 - Hutang Usaha ATK</option>
            <option value="142" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '142' ? 'selected' : '' }}>142 - Hutang Usaha Minuman</option>
            <option value="143" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '143' ? 'selected' : '' }}>143 - Hutang Usaha Makanan</option>
            <option value="144" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '144' ? 'selected' : '' }}>144 - Hutang Usaha Rokok</option>
            <option value="145" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '145' ? 'selected' : '' }}>145 - Hutang Usaha Konsinyasi</option>
            <option value="146" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '146' ? 'selected' : '' }}>146 - Hutang Usaha Keb. Rumah Tangga</option>
            <option value="147" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '147' ? 'selected' : '' }}>147 - Hutang Usaha Pulsa</option>
            <option value="148" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '148' ? 'selected' : '' }}>148 - Hutang Usaha Good Receive Not Invoice</option>
            <option value="149" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '149' ? 'selected' : '' }}>149 - Hutang Usaha Iklan</option>
            <option value="150" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '150' ? 'selected' : '' }}>150 - Hutang Usaha Kredit Barang</option>
            <option value="151" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '151' ? 'selected' : '' }}>151 - Hutang Usaha Pengurusan Surat</option>
            <option value="152" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '152' ? 'selected' : '' }}>152 - Hutang Usaha Pembiayaan</option>
            <option value="154" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '154' ? 'selected' : '' }}>154 - Hutang Pajak Penghasilan PPh Final</option>
            <option value="157" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '157' ? 'selected' : '' }}>157 - Laba/Rugi Periode Berjalan</option>
            <option value="158" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '158' ? 'selected' : '' }}>158 - Laba Ditahan (Defisit)</option>
            <option value="159" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '159' ? 'selected' : '' }}>159 - Pendapatan Usaha Niaga</option>
            <option value="160" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '160' ? 'selected' : '' }}>160 - Pendapatan Usaha Kredit Barang</option>
            <option value="161" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '161' ? 'selected' : '' }}>161 - Pendapatan Usaha Iklan</option>
            <option value="162" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '162' ? 'selected' : '' }}>162 - Pendapatan Usaha Foto Copy</option>
            <option value="163" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '163' ? 'selected' : '' }}>163 - Pendapatan Usaha Tiket & Voucher</option>
            <option value="164" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '164' ? 'selected' : '' }}>164 - Pendapatan Usaha Pengurusan Surat</option>
            <option value="165" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '165' ? 'selected' : '' }}>165 - Pendapatan Usaha Pembiayaan</option>
            <option value="167" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '167' ? 'selected' : '' }}>167 - Hutang Refund Tiket & Voucher</option>
            <option value="168" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '168' ? 'selected' : '' }}>168 - Pendapatan Lain Lain</option>
            <option value="169" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '169' ? 'selected' : '' }}>169 - Pendapatan Jasa Giro</option>
            <option value="17" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '17' ? 'selected' : '' }}>17 - Aktiva Tetap Berwujud</option>
            <option value="170" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '170' ? 'selected' : '' }}>170 - Biaya Administrasi Bank Lainnya</option>
            <option value="175" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '175' ? 'selected' : '' }}>175 - Beban Persewaan Bangunan</option>
            <option value="176" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '176' ? 'selected' : '' }}>176 - Biaya Penyusutan Aktiva Tetap (Inventaris)</option>
            <option value="177" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '177' ? 'selected' : '' }}>177 - Biaya Penyusutan Aktiva Tetap (Kendaraan)</option>
            <option value="178" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '178' ? 'selected' : '' }}>178 - Biaya Penyusutan Aktiva Tetap (Elektronik)</option>
            <option value="179" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '179' ? 'selected' : '' }}>179 - HPP Usaha Niaga</option>
            <option value="180" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '180' ? 'selected' : '' }}>180 - PPH 29/Badan</option>
            <option value="181" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '181' ? 'selected' : '' }}>181 - HPP Usaha Tiket dan Voucher</option>
            <option value="182" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '182' ? 'selected' : '' }}>182 - Investasi Jangka Panjang</option>
            <option value="183" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '183' ? 'selected' : '' }}>183 - Biaya BPJS</option>
            <option value="184" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '184' ? 'selected' : '' }}>184 - Pendapatan Sewa Lahan Koperasi</option>
            <option value="20" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '20' ? 'selected' : '' }}>20 - Nilai Perolehan Aktiva Tetap (Kendaraan)</option>
            <option value="28" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '28' ? 'selected' : '' }}>28 - Utang</option>
            <option value="29" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '29' ? 'selected' : '' }}>29 - Utang Usaha</option>
            <option value="31" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '31' ? 'selected' : '' }}>31 - Pengeluaran Lainnya</option>
            <option value="32" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '32' ? 'selected' : '' }}>32 - Simpanan Sukarela*</option>
            <option value="36" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '36' ? 'selected' : '' }}>36 - Utang Jangka Panjang</option>
            <option value="37" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '37' ? 'selected' : '' }}>37 - Utang Bank</option>
            <option value="39" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '39' ? 'selected' : '' }}>39 - Modal</option>
            <option value="40" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '40' ? 'selected' : '' }}>40 - Simpanan Pokok*</option>
            <option value="41" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '41' ? 'selected' : '' }}>41 - Simpanan Wajib*</option>
            <option value="42" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '42' ? 'selected' : '' }}>42 - Modal Awal</option>
            <option value="47" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '47' ? 'selected' : '' }}>47 - Pendapatan*</option>
            <option value="48" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '48' ? 'selected' : '' }}>48 - Pendapatan dari Pinjaman*</option>
            <option value="49" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '49' ? 'selected' : '' }}>49 - Pendapatan Lainnya</option>
            <option value="5" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '5' ? 'selected' : '' }}>5 - Persediaan Barang</option>
            <option value="50" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '50' ? 'selected' : '' }}>50 - Beban</option>
            <option value="52" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '52' ? 'selected' : '' }}>52 - Beban Telpon</option>
            <option value="53" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '53' ? 'selected' : '' }}>53 - Biaya Listrik dan Air</option>
            <option value="54" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '54' ? 'selected' : '' }}>54 - Biaya Transportasi</option>
            <option value="6" {{ ($saldoAwalNonKas->id_jenisAkunTransaksi_tujuan ?? '') == '6' ? 'selected' : '' }}>6 - Pinjaman Karyawan</option>
        </select>

        <div class="form-group">
            <label for="ket_transaksi">Keterangan</label>
            <input 
                type="text" 
                id="ket_transaksi" 
                name="ket_transaksi"
                value="{{ old('ket_transaksi', $saldoAwalNonKas->ket_transaksi ?? '') }}"
                placeholder="Masukkan keterangan"
            >
        </div>

        <div class="form-group">
            <label for="jumlah_transaksi">Saldo Awal</label>
            <input 
                type="number" 
                id="jumlah_transaksi" 
                name="jumlah_transaksi"
                value="{{ old('jumlah_transaksi', $saldoAwalNonKas->jumlah_transaksi ?? '') }}"
                step="0.01"
                required 
                placeholder="Masukkan nominal saldo awal"
            >
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
