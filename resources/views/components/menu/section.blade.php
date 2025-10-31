@props([
  'title',
  'open' => true,
  'hasSub' => true,
  'link' => null, // NEW: untuk item tanpa submenu
  'id' => null,   // biar bisa auto-generate kalau null
])

@php
  // Pastikan $id selalu ada, tanpa perlu import Str di Blade
  $id = $id ?: \Illuminate\Support\Str::slug($title);
@endphp

@once
  @vite(['resources/css/components/section.css', 'resources/js/laporan.js'])
@endonce

<li class="menu-section {{ $hasSub ? '' : 'no-submenu' }}">
  @if($hasSub)
    <button
      class="menu-head"
      data-toggle="collapse"
      data-target="#dd-{{ $id }}"
      aria-expanded="{{ $open ? 'true' : 'false' }}"
      type="button"
    >
      <span>{{ $title }}</span>
      <svg class="chev-svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        <path d="M5.5 7.5l4.5 4 4.5-4" />
      </svg>
    </button>

    <div id="dd-{{ $id }}" class="submenu {{ $open ? 'open' : '' }}">
      {{ $slot }}
    </div>
  @else
    {{-- Item tanpa submenu -> render anchor biasa --}}
    <a href="{{ $link ?? '#' }}" class="menu-head no-sub" role="menuitem">
      <span>{{ $title }}</span>
    </a>
  @endif
</li>


