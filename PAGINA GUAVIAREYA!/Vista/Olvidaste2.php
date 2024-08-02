<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación de Contraseña</title>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box">
                <div class="featured-image mb-3">
                    <img src="../media/politica.png" class="img-fluid" style="width: 500px" alt="Imagen de recuperación">
                </div>
            </div>
            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    <div class="header-text mb-4">
                        <h2 style="text-align: center;">RECUPERA TU CONTRASEÑA</h2>
                    </div>
                    <p style="text-align: center;">Ingresa la nueva contraseña</p>
                    <form action="../Controladores/Controlador_recuperar_contra.php" method="POST">
                        <input type="hidden" name="correo" value="<?php echo htmlspecialchars($_GET['correo']); ?>">
                        <div class="input-group mb-3">
                            <input type="password" id="NuevaContrasena" name="NuevaContrasena" class="form-control form-control-lg bg-light fs-6" placeholder="Nueva Contraseña" required>
                        </div>
                        <p style="text-align: center;">Confirma la contraseña</p>
                        <div class="input-group mb-3">
                            <input type="password" id="ConfirmarContrasena" name="ConfirmarContrasena" class="form-control form-control-lg bg-light fs-6" placeholder="Confirmar Contraseña" required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="checkbox" id="mostrarContrasena"> Mostrar contraseña
                        </div>
                        <div class="input-group mb-3 d-flex justify-content-center">
                            <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">Confirmar</button>
                        </div>
                    </form>
                    <p style="text-align: center;">¿Ya tienes cuenta? <a href="controlador.php?seccion=login">Inicia sesión aquí</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="../JS/mensaje_pass2.js"></script>
<script src="../JS/mostrar_contraseña.js"></script>
</html>
