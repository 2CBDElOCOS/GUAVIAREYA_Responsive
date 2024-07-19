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
$imgUrl = $user['img_A']; // Suponiendo que 'img_U' es el nombre de la columna que contiene la URL de la imagen


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>TU PERFIl</title>
</head>

<body>
    <div class="container">
        <div class="col-md-12 ico-carro">
            <a href="controlador.php?seccion=ADMI_Shop_A"><i class="fa-solid fa-tent-arrow-turn-left"></i></a>
        </div>
        <div class="main-body">
            <br>
            <div class=""><h4>TU RESTAURANTE</h4></div>


            <!-- /Migajas de pan -->

            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <!-- Rounded switch -->
                            <form action="Controlador_AdmiSwitch.php" method="POST">
                                <!-- Campo oculto para manejar el estado desmarcado -->
                                <input type="hidden" name="estado" value="Cerrado">
                                <!-- Checkbox para cambiar el estado -->
                                <label class="switch">
                                    <input type="checkbox" name="estado" value="Abierto" <?php echo $user['Estado'] === 'Abierto' ? 'checked' : ''; ?>>
                                    <span class="slider round"></span>
                                </label>
                                <input type="hidden" name="id_restaurante" value="<?php echo htmlspecialchars($user['ID_Restaurante']); ?>">
                               <button type="submit" class="btn btn-primary"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-custom-class="custom-tooltip"
                                        data-bs-title="">
                                Aceptar
                                </button>
                            </form>


                            <div class="d-flex flex-column align-items-center text-center">
                                <br>
                                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin"
                                    class="rounded-circle" width="150">
                                <div class="mt-3">
            
                                    <p class="text-secondary mb-1"><?php echo htmlspecialchars($user['Nombre_R']); ?></p>
                                    <p class="text-secondary mb-1"><?php echo htmlspecialchars($user['Direccion']); ?></p>
                                    <p class="text-muted font-size-sm"><?php echo htmlspecialchars($user['Telefono']); ?></p>
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Acciones
                                    </a>
                                    
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="controlador.php?seccion=ADMI_Editar_A">Editar datos</a></li>
                                        <li><a class="dropdown-item" href="controlador.php?seccion=ADMI_CambiarPass">Cambiar Contraseña</a></a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="controlador.php?seccion=Perfil_P">Ordenes</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="../Controladores/controlador_cerrar_session.php">Cerrar sesión</a>
                                    </ul>
                                    <br>
                                
                                    
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
                                    <h6 class="">Nombre</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo htmlspecialchars($user['Nombre_R']); ?>
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
                                    <h6 class="mb-0">Dirección </h6>
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