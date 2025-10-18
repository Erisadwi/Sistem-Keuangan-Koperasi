<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda | Koperasi TSM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite('resources/css/style-berandaProfil.css')
</head>
<body>
    <header class="topbar">
        <div class="left-section">
            <button id="menu-toggle" class="menu-btn"><i class="fa fa-bars"></i></button>
            <div class="title-group">
                <span class="title">Beranda</span>
                <span class="subtitle">Menu Utama</span>
            </div>
        </div>

        <div class="right-section">
            <div class="icons">
                <i class="fa fa-calendar"></i>
                <div class="notif-wrapper">
                    <i class="fa fa-bell"></i>
                    <span class="notif-count">111</span>
                </div>
                <span class="clock" id="clock"></span>
            </div>
            <div class="brand">
                <img src="/images/logo.png" alt="Logo" class="logo-img">
                <div class="brand-text">
                    <h3>KOPERASI</h3>
                    <p>'TSM'</p>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <aside class="sidebar" id="sidebar">
            <div class="profile-card">
                <div class="profile-photo">
                    <img src="/images/profile.jpg" alt="User Photo">
                </div>
                <div class="profile-info">
                    <h3>Iqbaal</h3>
                    <p>Admin Simpanan</p>
                </div>
            </div>

            <nav class="menu">
                <button class="menu-item dropdown-btn">Transaksi Kas <i class="fa fa-chevron-down"></i></button>
                <div class="dropdown-container">
                    <a href="#">Pemasukan</a>
                    <a href="#">Pengeluaran</a>
                    <a href="#">Transfer Kas</a>
                    <a href="#">Transaksi Non Kas</a>
                </div>

                <button class="menu-item dropdown-btn">Simpanan <i class="fa fa-chevron-down"></i></button>
                <div class="dropdown-container">
                    <a href="#">Simpanan Pokok</a>
                    <a href="#">Simpanan Wajib</a>
                    <a href="#">Simpanan Sukarela</a>
                </div>

                <button class="menu-item dropdown-btn">Pinjaman <i class="fa fa-chevron-down"></i></button>
                <div class="dropdown-container">
                    <a href="#">Data Pinjaman</a>
                    <a href="#">Pelunasan</a>
                </div>

                <button class="menu-item dropdown-btn">Laporan <i class="fa fa-chevron-down"></i></button>
                <div class="dropdown-container">
                    <a href="#">Laporan Keuangan</a>
                    <a href="#">Laporan Simpanan</a>
                </div>

                <button class="menu-item dropdown-btn">Master Data <i class="fa fa-chevron-down"></i></button>
                <div class="dropdown-container">
                    <a href="#">Data Anggota</a>
                    <a href="#">Data Pengguna</a>
                </div>

                <button class="menu-item dropdown-btn">Setting <i class="fa fa-chevron-down"></i></button>
                <div class="dropdown-container">
                    <a href="#">Profil</a>
                    <a href="#">Logout</a>
                </div>
            </nav>
        </aside>

        <main class="content">
            <section class="welcome">
                <h1>Selamat Datang</h1>
                <p>Hai, silahkan pilih menu untuk mengoperasikan aplikasi</p>
            </section>

            <section class="cards">
                <article class="card orange">
                    <h2>Pinjaman</h2>
                    <p>7,180,059,100 <span>Jumlah Tagihan</span></p>
                    <p>6,389,993,269 <span>Jumlah Pelunasan</span></p>
                    <p>790,065,831 <span>Sisa Tagihan</span></p>
                    <i class="fa fa-money-bill-wave icon-bg"></i>
                    <a href="#" class="more-info">More info <i class="fa fa-circle-info"></i></a>
                </article>

                <article class="card green">
                    <h2>Simpanan</h2>
                    <p>1,861,247,000 <span>Simpanan Anggota</span></p>
                    <p>876,049,740 <span>Penarikan Tunai</span></p>
                    <p>985,197,260 <span>Jumlah Simpanan</span></p>
                    <i class="fa fa-briefcase icon-bg"></i>
                    <a href="#" class="more-info">More info <i class="fa fa-circle-info"></i></a>
                </article>

                <article class="card purple">
                    <h2>Kas Bulan Oktober 2025</h2>
                    <p>429,565,371 <span>Saldo Awal</span></p>
                    <p>0 <span>Mutasi</span></p>
                    <p>429,565,371 <span>Saldo Akhir</span></p>
                    <i class="fa fa-book icon-bg"></i>
                    <a href="#" class="more-info">More info <i class="fa fa-circle-info"></i></a>
                </article>

                <article class="card blue">
                    <h2>Data Anggota</h2>
                    <p>267 <span>Anggota Aktif</span></p>
                    <p>330 <span>Anggota Tidak Aktif</span></p>
                    <p>579 <span>Jumlah Anggota</span></p>
                    <i class="fa fa-user-plus icon-bg"></i>
                    <a href="#" class="more-info">More info <i class="fa fa-circle-info"></i></a>
                </article>

                <article class="card sky">
                    <h2>Data Peminjam</h2>
                    <p>6071 <span>Peminjam</span></p>
                    <p>5850 <span>Sudah Lunas</span></p>
                    <p>221 <span>Belum Lunas</span></p>
                    <i class="fa fa-calendar icon-bg"></i>
                    <a href="#" class="more-info">More info <i class="fa fa-circle-info"></i></a>
                </article>

                <article class="card red">
                    <h2>Data Pengguna</h2>
                    <p>9 <span>User Aktif</span></p>
                    <p>3 <span>User Non-Aktif</span></p>
                    <p>12 <span>Jumlah User</span></p>
                    <i class="fa fa-users icon-bg"></i>
                    <a href="#" class="more-info">More info <i class="fa fa-circle-info"></i></a>
                </article>
            </section>
        </main>
    </div>

    <script>
        const toggleBtn = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });

        const dropdownBtns = document.querySelectorAll('.dropdown-btn');
        dropdownBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                this.classList.toggle('active');
                const content = this.nextElementSibling;
                content.style.display = content.style.display === 'block' ? 'none' : 'block';
            });
        });

        function updateClock() {
            const now = new Date();
            document.getElementById('clock').textContent =
                now.toLocaleTimeString('id-ID', { hour12: false });
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>
</html>
