{{-- Modal para agendar cita --}}
@php
    // horas disponibles cada 30 minutos 8:00 - 17:00
    $horas = [
        '08:00', '08:30',
        '09:00', '09:30',
        '10:00', '10:30',
        '11:00', '11:30',
        '12:00', '12:30',
        '13:00', '13:30',
        '14:00', '14:30',
        '15:00', '15:30',
        '16:00', '16:30',
        '17:00',
    ];

    // por si algún día incluyes el mismo modal 2 veces en la misma página
    $modalId = 'modal-cita-' . ($proyecto->id ?? 'x');
@endphp

<div id="{{ $modalId }}" class="cita-modal-overlay" style="display:none;">
    <div class="cita-modal">
        <div class="cita-modal-header">
            <h3>Agendar visita — {{ $proyecto->nombre ?? 'Proyecto' }}</h3>
            <button type="button" onclick="document.getElementById('{{ $modalId }}').style.display='none'">
                ✕
            </button>
        </div>

        {{-- mensajes de sesión --}}
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('citas.store') }}" method="POST">
            @csrf
            <input type="hidden" name="proyecto_id" value="{{ $proyecto->id }}">

            {{-- nombre (solo lectura) --}}
            <div class="field">
                <label>Nombre</label>
                <input type="text" value="{{ auth()->user()->name }}" readonly>
            </div>

            {{-- correo (solo lectura) --}}
            <div class="field">
                <label>Correo</label>
                <input type="email" value="{{ auth()->user()->email }}" readonly>
            </div>

            {{-- teléfono --}}
            <div class="field">
                <label for="telefono_contacto">Teléfono de contacto</label>
                <input type="text" name="telefono_contacto" id="telefono_contacto"
                       placeholder="Ej. 3001234567" value="{{ old('telefono_contacto') }}">
            </div>

            {{-- fecha --}}
            <div class="field">
                <label for="fecha">Fecha *</label>
                <input type="date" name="fecha" id="fecha"
                       min="{{ now()->toDateString() }}"
                       required>
            </div>

            {{-- hora --}}
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

{{-- estilos rápidos para el modal --}}
<style>
    .cita-modal-overlay{
        position:fixed;
        inset:0;
        background:rgba(0,0,0,.35);
        display:flex;
        align-items:center;
        justify-content:center;
        z-index:999;
        padding:1rem;
    }
    .cita-modal{
        background:#fff;
        border-radius:16px;
        max-width:420px;
        width:100%;
        padding:1.25rem 1.4rem 1.6rem;
        box-shadow:0 18px 40px rgba(0,0,0,.12);
    }
    .cita-modal-header{
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:1rem;
    }
    .cita-modal-header h3{
        margin:0;
        font-size:1.15rem;
    }
    .cita-modal-header button{
        border:none;
        background:transparent;
        font-size:1.1rem;
        cursor:pointer;
    }
    .field{
        margin-bottom:.8rem;
    }
    .field label{
        display:block;
        margin-bottom:.3rem;
        font-weight:500;
    }
    .field input,
    .field select{
        width:100%;
        padding:.55rem .6rem;
        border:1px solid #ddd;
        border-radius:8px;
    }
    .btn-agendar{
        width:100%;
        background:#a34700;
        color:#fff;
        border:none;
        padding:.65rem;
        border-radius:10px;
        font-weight:600;
        cursor:pointer;
    }
    .alert{
        padding:.4rem .6rem;
        border-radius:6px;
        margin-bottom:.7rem;
        font-size:.85rem;
    }
    .alert-error{background:#fde2e1;color:#9c2f2b;}
    .alert-success{background:#e1f5e6;color:#256333;}
</style>
