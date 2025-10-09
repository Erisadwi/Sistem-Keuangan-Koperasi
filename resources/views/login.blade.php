<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  @vite('resources/css/style.css')
</head>

<body>

  <div class="login-page">
    <div class="login-card">

      <!-- Bagian Logo -->
      <div class="logo-title">
        <div class="logo-card">
          <img class="logo-label" src="{{ asset('images/logo.png') }}" alt="Logo">
        </div>
      </div>

      <!-- Form Login -->
      <form class="login-form">
        <label for="username">Username</label>
        <input type="text" id="username" class="input-username" placeholder="Masukkan username">

        <label for="password">Password</label>
        <div class="password-wrapper">
          <input type="password" id="password" class="input-password" placeholder="Masukkan password">
          <button type="button" class="icon-eye" id="togglePassword">
          </button>
        </div>

        <button type="submit" class="button-login">Login</button>
      </form>
    </div>
  </div>

  <!-- toggle password -->
  <script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', () => {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
    });
  </script>

</body>
</html>