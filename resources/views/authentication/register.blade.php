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

<<<<<<< HEAD
        <!--Gmail-->
        <!--<form> Form = crear un formulario donde el usuario pone sus datos y despues se envian al servidor-->
        <!--POST users.store-->
        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <!--nickname-->
            <div class="mb-3">
                <label for="nickname" class="form-label mt-3 d-block text-start">Nombre de usuario</label>

                <div class="input-group flex-nowrap">  <!-- flex-nowrap = lo que hace es que si se achica el tamaño no se rompe el diseño -->
                    <span class="input-group-text" id="addon-wrapping">#</span> <!--Span ees un contenedor en línea para mostrar un texto o ícono-->
                    <!--→input-group-text  Es una clase especial de Bootstrap que se usa dentro de un input-group, le da estilo de caja gris clara-->
                    <input type="text" class="form-control" id="nickname" name = "nickname" placeholder="Nickname" aria-label="Nickname" aria-describedby="addon-wrapping">
                    <!--"from-control" = hace que el input ocupe todo el ancho disponible dentro del input gorup y tenga estilo de formulario de Bootstrap -->
                    <!--placeholder = Muestra el texto de ayuda “Username”-->
                </div>
            </div>

            <!--Email-->
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label d-block text-start">Correo electrónico</label>
                <input type="email" class="form-control" id="email" name = "email" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text text-start">No compartimos tu correo electrónico con nadie más.</div>
            </div>

            <!--Password-->
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label d-block text-start">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <!--Botón-->
            <button type="submit" class="btn btn-primary w-100">Hecho</button>
        </form>
    </div>
=======
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

      <!-- Opcional: confirmar contraseña (si usas 'confirmed' en la validación) -->
      <!--
      <div class="mb-3 text-start">
        <label for="passwordConfirm" class="form-label">Confirmar contraseña</label>
        <input type="password" name="password_confirmation" id="passwordConfirm" class="form-control" autocomplete="new-password">
      </div>
      -->
>>>>>>> feature

      <button type="submit" class="btn btn-primary w-100">Hecho</button>
    </form>
  </div>
</body>
</html>
