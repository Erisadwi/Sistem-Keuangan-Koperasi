<div class="btn-group-container">
  <a href="{{ $addUrl ?? '#' }}" class="df-btn df-tambah">
    <span class="df-ic" aria-hidden="true">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
        <path d="M12 5v14m-7-7h14" stroke="#0ea5e9" stroke-width="2" stroke-linecap="round"/>
      </svg>
    </span>
    Tambah
  </a>

  <a href="{{ $unduh ?? '#' }}" class="df-btn df-unduh">
    <span class="df-ic" aria-hidden="true">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
        <path d="M12 16v-8m0 8l4-4m-4 4l-4-4" stroke="#0ea5e9" stroke-width="2" stroke-linecap="round"/>
        <path d="M4 20h16" stroke="#0ea5e9" stroke-width="2" stroke-linecap="round"/>
      </svg>
    </span>
    Unduh
  </a>

  <a href="{{ $cari ?? '#' }}" class="df-btn df-cari">
    <span class="df-ic" aria-hidden="true">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
        <circle cx="11" cy="11" r="7" stroke="#0ea5e9" stroke-width="2"/>
        <line x1="16.5" y1="16.5" x2="21" y2="21" stroke="#0ea5e9" stroke-width="2" stroke-linecap="round"/>
      </svg>
    </span>
    Cari
  </a>
</div>

<style>
.btn-group-container {
  display: flex;
  align-items: center;
  justify-content: flex-start;
  gap: 10px;
  margin-top: 65px;
  margin-left: 22px;
}

.df-btn {
  appearance: none;
  border: 1px solid #d1d5db;
  background: #ffffff;
  padding: 6px 12px;
  border-radius: 8px;
  cursor: pointer;
  font-size: 12px;
  line-height: 1.2;
  text-decoration: none;
  color: #111827;
  display: inline-flex;
  align-items: center;
  justify-content: center; /* isi tombol dirata tengah */
  gap: 6px;
  box-shadow: 0 2px 4px rgba(107, 105, 105, 0.647);
  transition: 0.2s;
  width: 85px; /* ✅ lebar tombol seragam */
}

.df-btn:hover {
  background: #f0f9ff;
  border-color: #0ea5e9;
}

.df-btn .df-ic svg {
  display: block;
  vertical-align: middle;
}

/* Tombol Cari tetap bisa disesuaikan sedikit */
.df-cari {
  justify-content: flex-start; /* isi agak ke kiri */
  padding-left: 10px;
}

.df-tambah svg path,
.df-unduh svg path,
.df-cari svg path,
.df-cari svg circle,
.df-cari svg line {
  stroke: #0ea5e9;
}
</style>
