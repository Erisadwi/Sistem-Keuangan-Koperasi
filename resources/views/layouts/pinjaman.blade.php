<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app3.css'])

</head>
<body class="bg-gray-50 font-sans">
    <header>
        <x-menu.nav-top/>
    </header>

  @php
    $user = Auth::user(); 
  @endphp

    <div class="layout">
        <aside class="sidebar">
        <div class="profile-card">
        <div class="profile-left">
           @php
          $fotoPath = $user && $user->foto_user
          ? asset('storage/foto_user/' . $user->foto_user)
          : asset('images/default.jpeg');
          @endphp
          <img src="{{ $fotoPath }}" alt="Foto {{ $user->nama_lengkap ?? '' }}" class="avatar-70">
        </div>
        <div class="profile-right">
          <div class="profile-name">{{ $user->nama_lengkap ?? 'Nama Tidak Ditemukan' }}</div>
          <div class="profile-role">{{ $user->role->nama_role ?? 'Role Tidak Ditemukan' }}</div>
        </div>
        <a href="#{{-- {{ route('anggota.profil') }} --}}" class="btn-profil push-right" aria-label="Buka Profil">
          <img src="{{ asset('icons/arrow-profil.png') }}" alt="">
        </a>
      </div>

      <ul class="menu-list">
        
        <x-menu.section title="Pinjaman" :open="false" :has-sub="true">
          <a href="#" class="submenu-row">Data Pengajuan</a>
          <a href="#" class="submenu-row">Data Pinjaman</a>
          <a href="#" class="submenu-row">Angsuran</a>
          <a href="#" class="submenu-row">Pinjaman Lunas</a>
        </x-menu.section>

        <x-menu.section title="Laporan" :open="false" :has-sub="true">
          <a href="#" class="submenu-row">Jatuh Tempo</a>
          <a href="#" class="submenu-row">Buku Besar</a>
          <a href="#" class="submenu-row">Neraca Saldo</a>
          <a href="#" class="submenu-row">Neraca</a>
          <a href="#" class="submenu-row">Kas Pinjaman</a>
          <a href="#" class="submenu-row">Kas Simpanan</a>
          <a href="#" class="submenu-row">Saldo Kas</a>
          <a href="#" class="submenu-row">Laba Rugi</a>
          <a href="#" class="submenu-row">Sisa Hasil Usaha (SHU)</a>
        </x-menu.section>
        
      </ul>
    </aside>
    </div>



<div class="container">
  @yield('content')
</div>

</body>
</html>