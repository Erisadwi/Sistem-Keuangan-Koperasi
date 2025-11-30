document.addEventListener('DOMContentLoaded', () => {

  document.querySelectorAll('[data-toggle="collapse"]').forEach(btn => {
    const panel = document.querySelector(btn.getAttribute('data-target'));

    const open = panel.classList.contains('open');
    panel.style.maxHeight = open ? panel.scrollHeight + 'px' : '0px';
    btn.setAttribute('aria-expanded', open ? 'true' : 'false');

    btn.addEventListener('click', () => {
      const isOpen = panel.classList.contains('open');

      panel.classList.toggle('open', !isOpen);
      panel.style.maxHeight = !isOpen ? panel.scrollHeight + 'px' : '0px';
      btn.setAttribute('aria-expanded', !isOpen ? 'true' : 'false');
    });
  });

  document.querySelectorAll('.menu-head.no-sub').forEach(link => {
    if(link.href === window.location.href){
      link.classList.add('active');
    }
  });

  document.querySelectorAll('.submenu a').forEach(link => {
    if(link.href === window.location.href){
      link.classList.add('active');

      const parentPanel = link.closest('.submenu');
      parentPanel.classList.add('open');
      parentPanel.style.maxHeight = parentPanel.scrollHeight + 'px';

      const parentBtn = document.querySelector(`[data-target="#${parentPanel.id}"]`);
      if(parentBtn) parentBtn.setAttribute('aria-expanded', 'true');
    }
  });

});
