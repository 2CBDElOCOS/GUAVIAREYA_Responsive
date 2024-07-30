<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar contraseña</title>
</head>
<body>
    <div class="container">
        <div class="col-md-12 ico-footer1">
            <a href="controlador.php?seccion=Perfil_SuperAdmi"><i class="fa-solid fa-tent-arrow-turn-left"></i></a>
        </div>
        <div class="main-body">
            <br>
            <div>
                <h4>CAMBIAR CONTRASEÑA</h4>
            </div>

            <!-- Formulario de cambio de contraseña -->
            <form id="passwordForm" action="Controlador_SuperAdmi.php" method="POST">
                <div class="row gutters-sm">
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <br>
                                        <h6 class="mb-0">Contraseña anterior</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <br>
                                        <input type="password" id="ContrasenaAnterior" name="ContrasenaAnterior" class="form-control form-control-lg bg-light fs-6" placeholder="Contraseña anterior" required>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <br>
                                        <h6 class="mb-0">Nueva contraseña</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <br>
                                        <input type="password" id="NuevaContrasena" name="NuevaContrasena" class="form-control form-control-lg bg-light fs-6" placeholder="Nueva contraseña" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <br>
                                        <small id="password-strength" class="password-strength"></small>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Confirma la nueva contraseña</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="password" id="ConfirmarContrasena" name="ConfirmarContrasena" class="form-control form-control-lg bg-light fs-6" placeholder="Confirma la nueva contraseña" required>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-info">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                            <div class="row">
                <div class="col-md-8">
                    <!-- Mensaje de error -->
                    <?php
                    if (isset($_GET['error'])) {
                        $error_message = '';
                        switch ($_GET['error']) {
                            case '1':
                                $error_message = 'Todos los campos son obligatorios.';
                                break;
                            case '2':
                                $error_message = 'Las contraseñas no coinciden.';
                                break;
                            case '3':
                                $error_message = 'Contraseña anterior incorrecta.';
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
            </form>


        </div>
    </div>
    <script src="../JS/mensaje_pass2.js"></script>
</body>
</html>
