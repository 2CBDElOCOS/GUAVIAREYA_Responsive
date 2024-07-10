<!DOCTYPE html>
<html lang="es">
<head>
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
                        <h2 style="text-align: center;">REGÍSTRATE</h2>
                    </div>
                    <form id="registerForm" action="Controlador_Registrar.php" method="POST" enctype="multipart/form-data">
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
                                <input type="checkbox" required> He leído y acepto <a href="controlador.php?seccion=terminos">los términos de uso y condiciones</a> y las <a href="controlador.php?seccion=politicas">políticas de privacidad</a>
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

 <script src="../JS/mensaje_contraseña.js"></script>
</body>
</html>
