

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresa Admi</title>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-4 p-4 bg-white shadow-sm box-area">
            <!-- Columna izquierda con la imagen -->
            <div class="col-md-6 d-flex justify-content-center align-items-center left-box">
                <div class="featured-image">
                    <img src="../media/login.png" alt="Login Image" class="img-fluid">
                </div>
            </div>
            <!-- Columna derecha con el formulario -->
            <div class="col-md-6 right-box">
                <div class="text-center mb-4">
                    <h2>ADMINISTRADOR</h2>
                </div>
                <form method="POST" action="controlador_usuario_admi.php">
                    <div class="input-group mb-3">
                        <input type="email" name="correo" class="form-control form-control-lg bg-light" placeholder="Correo" required>
                    </div>
                    <div class="input-group mb-3">
                        <input id="Contrasena" type="password" name="contrasena" class="form-control form-control-lg bg-light" placeholder="Contraseña" required>
                    </div>

                    <!-- Mensaje de error -->
                    <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
                        <div class="w-100">
                            <div class="alert alert-danger mt-2 w-100" role="alert">
                                Correo o contraseña incorrectos. Por favor, inténtalo de nuevo.
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="input-group mb-3">
                        <input type="checkbox" id="mostrarContrasena"> Mostrar contraseña
                    </div>

                    <div class="mb-3 d-flex justify-content-between">
                        <small class="forgot"><a href="controlador.php?seccion=Olvidaste">¿Olvidaste tu contraseña?</a></small>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                    </div>
                </form>
                <div class="text-center">
                    <small>¿No tienes una cuenta? <a href="controlador.php?seccion=home">Comunícate con nosotros</a></small>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="../JS/mostrar_contraseña.js"></script>
    <script src="../JS/alerta_bloqueo.js"></script>
    
</body>

</html>