<div class="toolbar">
  <div class="date-filter">
    <button id="tanggalButton" class="filter-button">
      <span class="df-ic" aria-hidden="true">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
          <rect x="3" y="4" width="18" height="17" rx="3" stroke="#0ea5e9" stroke-width="2"/>
          <path d="M8 2v4M16 2v4M3 10h18" stroke="#0ea5e9" stroke-width="2" stroke-linecap="round"/>
        </svg>
      </span>
      <span class="btn-label">Tanggal</span>
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
        <button class="btn save" id="btnSaveDate">Simpan</button>
        <button class="btn cancel" id="btnCancelDate">Batal</button>
      </div>
    </div>
  </div>

  <div class="select-filter">
    <button id="jenisButton" class="filter-button" data-dropdown="jenisDropdown">
      <span class="df-ic" aria-hidden="true">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
          <path d="M4 7h16M4 12h12M4 17h8" stroke="#2563eb" stroke-width="2" stroke-linecap="round"/>
        </svg>
      </span>
      <span class="btn-label" id="jenisLabel">Jenis Pinjaman</span>
    </button>

    <div id="jenisDropdown" class="dropdown-content">
      <label class="dd-label" for="jenisSelect">Pilih jenis pinjaman</label>
      <select id="jenisSelect" class="input-select">
        <option value="">Semua</option>
        <option value="deposit">Pinjaman Biasa</option>
        <option value="withdrawal">Pinjaman Darurat</option>
        <option value="transfer">Pinjaman Barang</option>
      </select>
      <div class="dropdown-buttons">
        <button class="btn save" id="btnSaveJenis">Simpan</button>
        <button class="btn cancel" data-cancel="jenisDropdown">Batal</button>
      </div>
    </div>
  </div>

  <div class="select-filter">
    <button id="statusButton" class="filter-button" data-dropdown="statusDropdown">
      <span class="df-ic" aria-hidden="true">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
          <path d="M4 7h16M4 12h12M4 17h8" stroke="#2563eb" stroke-width="2" stroke-linecap="round"/>
        </svg>
      </span>
      <span class="btn-label" id="statusLabel">Status</span>
    </button>

    <div id="statusDropdown" class="dropdown-content">
      <label class="dd-label" for="statusSelect">Pilih status</label>
      <select id="statusSelect" class="input-select">
        <option value="">Semua</option>
        <option value="pending">Menunggu Konfirmasi</option>
        <option value="success">Disetujui</option>
        <option value="cancelled">Ditolak</option>
      </select>
      <div class="dropdown-buttons">
        <button class="btn save" id="btnSaveStatus">Simpan</button>
        <button class="btn cancel" data-cancel="statusDropdown">Batal</button>
      </div>
    </div>
  </div>

  <button class="filter-button apply" id="applyFilters">
    <span class="df-ic" aria-hidden="true">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
        <path d="M5 13l4 4L19 7" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </span>
    Terapkan
  </button>

  <button class="filter-button" id="clearFilter">
    <span class="df-ic" aria-hidden="true">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
        <path d="M6 6l12 12M18 6L6 18" stroke="#2563eb" stroke-width="2" stroke-linecap="round"/>
      </svg>
    </span>
    Hapus filter
  </button>
</div>

<style>
.toolbar {
  display: flex;
  justify-content: flex-start; 
  align-items: center;
  gap: 6px;
  background-color: transparent;
  padding: 8px;
  border-radius: 5px;
  margin-top: 60px;
  margin-left: 20px;
  margin-right: 0;           
  flex-wrap: wrap;              
  align-content: flex-start;    
  direction: ltr;               
}

.toolbar > * {
  flex: 0 0 auto;            
}


.filter-button {
  appearance: none;
  border: 1px solid #d1d5db;
  background: #ffffff;
  color: #111827;
  padding: 4px 8px;
  border-radius: 8px;
  cursor: pointer;
  font-size: 12px;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  box-shadow: 0 2px 4px rgba(107, 105, 105, 0.25);
  line-height: 1;
  transition: background-color 0.3s, border-color 0.3s;
}

.filter-button:hover { background-color: #f8fafc; border-color: #cbd5e1; }

.date-filter, .select-filter { position: relative; }

.btn-label.badge::after {
  content: attr(data-badge);
  margin-left: 6px;
  padding: 2px 6px;
  border-radius: 999px;
  border: 1px solid #cbd5e1;
  font-size: 11px;
  color: #0f172a;
  background: #f1f5f9;
}

.dropdown-content {
  display: none;
  position: absolute;
  top: calc(100% + 6px);
  right: 0;
  background-color: white;
  border: 1px solid #d1d5db;
  padding: 12px;
  box-shadow: 0 8px 24px rgba(15, 23, 42, 0.12);
  border-radius: 10px;
  z-index: 100;
  width: 220px;
}

.range { margin-bottom: 10px; }
.range label, .dd-label { font-size: 12px; color: #334155; display:block; margin-bottom: 6px; }

.input-date, .input-select {
  width: 100%;
  padding: 6px 8px;
  font-size: 12px;
  border-radius: 8px;
  border: 1px solid #d1d5db;
}

.dropdown-buttons {
  display: flex;
  gap: 8px;
  justify-content: flex-end;
  margin-top: 10px;
}

.btn {
  padding: 6px 10px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-size: 12px;
  box-shadow: 0 2px 4px rgba(107,105,105,0.25);
}

.btn.save { border:1px solid #25E11B; background:#25E11B; color:#fff; }
.btn.cancel { border:1px solid #EA2828; background:#EA2828; color:#fff; }

.filter-button.apply { border-color:#16a34a; }

@media (max-width: 768px) {
  .toolbar { margin-right: 0; justify-content:flex-start; }
  .dropdown-content { right: auto; left: 0; }
}
</style>

<script>
/* --- Helpers --- */
const $ = (sel) => document.querySelector(sel);
const show = (el) => el.style.display = 'block';
const hide = (el) => el.style.display = 'none';

function closeAllDropdowns(exceptId=null) {
  document.querySelectorAll('.dropdown-content').forEach(dd => {
    if (!exceptId || dd.id !== exceptId) hide(dd);
  });
}

function setBadge(buttonLabelEl, valueText) {
  if (!buttonLabelEl) return;
  if (valueText) {
    buttonLabelEl.classList.add('badge');
    buttonLabelEl.setAttribute('data-badge', valueText);
  } else {
    buttonLabelEl.classList.remove('badge');
    buttonLabelEl.removeAttribute('data-badge');
  }
}

/* --- Tanggal Dropdown --- */
$('#tanggalButton').addEventListener('click', (e) => {
  e.stopPropagation();
  const dd = $('#tanggalDropdown');
  const isOpen = dd.style.display === 'block';
  closeAllDropdowns();
  isOpen ? hide(dd) : show(dd);
});

$('#btnSaveDate').addEventListener('click', () => {
  const s = $('#startDate').value;
  const e = $('#endDate').value;
  if (s && e) {
    alert(`Tanggal dari ${s} hingga ${e} disimpan.`);
    // TODO: kirim ke backend
    const label = $('#tanggalButton .btn-label');
    setBadge(label, `${s} → ${e}`);
    hide($('#tanggalDropdown'));
  } else {
    alert('Silakan pilih tanggal yang valid.');
  }
});

$('#btnCancelDate').addEventListener('click', () => hide($('#tanggalDropdown')));

/* --- Jenis Dropdown --- */
$('#jenisButton').addEventListener('click', (e) => {
  e.stopPropagation();
  const id = e.currentTarget.getAttribute('data-dropdown');
  const dd = document.getElementById(id);
  const isOpen = dd.style.display === 'block';
  closeAllDropdowns();
  isOpen ? hide(dd) : show(dd);
});

$('#btnSaveJenis').addEventListener('click', () => {
  const val = $('#jenisSelect').value;
  const text = $('#jenisSelect').selectedOptions[0]?.text || '';
  setBadge($('#jenisLabel'), val ? text : '');
  hide($('#jenisDropdown'));
});

/* --- Status Dropdown --- */
$('#statusButton').addEventListener('click', (e) => {
  e.stopPropagation();
  const id = e.currentTarget.getAttribute('data-dropdown');
  const dd = document.getElementById(id);
  const isOpen = dd.style.display === 'block';
  closeAllDropdowns();
  isOpen ? hide(dd) : show(dd);
});

$('#btnSaveStatus').addEventListener('click', () => {
  const val = $('#statusSelect').value;
  const text = $('#statusSelect').selectedOptions[0]?.text || '';
  setBadge($('#statusLabel'), val ? text : '');
  hide($('#statusDropdown'));
});

/* --- Cancel buttons (generic) --- */
document.querySelectorAll('.btn.cancel[data-cancel]').forEach(btn => {
  btn.addEventListener('click', (e) => {
    const id = e.currentTarget.getAttribute('data-cancel');
    hide(document.getElementById(id));
  });
});

/* --- Terapkan --- */
$('#applyFilters').addEventListener('click', () => {
  const payload = {
    startDate: $('#startDate').value || null,
    endDate: $('#endDate').value || null,
    jenis: $('#jenisSelect').value || null,
    status: $('#statusSelect').value || null,
  };
  // Di sini ganti alert dengan fetch/axios ke backend kalian.
  alert('Menerapkan filter:\n' + JSON.stringify(payload, null, 2));
  // Contoh:
  // fetch('/transactions/filter', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify(payload) })
  //   .then(r => r.json()).then(console.log);
});

/* --- Hapus filter --- */
$('#clearFilter').addEventListener('click', () => {
  // reset inputs
  $('#startDate').value = '';
  $('#endDate').value = '';
  $('#jenisSelect').value = '';
  $('#statusSelect').value = '';

  // reset badges
  setBadge($('#tanggalButton .btn-label'), '');
  setBadge($('#jenisLabel'), '');
  setBadge($('#statusLabel'), '');

  alert('Filter dihapus.');
});

/* --- Close dropdown saat klik di luar / ESC --- */
document.addEventListener('click', (e) => {
  if (!e.target.closest('.date-filter') && !e.target.closest('.select-filter')) {
    closeAllDropdowns();
  }
});
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') closeAllDropdowns();
});
</script>
