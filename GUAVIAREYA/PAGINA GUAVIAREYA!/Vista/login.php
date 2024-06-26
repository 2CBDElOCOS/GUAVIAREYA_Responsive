<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $seccion; ?></title>
    <!-- Agregar aquí tus archivos CSS o CDN -->
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
                        <h2 style="text-align: center;">INICIA SESIÓN</h2>
                    </div>
                    <form method="POST" action="Controlador_Usuario.php">
                        <div class="input-group mb-3">
                            <input type="email" name="Correo" class="form-control form-control-lg bg-light fs-6"
                                placeholder="Correo">
                        </div>
                        <div class="input-group mb-1">
                            <input type="password" name="Contrasena"
                                class="form-control form-control-lg bg-light fs-6" placeholder="Contraseña">
                        </div>
                        <div class="input-group mb-5 d-flex justify-content-between">
                            <div class="forgot">
                                <small><a href="controlador.php?seccion=Olvidaste">¿Olvidaste tu
                                        contraseña?</a></small>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">Ingresar</button>
                        </div>
                    </form>
                    <div class="input-group mb-3">
                        <button class="btn btn-lg btn-light w-100 fs-6"><img src="../media/google.png"
                                style="width:20px" class="me-2"><small>Inicia sesión con Google</small></button>
                    </div>
                    <div class="row">
                        <small>¿No tienes una cuenta? <a href="controlador.php?seccion=registro">Regístrate</a></small>
                        <br>
                        <small>¿Eres Administrador? <a href="controlador.php?seccion=ADMI_login_A">Ingresa aquí</a></small>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Script para mostrar SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        // Función para obtener parámetros de la URL
        function obtenerParametroUrl(nombre) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(nombre);
        }

        // Mostrar SweetAlert si el usuario está bloqueado temporalmente
        document.addEventListener('DOMContentLoaded', function() {
            const error = obtenerParametroUrl('error');
            const tiempoRestante = obtenerParametroUrl('time');

            if (error === 'blocked') {
                Swal.fire({
                    icon: 'error',
                    title: 'Cuenta bloqueada temporalmente',
                    html: `Tu cuenta está bloqueada temporalmente.<br>Por favor espera ${tiempoRestante} segundos para intentar de nuevo.`,
                    footer: '<a href="#">¿Por qué tengo este problema?</a>'
                });
            }
        });
    </script>

</body>

</html>
