<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    
</head>
<body>
    <!--Boton en el header que manda hacia atras-->
    <header class="p-3 bg-light">
        <a href="pruebita.html" class="btn btn-sm btn-outline-dark">← Atrás</a>
    </header>
    
    <div class="container  text-center mt-5">
        <div class="row">
            <h1 class="fw-bold">Registrarse</h1>
        </div>
        <div class="input-group flex-nowrap">  <!-- flex-nowrap = lo que hace es que si se achica el tamaño no se rompe el diseño -->
            
            <span class="input-group-text" id="addon-wrapping">@</span> <!--Span ees un contenedor en línea para mostrar un texto o ícono-->
            <!--→input-group-text  Es una clase especial de Bootstrap que se usa dentro de un input-group, le da estilo de caja gris clara-->
            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="addon-wrapping">
            <!--"from-control" = hace que el input ocupe todo el ancho disponible dentro del input gorup y tenga estilo de formulario de Bootstrap -->
            <!--placeholder = Muestra el texto de ayuda “Username”-->
            
        </div>
        <!--Gmail-->
        <form> <!--Form = crear un formulario donde el usuario pone sus datos y despues se envian al servidor-->
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">No compartimos tu correo electrónico con nadie más.</div>
            </div>
            <!--Password-->
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="exampleInputPassword1">
            </div>
            <!--Botón-->
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Confirmar</label>
            </div>
            <button type="submit" class="btn btn-primary">Hecho</button>
        </form>
        
    </div>
</div>
</body>
</html>