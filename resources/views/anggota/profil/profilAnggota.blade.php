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
    {{-- 🔸 SIDEBAR --}}
    <aside class="sidebar">
      <div class="profile-card">
        <div class="profile-left">
          <img src="{{ asset('images/profilAnggota.jpg') }}"
          alt="Foto Anggota" class="avatar-70">
        </div>
        <div class="profile-right">
          <div class="profile-name">Angga</div>
          <div class="profile-role">Anggota</div>
        </div>
        <a href="#" class="btn-profil push-right" aria-label="Buka Profil">
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

    {{-- 🔸 ISI PROFIL --}}
    <main class="content">
      <h2 class="page-title">My Profile <span class="subtitle">Anggota</span></h2>

      <div class="profile-wrapper">
        {{-- Card Profil Tengah --}}
        <section class="card-profile">
          <img src="{{ asset('images/profilAnggota.jpg') }}" alt="Foto Anggota" class="profile-photo">
          <h3 class="profile-nama">Angga Aldi Yunanda</h3>
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
    <label>Jabatan</label>
    <input type="text" name="jabatan" value="anggota"  {{-- {{ $anggota->jabatan}} --}}>
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
