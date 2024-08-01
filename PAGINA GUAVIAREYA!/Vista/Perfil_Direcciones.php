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

// Obtener la información del usuario desde la base de datos
$user = DataUser::getUserByEmail($_SESSION['correo']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIS DIRECCIONES</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-3 ico-footer1">
                <a href="controlador.php?seccion=perfil"><i class="fa-solid fa-tent-arrow-turn-left"></i></a>
            </div>
            <div class="main-body">
                <?php
                if (isset($_GET['error'])) {
                    $error_message = '';
                    switch ($_GET['error']) {
                        case '1':
                            $error_message = 'Por favor, rellena todos los campos requeridos.';
                            break;
                        case '2':
                            $error_message = 'Error al agregar la dirección de entrega.';
                            break;
                        default:
                            $error_message = 'Error desconocido.';
                            break;
                    }
                    echo "<div class='alert alert-danger' role='alert'>$error_message</div>";
                }
                ?>
                <h3>Direcciones de Entrega</h3>
                <div class="card mb-4">
                    <div class="card-body">
                        <?php
                        $addresses = Modelo_Direccion_Entregas::obtenerDireccionesPorUsuario($_SESSION['correo']);
                        if ($addresses) {
                            foreach ($addresses as $address) {
                                echo "<div class='mb-4'>";
                                echo "<div class='row'>";
                                echo "<div class='col-sm-3'><h6 class='mb-0'>Dirección</h6></div>";
                                echo "<div class='col-sm-9 text-secondary'>" . htmlspecialchars($address['Direccion']) . "</div>";
                                echo "</div><hr>";
                                echo "<div class='row'>";
                                echo "<div class='col-sm-3'><h6 class='mb-0'>Barrio</h6></div>";
                                echo "<div class='col-sm-9 text-secondary'>" . htmlspecialchars($address['Barrio']) . "</div>";
                                echo "</div><hr>";
                                echo "<div class='row'>";
                                echo "<div class='col-sm-3'><h6 class='mb-0'>Descripción</h6></div>";
                                echo "<div class='colsm-9 text-secondary'>" . htmlspecialchars($address['Descripcion']) . "</div>";
                                echo "</div>";
                                echo "</div>";
                            }
                        } else {
                            echo "<p>No se encontraron direcciones de entrega.</p>";
                        }
                        ?>
                        <hr>
                        <div class="accordion" id="accordionPanelsStayOpenExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                        Agregar Nueva Dirección
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <form id="registerForm" action="Controlador_DireccionEntrega.php" method="POST">
                                            <div class="mb-3">
                                                <input type="text" name="Direccion" class="form-control form-control-lg bg-light fs-6" placeholder="Dirección" required>
                                            </div>
                                            <div class="mb-3">
                                                <input type="text" name="Barrio" class="form-control form-control-lg bg-light fs-6" placeholder="Barrio" required>
                                            </div>
                                            <div class="mb-3">
                                                <input type="text" name="Descripcion_Ubicacion" class="form-control form-control-lg bg-light fs-6" placeholder="Piso / Oficina / Apto / Depto" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary ">Aceptar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fin del formulario para agregar una nueva dirección -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
