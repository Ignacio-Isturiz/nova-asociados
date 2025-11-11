{{-- Modal de EDICIÓN (usa tus mismas clases/estilos del modal de agendar) --}}
<div id="citaEditOverlay" class="cita-modal-overlay d-none" role="dialog" aria-modal="true">
  <div class="cita-modal" role="document">
    <div class="cita-modal-header">
      <h3 class="m-0">Editar cita</h3>
      <button type="button" id="citaEditClose" aria-label="Cerrar">✕</button>
    </div>

    <div id="citaEditAlert" class="alert d-none"></div>

    {{-- Form actualizar (PUT /citas/{id}) --}}
    <form id="citaEditForm" method="POST" action="#">
      @csrf
      <input type="hidden" name="_method" value="PUT">
      <div class="field">
        <label>Proyecto</label>
        <input id="ceProyecto" type="text" readonly>
      </div>
      <div class="field">
        <label>Estado</label>
        <input id="ceEstado" type="text" readonly>
      </div>
      <div class="field">
        <label for="ceFecha">Fecha *</label>
        <input id="ceFecha" name="fecha" type="date" required>
      </div>
      <div class="field">
        <label for="ceHora">Hora *</label>
        <select id="ceHora" name="hora" required>
          @php
            $horas = [
              '08:00','08:30','09:00','09:30','10:00','10:30',
              '11:00','11:30','12:00','12:30','13:00','13:30',
              '14:00','14:30','15:00','15:30','16:00','16:30','17:00',
            ];
          @endphp
          @foreach($horas as $h)
            <option value="{{ $h }}">{{ $h }}</option>
          @endforeach
        </select>
      </div>
      <button type="submit" class="btn-agendar">Guardar cambios</button>
    </form>

    {{-- Form cancelar (DELETE /citas/{id}/cancelar) --}}
    <form id="citaCancelForm" method="POST" class="mt-2" action="#">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn-agendar" style="background:#dc2626">Cancelar cita</button>
    </form>
  </div>
</div>

<script>
  // Control del modal de edición
  window.CitaEditModal = (function(){
    const $ = (id) => document.getElementById(id);
    const overlay   = $('citaEditOverlay');
    const closeBtn  = $('citaEditClose');
    const alertBox  = $('citaEditAlert');

    const formEdit   = $('citaEditForm');
    const formCancel = $('citaCancelForm');

    const fProyecto = $('ceProyecto');
    const fEstado   = $('ceEstado');
    const fFecha    = $('ceFecha');
    const fHora     = $('ceHora');

    function show(){ overlay.classList.remove('d-none'); document.body.style.overflow = 'hidden'; }
    function hide(){ overlay.classList.add('d-none'); document.body.style.overflow = ''; }
    function setActions(id){
      formEdit.action   = `/citas/${id}`;
      formCancel.action = `/citas/${id}/cancelar`;
    }
    function fill(p){
      fProyecto.value = p.proyecto || '';
      fEstado.value   = p.estado   || '';
      fFecha.value    = p.fecha    || '';
      fHora.value     = (p.hora || '').substring(0,5);
    }

    closeBtn.onclick = hide;
    overlay.addEventListener('click', e => { if (e.target === overlay) hide(); });
    document.addEventListener('keydown', ev => { if (ev.key === 'Escape') hide(); });

    return {
      open(payload){
        alertBox.className = 'alert d-none';
        alertBox.textContent = '';
        setActions(payload.id);
        fill(payload);
        show();
      },
      close: hide
    }
  })();
</script>
