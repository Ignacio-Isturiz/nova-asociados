@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
  <h1 style="margin-bottom:1rem;">Dashboard</h1>

  {{-- Chart de Citas directamente en el dashboard --}}
  @include('admin.citas._stats_widget')
@endsection

@push('scripts')
  {{-- Reusa el mismo JS de estadísticas --}}
  @vite('resources/js/admin-citas-chart.js')
@endpush
