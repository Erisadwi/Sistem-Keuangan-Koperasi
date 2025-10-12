@props([
  'action'         => request()->url(),
  'start'          => request('start_date'),
  'end'            => request('end_date'),
  'preset'         => request('preset'),
  'method'         => 'GET',
  'submitOnChange' => false,
  'id'             => null,
  'compact'        => true,
])

@php
  use Illuminate\Support\Str;
  $uid = $id ?: 'df_'.Str::random(6);

  $label = 'Tanggal';
  if ($preset === 'this_year')   $label = 'Tanggal';
  if ($preset === 'last_year')   $label = 'Tanggal';
  if ($preset === 'custom' && ($start || $end)) $label = 'Tanggal';
@endphp

<form method="{{ strtoupper($method)==='POST' ? 'POST' : 'GET' }}"
      action="{{ $action }}"
      id="{{ $uid }}_form"
      class="df-inline {{ $compact ? 'df-compact' : '' }}">
  @if (strtoupper($method)==='POST') @csrf @endif

  <input type="hidden" name="preset" id="{{ $uid }}_preset" value="{{ $preset }}">

  <div class="df-row">

    <button type="button" class="df-btn df-date" id="{{ $uid }}_trigger" aria-haspopup="true" aria-expanded="false">
      <span class="df-ic" aria-hidden="true">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
          <rect x="3" y="4" width="18" height="17" rx="3" stroke="#0ea5e9" stroke-width="2"/>
          <path d="M8 2v4M16 2v4M3 10h18" stroke="#0ea5e9" stroke-width="2" stroke-linecap="round"/>
        </svg>
      </span>
      <span class="df-label">{{ $label }}</span>
      <span class="df-caret" aria-hidden="true">▾</span>
    </button>

    <a class="df-btn df-danger" href="{{ $action }}">
      <span class="df-ic" aria-hidden="true">
        {{-- X (SVG) --}}
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
          <path d="M6 6l12 12M18 6L6 18" stroke="#2563eb" stroke-width="2" stroke-linecap="round"/>
        </svg>
      </span>
      Hapus Filter
    </a>
  </div>

  <div class="df-pop" id="{{ $uid }}_pop" role="menu" aria-labelledby="{{ $uid }}_trigger" hidden>
    <div class="df-pop-section">
      <div class="df-pop-title">Pilih rentang</div>
      <div class="df-list">
        <button type="button" class="df-item {{ $preset==='this_year' ? 'active' : '' }}" data-preset="this_year">
          <span>Tahun ini</span>
        </button>
        <button type="button" class="df-item {{ $preset==='last_year' ? 'active' : '' }}" data-preset="last_year">
          <span>Tahun kemarin</span>
        </button>
        <button type="button" class="df-item {{ $preset==='custom' ? 'active' : '' }}" data-preset="custom">
          <span>Custom range</span>
        </button>
      </div>
    </div>

    <div class="df-pop-section" id="{{ $uid }}_custom" hidden>
      <div class="df-fields">
        <label for="{{ $uid }}_start">Dari</label>
        <input type="date" name="start_date" id="{{ $uid }}_start" value="{{ $start }}">
        <label for="{{ $uid }}_end">Sampai</label>
        <input type="date" name="end_date" id="{{ $uid }}_end" value="{{ $end }}">
      </div>
      <div class="df-actions">
        <button type="button" class="df-btn-red"  id="{{ $uid }}_cancel">Batal</button>
        <button type="submit" class="df-btn-green" id="{{ $uid }}_save"
                onclick="document.getElementById('{{ $uid }}_preset').value='custom'">Simpan</button>
      </div>
    </div>
  </div>

  {{ $slot }}
</form>

<style>
  .df-inline{display:inline-block;position:relative}
  .df-row{display:flex;gap:8px;align-items:center; margin-top:65px;margin-left:22px;}

  .df-btn{appearance:none;border:1px solid #d1d5db;background:#ffffff;
    padding:5px 6px;border-radius:8px;cursor:pointer;font-size:12px;line-height:1.2;
    text-decoration:none;color:#111827;display:inline-flex;align-items:center;gap:6px;
    box-shadow:0 2px 4px rgba(107, 105, 105, 0.647)
  }
  .df-btn:hover{background:#f8fafc}
  .df-btn.df-date .df-ic svg{display:block;width: 14px; }
  .df-caret{opacity:.7}
  .df-btn.df-danger{color:#1f2937;border-color:#d1d5db}
  .df-btn.df-danger .df-ic svg{display:block}

  .df-pop{position:absolute;z-index:40;top:100%;left:0;margin-top:6px;min-width:220px;max-width:min(92vw,320px);
    background:#fff;border:1px solid #e5e7eb;border-radius:8px;box-shadow:0 12px 28px rgba(0,0,0,.08);padding:8px}
  .df-pop-section+.df-pop-section{border-top:1px solid #f1f5f9;margin-top:6px;padding-top:8px}
  .df-pop-title{font-size:12px;color:#6b7280;margin:2px 0 8px}

  .df-list{display:flex;flex-direction:column;gap:4px}
  .df-item{border:1px solid #e5e7eb;background:#ffffff;border-radius:8px;padding:8px 10px;text-align:left;cursor:pointer;font-size: 12px}
  .df-item:hover{background:#f9fafb}
  .df-item.active{border-color:#0066B0;background:#eff6ff}

  .df-fields{display:grid;grid-template-columns:auto 1fr;gap:6px;align-items:center;margin-top:4px;font-size:12px}
  .df-fields input[type="date"]{border:1px solid #d1d5db;border-radius:8px;padding:6px 8px;font-size:12px; height: 28px;                       /* lebih kecil */
  width: 160px !important}
  .df-actions{display:flex;justify-content:flex-end;gap:8px;margin-top:10px}

  .df-btn-red{appearance:none;border:1px solid #EA2828;background:#EA2828;color:#fff;
    padding:6px 10px;border-radius:8px;cursor:pointer;font-size:12px;box-shadow:0 2px 4px rgba(107, 105, 105, 0.647); min-width: 70px; max-height:28px;margin-top:10px}
  .df-btn-red:hover{filter:brightness(.95)}
  .df-btn-green{appearance:none;border:1px solid #25E11B;background:#25E11B;color:#fff;
    padding:8px 12px;border-radius:8px;cursor:pointer;font-size:12px; box-shadow:0 2px 4px rgba(107, 105, 105, 0.647); min-width: 70px; max-height:28px;margin-top:10px}
  .df-btn-green:hover{filter:brightness(.95)}

  @media (max-width:480px){
    .df-fields{grid-template-columns:1fr 1fr}
    .df-fields label{display:none}
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

  pop.querySelectorAll('.df-item[data-preset]').forEach(btn=>{
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

  if (btnCancel){
    btnCancel.addEventListener('click', ()=>{
      closePop();
    });
  }

  if (btnSave){
    btnSave.addEventListener('click', ()=>{
      if (@json((bool)$submitOnChange)) {
        form.submit();
      } 
    });
  }
})();
</script>