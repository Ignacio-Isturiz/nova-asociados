function loadPartial(url, targetSelector = '#admin-dynamic') {
    const target = document.querySelector(targetSelector);
    if (!target) return;
  
    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
      .then(res => res.text())
      .then(html => {
        target.innerHTML = html;
        document.dispatchEvent(new CustomEvent('nova:content:loaded', { detail: { root: target } }));
      })
      .catch(console.error);
  }
  
  // Intercepta los enlaces con data-partial
  document.addEventListener('click', (e) => {
    const a = e.target.closest('a[data-partial]');
    if (!a) return;
  
    e.preventDefault();
    const target = a.dataset.target || '#admin-dynamic';
    loadPartial(a.href, target);
  });
  
  // Exponer por si quieres cargar por código
  window.novaLoadPartial = loadPartial;
  