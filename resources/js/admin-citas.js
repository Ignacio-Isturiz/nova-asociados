import DataTable from 'datatables.net';
import 'datatables.net-dt/css/dataTables.dataTables.css';

function initCitasDT(root = document) {
  const el = root.querySelector ? root.querySelector('#citasTable') : document.getElementById('citasTable');
  if (!el || el.dataset.dtInited) return;

  el.dataset.dtInited = '1';

  new DataTable(el, {
    ajax: el.dataset.endpoint,
    deferRender: true,
    responsive: true,
    scrollX: true,
    /* 👇 hace la tabla más "bajita" y manejable */
    scrollY: '42vh',
    scrollCollapse: true,
    pageLength: 5,
    lengthMenu: [5, 10, 25],
    order: [[1, 'desc'], [2, 'desc']],
    columns: [
      { data: 'id' }, { data: 'fecha' }, { data: 'hora' }, { data: 'cliente' },
      { data: 'email' }, { data: 'proyecto' }, { data: 'telefono' },
      { data: 'estado', render: (d) => `<span class="badge ${(d||'').toLowerCase()}">${d}</span>` },
      { data: 'notas' }, { data: 'created' },
      { data: null, orderable:false, searchable:false,
        render: (row) => `
          <div style="display:flex;gap:.5rem;white-space:nowrap">
            <a href="/citas/${row.id}/editar" class="btn-link">Editar</a>
            <a href="/citas/${row.id}" class="btn-link">Ver</a>
          </div>`
      }
    ],
    /* 👇 una sola barra: pageLength (izq) y search (der) */
    layout: {
      topStart: 'pageLength',
      topEnd: 'search',
      bottomStart: 'info',
      bottomEnd: 'paging'
    },
    language: {
      processing:"Procesando...", search:"Buscar:", lengthMenu:"Mostrar _MENU_",
      info:"Mostrando _START_ a _END_ de _TOTAL_", infoEmpty:"Mostrando 0 a 0 de 0",
      infoFiltered:"(filtrado de _MAX_ en total)", loadingRecords:"Cargando...",
      zeroRecords:"No hay registros", emptyTable:"No hay datos disponibles",
      paginate:{ first:"Primero", previous:"Anterior", next:"Siguiente", last:"Último" },
      aria:{ sortAscending:": activar asc", sortDescending:": activar desc" }
    }
  });
}

document.addEventListener('DOMContentLoaded', () => initCitasDT());
document.addEventListener('nova:content:loaded', (e) => initCitasDT(e.detail?.root || document));

window.initCitasDT = initCitasDT;
