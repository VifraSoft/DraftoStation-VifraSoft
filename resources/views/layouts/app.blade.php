<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'VifraSoft')</title>
    @stack('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="{{asset('css/styles.css')}}">       -->
</head>
<body class="papuu">
  
  <header>
    <div class="container-fluid bg-dark">
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <img class="navbar-brand" src="{{ asset('img/VifraSoft_Logo-removebg-preview.png') }}" alt="Logo" height="100px" width="220px">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Menú">
            <span class="navbar-toggler-icon"></span>
          </button>
          
          <div class="collapse navbar-collapse" id="menu">
          
            
            @yield('navigation')
            
            
            @guest
            <div class="d-flex">
                <a href="/login" class="btn btn-outline-light me-2">Iniciar Sesión</a>
                <a href="/register" class="btn btn-primary">Registrarse</a>
            </div>
            @endguest               
            @auth
            <div class="d-flex align-items-center">
            <form method="POST" action="/logout">
                  @if(auth()->check() && !Request::is('admin*'))
                  <span class="text-light">Hola, {{ auth()->user()->nickname }}</span>
                  <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                  <button class="btn btn-danger">Cerrar sesión</button>
            </form>
          @endif

            </div>
            @endauth
          </div>
        </div>
      </nav>
    </div>
  </header>
  
  <main class="container mt-5"> {{-- Usamos <main> para el contenido principal --}}
    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif
    
    {{-- Aquí se inyectará el contenido principal de cada página --}}
    @yield('content')
    
  </main>
  
  {{-- FOOTER GENÉRICO --}}
  <footer class="bg-dark text-white text-center py-3 mt-5">
    <div class="container">
      <img class="navbar-brand" src="{{ asset('img/VifraSoft_Logo-removebg-preview.png') }}" alt="Logo" height="50px" width="110px">
      <p>&copy; {{ date('Y') }} VifraSoft. Todos los derechos reservados.</p>
    </div>
  </footer>

  {{-- Scripts de JS al final del body para mejor rendimiento --}}
  <!-- <script src="{{ asset('js/scrip.js')}}"></script>  -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
  @stack('scripts')
</body>
</html>