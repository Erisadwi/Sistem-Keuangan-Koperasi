@extends('layouts.tambah-data-pengajuan')

@section('title', 'Tambah Pengajuan')  
@section('title-1', 'Tambah Pengajuan')  
@section('sub-title', 'Tambah Pengajuan')  

@section('content')

<form id="formPengajuan" class="form" method="post" action="{{ route('pengajuan.store') }}" enctype="multipart/form-data">
  @csrf

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

  async function generateSimulasi() {
    const nominalVal = parseNominal(nominal.value);
    const lamaVal = parseInt(lama.value);

    if (nominalVal <= 0 || !lamaVal) {
      simulasiSection.style.display = 'none';
      return;
    }

    // panggil controller via AJAX
    const res = await fetch(`{{ route('pengajuan.simulasi') }}?nominal=${nominalVal}&lama=${lamaVal}`);
    const data = await res.json();

    simulasiBody.innerHTML = '';
    data.forEach(row => {
      simulasiBody.insertAdjacentHTML('beforeend', `
        <tr>
          <td>${row.angsuran_ke}</td>
          <td>${row.jatuh_tempo}</td>
          <td>${formatNumber(row.pokok)}</td>
          <td>${formatNumber(row.bunga)}</td>
          <td>${formatNumber(row.admin)}</td>
          <td>${formatNumber(row.total)}</td>
        </tr>
      `);
    });
    simulasiSection.style.display = 'block';
  }

  [nominal, lama].forEach(el => el.addEventListener('input', generateSimulasi));

  nominal.addEventListener('input', (e) => {
    let val = e.target.value.replace(/\D/g, '');
    e.target.value = val.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
  });
</script>
@endpush
