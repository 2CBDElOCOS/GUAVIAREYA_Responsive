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
$imgUrl = $user['img_U']; // Suponiendo que 'img_U' es el nombre de la columna que contiene la URL de la imagen
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>MIS PEDIDOS</title>
</head>

<body>
    <div class="row">
        <div class="col-md-12">
            <?php
            if (isset($_GET['error'])) {
                $error_message = '';
                switch ($_GET['error']) {
                    case '1':
                        $error_message = 'Error al agregar la dirección de entrega.';
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
                <a href="controlador.php?seccion=perfil"><i class="fa-solid fa-tent-arrow-turn-left"></i></a>
            </div>
            
            <div class="row">
            <div class="col-md-8">
                    <div class="card mb-6">
                        <div class="card-body">
                            <!-- Mostrar las direcciones de entrega -->
                            <h3>Direcciones de Entrega</h3>
                            <br>
                            <?php
                            // Obtener y mostrar las direcciones de entrega del usuario
                            $addresses = Modelo_Direccion_Entregas::obtenerDireccionesPorUsuario($_SESSION['correo']);
                            if ($addresses) {
                                foreach ($addresses as $address) {
                                    echo "<div class='row'>";
                                    echo "<div class='col-sm-3'>";
                                    echo "<h6 class='mb-0'>Direccion</h6>";
                                    echo "</div>";
                                    echo "<div class='col-sm-9 text-secondary'>";
                                    echo htmlspecialchars($address['Direccion']);
                                    echo "</div>";
                                    echo "</div>";
                                    echo "<hr>";
                                    echo "<div class='row'>";
                                    echo "<div class='col-sm-3'>";
                                    echo "<h6 class='mb-0'>Barrio</h6>";
                                    echo "</div>";
                                    echo "<div class='col-sm-9 text-secondary'>";
                                    echo htmlspecialchars($address['Barrio']);
                                    echo "</div>";
                                    echo "</div>";
                                    echo "<hr>";
                                    echo "<div class='row'>";
                                    echo "<div class='col-sm-3'>";
                                    echo "<h6 class='mb-0'>Descripcion_Ubicacion</h6>";
                                    echo "</div>";
                                    echo "<div class='col-sm-9 text-secondary'>";
                                    echo htmlspecialchars($address['Descripcion_Ubicacion']);
                                    echo "</div>";
                                    echo "</div>";
                                }
                            } else {
                                echo "<p>No se encontraron direcciones de entrega.</p>";
                            }
                            ?>
                            <!-- Fin de mostrar las direcciones de entrega -->

                            <!-- Formulario para agregar una nueva dirección -->
                            <hr>
                            <div class="accordion" id="accordionPanelsStayOpenExample" >
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                    Editar direccion
                                </button>
                                </h2>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                                    <div class="accordion-body">

                                        <form id="registerForm" action="Controlador_DireccionEntrega.php" method="POST" enctype="multipart/form-data">
                                                <!-- Campos para el registro de usuario -->
                                                <div class="input-group mb-6">
                                                    <input type="text" name="Direccion" class="form-control form-control-lg bg-light fs-6" placeholder="Direccion" required>
                                                </div>
                                                <div class="input-group mb-6">
                                                    <input type="text" name="Barrio" class="form-control form-control-lg bg-light fs-6" placeholder="Barrio" required>
                                                </div>
                                                <div class="input-group mb-6">
                                                    <input type="text" name="Descipcion_Ubicacion" class="form-control form-control-lg bg-light fs-6" placeholder="Piso / Oficina / Apto / Depto" required>
                                                </div>

                                                <div class="input-group mb-3">
                                                    <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">Aceptar</button>
                                                </div>
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


        </div>

    </section>

</body>

</html>