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
          alt="Foto Profil" class="avatar-90">
        </div>
        <div class="profile-right">
          <div class="profile-name">angga</div>
          <div class="profile-role">Anggota</div>
        </div>
      </div>

      <nav class="menu">
        <div class="menu-section">
          <button class="menu-item" onclick="toggleSubmenu(this)">
            Laporan <span class="chev">›</span>
          </button>
          <ul class="submenu">
            <li><a href="#">Simpanan</a></li>
            <li><a href="#">Pinjaman</a></li>
            <li><a href="#">Pembayaran</a></li>
            <li><a href="#">Sisa Hasil Usaha (SHU)</a></li>
          </ul>
        </div>

        <div class="menu-section">
          <button class="menu-item" onclick="toggleSubmenu(this)">
            Pengajuan Pinjaman <span class="chev">›</span>
          </button>
          <ul class="submenu">
            <li><a href="#">Data Pengajuan</a></li>
            <li><a href="#">Tambah Pengajuan Baru</a></li>
          </ul>
        </div>
      </nav>
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
            <div class="form-group">
              <label>Username</label>
              <input type="text" value="angga">
            </div>

            <div class="form-group">
              <label>Password</label>
              <input type="password" value="........">
            </div>

            <div class="form-group">
              <label>Nama Lengkap</label>
              <input type="text" value="angga aldi yunanda">
            </div>

            <div class="form-group">
              <label>Alamat</label>
              <textarea rows="3">Perum Griya Sejahtera,
Blok J No. 20
jl. Medayu Utara 30A, Medokan Ayu,
Rungkut, Surabaya</textarea>
            </div>

            <div class="form-group">
              <label>Jabatan</label>
              <input type="text" value="anggota">
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
