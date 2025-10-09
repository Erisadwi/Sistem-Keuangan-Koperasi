<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Beranda Anggota</title>
  @vite(['resources/css/styleBeranda.css', 'resources/js/beranda.js'])
</head>
<body class="bg-gray-50 font-sans">


  <nav class="nav-top">
    <div class="nav-left"> </div>
    <div class="nav-right">
      <button id="btnNotif" class="btn-icon" type="button" aria-label="Buka notifikasi">
        <img src="{{ asset('icons/bell-notification.png') }}" alt="" class="icon-50">
        <span id="notifBadge" class="badge">3</span>
      </button>
      <div class="divider-16"></div>
        <img src="{{ asset('images/logo.png') }}" alt="Koperasi TSM" class="logo-coop">
    </div>
  </nav>

  <div class="layout">

    <aside class="sidebar">
      <div class="profile-card">
        <div class="profile-left">
          <img src="{{ asset('images/profilAnggota.jpg') }}" alt="Profil" class="avatar-90">
        </div>
        <div class="profile-right">
          <div class="profile-name">angga</div>
          <div class="profile-role">Anggota</div>
        </div>
        <a href="#" class="btn-profil push-right" aria-label="Buka Profil">
          <img src="{{ asset('icons/arrow-profil.png') }}" alt="">
        </a>
      </div>

      <ul class="menu-list">
        <li class="menu-section">
      <button class="menu-head" data-toggle="collapse" data-target="#dd-laporan" aria-expanded="true">
        <span>Laporan</span>
        <svg class="chev-svg" viewBox="0 0 20 20" fill="currentColor"><path d="M5.5 7.5l4.5 4 4.5-4" /></svg>
      </button>
      <div id="dd-laporan" class="submenu open">
        <a href="#" class="submenu-row">Simpanan</a>
        <a href="#" class="submenu-row">Pinjaman</a>
        <a href="#" class="submenu-row">Pembayaran</a>
        <a href="#" class="submenu-row">Sisa Hasil Usaha (SHU)</a>
      </div>
    </li>


    <li class="menu-section">
      <button class="menu-head" data-toggle="collapse" data-target="#dd-pengajuan" aria-expanded="true">
        <span>Pengajuan Pinjaman</span>
        <svg class="chev-svg" viewBox="0 0 20 20" fill="currentColor"><path d="M5.5 7.5l4.5 4 4.5-4" /></svg>
      </button>
      <div id="dd-pengajuan" class="submenu open">
        <a href="#" class="submenu-row">Data Pengajuan</a>
        <a href="#" class="submenu-row">Tambah Pengajuan Baru</a>
      </div>
    </li>
      </ul>
    </aside>


    <main class="main">
      <div class="page-title">
        <span class="title">Beranda</span>
        <span class="sep">Menu Utama</span>
        <span class="notif-pill">
          <img src="{{ asset('icons/bell.svg') }}" alt="Notif" class="icon-18">
        </span>
      </div>

      <h2 class="greeting">Selamat Siang Angga <span class="wave">👋</span></h2>


      <section class="cards">
        <div class="card pastel-orange">
          <div class="card-icon">
            <img src="{{ asset('icons/saving.svg') }}" alt="Simpanan" class="icon-28">
          </div>
          <div class="card-text">
            <div class="card-amount">Rp2.500.000</div>
            <div class="card-label">Simpananmu</div>
          </div>
        </div>

        <div class="card pastel-yellow">
          <div class="card-icon">
            <img src="{{ asset('icons/loan.svg') }}" alt="Pinjaman" class="icon-28">
          </div>
          <div class="card-text">
            <div class="card-amount">Rp1.500.000</div>
            <div class="card-label">Pinjamanmu</div>
          </div>
        </div>

        <div class="card pastel-pink">
          <div class="card-icon">
            <img src="{{ asset('icons/tx.svg') }}" alt="Transaksi" class="icon-28">
          </div>
          <div class="card-text">
            <div class="card-amount">3</div>
            <div class="card-label">Transaksimu</div>
          </div>
        </div>

        <a href="#" class="card pastel-green linklike">
          <div class="card-icon">
            <img src="{{ asset('icons/bill.svg') }}" alt="Tagihan" class="icon-28">
          </div>
          <div class="card-text">
            <div class="card-amount">1</div>
            <div class="card-label">Tagihanmu</div>
          </div>
        </a>
      </section>


      <section class="stat-panel">
        <div class="stat-left">
          <div class="mini-card">
            <div class="mini-card-header">
              <span class="mini-icon">↗</span>
              <button type="button" class="refresh-vert" title="Refresh">Refresh</button>
            </div>
            <div class="mini-amount">
              <div class="rp">Rp</div>
              <div class="money">4.000.000,00</div>
            </div>
            <div class="mini-caption">Total Dana</div>
          </div>
        </div>

        <div class="stat-right">
          <div class="stat-title">Statistik Dana</div>
          <div class="stat-sub">Jumlah dana mu</div>

          <div class="stat-content">
            <div class="legend">
              <div class="legend-row">
                <span class="dot dot-simpan"></span>
                <span class="legend-text">Dana Simpanan</span>
                <span class="legend-val">62%</span>
              </div>
              <div class="legend-row">
                <span class="dot dot-pinj"></span>
                <span class="legend-text">Dana Pinjaman</span>
                <span class="legend-val">38%</span>
              </div>
            </div>

            <div class="pie">
              <div class="pie-graphic"></div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>
</body>
</html>
