<table class="laporan-buku-besar-table">
  <thead>
    <tr class="head-group">
      <th>No</th>
      <th>Tanggal</th>
      <th>Jenis Transaksi</th>
      <th>Keterangan</th>
      <th>Debet</th>
      <th>Kredit</th>
      <th>Saldo</th>
    </tr>
  </thead>
  <tbody>
    @isset($data)
      @forelse ($data as $index => $item)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
          <td>{{ $item->jenis_transaksi }}</td>
          <td>{{ $item->keterangan }}</td>
          <td>{{ number_format($item->debet, 0, ',', '.') }}</td>
          <td>{{ number_format($item->kredit, 0, ',', '.') }}</td>
          <td>{{ number_format($item->saldo, 0, ',', '.') }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="7" class="empty-cell">Belum ada data {{ $label }}.</td>
        </tr>
      @endforelse
    @else
      <tr>
        <td colspan="7" class="empty-cell">Belum ada data {{ $label }}.</td>
      </tr>
    @endisset

    @if(isset($data) && $data->count() > 0)
      <tr class="total-row">
        <td colspan="4" class="text-right">Total</td>
        <td>{{ number_format($data->sum('debet'), 0, ',', '.') }}</td>
        <td>{{ number_format($data->sum('kredit'), 0, ',', '.') }}</td>
        <td>{{ number_format($data->last()->saldo, 0, ',', '.') }}</td>
      </tr>
    @endif
  </tbody>
</table>
