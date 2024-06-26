<!DOCTYPE html>
<html lang="en">

<head>

  <title>Ingresa Admi</title>
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
            <h2 style="text-align: center;">Administrador</h2>
          </div>
          <form method="POST" action="Controlador_Usuario_admi.php">
            <div class="input-group mb-3">
              <input type="email" name="correo" class="form-control form-control-lg bg-light fs-6" placeholder="Correo">
            </div>
            <div class="input-group mb-1">
              <input type="password" name="contrasena" class="form-control form-control-lg bg-light fs-6" placeholder="Contraseña">
            </div>
            <div class="input-group mb-5 d-flex justify-content-between">
              <div class="forgot">
                <small><a href="controlador.php?seccion=Olvidaste">¿Olvidaste tu contraseña?</a></small>
              </div>
            </div>
            <div class="input-group mb-3">
              <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">Ingresar</button>
            </div>
          </form>
          <div class="row">
          <small>¿No tienes una cuenta? <a href="controlador.php?seccion=home">Comunicate con nosotros</a></small>

          </div>
        </div>
      </div>


    </div>
  </div>

</body>

</html>