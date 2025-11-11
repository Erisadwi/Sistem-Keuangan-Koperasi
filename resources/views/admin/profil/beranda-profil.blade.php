<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Profile - Anggota</title>
  @vite(['resources/css/style-profilAnggota.css'])
</head>
<body class="bg-gray-50 font-sans">

    <header>
        <x-menu.nav-top/>
    </header>

  @php
  $user = Auth::guard('user')->user();
  @endphp

  <div class="layout">
            <aside class="sidebar">
        <div class="profile-card">
        <div class="profile-left">
        <img src="{{ $user->foto_user ? asset($user->foto_user) : asset('images/default.jpeg') }}" alt="Foto Admin" class="avatar-70">
        </div>
        <div class="profile-right">
          <div class="profile-name">{{ $user->nama_lengkap ?? 'Nama Tidak Ditemukan' }}</div>
          <div class="profile-role">{{ $user->role->nama_role ?? 'Role Tidak Ditemukan' }}</div>
        </div>
        <a href="{{ route('admin.profil.beranda-profil') }}" class="btn-profil push-right" aria-label="Buka Profil">
          <img src="{{ asset('icons/arrow-profil.png') }}" alt="">
        </a>
      </div>

      <ul class="menu-list">
      @if($user && in_array($user->id_role, ['R06', 'R07']))
        <x-menu.section title="Transaksi Kas" :open="false" :has-sub="true">
          <a href="{{ route('transaksi-pemasukan.index') }}" class="submenu-row">Pemasukan</a>
          <a href="{{ route('pengeluaran.index') }}" class="submenu-row">Pengeluaran</a>
          <a href="#" class="submenu-row">Transfer</a>
        </x-menu.section>
      @endif

      @if($user && in_array($user->id_role, ['R06', 'R07']))
        <x-menu.section         title="Transaksi Non Kas" 
        :open="false" 
        :has-sub="false" 
        :link="route('transaksi-non-kas.index')">
        </x-menu.section>
      @endif

      @if($user && in_array($user->id_role, ['R04', 'R07']))
        <x-menu.section title="Simpanan" :open="false" :has-sub="true">
          <a href="{{ route('setoran-tunai.index') }}" class="submenu-row">Setoran Tunai</a>
          <a href="#" class="submenu-row">Penarikan Tunai</a>
        </x-menu.section>
      @endif

      @if($user && in_array($user->id_role, ['R05', 'R07']))
        <x-menu.section title="Pinjaman" :open="false" :has-sub="true">
          <a href="{{ route('pengajuan-pinjaman.index') }}" class="submenu-row">Data Pengajuan</a>
          <a href="{{ route('pinjaman.index') }}" class="submenu-row">Data Pinjaman</a>
          <a href="{{ route('angsuran.index') }}" class="submenu-row">Angsuran</a>
          <a href="{{ route('pinjaman-lunas.index') }}" class="submenu-row">Pinjaman Lunas</a>
        </x-menu.section>
      @endif

      @if($user && in_array($user->id_role, ['R04', 'R05', 'R06', 'R07']))
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
      @endif

      @if($user && in_array($user->id_role, ['R07']))
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
      @endif

        @if($user && in_array($user->id_role, ['R07']))
        <x-menu.section title="Setting" :open="false" :has-sub="true">
          <a href="{{ route('identitas-koperasi.editSingle') }}" class="submenu-row">Identitas Koperasi</a>
          <a href="{{ route('suku-bunga.editSingle') }}" class="submenu-row">Suku Bunga</a>
        </x-menu.section>
        @endif

      </ul>
    </aside>

    <main class="content">
      <h2 class="page-title">My Profile <span class="subtitle">Admin</span></h2>

      <div class="profile-wrapper">
        <section class="card-profile">
          <img src="{{ $user->foto_user ? asset($user->foto_user) : asset('images/default.jpeg') }}" alt="Foto Admin" class="profile-photo">
          <h3 class="profile-nama">{{ $user->nama_lengkap ?? 'Nama Tidak Ditemukan' }}</h3>
          <p class="profile-status aktif">{{ $user->status ?? '' }}</p>

          <div class="action-group">
            <form action="{{ route('nonaktifkan') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-danger"
                    onclick="return confirm('Yakin ingin menonaktifkan akun Anda?')">
                    Non Aktifkan Akun
                </button>
            </form>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-light">Logout</button>
            </form>
          </div>
        </section>

        <section class="card-form"> 
  <div class="form-group">
    <label>Username</label>
    <input type="text" name="username" value="{{ $user->username }}" readonly>
  </div>

  <div class="form-group">
    <label>Password</label>
    <input type="password" name="password" value="********" readonly>
  </div>

  <div class="form-group">
    <label>Nama Lengkap</label>
    <input type="text" name="nama_lengkap"value="{{ $user->nama_lengkap}}" readonly>
  </div>

  <div class="form-group">
    <label>Alamat</label>
    <textarea name="alamat_user" rows="3">{{ $user->alamat_user }}</textarea>
  </div>
  
<div class="form-group">
            <label>Role</label>
            <input type="text" name="role" value="{{ $user->role->nama_role ?? '-' }}" readonly>
          </div>
          <a href="{{ route('profil.edit') }}" class="btn btn-primary">Edit Profil</a>
        </section>
      </div>
    </main>
  </div>

  <script>
    function toggleSubmenu(button) {
      const submenu = button.nextElementSibling;
      submenu.classList.toggle("active");
      button.querySelector(".chev").classList.toggle("rotate");
    }
  </script>
</body>
</html>
