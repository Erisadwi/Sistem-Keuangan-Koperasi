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
  $user = Auth::guard('anggota')->user();
  @endphp

  {{-- 🔹 KONTEN UTAMA --}}
  <div class="layout">
    {{-- 🔸 SIDEBAR --}}
    <aside class="sidebar">
      <div class="profile-card">
        <div class="profile-left">
          <img src="{{ $anggota->foto ? asset($anggota->foto) : asset('images/default.jpeg') }}" alt="Foto Anggota" class="avatar-70">
        </div>
        <div class="profile-right">
          <div class="profile-name">{{ $anggota->nama_anggota ?? 'Nama Tidak Ditemukan' }}</div>
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
          <a href="{{ route('anggota.pengajuan.index') }}" class="submenu-row">Data Pengajuan</a>
          <a href="{{ route('anggota.pengajuan.create') }}" class="submenu-row">Tambah Pengajuan Baru</a>
        </x-menu.section>
      </ul>
    </aside>

    {{-- 🔸 ISI PROFIL --}}
    <main class="content">
      <h2 class="page-title">My Profile <span class="subtitle">Anggota</span></h2>

      <div class="profile-wrapper">
        {{-- Card Profil Tengah --}}
        <section class="card-profile">
          <img src="{{ $anggota->foto ? asset($anggota->foto) : asset('images/default.jpeg') }}" alt="Foto Anggota" class="profile-photo">
          <h3 class="profile-nama">{{ $anggota->nama_anggota ?? 'Nama Tidak Ditemukan' }}</h3>
          <p class="profile-status aktif">{{ $anggota->status_anggota ?? '' }}</p>

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

        {{-- Form Profil Kanan --}}
        <section class="card-form"> 
          <div class="form">
          <div class="form-group">
            <label>Username</label>
            <input type="text" name="username_anggota" value="{{ $anggota->username_anggota }}"readonly>
          </div>
          <div class="form-group">
            <label>Password</label>
            <input 
              type="password" name="password" value="********" readonly>
          </div>
          <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_anggota"value="{{ $anggota->nama_anggota}}"readonly>
          </div>
          <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat_anggota" rows="3"readonly>{{ $anggota->alamat_anggota }}</textarea>
          </div>
          <div class="form-group">
            <label>Jabatan</label>
            <input type="text" name="jabatan" value="{{ $anggota->jabatan}}"readonly>
          </div>
          <a href="{{ route('anggota.profil.edit') }}" class="btn btn-primary">Edit Profil</a>
          </div>
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
