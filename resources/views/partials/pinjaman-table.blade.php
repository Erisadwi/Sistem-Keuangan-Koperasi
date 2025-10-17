<table class="laba-rugi-table">
  <thead>
    <tr class="head-group">
      <th>No</th>
      <th>Keterangan</th>
      <th>Jumlah</th>
    </tr>
  </thead>
  <tbody>
    @php
      $findAmount = function($collection, array $keywords) {
          if (empty($collection)) return 0;
          foreach ($collection as $row) {
              $ket = is_array($row) ? ($row['keterangan'] ?? '') : ($row->keterangan ?? '');
              $jml = is_array($row) ? ($row['jumlah'] ?? 0)     : ($row->jumlah ?? 0);
              $norm = mb_strtolower(trim($ket));
              foreach ($keywords as $kw) {
                  if (mb_strpos($norm, mb_strtolower($kw)) !== false) {
                      return (float) $jml;
                  }
              }
          }
          return 0;
      };

      $totalAngsuran = isset($data) ? $findAmount($data, ['jumlah angsuran', 'total angsuran', 'angsuran']) : 0;
      $totalPinjaman = isset($data) ? $findAmount($data, ['jumlah pinjaman', 'total pinjaman', 'pinjaman']) : 0;

      $jumlahPendapatanPinjaman = $totalAngsuran - $totalPinjaman;
    @endphp>

    @isset($data)
      @forelse ($data as $index => $item)
        @php
          $ket = is_array($item) ? ($item['keterangan'] ?? '') : ($item->keterangan ?? '');
          $jml = is_array($item) ? ($item['jumlah'] ?? 0)     : ($item->jumlah ?? 0);
        @endphp
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $ket }}</td>
          <td>{{ number_format($jml, 0, ',', '.') }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="3" class="empty-cell">Belum ada data {{ $label }}.</td>
        </tr>
      @endforelse
    @else
      <tr>
        <td colspan="3" class="empty-cell">Belum ada data {{ $label }}.</td>
      </tr>
    @endisset

    @if(isset($data) && $data && count($data) > 0)
      <tr class="total-row">
        <td colspan="2" class="text-right">Jumlah Pendapatan Pinjaman</td>
        <td>{{ number_format($jumlahPendapatanPinjaman, 0, ',', '.') }}</td>
      </tr>
    @endif
  </tbody>
</table>

