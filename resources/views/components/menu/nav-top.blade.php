@props([
  'logo'   => asset('images/logo.png'),
  'alt'    => 'Koperasi TSM',
  'height' => 45,
])

@once
  @vite('resources/css/components/nav-top.css')
@endonce


<nav class="nav-top">
  <div class="nav-left">
    {{ $left ?? '' }}
  </div>

  <div class="nav-right">
    <div class="divider-16"></div>
    <img src="{{ $logo }}" alt="{{ $alt }}" class="logo-coop" style="height: {{ $height }}px">
  </div>
</nav>

