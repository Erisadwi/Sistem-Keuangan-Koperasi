<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Notifikasi - Anggota</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="page-root">
    <header class="topbar">
      <div class="topbar-inner">
        <div class="breadcrumb"></div>
        <img class="brand" src="rectangle-570.png" alt="brand" />
      </div>
    </header>

    <div class="layout">
      <aside class="sidebar">
        <div class="profile-card">
          <img class="avatar" src="_51-ba-804-ddc-5-b-3-b-1878-f-647-e-83-e-19-bfe-5-10.png" alt="avatar" />
          <div class="profile-info">
            <div class="username">angga</div>
            <div class="role">Anggota</div>
          </div>
          <button class="card-action" title="Kembali">←</button>
        </div>

        <nav class="menu">
          <button class="menu-item">Laporan <span class="chev">›</span></button>
          <button class="menu-item">Pengajuan Pinjaman <span class="chev">›</span></button>
        </nav>
      </aside>

      <main class="content">
        <h1 class="page-title">Notifikasi</h1>

        <section class="panel">
          <div class="panel-header">
            <div class="left-controls">
              <button id="threeDotBtn" class="icon-btn dots" title="Menu lainnya">⋮</button>
            </div>

            <div class="right-controls">
              <div class="search-wrap">
                <input id="searchInput" class="search-input" placeholder="Cari notifikasi..." />
                <button id="searchBtn" class="icon-btn" title="Cari">🔍</button>
              </div>
              <button id="deleteBtn" class="btn-delete" title="Hapus terpilih" style="display:none">🗑 Hapus</button>
            </div>
          </div>

          <div class="panel-body">
            <div class="table header">
              <div class="col check-col"></div>
              <div class="col type-col">Tipe</div>
              <div class="col content-col">Notifikasi</div>
              <div class="col date-col">Tanggal</div>
            </div>

            <div id="rowsContainer" class="rows"></div>

            <div class="panel-footer">
              <div class="left-footer">
                <label>
                  Show
                  <select id="perPage">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="20">20</option>
                  </select>
                </label>
              </div>
              <div class="center-footer">
                <button id="firstPage" class="pg-btn">⏮</button>
                <button id="prevPage" class="pg-btn">◀</button>
                <span>Page <input id="pageInput" class="page-input" value="1" /> of <span id="pageCount">1</span></span>
                <button id="nextPage" class="pg-btn">▶</button>
                <button id="lastPage" class="pg-btn">⏭</button>
              </div>
            </div>
          </div>
        </section>
      </main>
    </div>
  </div>

  <div id="actionMenu" class="action-menu" role="menu" aria-hidden="true">
    <ul>
      <li data-action="mark-read">Mark as read</li>
      <li data-action="mark-unread">Mark as unread</li>
      <li data-action="mark-important">Mark as important</li>
      <li data-action="add-star">Add star</li>
      <li data-action="filter-like">Filter messages like these</li>
      <li data-action="mute">Mute</li>
    </ul>
  </div>

  <div id="sysToast" class="sys-toast" aria-live="polite" role="status" style="display:none"></div>

<script>

const dataSource = [
  { id:1, type:"Pinjaman", title:"Pengajuan Pinjaman Disetujui", desc:"Pengajuan pinjaman sebesar Rp 3.000.000 telah disetujui", date:"Oct 10 2025" },
  { id:2, type:"Simpanan", title:"Setoran Simpanan Sukarela Diterima", desc:"Setoran simpanan sukarela sebesar Rp 500.000", date:"Oct 10 2025" },
  { id:3, type:"Angsuran", title:"Pembayaran Angsuran Berhasil", desc:"Pembayaran angsuran pinjaman periode Oktober 2025", date:"Oct 09 2025" },
  { id:4, type:"Laporan SHU", title:"Pembagian Sisa Hasil Usaha (SHU)", desc:"Laporan SHU tahun 2024 telah diterbitkan", date:"Oct 09 2025" },
  { id:5, type:"Simpanan", title:"Saldo Simpanan Diperbarui", desc:"Saldo simpanan wajib Anda telah diperbarui setelah validasi", date:"Oct 09 2025" },
  { id:6, type:"Pengumuman", title:"Jadwal Tutup Buku Bulanan", desc:"Koperasi akan melakukan tutup buku keuangan pada 08 Oktober", date:"Oct 08 2025" },
  { id:7, type:"Pinjaman", title:"Pinjaman Anda Telah Lunas", desc:"Selamat! Pinjaman sebesar Rp 2.000.000 telah dinyatakan lunas", date:"Oct 08 2025" },
  { id:8, type:"Simpanan", title:"Permintaan Penarikan Diproses", desc:"Permintaan penarikan simpanan sukarela sedang diproses", date:"Oct 08 2025" },
  { id:9, type:"Pinjaman", title:"Pengajuan Pinjaman Ditolak", desc:"Pengajuan pinjaman sebesar Rp 5.000.000 tidak disetujui", date:"Oct 07 2025" },
  { id:10, type:"Pengumuman", title:"Pemeliharaan Sistem", desc:"Sistem koperasi akan mengalami pemeliharaan pada 07 Oktober 2025", date:"Oct 07 2025" }
];

let rows = dataSource.map(r => ({ ...r, checked:false, starred:false }));
let filtered = [...rows];
let currentPage = 1;
let perPage = 10;

const rowsContainer = document.getElementById('rowsContainer');
const deleteBtn = document.getElementById('deleteBtn');
const searchInput = document.getElementById('searchInput');
const sysToast = document.getElementById('sysToast');
const actionMenu = document.getElementById('actionMenu');
const threeDotBtn = document.getElementById('threeDotBtn');

const perPageSelect = document.getElementById('perPage');
const pageCountSpan = document.getElementById('pageCount');
const pageInput = document.getElementById('pageInput');
const prevPage = document.getElementById('prevPage');
const nextPage = document.getElementById('nextPage');
const firstPage = document.getElementById('firstPage');
const lastPage = document.getElementById('lastPage');

function render() {
  perPage = parseInt(perPageSelect.value,10);
  const total = Math.max(1, Math.ceil(filtered.length / perPage));
  if (currentPage > total) currentPage = total;
  pageCountSpan.textContent = total;
  pageInput.value = currentPage;

  const start = (currentPage-1) * perPage;
  const pageRows = filtered.slice(start, start + perPage);

  rowsContainer.innerHTML = '';
  pageRows.forEach(row => {
    const rEl = document.createElement('div');
    rEl.className = 'table-row' + (row.checked ? ' selected' : '');
    rEl.dataset.id = row.id;

    const cCheck = document.createElement('div'); cCheck.className = 'col check-col';
    const chk = document.createElement('input'); chk.type='checkbox'; chk.className='notif-checkbox'; chk.checked = row.checked;
    chk.dataset.id = row.id;
    const starBtn = document.createElement('button'); starBtn.className='star-btn'; starBtn.title='Tambahkan bintang';
    starBtn.innerHTML = row.starred ? '★' : '☆';
    if (row.starred) starBtn.classList.add('starred');
    cCheck.appendChild(chk); cCheck.appendChild(starBtn);

    const cType = document.createElement('div'); cType.className='col type-col'; cType.textContent = row.type;

    const cContent = document.createElement('div'); cContent.className='col content-col';
    const bold = document.createElement('span'); bold.className='content-title'; bold.textContent = row.title;
    const dash = document.createElement('span'); dash.textContent = ' - ';
    const detail = document.createElement('span'); detail.className='content-desc'; detail.textContent = row.desc;
    cContent.appendChild(bold); cContent.appendChild(dash); cContent.appendChild(detail);

    const cDate = document.createElement('div'); cDate.className='col date-col'; cDate.textContent = row.date;

    rEl.appendChild(cCheck); rEl.appendChild(cType); rEl.appendChild(cContent); rEl.appendChild(cDate);

    chk.addEventListener('change', (e) => {
      const id = Number(e.target.dataset.id);
      const item = rows.find(x=>x.id===id);
      item.checked = e.target.checked;
      updateAfterChange();
      render(); 
    });

    starBtn.addEventListener('click', (ev) => {
      const id = Number(row.id);
      const item = rows.find(x=>x.id===id);
      item.starred = !item.starred;
      showToast(item.starred ? 'Ditandai favorit' : 'Dihapus favorit', 'info');
      render();
    });

    rowsContainer.appendChild(rEl);
  });

  updateDeleteVisibility();
}

function applyFilter(q='') {
  q = q.trim().toLowerCase();
  if (!q) filtered = [...rows];
  else filtered = rows.filter(r => (r.type + ' ' + r.title + ' ' + r.desc).toLowerCase().includes(q));
  currentPage = 1;
  render();
}

searchInput.addEventListener('input', (e) => {
  applyFilter(e.target.value);
});

function updateDeleteVisibility() {
  const any = rows.some(r => r.checked);
  deleteBtn.style.display = any ? 'inline-block' : 'none';
}

deleteBtn.addEventListener('click', () => {
  const toDel = rows.filter(r => r.checked);
  if (!toDel.length) return;
  rows = rows.filter(r => !r.checked);
  applyFilter(searchInput.value || '');
  showToast(${toDel.length} notifikasi dihapus, 'success');
});

let toastTimer = null;
function showToast(text='', type='info', ms=2500) {
  sysToast.style.display = 'block';
  sysToast.textContent = text;
  sysToast.className = 'sys-toast ' + (type==='success' ? 'success' : type==='warn' ? 'warn' : 'info');
  if (toastTimer) clearTimeout(toastTimer);
  toastTimer = setTimeout(() => { sysToast.style.display = 'none'; }, ms);
}

threeDotBtn.addEventListener('click', (e) => {
  const rect = threeDotBtn.getBoundingClientRect();
  actionMenu.style.left = (rect.left) + 'px';
  actionMenu.style.top = (rect.bottom + 8) + 'px';
  actionMenu.setAttribute('aria-hidden','false');
  actionMenu.style.display = 'block';
});

document.addEventListener('click', (e) => {
  if (!actionMenu.contains(e.target) && e.target !== threeDotBtn) {
    actionMenu.style.display = 'none';
    actionMenu.setAttribute('aria-hidden','true');
  }
});

actionMenu.addEventListener('click', (e) => {
  const li = e.target.closest('li');
  if (!li) return;
  const act = li.dataset.action;
  actionMenu.style.display = 'none';
  if (act === 'add-star') {
    const visibleIds = filtered.map(r=>r.id);
    rows.forEach(r => { if (visibleIds.includes(r.id)) r.starred = true; });
    showToast('Ditambahkan bintang pada baris terlihat', 'info');
    render();
  } else {
    showToast(Aksi: ${li.textContent}, 'info');
  }
});

perPageSelect.addEventListener('change', () => {
  currentPage = 1;
  applyFilter(searchInput.value || '');
});
pageInput.addEventListener('change', () => {
  const v = parseInt(pageInput.value,10) || 1;
  currentPage = Math.max(1, v);
  render();
});
prevPage.addEventListener('click', () => { currentPage = Math.max(1, currentPage-1); render(); });
nextPage.addEventListener('click', () => { currentPage++; render(); });
firstPage.addEventListener('click', () => { currentPage = 1; render(); });
lastPage.addEventListener('click', () => { currentPage = Math.ceil(filtered.length / perPage); render(); });

function updateAfterChange() {
  const q = searchInput.value || '';
  applyFilter(q);
  updateDeleteVisibility();
}

applyFilter('');
render();
</script>
</body>
</html>