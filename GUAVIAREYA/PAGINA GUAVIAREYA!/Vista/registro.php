<!DOCTYPE html>
<html lang="en">

<head>


  <title>Registro</title>
</head>

<body>

  <!----------------------- Contenedor general-------------------------->

  <div class="container d-flex justify-content-center align-items-center min-vh-100">

    <!----------------------- Contenedor regis -------------------------->

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
            <h2 style="text-align: center;">REGISTRATE</h2>

          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Apodo">
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Nombres">
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Apellidos">
          </div>
          <div class="input-group mb-3">
            <input type="email" class="form-control form-control-lg bg-light fs-6" placeholder="Correo">
          </div>
          <br>
          <div class="input-group mb-3">
            <input type="password" class="form-control form-control-lg bg-light fs-6" placeholder="Contraseña">
          </div>
          <br>
          <div class="input-group mb-3">
            <input type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Numero telefonico">
          </div>
          <div class="row">
            <small> <input type="checkbox"> He leído y acepto <a href="?seccion=terminos">los términos  de uso y condiciones </a> y las 
                <a href="?seccion=politicas">las políticas de privacidad </a> </small>
          </div>
        
          <div class="input-group mb-3">
            <a href="?seccion=login"><button class="btn btn-lg btn-primary w-100 fs-6">Ingresar</button></a> 
          </div>
        </div>
      </div>

    </div>
  </div>

</body>

</html>