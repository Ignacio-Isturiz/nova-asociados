<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Citas — Exporte PDF</title>
<style>
  @page { margin: 24px 28px; }
  body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color:#111827; }
  h1 { font-size: 18px; margin: 0 0 6px; }
  .meta { font-size: 11px; color:#6b7280; margin-bottom: 12px; }
  table { width:100%; border-collapse: collapse; }
  th, td { border:1px solid #e5e7eb; padding:6px 8px; text-align:left; vertical-align: top; }
  thead th { background:#f3f4f6; }
  .badge { display:inline-block; padding:2px 6px; border-radius:999px; font-size:11px; border:1px solid #d1d5db; background:#e5e7eb; }
  .muted { color:#6b7280; }
</style>
</head>
<body>
  <h1>Citas</h1>
  <div class="meta">
    Generado: {{ $now->format('Y-m-d H:i') }} |
    Filtro: "{{ $q ?: '—' }}" |
    Orden: {{ $sort }} ({{ strtoupper($dir) }})
  </div>

  <table>
    <thead>
      <tr>
        <th>Fecha</th>
        <th>Hora</th>
        <th>Título</th>
        <th>Estado</th>
        <th>Usuario</th>
        <th>Proyecto</th>
        <th>Notas</th>
      </tr>
    </thead>
    <tbody>
      @forelse($citas as $c)
        <tr>
          <td>{{ \Illuminate\Support\Carbon::parse($c->fecha)->format('Y-m-d') }}</td>
          <td>{{ $c->hora }}</td>
          <td>{{ $c->titulo ?? '—' }}</td>
          <td><span class="badge">{{ $c->estado }}</span></td>
          <td>{{ $c->usuario?->name ?? $c->nombre_usuario ?? '—' }}</td>
          <td>{{ $c->proyecto?->nombre ?? '—' }}</td>
          <td class="muted">{{ \Illuminate\Support\Str::limit($c->notas ?? '—', 120) }}</td>
        </tr>
      @empty
        <tr><td colspan="7" class="muted">Sin resultados</td></tr>
      @endforelse
    </tbody>
  </table>
</body>
</html>
