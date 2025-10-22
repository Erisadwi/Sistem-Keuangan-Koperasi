@extends('layouts.app')

@section('title', 'Tambah Pengajuan')  
@section('title-1', 'Tambah Pengajuan')  
@section('sub-title', 'Tambah Pengajuan')  

@section('content')

@php 
$pinjaman = $pinjaman ?? null; 
@endphp 

<div class="pengajuan-form-wrap" style="margin: 40px 0 20px 25px; width: 860px;">
  <form id="formPengajuan" method="POST" action="#{{--{{ route('pengajuan.store') }}--}}">
    @csrf

    <div class="form-group">
      <label for="jenis">Jenis Pinjaman*</label>
      <select id="jenis" name="jenis" class="form-control" required>
        <option value="">Pilih Jenis Pinjaman</option>
        <option value="Pinjaman Biasa">Pinjaman Biasa</option>
        <option value="Pinjaman Darurat">Pinjaman Darurat</option>
        <option value="Pinjaman Barang">Pinjaman Barang</option>
      </select>
    </div>

    <div class="form-group">
      <label for="nominal">Nominal*</label>
      <input type="text" id="nominal" name="nominal" class="form-control" required>
    </div>

    <div class="form-group">
      <label for="lama_angsuran">Lama Angsuran (Bulan)*</label>
      <input type="number" id="lama_angsuran" name="lama_angsuran" class="form-control" min="1"required>
    </div>

    <div class="form-group">
      <label for="keterangan">Keterangan</label>
      <input type="text" id="keterangan" name="keterangan" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary" style="margin-top:10px;">Kirim</button>
    <button type="button" id="btnBatal" class="btn btn-secondary" style="margin-top:10px;">Batal</button>
  </form>
</div>

@if($pinjaman)
<div class="pengajuan-table-wrap">
  <h4 style="margin:10px 0 15px 10px;">Simulasi Pinjaman</h4>
  <table class="pengajuan-table">
    <thead>
      <tr class="head-group">
        <th>Angsuran Ke-</th>
        <th>Tanggal Tempo</th>
        <th>Angsuran Pokok</th>
        <th>Biaya Bunga</th>
        <th>Biaya Admin</th>
        <th>Jumlah Tagihan</th>
      </tr>
    </thead>
    <tbody>
      @foreach($pinjaman as $index => $p)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ \Carbon\Carbon::parse($p->tanggal_tempo)->format('d F Y') }}</td>
          <td>{{ number_format($p->angsuran_pokok, 0, ',', '.') }}</td>
          <td>{{ number_format($p->bunga, 0, ',', '.') }}</td>
          <td>{{ number_format($p->biaya_admin, 0, ',', '.') }}</td>
          <td>{{ number_format($p->total_tagihan, 0, ',', '.') }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endif

<script>
document.getElementById('formPengajuan').addEventListener('submit', function(e) {
    e.preventDefault();

    const wajib = ['jenis']; 
    for (let id of wajib) {
        if (!document.getElementById(id).value.trim()) {
            alert('⚠️ Kolom "Jenis Pinjaman" wajib diisi sebelum menyimpan.');
            return;
        }
    }

    if (confirm('Apakah data sudah benar dan ingin disimpan?')) {
        alert('✅ Data pengajuan berhasil disimpan!');
        this.reset();
    }
});

document.getElementById('btnBatal').addEventListener('click', function() {
    if (confirm('Apakah Anda yakin ingin membatalkan pengisian data?')) {
        alert('❌ Pengisian data dibatalkan.');
        window.history.back();
    }
});
</script>

<style>
.pengajuan-form-wrap label{ display:block; margin-bottom:5px; font-weight:600; color:#222; }
.pengajuan-form-wrap .form-group{ margin-bottom:10px; }
.pengajuan-form-wrap .form-control{
  width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;
  font-size:14px; font-family:system-ui; background:#f2f8fc;
}
.pengajuan-table-wrap{
  border: 1.5px solid #838383;
  background: #ffffff;
  width: 860px;
  margin-left: 25px;
  margin-top: 30px;
  overflow-x: auto;
}
.pengajuan-table{
  width: 870px;
  border-collapse: collapse;
  table-layout: fixed;
  font-size: 13px;
  color: #222;
}
.pengajuan-table thead th{
  background: #4a4a4a;
  color: #fff;
  text-align: center;
  padding: 10px;
}
.pengajuan-table td{
  padding: 10px;
  border-bottom: 1px solid #eee;
}
</style>

@endsection
