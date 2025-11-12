import Chart from 'chart.js/auto';

const form = document.getElementById('stats-filters');
const btnApply = document.getElementById('apply');
const btnClear = document.getElementById('clear');
const ctx = document.getElementById('citasChart');

if (form && ctx) {
  let chart;

  const buildUrl = () => {
    const base = form.dataset.url;
    const from = document.getElementById('from').value || '';
    const to = document.getElementById('to').value || '';
    const params = new URLSearchParams();
    if (from) params.set('from', from);
    if (to) params.set('to', to);
    return params.toString() ? `${base}?${params.toString()}` : base;
  };

  async function loadData() {
    const res = await fetch(buildUrl(), { headers: { 'Accept': 'application/json' }});
    const data = await res.json();

    const labels = data.by_month.labels || [];
    const total = data.by_month.total || [];
    const series = data.by_month.series || {}; // { estado: [..] }

    // Si ya existe, destruir para re-crear con nuevos datos
    if (chart) {
      chart.destroy();
    }

    // Construir datasets: una barra por estado y una línea con total
    const datasets = Object.entries(series).map(([estado, values]) => ({
      type: 'bar',
      label: estado.toUpperCase(),
      data: values,
      borderWidth: 1
    }));

    datasets.push({
      type: 'line',
      label: 'TOTAL',
      data: total,
      borderWidth: 2,
      tension: 0.3
    });

    chart = new Chart(ctx, {
      data: {
        labels,
        datasets
      },
      options: {
        responsive: true,
        plugins: {
          legend: { position: 'top' },
          title: { display: true, text: 'Citas por mes y por estado' },
          tooltip: { mode: 'index', intersect: false }
        },
        scales: {
          x: { stacked: true },
          y: { beginAtZero: true, stacked: true }
        }
      }
    });
  }

  btnApply?.addEventListener('click', loadData);
  btnClear?.addEventListener('click', () => {
    document.getElementById('from').value = '';
    document.getElementById('to').value = '';
    loadData();
  });

  // Carga inicial
  loadData();
}
