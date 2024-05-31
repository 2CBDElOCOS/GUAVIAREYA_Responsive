<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>¿Olvidaste?</title>
</head>

<body>

    <!----------------------- Contenedor general-------------------------->

    <div class="container d-flex justify-content-center align-items-center min-vh-100">

        <!----------------------- Contenedor login -------------------------->

        <div class="row border rounded-5 p-3 bg-white shadow box-area">

            <!--------------------------- Contenedor izquierdo ----------------------------->

            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box">
                <div class="featured-image mb-3">
                    <img src="../media/politica.png" class="img-fluid" style="width: 500px">
                </div>
            </div>

            <!-------------------- ------ Contenedor derecho ---------------------------->

            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    <div class="header-text mb-4">
                        <h2 style="text-align: center;">RECUPERA TU CONTRASEÑA</h2>

                    </div>
                    <br><br><br><br><br><br><br><br>
                    <div class="input-group mb-3">
                        <p style="text-align: center;">Ingrese su dirección de correo electrónico y le enviaremos un correo electrónico con
                            instrucciones para restablecer su contraseña.</p>
                        <input type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Correo">
                    </div>
                    <div class="input-group mb-3 d-flex justify-content-center">
                        <a href="?seccion=Olvidaste2" style="text-decoration: none;">
                            <button class="btn btn-lg btn-primary fs-6">Enviar</button>
                        </a>
                    </div>
                    
                    <div class="row">
                        <small><a href="?seccion=login">Inicia sesion</a></small>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>

</html>