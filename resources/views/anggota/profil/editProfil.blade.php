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
            <img src="{{ $anggota->foto ? asset($anggota->foto) : asset('images/default.jpeg') }}" alt="Foto Profil" class="avatar">
            <button type="button" id="btnCamera" class="btn-camera">
              <img src="{{ asset('icons/camera.png') }}" alt="" class="btn-icon" />
            </button>
          </div>
          <button type="button" id="btnUpload" class="btn-upload">Ubah Foto</button>
        </div>

        <form id="formProfil" class="form" method="post" action="{{ route('anggota.profil.update', $anggota->id_anggota) }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="field">
            <label>Username</label>
            <input type="text" name="username_anggota" value="{{ $anggota->username_anggota }}">
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
            <input type="text" name="nama_anggota" value="{{ $anggota->nama_anggota }}">
          </div>

          <div class="field">
            <label>Alamat</label>
            <textarea name="alamat_anggota" rows="3">{{ $anggota->alamat_anggota }}</textarea>
          </div>

          <div class="field">
            <label>Jabatan</label>
            <input type="text" name="jabatan" value="{{ $anggota->jabatan }}">
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
</html>
