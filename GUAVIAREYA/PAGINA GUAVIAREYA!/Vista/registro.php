<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box">
                <div class="featured-image mb-3">
                    <img src="../media/login.png" class="img-fluid" style="width: 500px">
                </div>
            </div>
            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    <div class="header-text mb-4">
                        <h2 style="text-align: center;">REGISTRATE</h2>
                    </div>
                    <form action="Controlador_Registrar.php" method="POST" enctype="multipart/form-data">
                        <div class="input-group mb-3">
                            <input type="text" name="Apodo" class="form-control form-control-lg bg-light fs-6"
                                placeholder="Apodo">
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="Nombre" class="form-control form-control-lg bg-light fs-6"
                                placeholder="Nombres">
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="Apellido" class="form-control form-control-lg bg-light fs-6"
                                placeholder="Apellidos">
                        </div>
                        <div class="input-group mb-3">
                            <input type="email" name="Correo" class="form-control form-control-lg bg-light fs-6"
                                placeholder="Correo">
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" name="Contrasena"
                                class="form-control form-control-lg bg-light fs-6" placeholder="Contraseña">
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="Telefono" class="form-control form-control-lg bg-light fs-6"
                                placeholder="Numero telefonico">
                        </div>
                        <div class="row">
                            <small>
                                <input type="checkbox"> He leído y acepto <a
                                    href="controlador.php?seccion=terminos">los términos de uso y condiciones</a> y
                                las
                                <a href="politicas.php">políticas de privacidad</a>
                            </small>
                        </div>
                        <div class="input-group mb-3">
                            <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">Ingresar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
