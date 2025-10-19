<style>
.toolbar {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 6px;
  margin-top: 70px;
  margin-left: 14px;
  margin-bottom: 15px;
  position: relative;
}

/* Tombol utama */
.filter-button {
  display: flex;
  align-items: center;
  gap: 6px;
  background-color: #fff;
  border: none;
  box-shadow: 0 2px 4px rgba(0,0,0,0.15);
  padding: 6px 10px;
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.2s ease;
  font-size: 13px;
  color: #000;
}

.filter-button:hover {
  background-color: #f0f8ff;
  transform: translateY(-1px);
}

.filter-button:focus,
.filter-button:active {
  outline: none;
  box-shadow: 0 0 0 2px #2563eb50;
}

/* Tombol merah khusus hapus */
.filter-button.danger:hover {
  background-color: #fee2e2;
}

/* Input pencarian */
.search-filter {
  display: flex;
  align-items: center;
  gap: 6px;
  margin-left: 4px;
}

.search-input {
  padding: 5px 8px;
  border: none;
  box-shadow: 0 1px 2px rgba(0,0,0,0.2);
  border-radius: 4px;
  font-size: 13px;
}

.search-input.small {
  width: 110px;
}

/* Fokus input jadi biru */
.search-input:focus {
  outline: none;
  box-shadow: 0 0 0 2px #2563eb50;
}

/* Dropdown tanggal */
.date-filter {
  position: relative;
}

.dropdown-content {
  position: absolute;
  top: 110%;
  left: 0;
  background: white;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  padding: 10px;
  z-index: 50;
  width: 200px;
}

.dropdown-content.hidden {
  display: none;
}

.range {
  display: flex;
  flex-direction: column;
  gap: 4px;
  margin-bottom: 8px;
}

.input-date {
  border: 1px solid #d1d5db;
  border-radius: 4px;
  padding: 4px 6px;
  font-size: 13px;
}

.dropdown-buttons {
  display: flex;
  justify-content: flex-end;
  gap: 6px;
}

.btn {
  border: none;
  border-radius: 4px;
  padding: 4px 8px;
  cursor: pointer;
  font-size: 13px;
  font-weight: 500;
}

.btn.save {
  background-color: #22c55e;
  color: white;
}

.btn.cancel {
  background-color: #ef4444;
  color: white;
}

/* Dropdown jenis simpanan */
select.filter-button {
  padding-right: 20px;
}

/* Ikon */
svg {
  flex-shrink: 0;
}

@media (max-width: 768px) {
  .toolbar {
    margin-top: 60px;
    gap: 4px;
  }
  .filter-button {
    font-size: 12px;
    padding: 5px 8px;
  }
  .search-input.small {
    width: 90px;
  }
}
</style>

<div class="toolbar">

  {{-- === Tombol Tambah === --}}
  <button class="filter-button">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
      <path d="M12 5v14M5 12h14" stroke="#2563eb" stroke-width="2" stroke-linecap="round"/>
    </svg>
    Tambah
  </button>

  {{-- === Tombol Edit === --}}
  <button class="filter-button">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
      <path d="M12 20h9M16.5 3.5a2.121 2.121 0 0 1 3 3L8 18l-4 1 1-4 11.5-11.5z" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    Edit
  </button>

  {{-- === Tombol Hapus === --}}
  <button class="filter-button danger">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
      <path d="M6 7h12M9 7V5h6v2M10 11v6M14 11v6M5 7h14l-1 14H6L5 7z" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    Hapus
  </button>

  {{-- === Filter Tanggal === --}}
  <div class="date-filter">
    <button id="tanggalButton" class="filter-button">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
        <rect x="3" y="4" width="18" height="17" rx="3" stroke="#2563eb" stroke-width="2"/>
        <path d="M8 2v4M16 2v4M3 10h18" stroke="#2563eb" stroke-width="2" stroke-linecap="round"/>
      </svg>
      Tanggal
    </button>

    <div id="tanggalDropdown" class="dropdown-content hidden">
      <div class="range">
        <label for="startDate">Tanggal Mulai:</label>
        <input type="date" id="startDate" class="input-date">
      </div>
      <div class="range">
        <label for="endDate">Tanggal Akhir:</label>
        <input type="date" id="endDate" class="input-date">
      </div>
      <div class="dropdown-buttons">
        <button class="btn save" onclick="saveDateRange()">Simpan</button>
        <button class="btn cancel" onclick="cancelDateRange()">Batal</button>
      </div>
    </div>
  </div>

  {{-- === Dropdown Jenis Simpanan === --}}
  <select id="jenisSimpanan" class="filter-button">
    <option value="" selected disabled>Pilih Jenis Simpanan</option>
    <option value="wajib">Simpanan Wajib</option>
    <option value="pokok">Simpanan Pokok</option>
    <option value="sukarela">Simpanan Sukarela</option>
  </select>

  {{-- === Search Filter === --}}
  <div class="search-filter">
    <span>Cari:</span>
    <input type="text" id="transactionId" placeholder="Kode Transaksi" class="search-input small">
    <input type="text" id="memberName" placeholder="Nama Anggota" class="search-input small">
  </div>

  {{-- === Tombol Hapus Filter === --}}
  <button class="filter-button" onclick="clearFilter()">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
      <path d="M6 6l12 12M18 6L6 18" stroke="#2563eb" stroke-width="2" stroke-linecap="round"/>
    </svg>
    Hapus Filter
  </button>

  {{-- === Tombol Unduh === --}}
  <button class="filter-button">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
      <path d="M12 16v-4m0 0l-4 4m4-4l4 4" stroke="#2563eb" stroke-width="2" stroke-linecap="round"/>
      <path d="M4 4h16v12H4V4z" stroke="#2563eb" stroke-width="2" stroke-linecap="round"/>
    </svg>
    Unduh
  </button>

</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const tanggalButton = document.getElementById("tanggalButton");
  const dropdown = document.getElementById("tanggalDropdown");

  tanggalButton.addEventListener("click", () => {
    dropdown.classList.toggle("hidden");
  });
});

function saveDateRange() {
  const start = document.getElementById("startDate").value;
  const end = document.getElementById("endDate").value;
  const btn = document.getElementById("tanggalButton");
  if (start && end) {
    btn.innerHTML = `
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
        <rect x="3" y="4" width="18" height="17" rx="3" stroke="#2563eb" stroke-width="2"/>
        <path d="M8 2v4M16 2v4M3 10h18" stroke="#2563eb" stroke-width="2" stroke-linecap="round"/>
      </svg>
      Tanggal: ${start} - ${end}
    `;
  }
  document.getElementById("tanggalDropdown").classList.add("hidden");
}

function cancelDateRange() {
  document.getElementById("tanggalDropdown").classList.add("hidden");
}

function clearFilter() {
  document.getElementById("transactionId").value = "";
  document.getElementById("memberName").value = "";
  document.getElementById("startDate").value = "";
  document.getElementById("endDate").value = "";
  document.getElementById("jenisSimpanan").selectedIndex = 0; // ✅ reset jenis simpanan
  document.getElementById("tanggalButton").innerHTML = `
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
      <rect x="3" y="4" width="18" height="17" rx="3" stroke="#2563eb" stroke-width="2"/>
      <path d="M8 2v4M16 2v4M3 10h18" stroke="#2563eb" stroke-width="2" stroke-linecap="round"/>
    </svg>
    Tanggal
  `;
}
</script>
