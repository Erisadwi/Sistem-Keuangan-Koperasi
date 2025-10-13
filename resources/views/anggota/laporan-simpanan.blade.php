@section('content')

<div class="laporan-page">
  {{-- Komponen filter tanggal & tombol hapus --}}
  <x-menu.date-filter />

  {{-- Tabel data laporan simpanan --}}
  <div class="laporan-simpanan-wrap">
    <table class="laporan-simpanan-table">
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>Jenis</th>
          <th>Jumlah</th>
          <th>Keterangan</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>10-09-2025</td>
          <td>Setoran</td>
          <td>100.000</td>
          <td>-</td>
        </tr>
      </tbody>
    </table>
  </div>

  {{-- Komponen pagination --}}
  <x-menu.pagination />
</div>

@endsection
