@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h1 style="margin-bottom:1rem;">Dashboard</h1>
    <div class="card">
        Bienvenido, {{ auth()->user()->name }}. Este es el panel de administración.
    </div>
@endsection