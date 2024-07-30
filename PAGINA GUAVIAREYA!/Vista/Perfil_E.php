<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['correo']) || $_SESSION['correo'] == "") {
    header("location: ../Controladores/controlador.php?seccion=login");
    exit();
}

include '../Modelos/DataUser.php';

$correo = $_SESSION['correo'];
$dataUser = new DataUser();
$user = DataUser::getUserByEmail($correo);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>

</head>
<body>
    <div class="container">
        <div class="col-md-12 ico-footer1">
            <a href="controlador.php?seccion=perfil"><i class="fa-solid fa-tent-arrow-turn-left"></i></a>
        </div>
        <div class="main-body">
            <br>
            <div>
                <h4>Editar Perfil</h4>
            </div>

            <!-- Formulario de edición de perfil -->
            <form action="Controlador_EditarUser.php" method="POST">
                <div class="row gutters-sm">
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Nombre</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="Nombre" class="form-control form-control-lg bg-light fs-6" placeholder="Nombre" value="<?php echo htmlspecialchars($user['Nombre']); ?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Apellido</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="Apellido" class="form-control form-control-lg bg-light fs-6" placeholder="Apellido" value="<?php echo htmlspecialchars($user['Apellido']); ?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Teléfono</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="tel" name="Telefono" class="form-control form-control-lg bg-light fs-6" placeholder="Teléfono" value="<?php echo htmlspecialchars($user['Telefono']); ?>">
                                    </div>
                                </div>
                                <hr>
                                <input type="hidden" name="Correo" value="<?php echo htmlspecialchars($correo); ?>">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-info">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>

        

</body>
</html>
