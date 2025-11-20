<style>
  .toolbar-wrapper {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin-bottom: 1rem;
    margin-top: 40px;
  }

  .toolbar-row {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
  }

  .toolbar-left,
  .toolbar-right {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
  }

  .filter-button {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #ffffff;
    color: #000;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    padding: 6px 12px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.2s ease;
  }

  .filter-button:hover {
    background-color: #f3f8ff;
    border-color: #c7d2fe;
  }

  .filter-button svg {
    color: #000;
  }

  .filter-button.danger {
    color: #ef4444;
    border-color: #ef4444;
  }
  .filter-button.danger svg {
    color: #ef4444;
  }
  .filter-button.danger:hover {
    background-color: #fff5f5;
    border-color: #ef4444;
  }

  select.filter-button {
    appearance: none;
    background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%232563eb' viewBox='0 0 20 20'%3E%3Cpath d='M5.25 7.5L10 12.25L14.75 7.5H5.25z'/%3E%3C/svg%3E") no-repeat right 8px center;
    background-size: 14px;
    padding-right: 28px;
    color: #000;
  }

  .search-area {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
    margin-left:300px;
    margin-top:10px;
  }

  .search-area span {
    font-weight: 500;
    color: #000;
  }

  .search-input {
    border: 1px solid #d1d5db;
    border-radius: 8px;
    padding: 5px 8px;
    font-size: 13px;
    width: 130px;
    color: #000;
    background-color: #fff;
  }

  .table-active {
    background-color: #e0f2fe !important;
  }

  /* === POPUP FILTER TANGGAL === */
  .date-filter-popup {
    position: absolute;
    background: #fff;
    border: 1px solid #d1d5db;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    padding: 16px;
    width: 230px;
    top: 50px;
    z-index: 1000;
    display: none;
  }

  .date-filter-popup label {
    font-size: 13px;
    font-weight: 500;
    display: block;
    margin-bottom: 4px;
    color: #000;
  }

  .date-filter-popup input {
    width: 100%;
    padding: 6px 8px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 13px;
    margin-bottom: 10px;
  }

  .date-filter-popup .btn-container {
    display: flex;
    justify-content: space-between;
    gap: 8px;
  }

  .btn-save {
    background-color: #22c55e;
    color: white;
    border: none;
    border-radius: 6px;
    padding: 6px 16px;
    cursor: pointer;
    font-size: 13px;
    font-weight: 500;
  }

  .btn-cancel {
    background-color: #ef4444;
    color: white;
    border: none;
    border-radius: 6px;
    padding: 6px 16px;
    cursor: pointer;
    font-size: 13px;
    font-weight: 500;
  }

  .btn-save:hover {
    background-color: #16a34a;
  }

  .btn-cancel:hover {
    background-color: #dc2626;
  }
</style>

<div class="toolbar-wrapper">

  <div class="toolbar-row">
    <div class="toolbar-left">

      <div>
        <a href="{{ $addUrl ?? '#' }}" class="filter-button">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
            <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
          Tambah
        </a>
      </div>

      <div>
        <button class="filter-button" data-action="edit" data-url="{{ $editUrl ?? '#' }}" disabled>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
            <path d="M12 20h9M16.5 3.5a2.121 2.121 0 0 1 3 3L8 18l-4 1 1-4 11.5-11.5z" 
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          Edit
        </button>
      </div>

      <div>
        <button class="filter-button" data-action="delete" data-url="{{ $deleteUrl ?? '#' }}" disabled>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
            <path d="M6 7h12M9 7V5h6v2M10 11v6M14 11v6M5 7h14l-1 14H6L5 7z" 
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          Hapus
        </button>
      </div>

      <div style="position: relative;">
        <button class="filter-button" id="btnTanggal">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" stroke="currentColor" stroke-width="2"/>
            <line x1="16" y1="2" x2="16" y2="6" stroke="currentColor" stroke-width="2"/>
            <line x1="8" y1="2" x2="8" y2="6" stroke="currentColor" stroke-width="2"/>
            <line x1="3" y1="10" x2="21" y2="10" stroke="currentColor" stroke-width="2"/>
          </svg>
          Tanggal
        </button>

        <div class="date-filter-popup" id="popupTanggal">
          <label>Tanggal Mulai:</label>
          <input type="date" id="tanggalMulai">

          <label>Tanggal Akhir:</label>
          <input type="date" id="tanggalAkhir">

          <div class="btn-container">
            <button class="btn-save" id="btnSimpanTanggal">Simpan</button>
            <button class="btn-cancel" id="btnBatalTanggal">Batal</button>
          </div>
        </div>
      </div>

    </div>

    <div class="toolbar-right">
      <div>
        <select id="statusPinjaman" class="filter-button">
          <option value="" selected disabled>Status Pinjaman</option>
          <option value="Lunas">Lunas</option>
          <option value="Belum Lunas">Belum Lunas</option>
      </select>
      </div>

      <div>
        <select class="filter-button" id="filterSort">
          <option selected>Urutkan Berdasarkan</option>
          <option value="baru">Tanggal (Baru → Lama)</option>
          <option value="lama">Tanggal (Lama → Baru)</option>
          <option value="nama_asc">Nama (A → Z)</option>
          <option value="nama_desc">Nama (Z → A)</option>

        </select>
      </div>

      <div>
        <a href="{{ $exportUrl ?? '#' }}" class="filter-button" id="btnExport">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
            <path d="M12 16v-4m0 0l-4 4m4-4l4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            <path d="M4 4h16v12H4V4z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
          Unduh
        </a>
      </div>
    </div>
  </div>

  <div class="toolbar-row">
    <div class="search-area">
      <span>Cari :</span>
      <input type="text" id="transactionId" placeholder="Kode Transaksi" class="search-input">
      <input type="text" id="memberName" placeholder="Nama Anggota" class="search-input">
      <button class="filter-button" id="btnSearch">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
          <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2"/>
          <path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
      </button>

      <button class="filter-button danger" onclick="clearFilter()">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
          <path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
        Hapus Filter
      </button>
    </div>
  </div>
</div>