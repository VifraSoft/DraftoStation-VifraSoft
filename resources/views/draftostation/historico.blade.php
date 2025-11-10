@extends('layouts.app')

@section('title', 'Histórico - DraftoStation')

@push('styles')
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    .drafto-wrap{ --bg:#0b1020; --panel:#0f1630; color:#e9edf1; background:var(--bg); min-height:100vh; }
    .panel{ background:var(--panel); border:1px solid rgba(255,255,255,.06); border-radius:.75rem; }
    .title{ color:#9db0ff; }
    .table thead th{ color:#9db0ff; text-transform:uppercase; font-size:.8rem; letter-spacing:.03em; }
  </style>
@endpush

@section('content')
<div class="drafto-wrap py-3">
  <div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="title m-0">Histórico de partidas</h3>
      <div class="d-flex gap-2">
        <a href="{{ url()->previous() }}" class="btn btn-outline-light">
          <i class="bi bi-arrow-left"></i> Volver
        </a>
      </div>
    </div>

    <div class="panel p-3">
      <div class="table-responsive">
        <table class="table table-dark table-sm align-middle mb-0">
          <thead>
            <tr>
             
              <th>Partida</th>
              <th>Jugador</th>
              <th class="text-end">Puntos (partida)</th>
              <th class="text-end">Total jugador</th>
            </tr>
          </thead>
          <tbody>
          @forelse($rows as $r)
            <tr>             
              <td>{{ $r['nombrePartida'] }}</td>
              <td>{{ $r['jugador'] }}</td>
              <td class="text-end">{{ $r['puntos'] }}</td>
              <td class="text-end">{{ $r['total'] }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center text-secondary">Sin registros aún.</td>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>
@endsection
