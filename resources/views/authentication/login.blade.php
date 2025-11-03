<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

    <style>
        /* Fondo general (puedes cambiar el color o poner una imagen) */
        body {
            min-height: 100vh;
            background: linear-gradient(180deg, #e9eef3 0%, #cfd7df 100%) no-repeat center/cover fixed;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Contenedor difuminado (efecto glass) */
        .glass-container {
            background: rgba(245, 245, 245, 0.55); /* gris translúcido */
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 400px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <!--Boton en el header que manda hacia atras-->
    <header class="p-3 bg-light">
        <a href="pruebita.html" class="btn btn-sm btn-outline-dark">← Atrás</a>

    <header class="p-3 bg-light position-absolute top-0 start-0 w-100">
        <a href="/" class="btn btn-sm btn-outline-dark">← Atrás</a>

    </header>

    <div class="glass-container text-center mt-5">
        <div class="row">
            <h1 class="fw-bold">Iniciar Sesión</h1>
        </div>

        <div class="mb-3">
            <!-- Label agregado para el campo de usuario/correo -->
            <label for="usernameInput" class="form-label mt-3 d-block text-start">Correo</label>

            <div class="input-group flex-nowrap">  <!-- flex-nowrap = lo que hace es que si se achica el tamaño no se rompe el diseño -->
                <span class="input-group-text" id="addon-wrapping">@</span> <!--Span ees un contenedor en línea para mostrar un texto o ícono-->
                <!--→input-group-text  Es una clase especial de Bootstrap que se usa dentro de un input-group, le da estilo de caja gris clara-->
                <input type="email" class="form-control" id="usernameInput" placeholder="Nombre de usuario" aria-label="Username" aria-describedby="addon-wrapping">
                <!--"from-control" = hace que el input ocupe todo el ancho disponible dentro del input gorup y tenga estilo de formulario de Bootstrap -->
                <!--placeholder = Muestra el texto de ayuda “Username”-->
            </div>
        </div>

        <!--Gmail-->
        <form class="mt-3"> <!--Form = crear un formulario donde el usuario pone sus datos y despues se envian al servidor-->
            <!--Password-->
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label d-block text-start">Contraseña</label>
                <input type="password" class="form-control" id="exampleInputPassword1">
            </div>

            <!--Botón-->
            <button type="submit" class="btn btn-primary w-100">Acceso</button>
        </form>
    </div>

</body>
</html>
