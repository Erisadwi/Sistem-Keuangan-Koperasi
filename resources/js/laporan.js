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

    document.querySelectorAll('.menu-head.no-sub').forEach(link => {
        link.addEventListener('click', () => {
            link.classList.toggle('active');
        });
    });
});
