@extends('layouts.admin')
@section('title', 'Estadísticas de Citas')

@section('content')
  @include('admin.citas._stats_widget')
@endsection

@push('scripts')
  @vite('resources/js/admin-citas-chart.js')
@endpush
