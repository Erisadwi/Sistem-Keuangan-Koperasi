@props(['data'])

@once
  @vite('resources/css/components/pagination.css')
@endonce

<div class="pagination-container">

    {{-- Pilihan jumlah data per halaman --}}
    <div class="pagination-version1">
        <form method="GET">
            <select id="itemsPerPage" name="per_page" class="items-per-page" onchange="this.form.submit()">
                @foreach([7, 14, 21, 28] as $size)
                    <option value="{{ $size }}" {{ request('per_page', 7) == $size ? 'selected' : '' }}>
                        {{ $size }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    {{-- Tombol navigasi halaman --}}
    <div class="pagination-version2">
        {{-- Tombol Prev --}}
        @if ($data->onFirstPage())
            <button class="pagination-btn prev-btn" disabled>Prev</button>
        @else
            <a href="{{ $data->previousPageUrl() }}{{ request('per_page') ? '&per_page='.request('per_page') : '' }}"
               class="pagination-btn prev-btn">Prev</a>
        @endif

        {{-- Nomor Halaman --}}
        <div class="page-numbers">
            @foreach ($data->getUrlRange(1, $data->lastPage()) as $page => $url)
                @if ($page == $data->currentPage())
                    <button class="page-btn active">{{ $page }}</button>
                @elseif ($page == 1 || $page == $data->lastPage() || abs($page - $data->currentPage()) <= 2)
                    <a href="{{ $url }}{{ request('per_page') ? '&per_page='.request('per_page') : '' }}"
                       class="page-btn">{{ $page }}</a>
                @elseif ($page == 2 && $data->currentPage() > 4)
                    <span class="ellipsis">...</span>
                @elseif ($page == $data->lastPage() - 1 && $data->currentPage() < $data->lastPage() - 3)
                    <span class="ellipsis">...</span>
                @endif
            @endforeach
        </div>

        {{-- Tombol Next --}}
        @if ($data->hasMorePages())
            <a href="{{ $data->nextPageUrl() }}{{ request('per_page') ? '&per_page='.request('per_page') : '' }}"
               class="pagination-btn next-btn">Next</a>
        @else
            <button class="pagination-btn next-btn" disabled>Next</button>
        @endif
    </div>
</div>
