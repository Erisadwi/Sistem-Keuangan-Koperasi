<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Beranda Anggota</title>
  @vite(['resources/css/styleBeranda.css'])
</head>
<body class="bg-gray-50 font-sans">


  <nav class="nav-top">
    <div class="nav-left"> </div>
    <div class="nav-right">
      <div class="divider-16"></div>
        <img src="{{ asset('images/logo.png') }}" alt="Koperasi TSM" class="logo-coop">
    </div>
  </nav>

  @php
  $user = Auth::guard('anggota')->user();
  @endphp

  <div class="layout">
    <aside class="sidebar">
      <div class="profile-card">
      <div class="profile-left">
      <img 
        src="{{ $user && $user->foto 
            ? asset('' . $user->foto) 
            : asset('images/default.jpeg') }}" 
        alt="Foto {{ $user->nama_anggota ?? 'Pengguna' }}" 
        class="avatar-70">
        </div>
        <div class="profile-right">
          <div class="profile-name">{{ $user->nama_anggota ?? 'Nama Tidak Ditemukan' }}</div>
          <div class="profile-role">Anggota</div>
        </div>
        <a href="{{ route('anggota.profil') }}" class="btn-profil push-right" aria-label="Buka Profil">
          <img src="{{ asset('icons/arrow-profil.png') }}" alt="">
        </a>
      </div>

      <ul class="menu-list">
        <x-menu.section title="Laporan" :open="false" :has-sub="true">
          <a href="#" class="submenu-row">Simpanan</a>
          <a href="#" class="submenu-row">Pinjaman</a>
          <a href="#" class="submenu-row">Pembayaran</a>
          <a href="#" class="submenu-row">Sisa Hasil Usaha (SHU)</a>
        </x-menu.section>

        <x-menu.section title="Pengajuan Pinjaman" :open="false" :has-sub="true">
          <a href="{{ route('anggota.pengajuan.index') }}" class="submenu-row">Data Pengajuan</a>
          <a href="{{ route('anggota.pengajuan.create') }}" class="submenu-row">Tambah Pengajuan Baru</a>
        </x-menu.section>
      </ul>
    </aside>

    <main class="main">
      <div class="page-title">
        <span class="title">Beranda</span>
        <span class="sep">Menu Utama</span>
      </div>

      <h2 class="greeting">
        {{ $salam }} {{ $namaDepan }}
        <span class="wave">👋</span>
      </h2>

      
      <section class="cards">
        <a href="# {{-- {{ route('nama_route_tujuan') }} --}}" class="card pastel-orange">
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
        </a>

        <a href="# {{-- {{ route('nama_route_tujuan') }} --}}" class="card pastel-yellow">
          <div class="card-icon">
            <img src="{{ asset('icons/icon-pinjaman.png') }}" alt="Pinjaman" class="icon-28">
          </div>
          <div class="card-text">
            <div class="card-amount">
              {{-- Rp{{ number_format($pinjaman, 0, ',', '.') }}  --}}
              Rp1.500.000</div>
            <div class="card-label">Pinjamanmu</div>
          </div>
        </a>

        <a href="# {{-- {{ route('nama_route_tujuan') }} --}}" class="card pastel-pink">
          <div class="card-icon">
            <img src="{{ asset('icons/icon-transaksi.png') }}" alt="Transaksi" class="icon-28">
          </div>
          <div class="card-text">
            <div class="card-amount">
              {{-- {{ $totalTransaksi }} --}}
              3</div>
            <div class="card-label">Transaksimu</div>
          </div>
        </a>

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
              <img src="{{ asset('icons/statistic.png') }}" alt="" class="icon-70">
              <button id="refreshPage" class="refresh-vert img-btn" type="button">
                <img src="{{ asset('icons/refresh.png') }}" alt="">
              </button>
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

<script>
  document.addEventListener('DOMContentLoaded', () => {
  const btn = document.getElementById('btnNotif');
  if (!btn) return;

  const badge = document.getElementById('notifBadge');
  const url = btn.dataset.targetUrl; 

  btn.addEventListener('click', () => {
    if (badge) badge.hidden = true;
    if (url) window.location.href = url;
  });
});

document.getElementById('refreshPage')?.addEventListener('click', () => {
  const btn = document.getElementById('refreshPage');
  btn.disabled = true; 
  // btn.textContent = 'Memuat…';
  location.reload(); 
});
</script>
