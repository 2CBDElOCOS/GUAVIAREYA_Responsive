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
        <div class="row">
            <div class="col-md-12 ico-footer1 mb-3">
                <a href="controlador.php?seccion=perfil"><i class="fa-solid fa-tent-arrow-turn-left"></i></a>
            </div>
            <div class="main-body">
                <h4>Editar Perfil</h4>
                <!-- Formulario de edición de perfil -->
                <form action="Controlador_EditarUser.php" method="POST">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label for="Nombre" class="col-sm-3 col-form-label">Nombre</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="Nombre" name="Nombre" class="form-control form-control-lg bg-light fs-6" placeholder="Nombre" value="<?php echo htmlspecialchars($user['Nombre']); ?>">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="mb-3 row">
                                        <label for="Apellido" class="col-sm-3 col-form-label">Apellido</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="Apellido" name="Apellido" class="form-control form-control-lg bg-light fs-6" placeholder="Apellido" value="<?php echo htmlspecialchars($user['Apellido']); ?>">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="mb-3 row">
                                        <label for="Telefono" class="col-sm-3 col-form-label">Teléfono</label>
                                        <div class="col-sm-9">
                                            <input type="tel" id="Telefono" name="Telefono" class="form-control form-control-lg bg-light fs-6" placeholder="Teléfono" value="<?php echo htmlspecialchars($user['Telefono']); ?>">
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
    </div>
</body>
</html>
