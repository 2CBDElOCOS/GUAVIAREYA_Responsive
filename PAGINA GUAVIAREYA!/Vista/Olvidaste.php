<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¿Olvidaste?</title>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <div class="col-md-6 d-flex justify-content-center align-items-center flex-column left-box">
                <div class="featured-image mb-3">
                    <img src="../media/politica.png" class="img-fluid" style="width: 100%; max-width: 500px;">
                </div>
            </div>
            <div class="col-md-6 d-flex flex-column justify-content-center right-box">
                <div class="header-text mb-4 text-center">
                    <h2>RECUPERA TU CONTRASEÑA</h2>
                </div>
                <div class="input-group mb-3">
                    <p class="text-center">Ingrese su dirección de correo electrónico y le enviaremos un correo electrónico con instrucciones para restablecer su contraseña.</p>
                </div>
                
                <!-- Mensaje de éxito o error -->
                <div id="message" class="message" style="display: none;"></div>

                <form id="recoveryForm">
                    <div class="input-group mb-3">
                        <input type="email" name="correo" id="correo" class="form-control form-control-lg bg-light fs-6" placeholder="Correo" required>
                        <button type="submit" class="btn btn-lg btn-primary fs-6 ms-2">Enviar</button>
                    </div>
                </form>
                <div class="row">
                    <small><a href="controlador.php?seccion=login">Inicia sesión</a></small>
                </div>
            </div>
        </div>
    </div>


<script src="../JS/mensaje_recuperar_contra.js"></script>
</body>
</html>
