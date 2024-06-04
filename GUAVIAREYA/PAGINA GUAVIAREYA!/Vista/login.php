

<head>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

  <title>Ingresar</title>
</head>

<body>

  <!----------------------- Contenedor general-------------------------->

  <div class="container d-flex justify-content-center align-items-center min-vh-100">

    <!----------------------- Contenedor login -------------------------->

    <div class="row border rounded-5 p-3 bg-white shadow box-area">

      <!--------------------------- Contenedor izquierdo ----------------------------->

      <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box">
        <div class="featured-image mb-3">
          <img src="../media/login.png" class="img-fluid" style="width: 500px">
        </div>
      </div>

      <!-------------------- ------ Contenedor derecho ---------------------------->

      <div class="col-md-6 right-box">
        <div class="row align-items-center">
          <div class="header-text mb-4">
            <h2 style="text-align: center;">INICIA SESION</h2>

          <form action="../Clases/tmp_pruebitas.php" method="POST">
          </div>
          <div class="input-group mb-3">
            <input type="email"  name="Correo" class="form-control form-control-lg bg-light fs-6" placeholder="Correo">
          </div>
          <div class="input-group mb-1">
            <input type="password" name="Contrasena" class="form-control form-control-lg bg-light fs-6" placeholder="Contraseña">
          </div>
          <div class="input-group mb-5 d-flex justify-content-between">
            <div class="forgot">
              <small><a href="?seccion=Olvidaste">¿Olvidaste tu contraseña?</a></small>
            </div>
          </div>
          <div class="input-group mb-3">
            <a href="?seccion=shop"><button class="btn btn-lg btn-primary w-100 fs-6">Ingresar</button></a>
          </div>
          </form>
          <div class="input-group mb-3">
            <button class="btn btn-lg btn-light w-100 fs-6"><img src="../media/google.png" style="width:20px"
                class="me-2"><small>Inicia sesion con Google</small></button>
          </div>
          <div class="row">
            <small>¿No tienes una cuenta? <a href="?seccion=registro">Registrate</a></small>
            <br>
            <small>¿Eres Administrador? <a href="?seccion=ADMI/logion_A">Ingresa aqui</a></small>
          </div>
        </div>
      </div>

    </div>
  </div>

</body>

</html>