@props([
  // form basics
  'action'         => request()->url(),
  'method'         => 'GET',
  'submitOnChange' => false,

  // date props
  'start'  => request('start_date'),
  'end'    => request('end_date'),
  'preset' => request('preset', 'this_year'),

  // dropdowns
  // format: ['value' => 'Label', ...]
  'jenisOptions'   => [],
  'statusOptions'  => [],

  // selected values
  'jenis'  => request('jenis'),
  'status' => request('status'),

  // unduh
  // jika null, akan pakai $action + query + &export=1
  'downloadUrl'    => null,

  // id unik opsional
  'id' => null,

  // tampil kompak
  'compact' => true,
])

@php
  use Illuminate\Support\Str;
  $uid = $id ?: 'ft_'.Str::random(6);

  // label ringkas untuk tombol tanggal
  $label = 'Tanggal';
  if ($preset === 'custom' && ($start || $end)) {
    $label = 'Tanggal';
  }

  // URL unduh: bawa seluruh query + export=1
  $q = request()->query();
  $q['export'] = 1;
  $finalDownload = $downloadUrl ?: ($action.'?'.http_build_query($q));
@endphp

<form method="{{ strtoupper($method)==='POST' ? 'POST' : 'GET' }}"
      action="{{ $action }}"
      id="{{ $uid }}_form"
      class="ft-toolbar {{ $compact ? 'ft-compact' : '' }}">
  @if (strtoupper($method)==='POST') @csrf @endif

  <input type="hidden" name="preset" id="{{ $uid }}_preset" value="{{ $preset }}">

  {{-- KIRI: Tanggal --}}
  <div class="ft-left">
    <button type="button" class="ft-btn ft-date" id="{{ $uid }}_trigger" aria-haspopup="true" aria-expanded="false">
      <span class="ft-ic" aria-hidden="true">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
          <rect x="3" y="4" width="18" height="17" rx="3" stroke="#0ea5e9" stroke-width="2"/>
          <path d="M8 2v4M16 2v4M3 10h18" stroke="#0ea5e9" stroke-width="2" stroke-linecap="round"/>
        </svg>
      </span>
      <span class="ft-label">{{ $label }}</span>
      <span class="ft-caret" aria-hidden="true">▾</span>
    </button>
  </div>

  {{-- TENGAH: Dropdown & Aksi --}}
  <div class="ft-middle">
    <div class="ft-field">
      <label for="{{ $uid }}_jenis">Cari :</label>
      <select name="jenis" id="{{ $uid }}_jenis" class="ft-select">
        <option value="">Pilih Jenis Pinjaman</option>
        @foreach($jenisOptions as $val => $text)
          <option value="{{ $val }}" @selected((string)$jenis===(string)$val)>{{ $text }}</option>
        @endforeach
      </select>
    </div>

    <div class="ft-field">
      <select name="status" id="{{ $uid }}_status" class="ft-select">
        <option value="">Pilih status</option>
        @foreach($statusOptions as $val => $text)
          <option value="{{ $val }}" @selected((string)$status===(string)$val)>{{ $text }}</option>
        @endforeach
      </select>
    </div>

    <button type="submit" class="ft-icon-btn" title="Cari">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
        <circle cx="11" cy="11" r="7" stroke="#0ea5e9" stroke-width="2"/>
        <path d="M20 20l-3.5-3.5" stroke="#0ea5e9" stroke-width="2" stroke-linecap="round"/>
      </svg>
    </button>

    <a class="ft-btn ft-clear" href="{{ $action }}"> 
      <span class="ft-ic" aria-hidden="true">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
          <path d="M6 6l12 12M18 6L6 18" stroke="#2563eb" stroke-width="2" stroke-linecap="round"/>
        </svg>
      </span>
      Hapus Filter
    </a>
  </div>

  {{-- KANAN: Unduh --}}
  <div class="ft-right">
    <a href="{{ $finalDownload }}" class="ft-btn ft-download">
      <span class="ft-ic" aria-hidden="true">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
          <path d="M12 3v10m0 0l4-4m-4 4l-4-4" stroke="#0ea5e9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M4 17h16v4H4z" stroke="#0ea5e9" stroke-width="2"/>
        </svg>
      </span>
      Unduh
    </a>
  </div>

  {{-- POPUP TANGGAL --}}
  <div class="ft-pop" id="{{ $uid }}_pop" role="menu" aria-labelledby="{{ $uid }}_trigger" hidden>
    <div class="ft-pop-section">
      <div class="ft-pop-title">Pilih rentang</div>
      <div class="ft-list">
        <button type="button" class="ft-item {{ $preset==='this_year' ? 'active' : '' }}" data-preset="this_year">Tahun ini</button>
        <button type="button" class="ft-item {{ $preset==='last_year' ? 'active' : '' }}" data-preset="last_year">Tahun kemarin</button>
        <button type="button" class="ft-item {{ $preset==='custom' ? 'active' : '' }}" data-preset="custom">Custom range</button>
      </div>
    </div>

    <div class="ft-pop-section" id="{{ $uid }}_custom" hidden>
      <div class="ft-fields">
        <label for="{{ $uid }}_start">Dari</label>
        <input type="date" name="start_date" id="{{ $uid }}_start" value="{{ $start }}">
        <label for="{{ $uid }}_end">Sampai</label>
        <input type="date" name="end_date" id="{{ $uid }}_end" value="{{ $end }}">
      </div>
      <div class="ft-actions">
        <button type="button" class="ft-btn-red"  id="{{ $uid }}_cancel">Batal</button>
        <button type="submit" class="ft-btn-green" id="{{ $uid }}_save"
                onclick="document.getElementById('{{ $uid }}_preset').value='custom'">Simpan</button>
      </div>
    </div>
  </div>

  {{ $slot }}
</form>

<style>
/* layout wrapper */
.ft-toolbar{
  width:895px;
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:12px;
  padding:10px 14px;
  background:transparent; 
  border-radius:10px;
  margin-left:10px;
  margin-top:55px;
}

/* groups */
.ft-left,.ft-middle,.ft-right{display:flex; align-items:center; gap:8px;}
.ft-middle{flex:1; justify-content:flex-start; gap:10px;}
.ft-right{justify-content:flex-end}

/* buttons & inputs */
.ft-btn{
  appearance:none; border:1px solid #d1d5db; background:#fff;
  padding:6px 10px; border-radius:8px; cursor:pointer; font-size:12px;
  text-decoration:none; color:#111827; display:inline-flex; align-items:center; gap:6px;
  box-shadow:0 2px 4px rgba(107,105,105,.25)
}
.ft-btn:hover{background:#f8fafc}
.ft-icon-btn{
  border:1px solid #d1d5db; background:#fff; padding:6px 8px; border-radius:8px; cursor:pointer;
  display:inline-flex; align-items:center; justify-content:center; box-shadow:0 2px 4px rgba(107,105,105,.25)
}
.ft-clear{color:#1f2937}
.ft-download{font-weight:500}

/* date trigger */
.ft-btn.ft-date .ft-ic svg{display:block;width:14px;}
.ft-caret{opacity:.7}

/* selects */
.ft-field{display:flex; align-items:center; gap:6px}
.ft-field label{font-size:12px; color:#111827}
.ft-select{
  border:1px solid #d1d5db; border-radius:8px; padding:6px 8px; font-size:12px;
  min-width:180px; box-shadow:0 2px 4px rgba(107,105,105,.25)
}

/* popover */
.ft-pop{position:fixed; z-index:999; top:100%; left:14px; margin-top:6px;
  min-width:240px; max-width:min(92vw,340px); background:#fff; border:1px solid #e5e7eb;
  border-radius:8px; box-shadow:0 12px 28px rgba(0,0,0,.08); padding:8px;}
.ft-pop-section+.ft-pop-section{border-top:1px solid #f1f5f9; margin-top:6px; padding-top:8px}
.ft-pop-title{font-size:12px; color:#6b7280; margin:2px 0 8px}
.ft-list{display:flex; flex-direction:column; gap:4px}
.ft-item{border:1px solid #e5e7eb; background:#fff; border-radius:8px; padding:8px 10px; text-align:left; cursor:pointer; font-size:12px}
.ft-item:hover{background:#f9fafb}
.ft-item.active{border-color:#0066B0; background:#eff6ff}

/* custom range */
.ft-fields{display:grid; grid-template-columns:auto 1fr; gap:6px; align-items:center; margin-top:4px; font-size:12px}
.ft-fields input[type="date"]{border:1px solid #d1d5db; border-radius:8px; padding:6px 8px; font-size:12px; height:28px; width:170px}
.ft-actions{display:flex; justify-content:flex-end; gap:8px; margin-top:10px}
.ft-btn-red{appearance:none;border:1px solid #EA2828;background:#EA2828;color:#fff;padding:6px 10px;border-radius:8px;cursor:pointer;font-size:12px;box-shadow:0 2px 4px rgba(107,105,105,.25); min-width:70px; max-height:28px}
.ft-btn-red:hover{filter:brightness(.95)}
.ft-btn-green{appearance:none;border:1px solid #25E11B;background:#25E11B;color:#fff;padding:8px 12px;border-radius:8px;cursor:pointer;font-size:12px;box-shadow:0 2px 4px rgba(107,105,105,.25); min-width:70px; max-height:28px}
.ft-btn-green:hover{filter:brightness(.95)}

/* responsive */
@media (max-width:800px){
  .ft-toolbar{flex-wrap:wrap; gap:10px}
  .ft-left{order:1} .ft-middle{order:3; width:100%; flex-wrap:wrap}
  .ft-right{order:2; margin-left:auto}
}
@media (max-width:480px){
  .ft-fields{grid-template-columns:1fr 1fr}
  .ft-fields label{display:none}
}
</style>

<script>
(function(){
  const form   = document.getElementById('{{ $uid }}_form');
  const trig   = document.getElementById('{{ $uid }}_trigger');
  const pop    = document.getElementById('{{ $uid }}_pop');
  const preset = document.getElementById('{{ $uid }}_preset');
  const start  = document.getElementById('{{ $uid }}_start');
  const end    = document.getElementById('{{ $uid }}_end');
  const customBox = document.getElementById('{{ $uid }}_custom');
  const btnSave   = document.getElementById('{{ $uid }}_save');
  const btnCancel = document.getElementById('{{ $uid }}_cancel');
  const autoSubmit = @json((bool)$submitOnChange);

  const pad = n => String(n).padStart(2,'0');
  const fmt = d => d.getFullYear()+'-'+pad(d.getMonth()+1)+'-'+pad(d.getDate());

  function openPop(){
    pop.hidden=false; trig.setAttribute('aria-expanded','true');
    setTimeout(()=>document.addEventListener('click', onDocClick),0);
    document.addEventListener('keydown', onEsc);
  }
  function closePop(){
    pop.hidden=true; trig.setAttribute('aria-expanded','false');
    document.removeEventListener('click', onDocClick);
    document.removeEventListener('keydown', onEsc);
  }
  function onDocClick(e){ if(!pop.contains(e.target) && e.target!==trig){ closePop(); } }
  function onEsc(e){ if(e.key==='Escape'){ closePop(); } }

  trig.addEventListener('click', ()=> pop.hidden ? openPop() : closePop());

  pop.querySelectorAll('.ft-item[data-preset]').forEach(btn=>{
    btn.addEventListener('click', ()=>{
      const v = btn.dataset.preset;
      preset.value = v;

      const showCustom = (v==='custom');
      customBox.hidden = !showCustom;

      if (v==='this_year' || v==='last_year') {
        const now = new Date();
        const year = v==='this_year' ? now.getFullYear() : now.getFullYear()-1;
        const from = new Date(year,0,1);
        const to   = new Date(year,11,31);
        if (start) start.value = fmt(from);
        if (end)   end.value   = fmt(to);
        if (autoSubmit) form.submit();
      }
    });
  });

  [start,end].forEach(inp=>inp && inp.addEventListener('change', ()=>{
    if(start.value && end.value && end.value < start.value){
      end.value = start.value;
    }
  }));

  if (btnCancel) btnCancel.addEventListener('click', closePop);

  if (btnSave){
    btnSave.addEventListener('click', ()=>{
      if (@json((bool)$submitOnChange)) form.submit();
    });
  }

  // optional autosubmit on dropdown change
  if (autoSubmit) {
    const jenis = document.getElementById('{{ $uid }}_jenis');
    const status = document.getElementById('{{ $uid }}_status');
    [jenis, status].forEach(el => el && el.addEventListener('change', ()=>form.submit()));
  }
})();
</script>
