<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['correo']) || $_SESSION['correo'] == "") {
    header("location: ../Controladores/controlador.php?seccion=login");
    exit();
}

include '../Modelos/DataUser.php';
include '../Modelos/Direccion_Entregas.php';
require_once '../Modelos/Cupones.php';

$user = DataUser::getUserByEmail($_SESSION['correo']);
$direcciones = Modelo_Direccion_Entregas::obtenerDireccionesPorUsuario($_SESSION['correo']);
$primera_direccion = $direcciones ? $direcciones[0] : null;
$cupon = Cupones::ObtenerCuponPorCorreo($_SESSION['correo']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MI PERFIL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function confirmarEliminacion() {
            return confirm('¿Estás seguro de que deseas eliminar tu cuenta?');
        }
    </script>
</head>

<body>
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-12">
                <?php
                if (isset($_GET['error'])) {
                    $error_message = '';
                    switch ($_GET['error']) {
                        case '1':
                            $error_message = 'Error al subir la foto, o no se encontró foto de perfil.';
                            break;
                        default:
                            $error_message = 'Error desconocido.';
                            break;
                    }
                    echo "<div class='alert alert-danger' role='alert'>$error_message</div>";
                }
                ?>
            </div>
        </div>

        <section id="hero3" class="my-4">
            <div class="d-flex justify-content-end mb-4 ico-footer1">
                <a href="controlador.php?seccion=shop"><i class="fa-solid fa-tent-arrow-turn-left"></i></a>
            </div>

            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <div style="height: 140px; width: 140px; margin: 0 auto;">
                                <?php if ($user['img_U']): ?>
                                    <img src="<?php echo htmlspecialchars($user['img_U']); ?>" alt="Foto de perfil" class="img-fluid rounded-circle" style="height: 140px; width: 140px;">
                                <?php else: ?>
                                    <p>No se ha encontrado ninguna foto de perfil.</p>
                                <?php endif; ?>
                            </div>
                            <div class="mt-3 file-upload">
                                <form method="POST" action="Controlador_Foto.php" enctype="multipart/form-data">
                                    <label for="img_U" class="file-upload-icon">
                                        <i class="fas fa-upload"></i> 
                                    </label>
                                    <br>
                                    <input type="file" id="img_U" name="img_U" accept="image/*">
                                    <button type="submit" class="btn btn-primary mt-2">Aceptar</button>
                                </form>
                            </div>
                            <div class="mt-3">
                                <p class="text-muted font-size-sm"><?php echo htmlspecialchars($user['Apodo']); ?></p>
                                <p class="text-muted font-size-sm"><?php echo htmlspecialchars($user['Telefono']); ?></p>

                                <div class="dropdown">
                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                        Acciones
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <li><a class="dropdown-item" href="controlador.php?seccion=perfil_E">Editar datos</a></li>
                                        <li><a class="dropdown-item" href="controlador.php?seccion=Cambiar_clave">Cambiar Contraseña</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="controlador.php?seccion=Perfil_P">Tus pedidos</a></li>
                                        <li><a class="dropdown-item" href="controlador.php?seccion=Perfil_Direcciones">Dirección de entregas</a></li>
                                        <li><a class="dropdown-item" href="../Controladores/controlador_cerrar_session.php">Cerrar sesión</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="../Controladores/Controlador_EliminarCuenta.php" onclick="return confirmarEliminacion();">Eliminar Cuenta</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-3 d-flex align-items-center">
                                    <h6 class="mb-0">Nombre</h6>
                                </div>
                                <div class="col-sm-9 text-end">
                                    <?php echo htmlspecialchars($user['Nombre']); ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3 d-flex align-items-center">
                                    <h6 class="mb-0">Apellido</h6>
                                </div>
                                <div class="col-sm-9 text-end">
                                    <?php echo htmlspecialchars($user['Apellido']); ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3 d-flex align-items-center">
                                    <h6 class="mb-0">Correo electrónico</h6>
                                </div>
                                <div class="col-sm-9 text-end">
                                    <?php echo htmlspecialchars($user['Correo']); ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3 d-flex align-items-center">
                                    <h6 class="mb-0">Teléfono</h6>
                                </div>
                                <div class="col-sm-9 text-end">
                                    <?php echo htmlspecialchars($user['Telefono']); ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3 d-flex align-items-center">
                                    <h6 class="mb-0">Dirección</h6>
                                </div>
                                <div class="col-sm-9 text-end">
                                    <?php
                                    if ($primera_direccion) {
                                        echo "<p>" . htmlspecialchars($primera_direccion['Direccion']) . "</p>";
                                        echo "<p>" . htmlspecialchars($primera_direccion['Barrio']) . "</p>";
                                    } else {
                                        echo "<p>No se encontraron direcciones de entrega.</p>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3 d-flex align-items-center">
                                    <h6 class="mb-0">Código cupón</h6>
                                </div>
                                <div class="col-sm-9 text-end">
                                    <?php
                                    if ($cupon) {
                                        echo htmlspecialchars($cupon['codigo']);
                                    } else {
                                        echo "No tienes un cupón disponible.";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/mensaje_confirmacion_cuenta.js"></script>

</body>

</html>
