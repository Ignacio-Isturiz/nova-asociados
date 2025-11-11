@php
    $horas = [
        '08:00','08:30','09:00','09:30','10:00','10:30',
        '11:00','11:30','12:00','12:30','13:00','13:30',
        '14:00','14:30','15:00','15:30','16:00','16:30','17:00',
    ];
    $modalId = 'modal-cita-' . ($proyecto->id ?? 'x');
@endphp

<div id="{{ $modalId }}" class="cita-modal-overlay" style="display:none;">
    <div class="cita-modal">
        <div class="cita-modal-header">
            <h3>Agendar visita — {{ $proyecto->nombre ?? 'Proyecto' }}</h3>
            <button type="button" onclick="document.getElementById('{{ $modalId }}').style.display='none'">✕</button>
        </div>

        <!-- Alerta de error (si existe) -->
        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <!-- Alerta de éxito (si existe) -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('citas.store') }}" method="POST">
            @csrf
            <input type="hidden" name="proyecto_id" value="{{ $proyecto->id }}">

            <div class="field">
                <label>Nombre</label>
                <input type="text" value="{{ auth()->user()->name }}" readonly>
            </div>

            <div class="field">
                <label>Correo</label>
                <input type="email" value="{{ auth()->user()->email }}" readonly>
            </div>

            <div class="field">
                <label for="telefono_contacto">Teléfono</label>
                <input type="text" name="telefono_contacto" id="telefono_contacto" value="{{ old('telefono_contacto') }}">
            </div>

            <div class="field">
                <label for="fecha">Fecha *</label>
                <input type="date" name="fecha" id="fecha" min="{{ now()->toDateString() }}" required>
            </div>

            <div class="field">
                <label for="hora">Hora *</label>
                <select name="hora" id="hora" required>
                    @foreach($horas as $h)
                        <option value="{{ $h }}">{{ $h }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn-agendar">Agendar</button>
        </form>
    </div>
</div>


<!-- Script para mostrar el modal de éxito o error -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Verifica si hay un mensaje de éxito
        @if(session('success'))
            setTimeout(function() {
                alert('¡Cita agendada con éxito!');
                document.getElementById('{{ $modalId }}').style.display = 'none'; // Cierra el modal
            }, 2000);
        @endif

        // Verifica si hay un mensaje de error
        @if(session('error'))
            setTimeout(function() {
                alert('{{ session('error') }}');
            }, 2000);
        @endif
    });
</script>
