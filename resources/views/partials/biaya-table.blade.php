<table class="laba-rugi-table">
  <thead>
    <tr class="head-group">
      <th>No</th>
      <th>Keterangan</th>
      <th>Jumlah (Rp)</th>
    </tr>
  </thead>
  <tbody>
    @isset($data)
      @php $no = 1; @endphp
      @forelse ($data as $item)
        @php
          $ket = is_array($item) ? ($item['keterangan'] ?? '') : ($item->keterangan ?? '');
          $jml = is_array($item) ? ($item['jumlah'] ?? 0) : ($item->jumlah ?? 0);
        @endphp
        <tr>
          <td>{{ $no++ }}</td>
          <td class="text-left">{{ $ket }}</td>
          <td class="text-right">{{ number_format($jml, 0, ',', '.') }}</td>
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

    @if(isset($data) && count($data) > 0)
      @php
        $totalBiaya = collect($data)->sum(function ($item) {
          return is_array($item) ? ($item['jumlah'] ?? 0) : ($item->jumlah ?? 0);
        });
      @endphp
      <tr class="total-row">
        <td colspan="2" class="text-right"><strong>Total Biaya</strong></td>
        <td class="text-right"><strong>{{ number_format($totalBiaya, 0, ',', '.') }}</strong></td>
      </tr>
    @endif
  </tbody>
</table>
