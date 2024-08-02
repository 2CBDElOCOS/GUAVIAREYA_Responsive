<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-5 p-3 bg-white shadow box-area w-100" style="max-width: 900px;">
            <div class="col-lg-6 d-none d-lg-flex justify-content-center align-items-center flex-column left-box">
                <div class="featured-image mb-3">
                    <img src="../media/login.png" class="img-fluid" style="max-width: 100%; height: auto;">
                </div>
            </div>
            <div class="col-lg-6 col-md-12 right-box">
                <div class="row align-items-center">
                    <div class="header-text mb-4">
                        <h2 style="text-align: center;">INICIA SESIÓN</h2>
                    </div>

                    <form method="POST" action="Controlador_Usuario.php">
                        <div class="input-group mb-3">
                            <input type="email" name="Correo" class="form-control form-control-lg bg-light fs-6" placeholder="Correo" required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" id="Contrasena" name="Contrasena" class="form-control form-control-lg bg-light fs-6" placeholder="Contraseña" required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="checkbox" id="mostrarContrasena"> Mostrar contraseña
                        </div>

                        <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
                        <div class="w-100">
                            <div class="alert alert-danger mt-2 w-100" role="alert">
                                Contraseña o correo incorrectos. Por favor, inténtalo de nuevo.
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <small><a href="controlador.php?seccion=Olvidaste">¿Olvidaste tu contraseña?</a></small>
                        </div>
                        <div class="input-group mb-3">
                            <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">Ingresar</button>
                        </div>
                    </form>
                    <div class="text-center">
                        <small>¿No tienes una cuenta? <a href="controlador.php?seccion=registro">Regístrate</a></small>
                        <br>
                        <small>¿Eres Administrador? <a href="controlador.php?seccion=ADMI_login_A">Ingresa aquí</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="../JS/alerta_bloqueo.js"></script>
    <script src="../JS/mostrar_contraseña.js"></script>
</body>

</html>
