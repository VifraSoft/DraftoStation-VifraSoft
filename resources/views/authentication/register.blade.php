<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Registro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      min-height: 100vh;
      background: linear-gradient(180deg, #e9eef3 0%, #cfd7df 100%) fixed;
      display: flex; align-items: center; justify-content: center;
    }
    .glass-container {
      background: rgba(245,245,245,0.55);
      backdrop-filter: blur(10px);
      border-radius: 15px; border: 1px solid rgba(0,0,0,0.1);
      padding: 40px; width: 400px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>
  <header class="p-3 bg-light position-absolute top-0 start-0 w-100">
    <a href="/" class="btn btn-sm btn-outline-dark">← Atrás</a>
  </header>

  <div class="glass-container text-center mt-5">
    <h1 class="fw-bold">Registrarse</h1>

    {{-- Mostrar errores globales --}}
    @if ($errors->any())
    <div class="alert alert-danger text-start">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <form action="{{ route('register.store') }}" method="POST" class="mt-3" novalidate>
      @csrf

      <div class="mb-3 text-start">
        <label for="usernameInput" class="form-label">Nombre de usuario</label>
        <div class="input-group">
          <span class="input-group-text" id="addon-wrapping">@</span>
          <input
            type="text"
            name="nickname"
            id="usernameInput"
            class="form-control @error('nickname') is-invalid @enderror"
            placeholder="Username"
            value="{{ old('nickname') }}"
            required
            autocomplete="nickname"
          >
        </div>
        @error('nickname')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3 text-start">
        <label for="emailInput" class="form-label">Correo electrónico</label>
        <input
          type="email"
          name="email"
          id="emailInput"
          class="form-control @error('email') is-invalid @enderror"
          value="{{ old('email') }}"
          aria-describedby="emailHelp"
          required
          autocomplete="email"
        >
        <div id="emailHelp" class="form-text">No compartimos tu correo electrónico con nadie más.</div>
        @error('email')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3 text-start">
        <label for="passwordInput" class="form-label">Contraseña</label>
        <input
          type="password"
          name="password"
          id="passwordInput"
          class="form-control @error('password') is-invalid @enderror"
          required
          autocomplete="new-password"
        >
        @error('password')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary w-100">Hecho</button>
    </form>
  </div>
</body>
</html>
