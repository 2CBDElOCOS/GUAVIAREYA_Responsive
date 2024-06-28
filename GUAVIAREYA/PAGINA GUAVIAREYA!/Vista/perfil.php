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
$userEmail = $_SESSION['correo'];
$user = DataUser::getUserByEmail($userEmail);
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <title>PERFIL</title>

</head>

<body>

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
                               <?php echo htmlspecialchars($user['img_U']); ?>
                                <div class="mt-3">
                                    <?php echo htmlspecialchars($user['Apodo']); ?>
                                    <p class="text-secondary mb-1">San Jose del Guaviare</p>
                                    <p class="text-secondary mb-1">#Dirección</p>
                                    <p class="text-muted font-size-sm"><?php echo htmlspecialchars($user['Telefono']); ?></p>
                                    <ul class="nav">
                                    <li class="nav-item">
                                        <a class="nav-link active" aria-current="page" href="controlador.php?seccion=perfil_E">Editar datos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="controlador.php?seccion=Cambiar_clave">Cambiar Contraseña</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="controlador.php?seccion=Perfil_P">Tus pedidos</a>
                                    </li>
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
                                    #Telefono
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

