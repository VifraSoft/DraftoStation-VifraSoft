{{-- resources/views/draftostation/juego.blade.php --}}
@extends('layouts.app')

@section('title', 'Partida - DraftoStation')

@push('styles')
  {{-- Bootstrap Icons (si ya las cargás globalmente, podés quitar esta línea) --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <link rel="stylesheet"
        href="{{ asset('css/draftostation-game.css') }}?v={{ file_exists(public_path('css/draftostation-game.css')) ? filemtime(public_path('css/draftostation-game.css')) : time() }}">
@endpush

@section('content')
{{-- importante para CSRF si usas rutas web con sesión --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="drafto-wrap">
  <div class="container-fluid py-3">
    <div class="row g-3 align-items-start">

      {{-- Izquierda: Información de ronda --}}
      <div class="col-12 col-md-2">
        <div class="panel p-3 h-100">
          <h5 class="title mb-3">Información de ronda</h5>

          <div class="mb-3">
            <label class="form-label">Ronda</label>
            <input id="roundInput" type="number" class="form-control" value="1" min="1" />
          </div>

          <div class="mb-3">
            <label class="form-label">Turno</label>
            <input id="turnInput" type="number" class="form-control" value="1" min="1" />
          </div>

          <div class="mb-3">
            <label class="form-label">Nuevo jugador</label>
            <div class="input-group">
              <input id="newPlayerName" type="text" class="form-control" placeholder="Nombre">
              <button id="btnAddPlayer" class="btn btn-success" type="button">+</button>
            </div>
            <div id="playerList" class="small text-secondary mt-2"></div>
          </div>

          <div class="mb-3">
            <label class="form-label">Jugador activo</label>
            <select id="activePlayer" class="form-select"></select>
          </div>

          <div class="mb-3 text-center">
            <span id="activePlayerIndicator" class="fw-bold small"></span>
          </div>

          <div class="d-grid gap-2">           

            {{-- NUEVO: Enviar resultados (antes "Reiniciar") --}}
            <button id="btnSendResults" class="btn btn-outline-light">
              <i class="bi bi-upload"></i> Guardar resultados
            </button>
          </div>
        </div>
      </div>

      {{-- Centro: Mapa (DnD) --}}
      <div class="col-12 col-md-7">
        <div class="panel p-3 h-150">

          <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="title mb-0">Mapa</h5>
            <span class="text-secondary small">Arrastrá iconos desde la derecha y soltá en una región</span>
          </div>

          {{-- root con board-id para que el JS lo lea --}}
          <div id="boardRoot" data-board-id="default">
            <div id="map" class="map-grid">

              <div class="card p-2" data-region="circuito_uniforme">
                <div class="d-flex align-items-center justify-content-between">
                  <strong class="region-title">Circuito Uniforme</strong>                 
                </div>
                <div class="dropzone" data-region="circuito_uniforme" data-cap="9999"></div>
              </div>

              <div class="card p-2" data-region="pixeles_variados">
                <div class="d-flex align-items-center justify-content-between">
                  <strong class="region-title">Pixeles Variados</strong>
                 
                </div>
                <div class="dropzone" data-region="pixeles_variados" data-cap="9999"></div>
              </div>

              <div class="card p-2" data-region="cuartel_multijugador">
                <div class="d-flex align-items-center justify-content-between">
                  <strong class="region-title">Cuartel Multijugador</strong>
                  
                </div>
                <div class="dropzone" data-region="cuartel_multijugador"data-cap="9999"></div>
              </div>

              <div class="card p-2" data-region="triple_a">
                <div class="d-flex align-items-center justify-content-between">
                  <strong class="region-title">Triple A</strong>
                
                </div>
                <div class="dropzone" data-region="triple_a" data-cap="9999"></div>
              </div>

              <div class="card p-2" data-region="consola_del_año">
                <div class="d-flex align-items-center justify-content-between">
                  <strong class="region-title">Consola del Año</strong>
                 
                </div>
                <div class="dropzone" data-region="consola_del_año" data-cap="9999"></div>
              </div>

              <div class="card p-2" data-region="edicion_limitada">
                <div class="d-flex align-items-center justify-content-between">
                  <strong class="region-title">Edición Limitada</strong>
                 
                </div>
                <div class="dropzone" data-region="edicion_limitada" data-cap="9999"></div>
              </div>

              <div class="card p-2" data-region="taller">
                <div class="d-flex align-items-center justify-content-between">
                  <strong class="region-title">Taller</strong>
                  
                </div>
                <div class="dropzone" data-region="taller" data-cap="9999"></div>
              </div>

            </div>
          </div>
        </div>
      </div>

      {{-- Derecha: Iconos y Score --}}
      <div class="col-12 col-md-3">
        <div class="panel p-3 mb-3">
          <div class="d-flex align-items-center justify-content-between">
            <h5 class="title mb-0">Iconos / Fichas</h5>
          </div>
          <div id="iconTray" class="d-flex flex-wrap gap-2">
            {{-- se llena por JS --}}
          </div>
          <div class="form-text mt-2">Arrastrá cualquiera de estos iconos al mapa</div>
        </div>

        <div class="panel p-3">
          {{-- NUEVO: botón “Histórico” en el header --}}
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="title mb-0">Score</h5>
            <a id="btnHistory"
              class="btn btn-sm btn-outline-light"
              href="{{ route('drafto.results.history') }}"
              role="button"
              title="Ver histórico">
              <i class="bi bi-clock-history"></i> Histórico
          </a>
          </div>

          <div class="table-responsive">
            <table class="table table-dark table-sm align-middle score-table mb-0">
              <thead>
                <tr>
                  <th>Jugador</th>
                  <th class="text-end">Pts</th>
                </tr>
              </thead>
              <tbody id="scoreBody"></tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
  <script src="{{ asset('js/draftostation-game.js') }}?v={{ file_exists(public_path('js/draftostation-game.js')) ? filemtime(public_path('js/draftostation-game.js')) : time() }}"></script>
@endpush
