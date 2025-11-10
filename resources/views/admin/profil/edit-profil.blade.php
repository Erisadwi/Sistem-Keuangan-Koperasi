<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profil Admin</title>
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
            <img src="{{ $user->foto_user ? asset('storage/foto_user/' . basename($user->foto_user)) : asset('images/default.jpeg') }}"alt="Foto Profil" class="avatar">
            <button type="button" id="btnCamera" class="btn-camera">
              <img src="{{ asset('icons/camera.png') }}" alt="" class="btn-icon" />
            </button>
          </div>
          <button type="button" id="btnUpload" class="btn-upload">
            Ubah Foto
          </button>
        </div>

        <form class="form" method="post" action="{{ route('profil.update', $user->id_user) }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="field">
            <label>Username</label>
            <input type="text" name="username" value="{{ $user->username }}">
          </div>

          <div class="field">
            <label>Password Lama</label>
            <input type="password" name="old_password" placeholder="Masukkan password lama">
          </div>

          <div class="field">
            <label>Password Baru</label>
            <input type="password" name="new_password" placeholder="Masukkan password baru">
          </div>

          <div class="field">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" value="{{ $user->nama_lengkap }}">
          </div>

          <div class="field">
            <label>Alamat</label>
            <textarea name="alamat_user" rows="3">{{ $user->alamat_user }}"</textarea>
          </div>

          <div class="field">
            <label>Role</label>
            <select name="role">
                <option value="" disabled>Pilih role</option>
                <option value="R04" {{ $user->id_role == 'R04' ? 'selected' : '' }}>admin simpanan</option>
                <option value="R05" {{ $user->id_role == 'R05' ? 'selected' : '' }}>admin pinjaman</option>
                <option value="R06" {{ $user->id_role == 'R06' ? 'selected' : '' }}>admin accounting</option>
                <option value="R07" {{ $user->id_role == 'R07' ? 'selected' : '' }}>pengurus</option>
            </select>
            </div>

             <input type="file" name="foto" id="fotoInput" accept="image/*" style="display: none;">

          <div class="actions">
            <button type="submit" class="btn btn-save">Simpan Perubahan</button>
            <a href="{{ url()->previous() }}" class="btn btn-cancel">Batal</a>
          </div>
        </form>
      </div>
    </section>
  </main>

  <script>

  const fotoInput = document.getElementById('fotoInput');
  const avatar = document.querySelector('.avatar');
  const btnUpload = document.getElementById('btnUpload');
  const btnCamera = document.getElementById('btnCamera');

  btnUpload.addEventListener('click', () => fotoInput.click());
  btnCamera.addEventListener('click', () => fotoInput.click());

  fotoInput.addEventListener('change', event => {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = e => {
        avatar.src = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  });
</script>

</body>