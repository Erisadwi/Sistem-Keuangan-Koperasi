<table class="laba-rugi-table">
  <thead>
    <tr class="head-group">
      <th>No</th>
      <th>Keterangan</th>
      <th>Jumlah (Rp)</th>
    </tr>
  </thead>

  <tbody>

    {{-- ================================
         NORMALISASI DATA AGAR ANTI ERROR
         ================================ --}}
    @php
        // Jika data adalah angka → ubah menjadi array berisi object
        if (is_numeric($data ?? null)) {
            $data = [
                (object)[
                    'keterangan' => $label ?? 'Data',
                    'jumlah'     => $data
                ]
            ];
        }

        // Jika null → ubah jadi array kosong
        if (is_null($data)) {
            $data = [];
        }

        // Jika object tunggal → ubah jadi array
        if (is_object($data) && !($data instanceof \Illuminate\Support\Collection)) {
            $data = [$data];
        }

        // Jika bukan array atau collection → jadikan array
        if (!is_array($data) && !($data instanceof \Illuminate\Support\Collection)) {
            $data = [$data];
        }
    @endphp


    {{-- ================================
         TAMPILKAN DATA
         ================================ --}}
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



    {{-- ================================
         TOTAL (Pendapatan / Biaya)
         ================================ --}}
    @if(count($data) > 0)
      @php
        $total = collect($data)->sum(function ($item) {
          return is_array($item)
            ? ($item['jumlah'] ?? 0)
            : ($item->jumlah ?? 0);
        });
      @endphp

      <tr class="total-row">
        <td colspan="2" class="text-right">
            <strong>Total {{ $label }}</strong>
        </td>
        <td class="text-right">
            <strong>{{ number_format($total, 0, ',', '.') }}</strong>
        </td>
      </tr>
    @endif

  </tbody>
</table>
