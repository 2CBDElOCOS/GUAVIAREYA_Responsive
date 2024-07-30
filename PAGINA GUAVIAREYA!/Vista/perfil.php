<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['correo']) || $_SESSION['correo'] == "") {
    header("location: ../Controladores/controlador.php?seccion=login");
    exit();
}

// Incluir el archivo del modelo
include '../Modelos/DataUser.php';
include '../Modelos/Direccion_Entregas.php';

// Obtener la información del usuario
$user = DataUser::getUserByEmail($_SESSION['correo']);

// Obtener la primera dirección de entrega del usuario
$direcciones = Modelo_Direccion_Entregas::obtenerDireccionesPorUsuario($_SESSION['correo']);
$primera_direccion = $direcciones ? $direcciones[0] : null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>MI PERFIL</title>
</head>
<body>
    <div class="row">
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
    <section id="hero3">
        <div class="subcontainer2">
            <div class="col-md-12 ico-footer1">
                <a href="controlador.php?seccion=shop"><i class="fa-solid fa-tent-arrow-turn-left"></i></a>
            </div>

            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <br>
                                <div class="mx-auto" style="width: 140px;">
                                    <?php if ($user['img_U']): ?>
                                        <img src="<?php echo htmlspecialchars($user['img_U']); ?>" alt="Foto de perfil" style="height: 140px; background-color: rgb(233, 236, 239);"> 
                                    <?php else: ?>
                                        <p>No se ha encontrado ninguna foto de perfil.</p>
                                    <?php endif; ?>
                                </div>
                                <br>
                                <div class="col 1">
                                    <form method="POST" action="Controlador_Foto.php" enctype="multipart/form-data">
                                        <input type="file" style="width: 390px; padding: 5px; font-size:15px;" id="img_U" name="img_U" accept="image/*">
                                        <button type="submit">Aceptar</button>
                                    </form>
                                </div>

                                <div class="mt-3">
                                    <p class="text-muted font-size-sm"><?php echo htmlspecialchars($user['Apodo']); ?></p>
                                    <p class="text-muted font-size-sm"><?php echo htmlspecialchars($user['Telefono']); ?></p>
                                    
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Acciones
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="controlador.php?seccion=perfil_E">Editar datos</a></li>
                                            <li><a class="dropdown-item" href="controlador.php?seccion=Cambiar_clave">Cambiar Contraseña</a></a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item" href="controlador.php?seccion=Perfil_P">Tus pedidos</a></li>
                                            <li><a class="dropdown-item" href="controlador.php?seccion=Perfil_Direcciones">Dirección de entregas</a></li>
                                            <li><a class="dropdown-item" href="../Controladores/controlador_cerrar_session.php">Cerrar sesión</a></li>
                                        </ul>
                                    </li>
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
                                    <h6 class="mb-0">Nombre</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo htmlspecialchars($user['Nombre']); ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Apellido</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo htmlspecialchars($user['Apellido']); ?>
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
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Teléfono</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo htmlspecialchars($user['Telefono']); ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Dirección</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php
                                    if ($primera_direccion) {
                                        echo "<p> " . htmlspecialchars($primera_direccion['Direccion']) . "</p>";
                                        echo "<p>". htmlspecialchars($primera_direccion['Barrio']) . "</p>";          
                                    } else {
                                        echo "<p>No se encontraron direcciones de entrega.</p>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                    
                </div>

            </div>
            
        </div>
        
    </section>
</body>
</html>