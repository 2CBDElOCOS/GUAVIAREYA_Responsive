<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['correo']) || $_SESSION['correo'] == "") {
    header("location: ../Controladores/controlador.php?seccion=login");
    exit();
}

// Incluir el archivo del modelo
include '../Modelos/DataAdmi.php';

// Obtener la información del usuario desde la base de datos
$user = DataAdmi::getUserByEmail($_SESSION['correo']);
$imgUrl = $user['img_R']; // Esta ahora es la URL de la imagen del restaurante
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TU PERFIL</title>
</head>

<body>
    <div class="container">
        <div class="col-md-12 ico-footer">
            <a href="controlador.php?seccion=ADMI_Shop_A"><i class="fa-solid fa-circle-arrow-left" style="color: #000000;"></i></a>
        </div>
        <div class="main-body">
            <h4 class="text-center mb-4">TU RESTAURANTE</h4>

            <!-- /Migajas de pan -->

            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <form action="Controlador_AdmiSwitch.php" method="POST">
                                <input type="hidden" name="estado" value="Cerrado">
                                <label class="switch">
                                    <input type="checkbox" name="estado" value="Abierto" <?php echo $user['Estado'] === 'Abierto' ? 'checked' : ''; ?>>
                                    <span class="slider round"></span>
                                </label>
                                <input type="hidden" name="id_restaurante" value="<?php echo htmlspecialchars($user['ID_Restaurante']); ?>">
                                <button type="submit" class="btn btn-primary mt-3">Aceptar</button>
                            </form>

                            <!-- Mostrar la imagen del restaurante -->
                            <img src="<?php echo htmlspecialchars($imgUrl); ?>" alt="Imagen del Restaurante" style="width: 150px; height: 150px; object-fit: cover;" class="rounded-circle mt-3">

                            <div class="mt-3">
                                <p class="text-secondary mb-1"><?php echo htmlspecialchars($user['Nombre_R']); ?></p>
                                <p class="text-secondary mb-1"><?php echo htmlspecialchars($user['Direccion']); ?></p>
                                <p class="text-muted"><?php echo htmlspecialchars($user['Telefono']); ?></p>

                                <div class="dropdown">
                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Acciones
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="controlador.php?seccion=ADMI_Editar_A">Editar datos</a></li>
                                        <li><a class="dropdown-item" href="controlador.php?seccion=ADMI_CambiarPass">Cambiar Contraseña</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="controlador.php?seccion=ADMI_Ordenes">Ordenes</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="../Controladores/controlador_cerrar_session.php">Cerrar sesión</a></li>
                                    </ul>
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
                                    <h6>Nombre</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo htmlspecialchars($user['Nombre_R']); ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6>Teléfono</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo htmlspecialchars($user['Telefono']); ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6>Dirección</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo htmlspecialchars($user['Direccion']); ?>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
