<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tambah Pengajuan</title>
  @vite(['resources/css/style-tambahPengajuan.css'])
</head>

<body class="bg-gray-50 font-sans">
    <header>
        <x-menu.nav-top/>
    </header>

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
          <a href="{{ route('anggota.laporan.simpanan') }}" class="submenu-row">Simpanan</a>
          <a href="{{ route('anggota.laporan.pinjaman') }}" class="submenu-row">Pinjaman</a>
          <a href="{{ route('anggota.laporan.pembayaran') }}" class="submenu-row">Pembayaran</a>
          <a href="{{ route('anggota.laporan.SHU') }}" class="submenu-row">Sisa Hasil Usaha (SHU)</a>
        </x-menu.section>

        <x-menu.section title="Pengajuan Pinjaman" :open="false" :has-sub="true">
          <a href="{{ route('anggota.pengajuan.index') }}" class="submenu-row">Data Pengajuan</a>
          <a href="{{ route('anggota.pengajuan.create') }}" class="submenu-row">Tambah Pengajuan Baru</a>
        </x-menu.section>
      </ul>
    </aside>
    </div>

    <main class="main">
  <div class="title-1">@yield('title-1', 'Tambah Pengajuan')</div>
  <div class="container">
    <div class="content-container">
        @yield('content')
    </div>
    <div class="title-container">
      <div class="sub-title">
        @yield('sub-title', 'Tambah Pengajuan')
      </div>
    </div>
  </div>

@stack('scripts')
</body>
</html>