@extends('layouts.tambah-data-pengajuan')

@section('title', 'Tambah Pengajuan')  
@section('title-1', 'Tambah Pengajuan')  
@section('sub-title', 'Tambah Pengajuan')  

@section('content')

<form id="formPengajuan" class="form" method="post" action="{{ route('anggota.pengajuan.store') }}" enctype="multipart/form-data">
  @csrf

  <div class="form-group">
    <label for="jenis">Jenis Pinjaman*</label>
    <select id="jenis" name="jenis_ajuan" class="form-input" required>
      <option value="">Pilih Jenis Pinjaman</option>
      <option value="PINJAMAN BIASA">Pinjaman Biasa</option>
      <option value="PINJAMAN DARURAT">Pinjaman Darurat</option>
      <option value="PINJAMAN BARANG">Pinjaman Barang</option>
    </select>
  </div>

  <div class="form-group">
    <label for="nominal">Nominal*</label>
    <input type="text" id="nominal" name="jumlah_ajuan" class="form-input" required>
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


  <input type="hidden" id="id_biayaAdministrasi" name="id_biayaAdministrasi" value="{{ $biayaAdministrasi->first()->id_biayaAdministrasi }}">
  <input type="hidden" name="tanggal_pengajuan" value="{{ now()->toDateString() }}">
  <input type="hidden" name="tanggal_update" value="{{ now()->toDateString() }}">
  <input type="hidden" name="status_ajuan" value="MENUNGGU KONFIRMASI">


  <div class="form-group">
    <label for="keterangan">Keterangan</label>
    <input type="text" id="keterangan" name="keterangan" class="form-input">
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
  console.log('Nominal:', nominalVal, 'Lama:', lamaVal);

  async function generateSimulasi() {
    const nominalVal = parseNominal(nominal.value);
    const lamaVal = parseInt(lama.value);

    if (nominalVal <= 0 || !lamaVal) {
      simulasiSection.style.display = 'none';
      return;
    }

    // panggil controller via AJAX
    const res = await fetch(`{{ route('anggota.pengajuan.simulasi') }}`, {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': '{{ csrf_token() }}'
  },
  body: JSON.stringify({
    jumlah_ajuan: nominalVal,
    id_lamaAngsuran: lamaVal,
    id_biayaAdministrasi: document.getElementById('id_biayaAdministrasi').value
  })

});
    const data = await res.json();

    if (!res.ok) {
  const errText = await res.text();
  console.error('Gagal ambil simulasi:', errText);
  simulasiSection.style.display = 'none';
  return;
}


    simulasiBody.innerHTML = '';
    data.forEach(row => {
      simulasiBody.insertAdjacentHTML('beforeend', `
      <tr>
        <td>${row.bulan_ke}</td>
        <td>-</td>
        <td>${row.angsuran_pokok}</td>
        <td>${row.angsuran_bunga}</td>
        <td>${row.biaya_admin}</td>
        <td>${row.total_angsuran}</td>
      </tr>
    `);
    });
    simulasiSection.style.display = 'block';
  }

  nominal.addEventListener('input', generateSimulasi);
  lama.addEventListener('change', generateSimulasi);

  nominal.addEventListener('input', (e) => {
    let val = e.target.value.replace(/\D/g, '');
    e.target.value = val.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
  });
</script>
@endpush
