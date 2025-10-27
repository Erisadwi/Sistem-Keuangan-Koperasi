<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>  
    @vite(['resources/css/laporan.css'])
    @stack('styles')
    @yield('styles')
    @stack('scripts')
    @yield(section:'scripts')
</head>
<body class="bg-gray-50 font-sans">
    <header>
        <x-menu.nav-top/>
    </header>

      {{-- @php
        $user = Auth::guard('anggota')->user();
        @endphp --}}

    <div class="layout">
        <aside class="sidebar">
        <div class="profile-card">
        <div class="profile-left">
          <img src="{{ asset('images/profilAnggota.jpg') }}{{-- {{ $user && $user->foto ? asset('storage/' . $user->foto) : asset('images/profilAnggota.jpg') }} --}}"
          alt="Foto {{-- {{ $user->nama_lengkap ?? 'Pengguna' }} --}}" class="avatar-70">
        </div>
        <div class="profile-right">
          <div class="profile-name">angga{{-- {{ $user->nama_lengkap ?? 'Nama Tidak Ditemukan' }} --}}</div>
          <div class="profile-role">Anggota</div>
        </div>
        <a href="#{{-- {{ route('anggota.profil') }} --}}" class="btn-profil push-right" aria-label="Buka Profil">
          <img src="{{ asset('icons/arrow-profil.png') }}" alt="">
        </a>
      </div>

      <ul class="menu-list">
        <x-menu.section title="Laporan" :open="false">
          <a href="#" class="submenu-row">Simpanan</a>
          <a href="#" class="submenu-row">Pinjaman</a>
          <a href="#" class="submenu-row">Pembayaran</a>
          <a href="#" class="submenu-row">Sisa Hasil Usaha (SHU)</a>
        </x-menu.section>

        <x-menu.section title="Pengajuan Pinjaman" :open="false">
          <a href="#" class="submenu-row">Data Pengajuan</a>
          <a href="#" class="submenu-row">Tambah Pengajuan Baru</a>
        </x-menu.section>
      </ul>
    </aside>
    </div>

    <main class="main">
          <div class="title-1">@yield('title-1', 'Default Title')</div>       
        <div class="container">
                <div class="content-container2">
                  @yield('content')
                </div>
                <div class="title-content">
                    @yield('title-content', 'Default title') 
                    <br />
                    @yield('period', 'Default period')
                </div>
            <div class="title-container">
                <div class="sub-title">
                    @yield('sub-title', 'Default sub title')
                </div>
            </div>
        </div>

    </main>

</body>
</html>
