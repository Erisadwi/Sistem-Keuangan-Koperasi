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
        <option value="{{ $item->id_lamaAngsuran }}">{{ $item->lama_angsuran }}</option>
      @endforeach
    </select>
  </div>

<input type="hidden" id="id_biayaAdministrasi" name="id_biayaAdministrasi" value="{{ $biayaAdministrasi->id_biayaAdministrasi }}">

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

<style>

.table-simulasi {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
  font-family: Arial, sans-serif;
  font-size: 14px;
}

.table-simulasi thead {
  background-color: #6e9eb6; 
  color: #ffffff;
}

.table-simulasi th,
.table-simulasi td {
  border: 1px solid #f9f9f9;
  padding: 8px;
  text-align: center;
}

.table-simulasi tbody tr {
  background-color: #ffffff; 
  color: #000000; 
}

.table-simulasi tbody tr:nth-child(even),
.table-simulasi tbody tr:hover {
  background-color: #ffffff;
  color: #000000;
}

.table-simulasi th {
  padding-top: 10px;
  padding-bottom: 10px;
  font-weight: bold;
}

#simulasiSection h3 {
  font-family: Arial, sans-serif;
  color: #333;
}


</style>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const nominal = document.getElementById('nominal');
  const lama = document.getElementById('id_lamaAngsuran');
  const simulasiSection = document.getElementById('simulasiSection');
  const simulasiBody = document.getElementById('simulasiBody');

  function parseNominal(str) {
    return parseFloat(str.replace(/\./g, '').replace(/,/g, '')) || 0;
  }

  async function generateSimulasi() {
    const nominalVal = parseNominal(nominal.value);
    const lamaOption = lama.options[lama.selectedIndex];
    const lamaVal = lama.value; 
    if (nominalVal <= 0 || !lamaVal) {
    simulasiSection.style.display = 'none';
    return;
  }


    console.log('🔹 generateSimulasi() terpanggil');
    console.log('Nominal:', nominalVal, 'Lama:', lamaVal);

    if (nominalVal <= 0 || !lamaVal) {
      simulasiSection.style.display = 'none';
      return;
    }
    console.log('Payload simulasi:', {
    jumlah_ajuan: parseNominal(nominal.value),
    id_lamaAngsuran: lama.value,
    id_biayaAdministrasi: document.getElementById('id_biayaAdministrasi').value
});

    try {
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
      console.log('Response simulasi:', data);

      if (!res.ok) {
        console.error('Gagal ambil simulasi:', data);
        simulasiSection.style.display = 'none';
        return;
      }

      simulasiBody.innerHTML = '';
      data.forEach(row => {
        simulasiBody.insertAdjacentHTML('beforeend', `
          <tr>
            <td>${row.bulan_ke}</td>
            <td>${row.jatuh_tempo}</td>
            <td>${row.angsuran_pokok}</td>
            <td>${row.angsuran_bunga}</td>
            <td>${row.biaya_admin}</td>
            <td>${row.total_angsuran}</td>
          </tr>
        `);
      });

      simulasiSection.style.display = 'block';
    } catch (error) {
      console.error('Error:', error);
    }
  }


  nominal.addEventListener('input', (e) => {
    let val = e.target.value.replace(/\D/g, '');
    e.target.value = val.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    generateSimulasi();
  });

  lama.addEventListener('change', generateSimulasi);
});
</script>
@endpush
