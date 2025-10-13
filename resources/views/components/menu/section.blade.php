@props([
  'title',
  'open' => true,
  'id' => Str::slug($title),
  'hasSub' => true, // menandai apakah menu punya sub-menu
])

@once
    @vite(['resources/css/components/section.css', 'resources/js/laporan.js'])
@endonce

<li class="menu-section {{ $hasSub ? '' : 'no-submenu' }}">
  @if($hasSub)
    <button class="menu-head" data-toggle="collapse" data-target="#dd-{{ $id }}" aria-expanded="{{ $open ? 'true':'false' }}">
      <span>{{ $title }}</span>
      <svg class="chev-svg" viewBox="0 0 20 20" fill="currentColor">
        <path d="M5.5 7.5l4.5 4 4.5-4" />
      </svg>
    </button>
    <div id="dd-{{ $id }}" class="submenu {{ $open ? 'open' : '' }}">
      {{ $slot }}
    </div>
  @else
    <!-- Menu tanpa sub-menu, bisa dijadikan link -->
    <a href="#" class="menu-head no-sub">{{ $title }}</a>
  @endif
</li>

