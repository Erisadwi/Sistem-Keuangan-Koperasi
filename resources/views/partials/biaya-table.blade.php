<table class="laba-rugi-table">
  <thead>
    <tr class="head-group">
      <th>No</th>
      <th>Keterangan</th>
      <th>Jumlah (Rp)</th>
    </tr>
  </thead>

  <tbody>
    @php
      // Normalisasi data supaya selalu array list
      if (is_numeric($data)) {
          // Ubah float menjadi array item tunggal
          $data = [
              (object)[
                  'keterangan' => $label ?? 'Data',
                  'jumlah' => $data
              ]
          ];
      } elseif (is_null($data)) {
          $data = [];
      } elseif (is_object($data) && !($data instanceof \Illuminate\Support\Collection)) {
          // Object tunggal → jadikan array
          $data = [$data];
      }
      // Jika Collection → biarkan
    @endphp

    @forelse ($data as $item)
      @php
        $ket = is_array($item) ? ($item['keterangan'] ?? '') : ($item->keterangan ?? '');
        $jml = is_array($item) ? ($item['jumlah'] ?? 0) : ($item->jumlah ?? 0);
      @endphp
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td class="text-left">{{ $ket }}</td>
        <td class="text-right">{{ number_format($jml, 0, ',', '.') }}</td>
      </tr>
    @empty
      <tr>
        <td colspan="3" class="empty-cell">Belum ada data {{ $label }}.</td>
      </tr>
    @endforelse

    @if(count($data) > 0)
      @php
        $total = collect($data)->sum(function($item){
            return is_array($item) ? ($item['jumlah'] ?? 0) : ($item->jumlah ?? 0);
        });
      @endphp
      <tr class="total-row">
        <td colspan="2" class="text-right"><strong>Total {{ $label }}</strong></td>
        <td class="text-right"><strong>{{ number_format($total, 0, ',', '.') }}</strong></td>
      </tr>
    @endif
  </tbody>
</table>
