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

  <form action="{{ $cari ?? '#' }}" method="GET" class="df-search-form" id="searchForm">
    <input 
      type="text" 
      name="search" 
      class="df-input" 
      id="searchInput"
      placeholder="Cari..." 
      value="{{ request('search') }}">

    <button type="button" class="df-btn" onclick="clearFilter()" style="width:auto; padding:6px 12px;">
      <span class="df-ic">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
          <path d="M6 6l12 12M18 6L6 18" stroke="#0ea5e9" stroke-width="2" stroke-linecap="round"/>
        </svg>
      </span>
      Hapus Filter
    </button>
  </form>
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
  justify-content: center; 
  gap: 6px;
  box-shadow: 0 2px 4px rgba(107, 105, 105, 0.647);
  transition: 0.2s;
  width: auto; /* Supaya panjang tombol otomatis mengikuti teks */
  min-width: 85px; /* Biar tetap seragam jika teks pendek */
}

.df-btn:hover {
  background: #f0f9ff;
  border-color: #0ea5e9;
}

.df-btn:active {
  transform: scale(0.97);
  box-shadow: 0 1px 2px rgba(0,0,0,0.2);
}

.df-btn .df-ic svg {
  display: block;
}

.df-search-form {
  display: flex;
  align-items: center;
  gap: 8px;
}

.df-input {
  padding: 6px 10px;
  border: 1px solid #d1d5db;
  border-radius: 8px;
  font-size: 12px;
  box-shadow: 0 2px 4px rgba(107, 105, 105, 0.647);
  width: 150px;
}

.df-input:focus {
  outline: none;
  border-color: #0ea5e9;
  box-shadow: 0px 4px 8px rgba(14, 165, 233, 0.35);
}
</style>

<script>
function clearFilter() {
  document.getElementById('searchInput').value = '';
  document.getElementById('searchForm').submit();
}
</script>
