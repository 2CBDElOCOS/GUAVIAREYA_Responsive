<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['correo']) || $_SESSION['correo'] == "") {
    header("location: ../Controladores/controlador.php?seccion=login");
    exit();
}

require_once '../Modelos/DataSuperAdmi.php';

$user = DataSuperAdmi::obteneremail($_SESSION['correo']);

if ($user === null) {
    echo "Usuario no encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MI PERFIL</title>
</head>
<body>
    <section id="hero3" class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between mb-4">
            <div class="col-md-12 ico-footer1">
                <a href="controlador.php?seccion=SuperAdmin_Panel"><i class="fa-solid fa-tent-arrow-turn-left"></i></a>
            </div>
            </div>

            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <div class="mt-3">
                                    <h5><?php echo htmlspecialchars($user['Apodo']); ?></h5>
                                    <p class="text-muted"><?php echo htmlspecialchars($user['Correo']); ?></p>
                                    <div class="dropdown">
                                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Acciones
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="controlador.php?seccion=CambiarClave_SuperAdmi">Cambiar Contraseña</a></li>
                                            <li><a class="dropdown-item" href="controlador.php?seccion=Perfil_Restaurantes">Restaurantes</a></li>
                                            <li><a class="dropdown-item" href="controlador.php?seccion=Estadisticas">Ver Estadisticas</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Apodo</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo htmlspecialchars($user['Apodo']); ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Correo electrónico</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo htmlspecialchars($user['Correo']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
