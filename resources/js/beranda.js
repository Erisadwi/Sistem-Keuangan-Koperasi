document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-toggle="collapse"]').forEach(btn => {
    const panel = document.querySelector(btn.getAttribute('data-target'));
    const open = panel.classList.contains('open');
    panel.style.maxHeight = open ? panel.scrollHeight + 'px' : '0px';
    btn.setAttribute('aria-expanded', open ? 'true' : 'false');

    btn.addEventListener('click', () => {
      const isOpen = panel.classList.toggle('open');
      btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      panel.style.maxHeight = isOpen ? panel.scrollHeight + 'px' : '0px';
    });
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const btn = document.getElementById('btnNotif');
  if (!btn) return;

  const badge = document.getElementById('notifBadge');
  const url = btn.dataset.targetUrl; 

  btn.addEventListener('click', () => {
    if (badge) badge.hidden = true;
    if (url) window.location.href = url;
  });
});

document.getElementById('refreshPage')?.addEventListener('click', () => {
  
  const btn = document.getElementById('refreshPage');
  btn.disabled = true; btn.textContent = 'Memuat…';
  location.reload(); // reload full page
});
