<div class="btn-group-container">
    @if(isset($tambah))
    <a href="{{ $tambah }}" class="df-btn df-tambah">
        <span class="df-ic" aria-hidden="true">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                <path d="M12 5v14m-7-7h14" stroke="#0ea5e9" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </span>
        Tambah
    </a>
    @endif

    @if(isset($edit))
    <a href="{{ $edit }}" class="df-btn df-edit">
        <span class="df-ic" aria-hidden="true">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                <path d="M15.232 5.232l3.536 3.536M4 20h4l10.293-10.293a1 1 0 000-1.414l-2.586-2.586a1 1 0 00-1.414 0L4 16v4z" stroke="#0ea5e9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </span>
        Edit
    </a>
    @endif

    @if(isset($hapus))
    <form action="{{ $hapus }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus data ini?')" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="df-btn df-hapus">
            <span class="df-ic" aria-hidden="true">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                    <path d="M6 7h12M10 11v6m4-6v6M5 7l1 12a2 2 0 002 2h8a2 2 0 002-2l1-12M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
            Hapus
        </button>
    </form>
    @endif
</div>


<style>
.btn-group-container {
  display: flex;
  align-items: center;
  justify-content: flex-start; /* rata kiri */
  gap: 10px; 
  margin-top: 65px;
  margin-left: 22px;
}

.df-btn {
  appearance: none;
  border: 1px solid #d1d5db;
  background: #ffffff;
  padding: 5px 12px;
  border-radius: 8px;
  cursor: pointer;
  font-size: 12px;
  line-height: 1.2;
  text-decoration: none;
  color: #111827;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  box-shadow: 0 2px 4px rgba(107, 105, 105, 0.647);
}

.df-btn:hover {
  background: #f0f9ff;
  border-color: #0ea5e9;
}

.df-btn .df-ic svg {
  display: block;
  width: 14px;
  height: 14px;
  vertical-align: middle;
}

.df-tambah svg path,
.df-edit svg path {
  stroke: #0ea5e9;
}

.df-hapus svg path {
  stroke: #ef4444; 
}
</style>
