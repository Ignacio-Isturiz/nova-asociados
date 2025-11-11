import DataTable from 'datatables.net';
import 'datatables.net-dt/css/dataTables.dataTables.css';

function initUsersDT(root = document) {
  const el = root.querySelector ? root.querySelector('#usersTable') : document.getElementById('usersTable');
  if (!el || el.dataset.dtInited) return;
  el.dataset.dtInited = '1';

  new DataTable(el, {
    ajax: el.dataset.endpoint,
    deferRender: true,
    responsive: true,
    scrollX: true,          // permite que no se rompa pero evitamos scroll vertical de página
    // 👇 SIN scrollY para que no aparezca ningún scroll interno
    pageLength: 5,          // 4–5 filas suele caber sin hacer scroll de página
    lengthMenu: [5, 10, 25],
    order: [[4, 'desc']],   // por creado
    columns: [
      { data:'id' },
      { data:'name' },
      { data:'email' },
      { data:'role', render:(r)=> `<span class="role-badge">${r ?? '—'}</span>` },
      { data:'created' },
      { data:'updated' },
      { data:null, orderable:false, searchable:false,
        render:(row)=>`
          <div style="display:flex;gap:.5rem;white-space:nowrap">
            <a href="/admin/usuarios/${row.id}?fragment=1"
               data-partial
               data-target="#admin-dynamic"
               class="btn-link">Ver</a>
          </div>`
      }
    ],
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

document.addEventListener('DOMContentLoaded', () => initUsersDT());
document.addEventListener('nova:content:loaded', (e) => initUsersDT(e.detail?.root || document));

window.initUsersDT = initUsersDT;
