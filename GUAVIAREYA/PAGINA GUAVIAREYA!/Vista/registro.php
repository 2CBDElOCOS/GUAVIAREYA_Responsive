<!DOCTYPE html>
<html lang="es">
<head>
    <title>Registro</title>
    <!-- Asegúrate de tener el enlace a los estilos de Bootstrap u otros necesarios -->
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
                        <h2 style="text-align: center;">REGÍSTRATE</h2>
                    </div>
                    <form id="registerForm" action="Controlador_Registrar.php" method="POST" enctype="multipart/form-data">
                        <!-- Otros campos del formulario -->
                        <div class="input-group mb-3">
                            <input type="text" name="Apodo" class="form-control form-control-lg bg-light fs-6" placeholder="Apodo" required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="Nombre" class="form-control form-control-lg bg-light fs-6" placeholder="Nombres" required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="Apellido" class="form-control form-control-lg bg-light fs-6" placeholder="Apellidos" required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="email" name="Correo" class="form-control form-control-lg bg-light fs-6" placeholder="Correo" required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" id="Contrasena" name="Contrasena" class="form-control form-control-lg bg-light fs-6" placeholder="Contraseña" required>
                        </div>
                        <div class="input-group mb-3">
                            <small id="password-strength" class="password-strength"></small>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="Telefono" class="form-control form-control-lg bg-light fs-6" placeholder="Número telefónico" required>
                        </div>
                        <div class="row mb-3">
                            <small>
                                <input type="checkbox" required> He leído y acepto <a href="controlador.php?seccion=terminos">los términos de uso y condiciones</a> y las <a href="politicas.php">políticas de privacidad</a>
                            </small>
                        </div>
                        <?php
                        if (isset($_GET['error'])) {
                            $error_message = '';
                            switch ($_GET['error']) {
                                case '1':
                                    $error_message = 'El correo ya existe, intenta con otro.';
                                    break;
                                case '2':
                                    $error_message = 'Error en el captcha';
                                    break;
                            }
                            echo "<div class='alert alert-danger' role='alert'>$error_message</div>";
                        }
                        ?>
                        <div class="input-group mb-3">
                            <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">Ingresar</button>
                        </div>
                        <div class="cf-turnstile" data-sitekey="0x4AAAAAAAgDs9tR8EZ6iKVr" data-language="es" data-theme="light"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <script src="../JS/mensaje_contraseña.js"></script>
</body>
</html>
