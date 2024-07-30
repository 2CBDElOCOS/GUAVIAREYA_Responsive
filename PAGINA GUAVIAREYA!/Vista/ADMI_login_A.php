<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ingresa Admi</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
                        <h2 style="text-align: center;">ADMINISTRADOR</h2>
                    </div>
                    <form method="POST" action="controlador_usuario_admi.php">
                        <div class="input-group mb-3">
                            <input type="email" name="correo" class="form-control form-control-lg bg-light fs-6" placeholder="Correo" required>
                        </div>
                        <div class="input-group mb-1">
                            <input type="password" name="contrasena" class="form-control form-control-lg bg-light fs-6" placeholder="Contraseña" required>
                        </div>

                        <?php if (isset($_GET['error'])): ?>
                        <div class="w-100">
                            <div class="alert alert-danger mt-2 w-100" role="alert">
                                <?php echo htmlspecialchars($_GET['error']); ?>
                            </div>
                        </div>
                        <?php endif; ?>

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
                        <small>¿No tienes una cuenta? <a href="controlador.php?seccion=home">Comunícate con nosotros</a></small>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>
