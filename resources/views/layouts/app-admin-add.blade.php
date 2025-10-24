<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
    @vite(['resources/css/app-add.css'])
    @stack('styles')
    @yield('styles')
    @stack('scripts')
    @yield(section: 'scripts')
</head>

<body class="bg-gray-50 font-sans">
    <header>
        <x-menu.nav-top />
    </header>

    {{-- @php
        $user = Auth::guard('user')->user();
        @endphp --}}

    <div class="layout">
        <aside class="sidebar">
            <div class="profile-card">
                <div class="profile-left">
                    <img src="{{ asset('images/profil-admin.jpg') }}" alt="Foto {{-- {{ $user->nama_lengkap ?? 'Pengguna' }} --}}" class="avatar-70">
                </div>
                <div class="profile-right">
                    <div class="profile-name">Iqbal{{-- {{ $user->nama_lengkap ?? 'Nama Tidak Ditemukan' }} --}}</div>
                    <div class="profile-role">Admin Simpanan {{-- {{ $user->role ?? '' }} --}}</div>
                </div>
                <a href="#{{-- {{ route('anggota.profil') }} --}}" class="btn-profil push-right" aria-label="Buka Profil">
                    <img src="{{ asset('icons/arrow-profil.png') }}" alt="">
                </a>
            </div>

            <ul class="menu-list">
                <x-menu.section title="Transaksi Kas" :open="false" :has-sub="true">
                    <a href="#" class="submenu-row">Pemasukan</a>
                    <a href="#" class="submenu-row">Pengeluaran</a>
                    <a href="#" class="submenu-row">Transfer</a>
                </x-menu.section>

                <x-menu.section title="Transaksi Non Kas" :open="false" :has-sub="false">
                </x-menu.section>

                <x-menu.section title="Simpanan" :open="false" :has-sub="true">
                    <a href="#" class="submenu-row">Setoran Tunai</a>
                    <a href="#" class="submenu-row">Penarikan Tunai</a>
                </x-menu.section>

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

                <x-menu.section title="Master Data" :open="false" :has-sub="true">
                    <a href="#" class="submenu-row">Saldo Awal Kas</a>
                    <a href="#" class="submenu-row">Saldo Awal Non Kas</a>
                    <a href="#" class="submenu-row">Jenis Simpanan</a>
                    <a href="#" class="submenu-row">Jenis Akun Transaksi</a>
                    <a href="#" class="submenu-row">Lama Angsuran</a>
                    <a href="#" class="submenu-row">Data Barang</a>
                    <a href="#" class="submenu-row">Data Anggota</a>
                    <a href="#" class="submenu-row">Data Pengguna</a>
                </x-menu.section>

                <x-menu.section title="Setting" :open="false" :has-sub="true">
                    <a href="#" class="submenu-row">Identitas Koperasi</a>
                    <a href="#" class="submenu-row">Suku Bunga</a>
                </x-menu.section>
            </ul>
        </aside>
    </div>

    <main class="main">
        <div class="header-wrapper">
            <div class="back-title">
            <a href="@yield('back-url', '#')" class="text-blue-500">
                @yield('back-title', 'Default >')
            </a>
            </div>
            <div class="title-1">@yield('title-1', 'Default Title')</div>
            <a href="# {{-- {{ url('') }} --}}">
                <img src="{{ asset('icons/home.png') }}" alt="Home Icon" class="home-image" />
            </a>
        </div>
        <div class="container">
            <div class="content-container">
                <div class="content-container2">
                        @yield('content')
                </div>
            </div>
            <div class="title-container">
                <div class="title-container2"></div>
                <div class="sub-title">
                    @yield('sub-title', 'Default sub title')
                </div>
            </div>
        </div>
    </main>



</body>

</html>
