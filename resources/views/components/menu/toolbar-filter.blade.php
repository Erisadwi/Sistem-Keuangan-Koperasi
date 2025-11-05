@props([
  'downloadRoute' => null,
])

<div class="toolbar">

  <div class="date-filter">
    <button id="tanggalButton" class="filter-button">
      <span class="df-ic" aria-hidden="true">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
          <rect x="3" y="4" width="18" height="17" rx="3" stroke="#0ea5e9" stroke-width="2"/>
          <path d="M8 2v4M16 2v4M3 10h18" stroke="#0ea5e9" stroke-width="2" stroke-linecap="round"/>
        </svg>
      </span>
      Tanggal
    </button>

    <div id="tanggalDropdown" class="dropdown-content">
      <div class="range">
        <label for="startDate">Tanggal Mulai:</label>
        <input type="date" id="startDate" name="startDate" class="input-date">
      </div>
      <div class="range">
        <label for="endDate">Tanggal Akhir:</label>
        <input type="date" id="endDate" name="endDate" class="input-date">
      </div>
      <div class="dropdown-buttons">
        <button class="btn save" onclick="applyDateFilter()">Simpan</button>
        <button class="btn cancel" onclick="cancelDateRange()">Batal</button>
      </div>
    </div>
  </div>

  <div class="search-filter">
    Cari :
    <input type="text" id="kodeTransaksi" placeholder="Cari Kode Trans" class="search-input">
    <input type="text" id="namaAnggota" placeholder="Cari Nama Anggota" class="search-input">
    <button id="searchButton" class="filter-button" onclick="applySearch()">
      <span class="df-ic" aria-hidden="true">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
          <path d="M21 21l-6-6m2.5-4.5A7.5 7.5 0 1 1 12 4.5a7.5 7.5 0 0 1 7.5 7.5z" stroke="#2563eb" stroke-width="2" stroke-linecap="round"/>
        </svg>
      </span>
    </button>
  </div>

  <button class="filter-button" onclick="clearFilter()">
    <span class="df-ic" aria-hidden="true">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
        <path d="M6 6l12 12M18 6L6 18" stroke="#2563eb" stroke-width="2" stroke-linecap="round"/>
      </svg>
    </span>
    Hapus filter
  </button>

  @if($downloadRoute)
  <a href="{{ $downloadRoute }}" class="filter-button">
    <span class="df-ic" aria-hidden="true">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
        <path d="M12 16v-4m0 0l-4 4m4-4l4 4" stroke="#0ea5e9" stroke-width="2" stroke-linecap="round"/>
        <path d="M4 4h16v12H4V4z" stroke="#0ea5e9" stroke-width="2" stroke-linecap="round"/>
      </svg>
    </span>
    Unduh
  </a>
  @endif
</div>

<style>
.toolbar {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  gap: 6px;
  background-color: transparent;
  padding: 8px;
  margin-top: 50px;
  margin-right: 10px;
  flex-wrap: wrap;
}

.filter-button {
  appearance: none;
  border: 1px solid #d1d5db;
  background: #ffffff;
  color: #111827;
  padding: 5px 10px;
  border-radius: 8px;
  cursor: pointer;
  font-size: 12px;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  box-shadow: 0 2px 4px rgba(107, 105, 105, 0.647);
  line-height: 1;
  transition: all 0.25s ease;
}
.filter-button:hover {
  background-color: #f8fafc;
  border-color: #0ea5e9;
  color: #0ea5e9;
}
.filter-button:active {
  transform: scale(0.96);
}

/* Popup tanggal */
.date-filter {
  position: relative;
}
#tanggalDropdown {
  display: none;
  position: absolute;
  top: 35px;
  background-color: white;
  border: 1px solid #d1d5db;
  padding: 15px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  border-radius: 8px;
  z-index: 100;
  width: 210px;
}
.range {
  margin-bottom: 10px;
}
.range label {
  font-size: 12px;
  color: #333;
}
.input-date {
  width: 100%;
  padding: 6px;
  font-size: 12px;
  border-radius: 8px;
  border: 1px solid #d1d5db;
}
.dropdown-buttons {
  display: flex;
  justify-content: space-between;
}
.btn.save {
  border: 1px solid #25E11B;
  background: #25E11B;
  color: #fff;
  padding: 6px 12px;
  border-radius: 8px;
  font-size: 12px;
  box-shadow: 0 2px 4px rgba(107, 105, 105, 0.647);
}
.btn.cancel {
  border: 1px solid #EA2828;
  background: #EA2828;
  color: #fff;
  padding: 6px 12px;
  border-radius: 8px;
  font-size: 12px;
  box-shadow: 0 2px 4px rgba(107, 105, 105, 0.647);
}

.search-filter {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 13px;
  font-weight: 500;
}
.search-filter input {
  padding: 5px 10px;
  font-size: 12px;
  border-radius: 8px;
  border: 1px solid #d1d5db;
  box-shadow: 0 2px 4px rgba(107, 105, 105, 0.647);
  width: 130px;
}
.search-filter input:focus {
  outline: none;
  border-color: #0ea5e9;
}
</style>

<script>
document.getElementById('tanggalButton').addEventListener('click', function() {
  const dropdown = document.getElementById('tanggalDropdown');
  dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
});

function applyDateFilter() {
  const startDate = document.getElementById('startDate').value;
  const endDate = document.getElementById('endDate').value;
  if (startDate && endDate) {
    const button = document.getElementById('tanggalButton');
    button.innerHTML = `
      <span class="df-ic" aria-hidden="true">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
          <rect x="3" y="4" width="18" height="17" rx="3" stroke="#0ea5e9" stroke-width="2"/>
          <path d="M8 2v4M16 2v4M3 10h18" stroke="#0ea5e9" stroke-width="2" stroke-linecap="round"/>
        </svg>
      </span>
      ${formatDate(startDate)} - ${formatDate(endDate)}
    `;
    document.getElementById('tanggalDropdown').style.display = 'none';
  } else {
    alert('Pilih tanggal mulai dan akhir!');
  }
}

function formatDate(dateStr) {
  const d = new Date(dateStr);
  const day = String(d.getDate()).padStart(2, '0');
  const month = String(d.getMonth() + 1).padStart(2, '0');
  const year = d.getFullYear();
  return `${day}/${month}/${year}`;
}

function applySearch() {
  const kode = document.getElementById('kodeTransaksi').value;
  const nama = document.getElementById('namaAnggota').value;
  const params = new URLSearchParams(window.location.search);
  if (kode) params.set('kode', kode); else params.delete('kode');
  if (nama) params.set('nama', nama); else params.delete('nama');
  window.location.search = params.toString();
}

function clearFilter() {
  document.getElementById('kodeTransaksi').value = '';
  document.getElementById('namaAnggota').value = '';
  document.getElementById('startDate').value = '';
  document.getElementById('endDate').value = '';
  document.getElementById('tanggalButton').innerHTML = `
    <span class="df-ic" aria-hidden="true">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
        <rect x="3" y="4" width="18" height="17" rx="3" stroke="#0ea5e9" stroke-width="2"/>
        <path d="M8 2v4M16 2v4M3 10h18" stroke="#0ea5e9" stroke-width="2" stroke-linecap="round"/>
      </svg>
    </span>
    Tanggal
  `;
}

function cancelDateRange() {
  document.getElementById('tanggalDropdown').style.display = 'none';
}
</script>
