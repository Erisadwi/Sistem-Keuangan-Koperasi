@extends('layouts.tambah-data-pengajuan')

@section('title', 'Tambah Pengajuan')  
@section('title-1', 'Tambah Pengajuan')  
@section('sub-title', 'Tambah Pengajuan')  

@section('content')

<form id="formPengajuan" class="form" method="post" action="#" enctype="multipart/form-data">
  @csrf
  @method('PUT')

  <div class="form-group">
    <label for="jenis">Jenis Pinjaman*</label>
    <select id="jenis" name="jenis_pinjaman" class="form-input" required>
      <option value="">Pilih Jenis Pinjaman</option>
      <option value="Pinjaman Biasa">Pinjaman Biasa</option>
      <option value="Pinjaman Darurat">Pinjaman Darurat</option>
      <option value="Pinjaman Barang">Pinjaman Barang</option>
    </select>
  </div>

  <div class="form-group">
    <label for="nominal">Nominal*</label>
    <input type="text" id="nominal" name="nominal" class="form-input" required>
  </div>

  <div class="form-group">
    <label for="lama_angsuran">Lama Angsuran (Bulan)*</label>
    <input type="number" id="lama_angsuran" name="lama_angsuran" class="form-input" min="1" required>
  </div>

  <div class="form-group">
    <label for="keterangan">Keterangan</label>
    <input type="text" id="keterangan" name="keterangan" class="form-input" required>
  </div>

  <div class="form-group form-group-btn">
    <button type="submit" class="btn-submit">Kirim</button>
  </div>
</form>

{{-- Bagian tabel simulasi (otomatis muncul jika form lengkap) --}}
<section id="simulasiSection" style="display:none; margin-top: 40px;">
  <h3 style="margin-bottom: 15px;">Simulasi Pinjaman</h3>
  <table class="table-simulasi">
    <thead>
      <tr>
        <th>Angsuran Ke</th>
        <th>Jatuh Tempo</th>
        <th>Pokok</th>
        <th>Bunga</th>
        <th>Admin</th>
        <th>Total Tagihan</th>
      </tr>
    </thead>
    <tbody id="simulasiBody"></tbody>
  </table>
</section>



@endsection

@push('scripts')
<script>
  const jenis = document.getElementById('jenis');
  const nominal = document.getElementById('nominal');
  const lama = document.getElementById('lama_angsuran');
  const simulasiSection = document.getElementById('simulasiSection');
  const simulasiBody = document.getElementById('simulasiBody');

  function formatNumber(num) {
    return num.toLocaleString('id-ID');
  }

  function parseNominal(str) {
    return parseFloat(str.replace(/\./g, '').replace(/,/g, '')) || 0;
  }

  function generateSimulasi() {
    const jenisVal = jenis.value.trim();
    const nominalVal = parseNominal(nominal.value);
    const lamaVal = parseInt(lama.value);

    // Jika belum lengkap, sembunyikan tabel
    if (!jenisVal || nominalVal <= 0 || !lamaVal) {
      simulasiSection.style.display = 'none';
      return;
    }

    // Hitung simulasi pinjaman
    const bunga = 0.02; // bunga 2%
    const admin = 0;
    const angsuranPokok = nominalVal / lamaVal;
    simulasiBody.innerHTML = '';

    const today = new Date();
    for (let i = 1; i <= lamaVal; i++) {
      const tempo = new Date(today);
      tempo.setMonth(today.getMonth() + i);
      const bungaBulanan = nominalVal * bunga;
      const totalTagihan = angsuranPokok + bungaBulanan + admin;

      simulasiBody.insertAdjacentHTML('beforeend', `
        <tr>
          <td>${i}</td>
          <td>${tempo.toLocaleDateString('id-ID', { day:'2-digit', month:'long', year:'numeric' })}</td>
          <td>${formatNumber(angsuranPokok)}</td>
          <td>${formatNumber(bungaBulanan)}</td>
          <td>${formatNumber(admin)}</td>
          <td>${formatNumber(totalTagihan)}</td>
        </tr>
      `);
    }

    simulasiSection.style.display = 'block';
  }

  // Event agar tabel muncul otomatis saat input berubah
  [jenis, nominal, lama].forEach(el => {
    el.addEventListener('input', generateSimulasi);
  });

  // Format nominal agar tetap ribuan saat diketik
  nominal.addEventListener('input', (e) => {
    let val = e.target.value.replace(/\D/g, '');
    e.target.value = val.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    generateSimulasi();
  });

  // Hentikan reload form agar tidak hilang tabel
  const form = document.getElementById('formPengajuan');
  form.addEventListener('submit', function(e) {
    e.preventDefault();
    alert('✅ Data pengajuan disimpan (simulasi muncul otomatis di bawah)');
  });
</script>
@endpush
