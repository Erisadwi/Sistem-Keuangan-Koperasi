@extends('layouts.tambah-data-pengajuan')


@section('title', 'Tambah Pengajuan')  
@section('title-1', 'Tambah Pengajuan')  
@section('sub-title', 'Tambah Pengajuan')  

@section('content')

  <form class="form" method="post" action="#" {{-- {{ route('profile.update', $ajuan_pinjaman->id_ajuanPinjaman) }} --}} enctype="multipart/form-data">
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
      <input type="text" id="nominal" name="nominal" class="form-input" placeholder="cth. 12.000.000" required>
    </div>

    <div class="form-group">
      <label for="lama_angsuran">Lama Angsuran (Bulan)*</label>
      <input type="number" id="lama_angsuran" name="lama_angsuran" class="form-input" min="1" placeholder="cth. 5" required>
    </div>

    <div class="form-group">
      <label for="keterangan">Keterangan</label>
      <input type="text" id="keterangan" name="keterangan" class="form-input" placeholder="Pinjaman">
    </div>

    <div class="form-group form-group-btn">
      <button type="submit" class="btn-submit">Kirim</button>
    </div>
  </form>

{{-- Komponen pagination --}}
<x-menu.pagination />

@endsection


  {{-- SCRIPT --}}
  <script>
    const form = document.getElementById('formPengajuan');

    form.addEventListener('submit', function(e) {
      // Hentikan refresh dulu biar tabel muncul dulu
      e.preventDefault();

      const jenis = document.getElementById('jenis').value.trim();
      const nominal = parseFloat(document.getElementById('nominal').value.replace(/\./g, '').replace(/,/g, '')) || 0;
      const lama = parseInt(document.getElementById('lama_angsuran').value);

      if (!jenis || nominal <= 0 || !lama) {
        alert('⚠️ Mohon lengkapi semua kolom wajib!');
        return;
      }

      // Buat simulasi
      const bunga = 0.02;
      const admin = 0;
      const angsuranPokok = nominal / lama;
      const simulasiBody = document.getElementById('simulasiBody');
      simulasiBody.innerHTML = '';

      const today = new Date();
      for (let i = 1; i <= lama; i++) {
        const tempo = new Date(today);
        tempo.setMonth(today.getMonth() + i);
        const bungaBulanan = nominal * bunga;
        const totalTagihan = angsuranPokok + bungaBulanan + admin;

        simulasiBody.insertAdjacentHTML('beforeend', `
          <tr>
            <td>${i}</td>
            <td>${tempo.toLocaleDateString('id-ID', { day:'2-digit', month:'long', year:'numeric' })}</td>
            <td>${angsuranPokok.toLocaleString('id-ID')}</td>
            <td>${bungaBulanan.toLocaleString('id-ID')}</td>
            <td>${admin.toLocaleString('id-ID')}</td>
            <td>${totalTagihan.toLocaleString('id-ID')}</td>
          </tr>
        `);
      }

      document.getElementById('simulasiSection').style.display = 'block';

      // Setelah simulasi tampil, kirim form ke server (biar tersimpan di DB)
      setTimeout(() => {
        form.submit();
        form.reset();
      }, 800);
    });
  </script>
