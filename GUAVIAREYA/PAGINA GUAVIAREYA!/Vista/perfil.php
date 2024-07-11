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

// Obtener la información del usuario desde la base de datos
$user = DataUser::getUserByEmail($_SESSION['correo']);
$imgUrl = $user['img_U']; // Suponiendo que 'img_U' es el nombre de la columna que contiene la URL de la imagen


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
                    // Puedes agregar más casos según sea necesario
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
                                <div style="width: 140px;">
                                    <?php if ($imgUrl): ?>
                                         <img src="<?php echo $imgUrl; ?>" alt="Foto de perfil" style="height: 140px; background-color: rgb(233, 236, 239);">
                                    <?php else: ?>
                                        <p>No se ha encontrado ninguna foto de perfil.</p>
                                    <?php endif; ?>
                                </div>
                                <br>
                                <div class="col 1">
                                <form method="POST" action="Controlador_Foto.php" enctype="multipart/form-data">
                                    <input type="file"  style="width: 390px; padding: 5px; font-size 15px;"  id="img_U" name="img_U" accept="image/*">
                                    <button type="submit">Aceptar</button>
                                </form>
                                </div>

                                <div class="mt-3">
                                    <?php echo htmlspecialchars($user['Apodo']); ?>
                                    <p class="text-secondary mb-1">San Jose del Guaviare</p>
                                    <p class="text-secondary mb-1">#Dirección</p>
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
                                        <li><a class="dropdown-item" href="controlador.php?seccion=pedidos_per">Dirección de entregas</a></li>
                                        <li><a class="dropdown-item" href="../Controladores/controlador_cerrar_session.php">Cerrar sesión</a>
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
                                    <h6 class="mb-0">Nombre </h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo htmlspecialchars($user['Nombre']); ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Apellido </h6>
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
                                    #Dirección
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
