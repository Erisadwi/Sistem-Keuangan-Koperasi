@extends('layouts.app-admin-add')

@section('title', 'Lama Angsuran')  
@section('back-title', 'Master Data >')
@section('title-1', 'Lama Angsuran')  
@section('sub-title', 'Tambah Data Lama Angsuran')  


@section('content')

<div class="form-wrapper">
    <form action="# {{-- {{ route('tambah-data-lama-angsuran.store', $transaksi->id) }} --}}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="lama_angsuran">Lama Angsuran (Bulan)*</label>
            <input 
                type="number" 
                name="lama_angsuran" 
                id="lama_angsuran" 
                class="form-input" 
                placeholder="Masukkan lama angsuran dalam bulan"
                required>
        </div>

        <div class="form-group">
            <label for="is_active">Keterangan Aktif*</label>
            <select name="is_active" id="is_active" class="form-select" required>
                <option value="">Pilih Keterangan Aktif</option>
                <option value="Y">Y</option>
                <option value="T">T</option>
            </select>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn btn-simpan">Simpan</button>
            <a href="# {{-- {{ route('transaksi.index') }} --}}" class="btn btn-batal">Batal</a>
        </div>
    </form>
</div>

<style>
  /* Wrapper utama form */
  .form-wrapper {
    margin-top: 60px; /* jarak dari judul */
    margin-left: 40px;
    width: 750px;
  }

  /* Judul kecil form */
  .form-title {
    font-size: 18px;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 25px;
    border-bottom: 2px solid #3b82f6;
    padding-bottom: 6px;
  }

  /* Tiap grup input */
  .form-group {
    margin-bottom: 20px;
  }

  .form-group label {
    display: block;
    font-size: 14px;
    font-weight: 500;
    color: #333;
    margin-bottom: 6px;
  }

  /* Input dan Select */
  .form-input,
  .form-select {
    width: 100%;
    padding: 10px 12px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 6px;
    background-color: rgba(255,255,255,0.7); /* sedikit transparan agar tetap selaras dengan background */
    outline: none;
    transition: all 0.2s ease-in-out;
  }

  .form-input:focus,
  .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 5px rgba(59, 130, 246, 0.4);
    background-color: rgba(255,255,255,0.9);
  }

  /* Tombol Simpan dan Batal */
  .form-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 300px;
  }

  .btn-simpan {
    background-color: #25E11B;
    border: none;
    color: white;
    padding: 9px 22px;
    font-size: 13px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
  }

  .btn-simpan:hover {
    background-color: #1dc215;
  }

  .btn-batal {
    background-color: #FF0000;
    color: white;
    text-decoration: none;
    padding: 9px 22px;
    font-size: 13px;
    border-radius: 6px;
    font-weight: 600;
  }

  .btn-batal:hover {
    background-color: #d90b0b;
  }

  @media (max-width: 768px) {
    .form-wrapper {
      width: 100%;
      margin: 40px 20px;
    }
  }
</style>

<script>
document.getElementById('form-container').addEventListener('submit', function(e) {
    e.preventDefault();

    const wajib = ['lama_angsuran','is_active'];

    for (let id of wajib) {
        if (!document.getElementById(id).value.trim()) {
            alert('⚠️ Mohon isi semua kolom wajib sebelum menyimpan.');
            return;
        }
    }

    if (confirm('Apakah data sudah benar dan ingin disimpan?')) {
        alert('✅ Data barang berhasil disimpan!');
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

@endsection
