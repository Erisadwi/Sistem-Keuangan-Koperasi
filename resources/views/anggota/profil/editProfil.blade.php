<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profil Anggota</title>
  @vite(['resources/css/style-editProfil.css'])
</head>
<body>

<x-menu.nav-top />

  <main class="page">
    <div class="page-header">
      <span class="crumb">My Profile &gt;</span>
      <h1 class="title">Edit Profile</h1>
    </div>

    <section class="panel">
      <div class="panel-inner">
        <div class="left">
          <div class="avatar-wrap">
            <img src="{{ asset('images/profilAnggota.jpg') }}" alt="" class="avatar">
            <button class="btn-camera">
              <img src="{{ asset('icons/camera.png') }}" alt="" class="btn-icon" />
            </button>
          </div>
          
          <button type="button" class="btn-upload">
            Ubah Foto
          </button>
        </div>

        <form class="form" method="post" action="#{{-- {{ route('profile.update') }} --}}">
          @csrf
          @method('PUT')

          <div class="field">
            <label>Username</label>
            <input type="text" name="username" value="angga">
          </div>

          <div class="field">
            <label>Password Lama</label>
            <input type="password" name="old_password" value="........">
          </div>

          <div class="field">
            <label>Password Baru</label>
            <input type="password" name="new_password" value="........">
          </div>

          <div class="field">
            <label>Nama Lengkap</label>
            <input type="text" name="full_name" value="angga aldi yunanda">
          </div>

          <div class="field">
            <label>Alamat</label>
            <textarea name="address" rows="3">Perum Griya Sejahtera, Blok J No. 20 jl. Medayu Utara 30A, Medokan Ayu, Rungkut Surabaya</textarea>
          </div>

          <div class="field">
            <label>Jabatan</label>
            <input type="text" name="position" value="anggota">
          </div>

          <div class="actions">
            <button type="submit" class="btn btn-save">Simpan Perubahan</button>
            <a href="{{ url()->previous() }}" class="btn btn-cancel">Batal</a>
          </div>
        </form>
      </div>
    </section>
  </main>

</body>
</html>
