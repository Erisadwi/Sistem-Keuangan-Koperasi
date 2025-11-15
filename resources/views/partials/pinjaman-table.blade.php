<table class="laba-rugi-table">
  <thead>
    <tr class="head-group">
      <th>No</th>
      <th>Keterangan</th>
      <th>Jumlah (Rp)</th>
    </tr>
  </thead>

  <tbody>

    {{-- ======================================
         NORMALISASI DATA
         ====================================== --}}
    @php
        // Null → array kosong
        if (is_null($data)) {
            $data = [];
        }

        // Numeric → jadikan array of object
        if (is_numeric($data)) {
            $data = [
                (object)[
                    'keterangan' => $label ?? 'Data',
                    'jumlah'     => $data
                ]
            ];
        }

        // Object tunggal → arraykan
        if (is_object($data) && !($data instanceof \Illuminate\Support\Collection)) {
            $data = [$data];
        }

        // Jika bukan array/collection → jadikan array
        if (!is_array($data) && !($data instanceof \Illuminate\Support\Collection)) {
            $data = [$data];
        }

        // Ubah Collection ke array agar index [0], [1] aman
        if ($data instanceof \Illuminate\Support\Collection) {
            $data = $data->values()->all();
        }
    @endphp


    {{-- ======================================
         TAMPILKAN DATA PINJAMAN
         ====================================== --}}
    @php $no = 1; @endphp

    @forelse ($data as $item)
        @php
            $ket = is_array($item) ? ($item['keterangan'] ?? '') : ($item->keterangan ?? '');
            $jml = is_array($item) ? ($item['jumlah'] ?? 0)      : ($item->jumlah ?? 0);
        @endphp

        <tr>
          <td>{{ $no++ }}</td>
          <td class="text-left">{{ $ket }}</td>
          <td class="text-right">{{ number_format($jml, 0, ',', '.') }}</td>
        </tr>

    @empty
        <tr>
          <td colspan="3" class="empty-cell">
            Belum ada data {{ $label }}.
          </td>
        </tr>
    @endforelse

    @if(count($data) >= 2)

        @php
            $baris1 = is_array($data[0]) ? ($data[0]['jumlah'] ?? 0) : ($data[0]->jumlah ?? 0);
            $baris2 = is_array($data[1]) ? ($data[1]['jumlah'] ?? 0) : ($data[1]->jumlah ?? 0);

            // Pendapatan pinjaman = angsuran - jumlah uang dipinjamkan
            $totalPinjaman = $baris2 - $baris1;
        @endphp

        <tr class="total-row">
            <td colspan="2" class="text-right"><strong>Jumlah Pendapatan Pinjaman</strong></td>
            <td class="text-right">
                <strong>{{ number_format($totalPinjaman, 0, ',', '.') }}</strong>
            </td>
        </tr>
    @endif

  </tbody>
</table>
