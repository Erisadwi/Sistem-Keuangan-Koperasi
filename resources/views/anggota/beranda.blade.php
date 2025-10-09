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
      </div>

      <h2 class="greeting">
        {{-- {{ $salam }} {{ $namaDepan }} --}}
        Selamat Siang Angga <span class="wave">👋</span>
      </h2>

      
      <section class="cards">
        <div class="card pastel-orange">
          <div class="card-icon">
            <img src="{{ asset('icons/icon-simpanan.png') }}" alt="Simpanan" class="icon-28">
          </div>
          <div class="card-text">
            <div class="card-amount">
              {{-- Rp{{ number_format($simpanan, 0, ',', '.') }}  --}}
              Rp2.500.000
            </div>
            <div class="card-label">Simpananmu</div>
          </div>
        </div>

        <div class="card pastel-yellow">
          <div class="card-icon">
            <img src="{{ asset('icons/icon-pinjaman.png') }}" alt="Pinjaman" class="icon-28">
          </div>
          <div class="card-text">
            <div class="card-amount">
              {{-- Rp{{ number_format($pinjaman, 0, ',', '.') }}  --}}
              Rp1.500.000</div>
            <div class="card-label">Pinjamanmu</div>
          </div>
        </div>

        <div class="card pastel-pink">
          <div class="card-icon">
            <img src="{{ asset('icons/icon-transaksi.png') }}" alt="Transaksi" class="icon-28">
          </div>
          <div class="card-text">
            <div class="card-amount">
              {{-- {{ $totalTransaksi }} --}}
              3</div>
            <div class="card-label">Transaksimu</div>
          </div>
        </div>

        <a href="#" class="card pastel-green linklike">
          <div class="card-icon">
            <img src="{{ asset('icons/icon-tagihan.png') }}" alt="Tagihan" class="icon-28">
          </div>
          <div class="card-text">
            <div class="card-amount">
              {{-- {{ $totalTagihan }} --}}
              1</div>
            <div class="card-label">Tagihanmu</div>
          </div>
        </a>
      </section>


      <section class="stat-panel">
        <div class="stat-left">
          <div class="mini-card">
            <div class="mini-card-header">
              <img src="{{ asset('icons/statistic.png') }}" alt="" class="icon-100">
              <button id="refreshPage" type="button" class="refresh-vert bold" title="Refresh">Refresh</button>
            </div>
            <div class="mini-amount">
              <div class="rp">Rp</div>
              <div class="money">
                {{-- {{ number_format($totalDana, 2, ',', '.') }} --}}
                4.000.000,00</div>
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
