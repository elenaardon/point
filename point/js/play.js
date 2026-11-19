// Pestañas de la sección Play: muestra una función a la vez (sin JS se ven todas).
(function () {
  const tabs = [...document.querySelectorAll('.ptabs [data-tab]')], panels = [...document.querySelectorAll('.pp')];
  if (!tabs.length) return;
  function show(id) {
    if (!panels.some(p => p.id === id)) id = panels[0].id;
    panels.forEach(p => p.hidden = p.id !== id);
    tabs.forEach(t => { const on = t.dataset.tab === id; t.classList.toggle('on', on); t.setAttribute('aria-current', on ? 'true' : 'false'); });
  }
  tabs.forEach(t => t.addEventListener('click', e => { e.preventDefault(); history.replaceState(null, '', '#' + t.dataset.tab); show(t.dataset.tab); }));
  window.addEventListener('hashchange', () => show(location.hash.slice(1)));
  show(location.hash.slice(1));
})();
