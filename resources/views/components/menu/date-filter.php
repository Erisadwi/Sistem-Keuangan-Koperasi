@props([
  'action' => request()->url(),    // default: halaman saat ini
  'start'  => $start ?? request('start_date'),
  'end'    => $end   ?? request('end_date'),
  'preset' => $preset?? request('preset'),
])

@php
  use Illuminate\Support\Str;
  $uid = 'df_'.Str::random(6);
@endphp

<form method="GET" action="{{ route('laporan.shu') }}" id="{{ $uid }}_form" class="df-wrap">
  <div class="df-btn-group">
    <button type="button" class="df-btn {{ $preset==='this_month' ? 'active' : '' }}" data-preset="this_month">Bulan ini</button>
    <button type="button" class="df-btn {{ $preset==='last_month' ? 'active' : '' }}" data-preset="last_month">Bulan lalu</button>
    <button type="button" class="df-btn {{ $preset==='ytd' ? 'active' : '' }}"        data-preset="ytd">Year-to-Date</button>
    <button type="button" class="df-btn {{ $preset==='this_year' ? 'active' : '' }}"  data-preset="this_year">Tahun ini</button>

    <button type="submit" class="df-btn {{ $preset==='custom' ? 'active' : '' }}"
            onclick="document.getElementById('{{ $uid }}_preset').value='custom'">Terapkan</button>

    {{-- Hapus filter: kembali ke route tanpa query string --}}
    <a class="df-btn danger" href="{{ route('laporan.shu') }}">Hapus Filter</a>
  </div>

  <div class="df-fields">
    <input type="hidden" name="preset" id="{{ $uid }}_preset" value="{{ $preset }}">
    <label for="{{ $uid }}_start">Dari</label>
    <input type="date" name="start_date" id="{{ $uid }}_start" value="{{ $start }}">
    <label for="{{ $uid }}_end">Sampai</label>
    <input type="date" name="end_date" id="{{ $uid }}_end" value="{{ $end }}">
  </div>
</form>


<style>
  .df-wrap{ display:block; margin: 0 0 12px 0 }
  .df-btn-group{ display:flex; gap:8px; flex-wrap:wrap; margin-bottom:10px }
  .df-btn{ padding:8px 12px; border:1px solid #ddd; border-radius:8px; background:#fff; cursor:pointer; text-decoration:none; display:inline-block }
  .df-btn.active{ border-color:#333; font-weight:600 }
  .df-btn.danger{ border-color:#e2e2e2; color:#b00020 }
  .df-fields{ display:flex; gap:8px; align-items:center; flex-wrap:wrap }
  .df-fields input[type="date"]{ padding:8px 10px; border:1px solid #ccc; border-radius:6px }
</style>

<script>
  (function(){
    const form   = document.getElementById('{{ $uid }}_form');
    const startI = document.getElementById('{{ $uid }}_start');
    const endI   = document.getElementById('{{ $uid }}_end');
    const preset = document.getElementById('{{ $uid }}_preset');

    function pad(n){ return String(n).padStart(2,'0'); }
    function fmt(d){ return d.getFullYear()+'-'+pad(d.getMonth()+1)+'-'+pad(d.getDate()); }
    function setDates(s,e,p){ startI.value=s; endI.value=e; preset.value=p; form.submit(); }

    form.addEventListener('click', function(ev){
      const btn = ev.target.closest('[data-preset]');
      if(!btn) return;

      const which = btn.dataset.preset;
      const now = new Date();
      const startYear   = new Date(now.getFullYear(), 0, 1);
      const startMonth  = new Date(now.getFullYear(), now.getMonth(), 1);
      const endMonth    = new Date(now.getFullYear(), now.getMonth()+1, 0);
      const lastMonthSt = new Date(now.getFullYear(), now.getMonth()-1, 1);
      const lastMonthEn = new Date(now.getFullYear(), now.getMonth(), 0);

      if(which==='this_month') return setDates(fmt(startMonth), fmt(endMonth), 'this_month');
      if(which==='last_month') return setDates(fmt(lastMonthSt), fmt(lastMonthEn), 'last_month');
      if(which==='ytd')        return setDates(fmt(startYear), fmt(now), 'ytd');
      if(which==='this_year')  return setDates(fmt(startYear), fmt(new Date(now.getFullYear(), 11, 31)), 'this_year');
    });
  })();
</script>


