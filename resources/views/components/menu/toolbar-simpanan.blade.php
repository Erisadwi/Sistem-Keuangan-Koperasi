<style>
  .toolbar-wrapper {
    display: flex;
    flex-direction: column;
    gap: 5px;
    margin-bottom: 1rem;
    margin-top: 40px;
  }

  /* === BARIS 1 === */
  .toolbar-row-1 {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
  }

  .toolbar-actions {
    display: flex;
    align-items: center;
    gap: 8px;
  }

  /* === BARIS 2 === */
  .toolbar-row-2 {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
  }

  /* === Tombol Umum === */
  .filter-button {
    display: flex;
    align-items: center;
    gap: 6px;
    border: 1px solid #2563eb;
    background-color: white;
    color: #000; /* teks hitam */
    border-radius: 6px;
    padding: 6px 10px;
    cursor: pointer;
    font-size: 13px;
    transition: all 0.2s ease;
  }

  .filter-button svg {
    color: #2563eb; /* semua ikon biru */
  }

  .filter-button:hover {
    background-color: #2563eb;
    color: white;
  }

  .filter-button:hover svg {
    color: white !important;
  }

  /* === Tombol Hapus (warna merah) === */
  .filter-button.danger {
    border-color: #ef4444;
    color: #000 !important; /* tetap teks hitam */
  }

  .filter-button.danger svg {
    color: #ef4444 !important; /* ikon merah */
  }

  .filter-button.danger:hover {
    background-color: #ef4444 !important;
    color: white !important;
  }

  .filter-button.danger:hover svg {
    color: white !important;
  }

  /* === Dropdown tanggal === */
  .date-filter {
    position: relative;
  }

  .dropdown-content {
    position: absolute;
    top: 38px;
    left: 0;
    background-color: white;
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 10px;
    width: 220px;
    z-index: 20;
    box-shadow: 0 2px 10px rgba(0,0,0,0.15);
  }

  .dropdown-content.hidden {
    display: none;
  }

  .range {
    display: flex;
    flex-direction: column;
    margin-bottom: 8px;
    font-size: 13px;
    color: #000; /* teks label tanggal tetap hitam */
  }

  .input-date {
    border: 1px solid #ccc;
    border-radius: 6px;
    padding: 4px;
  }

  .dropdown-buttons {
    display: flex;
    justify-content: space-between;
  }

  .btn {
    padding: 4px 8px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-size: 13px;
  }

  .btn.save {
    background-color: #25E11B;
    color: white;
  }

  .btn.cancel {
    background-color: #EA2828;
    color: white;
  }

  /* Input cari */
  .search-input {
    border: 1px solid #ccc;
    border-radius: 6px;
    padding: 4px 8px;
    font-size: 13px;
    color: gray; /* biarkan abu-abu */
  }

  .search-input.small {
    width: 130px;
  }

  a.filter-button {
    text-decoration: none !important;
    color: #000; /* teks tombol link tetap hitam */
  }

  /* Tombol disable visual */
  .filter-button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }

  .table-active {
    background-color: #e0f2fe !important;
  }

  /* Label "Cari:" tetap hitam */
  .search-filter span {
    color: #000;
    font-weight: 500;
  }
</style>


<div class="toolbar-wrapper">

  <!-- BARIS 1 -->
  <div class="toolbar-row-1">
    <div class="toolbar-actions">

      <a href="{{ $addUrl ?? '#' }}" class="filter-button">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
          <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
        Tambah
      </a>

      <button class="filter-button" data-action="edit" data-url="{{ $editUrl ?? '#' }}" disabled>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
          <path d="M12 20h9M16.5 3.5a2.121 2.121 0 0 1 3 3L8 18l-4 1 1-4 11.5-11.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Edit
      </button>

      <button class="filter-button danger" data-action="delete" data-url="{{ $deleteUrl ?? '#' }}" disabled>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
          <path d="M6 7h12M9 7V5h6v2M10 11v6M14 11v6M5 7h14l-1 14H6L5 7z" 
                stroke="currentColor" stroke-width="2" 
                stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Hapus
      </button>
    </div>

    <div class="toolbar-actions">
      <button class="filter-button" onclick="clearFilter()">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
          <path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
        Hapus Filter
      </button>

      <a href="{{ $exportUrl ?? '#' }}" class="filter-button" data-action="export">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
          <path d="M12 16v-4m0 0l-4 4m4-4l4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          <path d="M4 4h16v12H4V4z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
        Unduh
      </a>
    </div>
  </div>

  <!-- BARIS 2 -->
  <div class="toolbar-row-2">
    <div class="date-filter">
      <button id="tanggalButton" class="filter-button">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
          <rect x="3" y="4" width="18" height="17" rx="3" stroke="currentColor" stroke-width="2"/>
          <path d="M8 2v4M16 2v4M3 10h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
        Tanggal
      </button>
      <div id="tanggalDropdown" class="dropdown-content hidden">
        <div class="range">
          <label for="startDate">Mulai:</label>
          <input type="date" id="startDate" class="input-date">
        </div>
        <div class="range">
          <label for="endDate">Selesai:</label>
          <input type="date" id="endDate" class="input-date">
        </div>
        <div class="dropdown-buttons">
          <button class="btn save" onclick="saveDateRange()">Simpan</button>
          <button class="btn cancel" onclick="cancelDateRange()">Batal</button>
        </div>
      </div>
    </div>

    <select id="jenisSimpanan" class="filter-button">
      <option value="" selected disabled>Pilih Jenis Simpanan</option>
      <option value="Simpanan Wajib">Simpanan Wajib</option>
      <option value="Simpanan Pokok">Simpanan Pokok</option>
      <option value="Simpanan Sukarela">Simpanan Sukarela</option>
    </select>

    <div class="search-filter">
      <span>Cari:</span>
      <input type="text" id="transactionId" placeholder="Kode Transaksi" class="search-input small">
      <input type="text" id="memberName" placeholder="Nama Anggota" class="search-input small">
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
  let selectedId = null;
  const editBtn = document.querySelector('[data-action="edit"]');
  const deleteBtn = document.querySelector('[data-action="delete"]');

  const rows = document.querySelectorAll(".selectable-row");
  if (rows.length > 0) {
    rows.forEach(row => {
      row.addEventListener("click", function() {
        rows.forEach(r => r.classList.remove("table-active"));
        this.classList.add("table-active");
        selectedId = this.dataset.id;
        editBtn.disabled = false;
        deleteBtn.disabled = false;
      });
    });
  }

  editBtn?.addEventListener("click", function() {
    if (!selectedId) return alert("Pilih data terlebih dahulu!");
    const url = this.dataset.url.replace("__ID__", selectedId);
    window.location.href = url;
  });

  deleteBtn?.addEventListener("click", function() {
    if (!selectedId) return alert("Pilih data terlebih dahulu!");
    if (!confirm("Yakin ingin menghapus data ini?")) return;
    const url = this.dataset.url.replace("__ID__", selectedId);
    fetch(url, {
      method: "DELETE",
      headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
    }).then(() => location.reload());
  });

  const transactionInput = document.getElementById("transactionId");
  const memberInput = document.getElementById("memberName");
  const jenisSelect = document.getElementById("jenisSimpanan");
  const startInput = document.getElementById("startDate");
  const endInput = document.getElementById("endDate");

  function applyFilter() {
    const params = new URLSearchParams();
    if (startInput.value) params.append("start", startInput.value);
    if (endInput.value) params.append("end", endInput.value);
    if (transactionInput.value) params.append("kode", transactionInput.value);
    if (memberInput.value) params.append("nama", memberInput.value);
    if (jenisSelect.value) params.append("jenis", jenisSelect.value);
    window.location.href = "{{ url()->current() }}?" + params.toString();
  }

  [transactionInput, memberInput].forEach(el => {
    el?.addEventListener("keypress", e => {
      if (e.key === "Enter") applyFilter();
    });
  });
  jenisSelect?.addEventListener("change", applyFilter);

  const tanggalButton = document.getElementById("tanggalButton");
  const dropdown = document.getElementById("tanggalDropdown");
  tanggalButton?.addEventListener("click", e => {
    e.stopPropagation();
    dropdown.classList.toggle("hidden");
  });
  document.addEventListener("click", e => {
    if (!dropdown.contains(e.target) && !tanggalButton.contains(e.target)) {
      dropdown.classList.add("hidden");
    }
  });

  window.saveDateRange = function() { applyFilter(); };
  window.cancelDateRange = function() {
    document.getElementById("startDate").value = "";
    document.getElementById("endDate").value = "";
    dropdown.classList.add("hidden");
  };

  window.clearFilter = function() {
    window.location.href = "{{ url()->current() }}";
  };

  const params = new URLSearchParams(window.location.search);
const jenis = params.get('jenis');
if (jenis) {
  const jenisSelect = document.getElementById('jenisSimpanan');
  jenisSelect.value = jenis;
}

});
</script>