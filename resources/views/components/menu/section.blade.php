@props([
  'title',
  'open' => true,
  'id' => Str::slug($title) // pastikan pakai Str di helper atau ubah manual
])

<li class="menu-section">
  <button class="menu-head" data-toggle="collapse" data-target="#dd-{{ $id }}" aria-expanded="{{ $open ? 'true':'false' }}">
    <span>{{ $title }}</span>
    <svg class="chev-svg" viewBox="0 0 20 20" fill="currentColor"><path d="M5.5 7.5l4.5 4 4.5-4" /></svg>
  </button>
  <div id="dd-{{ $id }}" class="submenu {{ $open ? 'open' : '' }}">
    {{ $slot }}
  </div>
</li>
