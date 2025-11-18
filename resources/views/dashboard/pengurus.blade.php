@extends('layouts.pengurus')

@section('content')
<div class="dashboard-container">
  <div class="page-header">
    <h2><b>Beranda</b> <span class="text-muted">Menu Utama</span></h2>
    <h3><b>Selamat Datang</b></h3>
    <p>Hai, Silahkan pilih menu untuk mengoperasikan aplikasi</p>
  </div>

  <div class="card-grid">
    {{-- === Card: Pinjaman === --}}
    <div class="card orange">
      <div class="card-header">
        <h4>Pinjaman</h4>
        <span class="icon">💰</span>
      </div>
      <div class="card-body">
        <div>{{ number_format($pinjaman->tagihan ?? 7180059100, 0, ',', '.') }} <span>Jumlah Tagihan</span></div>
        <div>{{ number_format($pinjaman->pelunasan ?? 6389993269, 0, ',', '.') }} <span>Jumlah Pelunasan</span></div>
        <div>{{ number_format($pinjaman->sisa ?? 790065831, 0, ',', '.') }} <span>Sisa Tagihan</span></div>
      </div>
      <a href="#" class="card-footer">More info ➜</a>
    </div>

    {{-- === Card: Simpanan === --}}
    <div class="card green">
      <div class="card-header">
        <h4>Simpanan</h4>
        <span class="icon">💼</span>
      </div>
      <div class="card-body">
        <div>{{ number_format($simpanan->anggota ?? 1861247000, 0, ',', '.') }} <span>Simpanan Anggota</span></div>
        <div>{{ number_format($simpanan->penarikan ?? 876049740, 0, ',', '.') }} <span>Penarikan Tunai</span></div>
        <div>{{ number_format($simpanan->jumlah ?? 985197260, 0, ',', '.') }} <span>Jumlah Simpanan</span></div>
      </div>
      <a href="#" class="card-footer">More info ➜</a>
    </div>

    {{-- === Card: Kas Bulan === --}}
    <div class="card purple">
      <div class="card-header">
        <h4>Saldo Kas Bulan {{ $bulanName }} {{ $tahun }}</h4>
        <span class="icon">📒</span>
      </div>
      <div class="card-body">
        <div>Rp {{ number_format($saldo_awal, 0, ',', '.') }} <span>Saldo Awal</span></div>
        <div>Rp {{ number_format($mutasi, 0, ',', '.') }} <span>Mutasi</span></div>
        <div>Rp {{ number_format($saldo_akhir, 0, ',', '.') }} <span>Saldo Akhir</span></div>
     </div>
      <a href="{{ route('laporan.saldo-kas') }}" class="card-footer">More info ➜</a>
    </div>

    {{-- === Card: Data Anggota === --}}
    <div class="card blue">
      <div class="card-header">
        <h4>Data Anggota</h4>
        <span class="icon">👥</span>
      </div>
      <div class="card-body">
        <div>{{ $anggota_aktif ?? 0 }} <span>Anggota Aktif</span></div>
        <div>{{ $anggota_nonaktif ?? 0 }} <span>Anggota Tidak Aktif</span></div>
        <div>{{ $anggota_total ?? 0 }} <span>Jumlah Anggota</span></div>
      </div>
      @php
          $role = Auth::guard('user')->user()->id_role;
      @endphp
      @if($role === 'R07') 
          <a href="{{ route('anggota.index') }}" class="card-footer">More info ➜</a>
      @else
          <span class="card-footer text-gray-400 cursor-not-allowed">More info ➜</span>
      @endif
    </div>

    {{-- === Card: Data Peminjam === --}}
    <div class="card light-blue">
      <div class="card-header">
        <h4>Data Peminjam</h4>
        <span class="icon">🧾</span>
      </div>
      <div class="card-body">
        <div>{{ $peminjam_total ?? 0 }} <span>Peminjam</span></div>
        <div>{{ $peminjam_lunas ?? 0 }} <span>Sudah Lunas</span></div>
        <div>{{ $peminjam_belum ?? 0 }} <span>Belum Lunas</span></div>
      </div>
      @php
          $role = Auth::guard('user')->user()->id_role;
      @endphp
      @if(in_array($role, ['R05', 'R07']))
          <a href="{{ route('pinjaman.index') }}" class="card-footer">More info ➜</a>
      @else
          <span class="card-footer text-gray-400 cursor-not-allowed">More info ➜</span>
      @endif
    </div>

    {{-- === Card: Data Pengguna === --}}
    <div class="card red">
      <div class="card-header">
        <h4>Data Pengguna</h4>
        <span class="icon">👤</span>
      </div>
      <div class="card-body">
        <div>{{ $user_aktif ?? 0 }} <span>User Aktif</span></div>
        <div>{{ $user_nonaktif ?? 0}} <span>User Non-Aktif</span></div>
        <div>{{ $user_total ?? 0 }} <span>Jumlah User</span></div>
      </div> 
      @php
          $role = Auth::guard('user')->user()->id_role;
      @endphp
      @if($role === 'R07') 
          <a href="{{ route('data-user.index') }}" class="card-footer">More info ➜</a>
      @else
          <span class="card-footer text-gray-400 cursor-not-allowed">More info ➜</span>
      @endif
    </div>

  </div>
</div>

{{-- ================= CSS ================= --}}
<style>
.dashboard-container {
  margin-top: -60px;
  margin-left: 10px;
  margin-right: 20px;
}

.page-header h2 { font-size: 22px; }
.page-header h3 { margin-top: 5px; font-size: 20px; }
.page-header p { color: gray; margin-bottom: 25px; }

.card-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 25px;
  width: 100%;
  margin: 0 auto;
}

.card {
  height: auto;
  max-width: 350px;
  min-width: 280px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  border-radius: 14px;
  color: #fff;
  position: relative;
  box-shadow: 0 4px 8px rgba(0,0,0,0.15);
  transition: all 0.3s ease;
  overflow: hidden;
}

.card:hover {
  transform: translateY(-6px);
  box-shadow: 0 8px 16px rgba(0,0,0,0.2);
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 20px 0 20px;
}
.card-header h4 {
  font-size: 16px;
  font-weight: 700;
  line-height: 1;
}

.icon {
  display: inline-block;
  font-family: 'Segoe UI Emoji', 'Noto Color Emoji', 'Apple Color Emoji', sans-serif;
  font-style: normal;
  font-size: 48px;             
  color: rgba(255, 255, 255, 0.7);
  position: relative;
  top: 6px;
  align-self: flex-end;
}

.card-body {
  margin-top: 10px;
  padding: 0 20px 15px 20px;
  line-height: 1.7;
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
}
.card-body div {
  font-weight: bold;
  font-size: 13px;
}
.card-body span {
  font-weight: normal;
  margin-left: 6px;
  font-size: 12px;
}

.card-footer {
  display: flex;
  justify-content: center;
  align-items: center;
  text-decoration: none;
  color: white;
  font-weight: 600;
  background: rgba(255,255,255,0.25);
  border-radius: 0 0 14px 14px;
  padding: 10px 0;
  font-size: 14px;
  transition: background 0.3s;
  width: 100%;
}
.card-footer:hover {
  background: rgba(255,255,255,0.4);
}

.orange { background-color: #FEA855; }
.green { background-color: #8EDAAB; }
.purple { background-color: #DC9CE9; }
.blue { background-color: #0067b0cb; }
.light-blue { background-color: #29aae2d1; }
.red { background-color: #ea2828be; }
</style>
@endsection
