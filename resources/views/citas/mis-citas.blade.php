@extends('layouts.proyecto')

<style>
  :root {
    --slate-50: #f8fafc;
    --slate-100: #f1f5f9;
    --slate-200: #e2e8f0;
    --slate-600: #475569;
    --slate-700: #334155;
    --slate-800: #1f2937;
    --slate-900: #0f172a;
    --white: #fff;
    --green-100: #dcfce7;
    --green-700: #15803d;
    --yellow-100: #fef9c3;
    --yellow-700: #a16207;
    --red-100: #fee2e2;
    --red-700: #b91c1c;
    --blue-50: #eff6ff;
    --blue-600: #2563eb;
    --red-50: #fef2f2;
    --red-600: #dc2626;
    --radius: 16px;
    --shadow: 0 10px 25px rgba(15, 23, 42, .08), 0 2px 6px rgba(15, 23, 42, .06);
  }

  /* Cabecera de tabla en gris (sin gradiente) */
  .table.table-bordered thead.table-dark th {
    background: var(--slate-700) !important; /* gris sólido */
    color: #fff !important;
    border-color: transparent !important;
    font-weight: 700;
    letter-spacing: .3px;
    padding: 16px 24px !important;
    text-align: center; /* Centrado horizontal de los títulos */
    vertical-align: middle; /* Centrado vertical de los títulos */
  }

  /* Bordes redondeados en la tabla */
  .table.table-bordered {
    border-collapse: separate; /* Para que los bordes redondeados se vean */
    border-radius: var(--radius) !important; /* Bordes redondeados en la tabla */
    overflow: hidden; /* Para evitar que los bordes se corten */
    box-shadow: var(--shadow); /* Opcional: agregar sombra a la tabla */
  }



  /* Bordes entre celdas */
  .table.table-bordered td, .table.table-bordered th {
    border-left: 1px solid var(--slate-200); /* Borde izquierdo de cada celda */
    border-right: 1px solid var(--slate-200); /* Borde derecho de cada celda */
  }

  /* Botones de acción: look más suave sin romper Bootstrap */
  .btn.btn-primary.btn-sm.btn-fixed {
    background: var(--blue-50);
    color: var(--blue-600);
    border: 1px solid rgba(37, 99, 235, .25);
  }
  /* Clase para el texto 'sinacciones' */

</style>



@section('content')
    @include('partials.navbar-nova')

    <div class="container d-flex justify-content-center" style="margin-top:6rem; min-height: calc(100vh - 6rem);">
        <div class="table-container w-100">
            <h2 class="text-center mb-4">Mis Citas Agendadas</h2>

            @if($citas->isEmpty())
                <p class="text-center">No tienes citas agendadas.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>Proyecto</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($citas as $cita)
                                @php
                                    $fechaHoraCita = \Carbon\Carbon::parse($cita->fecha . ' ' . $cita->hora);
                                    $ahora = \Carbon\Carbon::now();
                                @endphp
                                <tr>
                                    <td>{{ $cita->proyecto->nombre ?? '-' }}</td>
                                    <td>{{ $cita->fecha }}</td>
                                    <td>{{ $cita->hora }}</td>
                                    <td>{{ ucfirst($cita->estado) }}</td>
                                    <td class="d-flex justify-content-center gap-2">
                                      @if(strtolower($cita->estado) !== 'cancelada')
                                          @can('update', $cita)
                                              <button class="btn btn-primary btn-sm btn-fixed" data-bs-toggle="modal" data-bs-target="#editarModal{{ $cita->id }}">
                                                  Editar
                                              </button>
                                          @endcan
                                          @can('cancel', $cita)
                                              <button class="btn btn-primary btn-sm btn-fixed" style="background-color: rgba(220, 38, 38, 0.1); border-color: #dc2626; color: #000;" data-bs-toggle="modal" data-bs-target="#cancelModal{{ $cita->id }}">
                                                  Cancelar
                                              </button>
                                          @endcan
                                      @else
                                          <span>-- sin acciones --</span>
                                      @endif
                                  </td>


                                    {{-- Modal Editar --}}
                                    <div class="modal fade" id="editarModal{{ $cita->id }}" tabindex="-1" aria-labelledby="editarModalLabel{{ $cita->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content rounded-3 shadow-lg">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title" id="editarModalLabel{{ $cita->id }}">Editar Cita</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                </div>
                                                <form action="{{ route('citas.update', $cita) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label>Fecha</label>
                                                            <input type="date" name="fecha" class="form-control" value="{{ $cita->fecha }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Hora</label>
                                                            <select name="hora" class="form-control" required>
                                                                @foreach($horasDisponibles as $hora)
                                                                    <option value="{{ $hora }}" @if($cita->hora == $hora) selected @endif>{{ $hora }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Modal Cancelar --}}
                                    <div class="modal fade" id="cancelModal{{ $cita->id }}" tabindex="-1" aria-labelledby="cancelModalLabel{{ $cita->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content rounded-3 shadow-lg">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title" id="cancelModalLabel{{ $cita->id }}">Confirmar Cancelación</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <p>¿Estás seguro que deseas cancelar la cita para <strong>{{ $cita->proyecto->nombre ?? '-' }}</strong> el {{ $cita->fecha }} a las {{ $cita->hora }}?</p>
                                                </div>
                                                <div class="modal-footer justify-content-center">
                                                    <form action="{{ route('citas.cancelar', $cita) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Sí, cancelar</button>
                                                    </form>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    @endsection
