<div class="toolbar">
  <div class="toolbar-left">
    {{-- 🔹 Filter tanggal --}}
    <div class="tanggal-wrapper">
      <button id="btnTanggal" class="btn-toolbar">Pilih Tanggal</button>

      <div id="popupTanggal" class="popup-tanggal hidden">
        <label for="tanggalMulai">Tanggal Mulai:</label>
        <input type="date" id="tanggalMulai">

        <label for="tanggalAkhir">Tanggal Akhir:</label>
        <input type="date" id="tanggalAkhir">

        <div class="popup-buttons">
          <button id="btnSimpanTanggal" class="btn-toolbar btn-simpan">Simpan</button>
          <button id="btnBatalTanggal" class="btn-toolbar btn-batal">Batal</button>
        </div>
      </div>
    </div>

    {{-- 🔹 Input kode & nama anggota --}}
    <input type="text" id="kodeTransaksi" class="input-filter" placeholder="Kode Transaksi">
    <input type="text" id="namaAnggota" class="input-filter" placeholder="Nama Anggota">

    {{-- 🔹 Tombol aksi --}}
    <button class="btn-toolbar" id="btnCari">Cari</button>
    <button class="btn-toolbar btn-reset" id="btnReset">Hapus Filter</button>
  </div>
</div>

{{-- ======================= STYLE ======================= --}}
<style>
:root {
  --primary: #6ba1be;
  --primary-dark: #558ca3;
  --border: #d1d5db;
  --shadow: rgba(0,0,0,0.15);
  --green: #22c55e;
  --green-dark: #16a34a;
  --red: #ef4444;
  --red-dark: #dc2626;
}

/* Toolbar */
.toolbar {
  display: flex;
  justify-content: flex-start;
  align-items: center;
  flex-wrap: wrap;
  gap: 8px;
  margin-top: 70px;     /* dari 60px → turun sedikit ke bawah */
  margin-bottom: 15px;
  padding-left: 30px;   /* dari 15px → agak lebih ke kanan */
}

.toolbar-left {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 8px;
}



/* Tombol umum */
.btn-toolbar {
  padding: 3px 8px;
  height: 32px;
  border-radius: 5px;
  font-size: 12.5px;
  border: 1px solid var(--border);
  background: white;
  color: #111827;
  cursor: pointer;
  font-weight: 500;
  transition: all 0.2s ease;
  display: flex;
  align-items: center;
  justify-content: center;
}
.btn-toolbar:hover {
  border-color: #1e40af;
  color: #1e3a8a;
}

/* Tombol khusus pop-up */
.btn-simpan {
  background: var(--green);
  color: #fff;
  border: none;
}
.btn-simpan:hover {
  background: var(--green-dark);
}
.btn-batal {
  background: var(--red);
  color: #fff;
  border: none;
}
.btn-batal:hover {
  background: var(--red-dark);
}

/* Input */
.input-filter {
  padding: 4px 8px;
  border: 1px solid var(--border);
  border-radius: 5px;
  min-width: 140px;
  height: 32px;
  font-size: 12.5px;
}
.input-filter:focus {
  border-color: #1e3a8a;
  outline: none;
}

/* Pop-up tanggal */
.tanggal-wrapper {
  position: relative;
  display: inline-block;
}
.popup-tanggal {
  position: absolute;
  top: 110%;
  left: 0;
  background: white;
  border: 1px solid var(--border);
  border-radius: 6px;
  padding: 10px 12px;
  box-shadow: 0 2px 8px var(--shadow);
  display: flex;
  flex-direction: column;
  gap: 8px;
  z-index: 10;
  min-width: 260px;
}
.popup-tanggal.hidden {
  display: none;
}
.popup-tanggal label {
  font-size: 13px;
  color: #374151;
}
.popup-tanggal input {
  padding: 5px 8px;
  border: 1px solid var(--border);
  border-radius: 5px;
  height: 30px;
  font-size: 12.5px;
}
.popup-buttons {
  display: flex;
  justify-content: flex-end;
  gap: 6px;
  margin-top: 6px;
}
</style>

{{-- ======================= SCRIPT ======================= --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
  const btnTanggal = document.getElementById('btnTanggal');
  const popupTanggal = document.getElementById('popupTanggal');
  const btnSimpanTanggal = document.getElementById('btnSimpanTanggal');
  const btnBatalTanggal = document.getElementById('btnBatalTanggal');
  const btnReset = document.getElementById('btnReset');
  const inputMulai = document.getElementById('tanggalMulai');
  const inputAkhir = document.getElementById('tanggalAkhir');

  // 🔹 Toggle popup tanggal
  btnTanggal.addEventListener('click', (e) => {
    e.stopPropagation();
    popupTanggal.classList.toggle('hidden');
  });

  // 🔹 Klik luar -> tutup popup
  document.addEventListener('click', (e) => {
    if (!popupTanggal.contains(e.target) && e.target !== btnTanggal) {
      popupTanggal.classList.add('hidden');
    }
  });

  // 🔹 Tombol batal
  btnBatalTanggal.addEventListener('click', () => {
    popupTanggal.classList.add('hidden');
  });

  // 🔹 Tombol simpan
  btnSimpanTanggal.addEventListener('click', () => {
    const dari = inputMulai.value;
    const sampai = inputAkhir.value;

    if (dari && sampai) {
      // format ke dd/mm/yyyy
      const formatTanggal = (t) => {
        const d = new Date(t);
        return `${String(d.getDate()).padStart(2,'0')}/${String(d.getMonth()+1).padStart(2,'0')}/${d.getFullYear()}`;
      };

      btnTanggal.textContent = `Tanggal: ${formatTanggal(dari)} - ${formatTanggal(sampai)}`;
    } else {
      btnTanggal.textContent = 'Pilih Tanggal';
    }

    popupTanggal.classList.add('hidden');
  });

  // 🔹 Tombol hapus filter
  btnReset.addEventListener('click', () => {
    document.querySelectorAll('.input-filter').forEach(i => i.value = '');
    inputMulai.value = '';
    inputAkhir.value = '';
    btnTanggal.textContent = 'Pilih Tanggal'; // reset teks tombol tanggal
    popupTanggal.classList.add('hidden');
  });
});
</script>
