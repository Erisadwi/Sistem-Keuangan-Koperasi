<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Profile - Anggota</title>
  @vite(['resources/css/style-profilAnggota.css'])
</head>
<body class="bg-gray-50 font-sans">

  {{-- 🔹 HEADER ATAS --}}
  <nav class="nav-top">
    <div class="nav-left"></div>
    <div class="nav-right">
      <img src="{{ asset('images/logo.png') }}" alt="Koperasi TSM" class="logo-coop">
    </div>
  </nav>

  {{-- 🔹 KONTEN UTAMA --}}
  <div class="layout">
            <aside class="sidebar">
        <div class="profile-card">
        <div class="profile-left">
          <img src="{{ asset('images/profil-admin.jpg') }}"
          alt="Foto {{-- {{ $user->nama_lengkap ?? 'Pengguna' }} --}}" class="avatar-70">
        </div>
        <div class="profile-right">
          <div class="profile-name">Iqbal{{-- {{ $user->nama_lengkap ?? 'Nama Tidak Ditemukan' }} --}}</div>
          <div class="profile-role">Admin Simpanan{{-- {{ $user->role ?? '' }} --}}</div>
        </div>
        <a href="#{{-- {{ route('admin.profil') }} --}}" class="btn-profil push-right" aria-label="Buka Profil">
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

    <main class="content">
      <h2 class="page-title">My Profile <span class="subtitle">Anggota</span></h2>

      <div class="profile-wrapper">
        <section class="card-profile">
          <img src="{{ asset('images/profil-admin.jpg') }}" alt="Foto Admin" class="profile-photo">
          <h3 class="profile-nama">Iqbaal Diafakhri Ramadhan</h3>
          <p class="profile-status aktif">Aktif</p>

          <div class="action-group">
            <button class="btn btn-danger">Non Aktifkan Akun</button>
            <button class="btn btn-light">Logout</button>
          </div>
        </section>

        {{-- Form Profil Kanan --}}
        <section class="card-form"> 
          <form>
         <form class="form" method="post" action="#" {{-- {{ route('profile.update', $anggota->id_anggota) }} --}} enctype="multipart/form-data">
          @csrf
          @method('PUT')

  <div class="form-group">
    <label>Username</label>
    <input type="text" name="username_anggota" value="angga" {{-- {{ $anggota->username_anggota }} --}}>
  </div>

  <div class="form-group">
    <label>Password</label>
    <input type="password" name="password" placeholder="Masukkan password">
  </div>

  <div class="form-group">
    <label>Nama Lengkap</label>
    <input type="text" name="nama_lengkap"value="angga aldi yunanda" {{-- {{ $anggota->nama_lengkap}} --}}>
  </div>

  <div class="form-group">
    <label>Alamat</label>
    <textarea name="alamat_anggota" rows="3">Perum Griya Sejahtera, Blok J No. 20 jl. Medayu Utara 30A, Medokan Ayu, Rungkut Surabaya {{-- {{ $anggota->alamat_anggota }} --}}</textarea>
  </div>
  
<div class="form-group">
            <label>Role</label>
            <select name="id_role">
              <option value="" disabled selected>pilih role</option>
              <option value="admin simpanan">admin simpanan</option>
              <option value="admin pinjaman">admin pinjaman</option>
              <option value="admin accounting">admin accounting</option>
              <option value="pengurus">pengurus</option>
            </select>
          </div>

            <button type="submit" class="btn btn-primary">Edit Profil</button>
          </form>
        </section>
      </div>
    </main>
  </div>

  <script>
    // dropdown sidebar
    function toggleSubmenu(button) {
      const submenu = button.nextElementSibling;
      submenu.classList.toggle("active");
      button.querySelector(".chev").classList.toggle("rotate");
    }
  </script>
</body>
</html>
