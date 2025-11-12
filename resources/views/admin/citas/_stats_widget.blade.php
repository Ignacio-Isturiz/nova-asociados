<div class="card" style="padding:1rem;">
  <div style="display:flex;justify-content:space-between;align-items:center;gap:.5rem">
    <h2 style="margin:0;">Estadísticas de Citas</h2>
    <a href="{{ route('admin.citas.stats') }}" class="btn" style="opacity:.8;">Pantalla completa</a>
  </div>

  <form id="stats-filters"
        data-url="{{ route('admin.citas.stats.data') }}"
        style="display:flex; gap:.5rem; align-items:center; margin:.75rem 0 1rem;">
    <label>Desde
      <input type="date" name="from" id="from">
    </label>
    <label>Hasta
      <input type="date" name="to" id="to">
    </label>
    <button type="button" id="apply" class="btn">Aplicar</button>
    <button type="button" id="clear" class="btn" style="opacity:.8;">Limpiar</button>
  </form>

  <div class="chart-wrap" style="background:#fff; border-radius:12px; padding:1rem;">
    <canvas id="citasChart" height="120"></canvas>
  </div>
</div>
