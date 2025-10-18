<table class="laba-rugi-table">
  <thead>
    <tr class="head-group">
      <th>No</th>
      <th>Keterangan</th>
      <th>Jumlah</th>
    </tr>
  </thead>
  <tbody>
    @isset($data)
      @forelse ($data as $index => $item)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $item->keterangan }}</td>
          <td>{{ number_format($item->jumlah, 0, ',', '.') }}</td>
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

    @if(isset($data) && $data->count() > 0)
      <tr class="total-row">
        <td colspan="2" class="text-right">Jumlah Pendapatan</td>
        <td>{{ number_format($data->last()->jumlah, 0, ',', '.') }}</td>
      </tr>
    @endif
  </tbody>
</table>
