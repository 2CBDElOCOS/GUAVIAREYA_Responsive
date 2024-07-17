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
                <a href="controlador.php?seccion=shop"><i class="fa-solid fa-tent-arrow-turn-left"></i></a>
            </div>
            
            <div class="row">
            <div class="col-md-10">
                    <div class="card mb-12">
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
                                    echo "<h6 class='mb-0'>Calle/Carrera y Número</h6>";
                                    echo "</div>";
                                    echo "<div class='col-sm-9 text-secondary'>";
                                    echo htmlspecialchars($address['CL_Cra_AV'] . ' ' . $address['Numero_Casa']);
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
                                    echo "<br>";
                                }
                            } else {
                                echo "<p>No se encontraron direcciones de entrega.</p>";
                            }
                            ?>
                            <!-- Fin de mostrar las direcciones de entrega -->

                            <!-- Formulario para agregar una nueva dirección -->
                            <hr>
                            <h3>Agregar Nueva Dirección de Entrega</h3>
                             <form action="ControladorDireccionEntrega.php" method="POST">
                                <div class="mb-3">
                                    <label for="Numero_Casa" class="form-label">Número de Casa</label>
                                    <input type="text" class="form-control" id="Numero_Casa" name="Numero_Casa" placeholder="Casa N°" required>
                                </div>
                                <div class="mb-3">
                                    <label for="CL_Cra_AV" class="form-label">Calle/Carrera o Avenida</label>
                                    <input type="text" class="form-control" id="CL_Cra_AV" name="CL_Cra_AV" placeholder="Direccion" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Barrio" class="form-label">Barrio</label>
                                    <input type="text" class="form-control" id="Barrio" name="Barrio" placeholder="Nombre del barrio" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Agregar Dirección</button>
                            </form>
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
