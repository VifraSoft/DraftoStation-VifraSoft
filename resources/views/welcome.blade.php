<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VifraSoft</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  <link rel="stylesheet" href="{{asset('css/styles.css')}}">    
</head>
<body>
  <header>
    <!-- Barra de menú en el header -->
    <div class="container-fluid bg-dark">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <!-- Logo o título -->
          <img class="navbar-brand" src="{{ asset('img/VifraSoft_Logo-removebg-preview.png') }}" alt="Logo" height="100px" width="220px">
          <!-- Botón para menú colapsable en móviles -->
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Menú">
            <span class="navbar-toggler-icon"></span>
          </button>
          
          <!-- Links del menú -->
          <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto pe-3">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#Informacion">Informacion</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#Jugar">Jugar</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#Clasificación">Clasificación</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Jugadores</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Acerca de</a>
              </li>
            </ul>
            
            <!-- Botones a la derecha -->
            <div class="d-flex">
                <a href="/login" class="btn btn-outline-light me-2">Iniciar Sessión</a>
                <a href="/register" class="btn btn-primary">Registrarse</a>
            </div>
            
          </div>
        </div>
      </nav>
    </div>
  </header>
  <!-- Contenedor principal -->
  <div class="container mt-5">
    <div class="row">
      <div class="col-12 col-md-6 col-lg-6 p-5">
        <h1>DraftoStation</h1>
        <p>DraftoStation es un juego de colección y draft donde los jugadores seleccionan consolas de videojuegos para colocarlas en distintos recintos de su tablero. 
          El objetivo es puntuar lo máximo posible utilizando la estrategia correcta para cada espacio.</p>
      </div>
      <div class="col-6 py-5 px-1">
        <img src="{{ asset('img/ImagenPrincipal.png') }}" class="img-fluid main-image" alt="...">
      </div>
    </div>
    
    <!-- Contenedor botón de Jugar-->
    
    <div id="Jugar" class="container mt-5 bg-dark py-5">
      <div class="row">
        <h2 class="text-center mt-3 my-5 white-text">Entrar a una partida</h2>
        <div class="d-grid gap-2 col-6 mx-auto">
          <button class="btn btn-success" type="button">Jugar</button>
        </div>
        <!-- ALERTA DE BOOTSTRAP (invisible al inicio) -->
        <div id="mensaje" class="alert alert-success mt-3 d-none" role="alert">
          ¡La partida comenzó!
        </div>
      </div>
    </div>
    
    
    <!-- Información del juego -->
    <div class="card shadow-lg border-0 mb-4">
      <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Información del juego</h4>
      </div>
      <div class="card-body">
        <p><strong>Jugadores:</strong> 2 a 5</p>
        <p><strong>Duración:</strong> 15-20 minutos</p>
        <p><strong>Edad recomendada:</strong> 10+</p>
        
        <h5 class="mt-4">Componentes:</h5>
        <ul class="list-group list-group-flush">
          <li class="list-group-item">Bolsita con consolas de distintos tipos.</li>
          <li class="list-group-item">Tableros individuales con recintos.</li>
          <li class="list-group-item">Marcadores de puntuación.</li>
          <li class="list-group-item">Una consola Atari, que cumple el rol del T-Rex en Draftosaurus.</li>
        </ul>
      </div>
    </div>
    
    <!-- Reglas del juego -->
    <div class="card shadow-lg border-0 mb-4">
      <div class="card-header bg-success text-white">
        <h4 class="mb-0">Reglas del juego</h4>
      </div>
      <div class="card-body">
        <p>En cada ronda, los jugadores eligen una consola de las que tienen en mano y pasan el resto al jugador siguiente. Cada consola se debe colocar en un recinto de tu tablero, respetando sus condiciones.<br>
          Al final de la partida se suman los puntos de todos los recintos, más los de la Atari (T-Rex) si corresponde.</p>
        </div>
      </div>
      
      <!-- Circuito Uniforme -->
      <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
          <h5 class="card-title">Circuito Uniforme</h5>
          <p>Aquí se premia la constancia tecnológica.</p>
          <ul>
            <li>Solo puedes colocar consolas del mismo tipo.</li>
            <li>Cuantas más consolas iguales logres en este recinto, mayor será la puntuación.</li>
            <li>La escala de puntos es progresiva: 2, 4, 8, 12, 18, 24.</li>
          </ul>
        </div>
      </div>
      
      <!-- Triple A -->
      <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
          <h5 class="card-title">Triple A</h5>
          <p>El escaparate de los grandes éxitos.</p>
          <ul>
            <li>Coloca aquí consolas del mismo tipo.</li>
            <li>Si logras al menos tres iguales, ganas 7 puntos fijos.</li>
            <li>No importa si colocas más de tres, la puntuación máxima siempre será 7.</li>
          </ul>
        </div>
      </div>
      
      <!-- El Cuartel Multijugador -->
      <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
          <h5 class="card-title">El Cuartel Multijugador</h5>
          <p>Donde las consolas se conectan entre sí.</p>
          <ul>
            <li>Cada consola colocada en este recinto vale 5 puntos de vida.</li>
            <li>No importa el tipo, todas suman el mismo valor.</li>
          </ul>
        </div>
      </div>
      
      <!-- Console of the Year -->
      <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
          <h5 class="card-title">Console of the Year</h5>
          <p>El premio a la mejor consola del año.</p>
          <ul>
            <li>Solo se permite colocar una consola en este recinto.</li>
            <li>Si esa consola no se repite en otro recinto, otorga 7 puntos extra.</li>
            <li>Si se repite, este espacio queda anulado y no puntúa nada.</li>
          </ul>
        </div>
      </div>
      
      <!-- Pixeles Variados -->
      <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
          <h5 class="card-title">Pixeles Variados</h5>
          <p>El rincón de los coleccionistas.</p>
          <ul>
            <li>Cada consola debe ser de un tipo distinto.</li>
            <li>Según la cantidad de consolas diferentes, se ganan los puntos: 1, 3, 6, 10, 15, 21.</li>
          </ul>
        </div>
      </div>
      
      <!-- La Edición Limitada -->
      <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
          <h5 class="card-title">La Edición Limitada</h5>
          <p>Un espacio exclusivo para verdaderas joyas.</p>
          <ul>
            <li>Este recinto solo puntúa si colocas exactamente dos consolas iguales.</li>
            <li>Si cumples, otorga 7 puntos.</li>
            <li>Si pones más o menos de dos, no suma nada.</li>
          </ul>
        </div>
      </div>
      
      <!-- La Atari (T-Rex) -->
      <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
          <h5 class="card-title">La Atari (T-Rex)</h5>
          <p>La Atari es una consola especial, que funciona igual que el T-Rex en Draftosaurus.</p>
          <ul>
            <li>No puede colocarse en ningún recinto.</li>
            <li>En su lugar, se coloca en un espacio libre junto al tablero.</li>
            <li>No cuenta para las reglas de los recintos, pero sí otorga 1 punto fijo por estar en juego.</li>
          </ul>
        </div>
      </div>
      
      <!-- Fin del juego -->
      <div class="card shadow-lg border-0">
        <div class="card-header bg-danger text-white">
          <h4 class="mb-0">Fin del juego</h4>
        </div>
        <div class="card-body">
          <p>La partida termina cuando todas las consolas fueron colocadas.<br>
            Se suman los puntos de cada recinto, más la puntuación de la Atari.<br>
            El jugador con más puntos se convierte en el <strong>Maestro de DraftoStation</strong>.</p>
          </div>
        </div>
        
        
        <div class="container text-center my-5">
          <h3>Clasificación</h3>
          <table class="table table-success table-striped" id="Clasificación">
            
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">Handle</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
              </tr>
              <tr>
                <th scope="row">2</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
              </tr>
              <tr>
                <th scope="row">3</th>
                <td>John</td>
                <td>Doe</td>
                <td>@social</td>
              </tr>
            </tbody>
          </table>
        </div>
        
      </div>
    </div>
    
    
  </div>
  
  <script src="{{ asset('js/scrip.js')}}"></script> 
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
  
</body>
</html>
