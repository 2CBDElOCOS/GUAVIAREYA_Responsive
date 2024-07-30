<?php
include '../Modelos/mostrar_restaurantes.php';

// Instanciar el modelo
$mostrarProductos = new mostrar_restaurantes();
$restaurantes = $mostrarProductos->obtenerRestaurantes();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>RESTAURANTES</title>
</head>
<body class="body">
    <section id="hero3">
        <div class="subcontainer2">
            <div class="row hero2">
                <div class="col-md-12 ico-footer">
                    <a href="controlador.php?seccion=SuperAdmin_Panel"><i class="fa-solid fa-tent-arrow-turn-left"></i></a>
                </div>
                <h1>RESTAURANTES</h1>
                <div class="row row-cols-1 row-cols-md-3 g-4 py-5">
                    <?php
                    foreach ($restaurantes as $restaurante) {
                        $estado = $restaurante['Estado'];
                        $id_restaurante = $restaurante['ID_Restaurante'];

                        // Determina la clase de color basada en el estado
                        $estadoClase = $estado === 'Abierto' ? 'text-success' : 'text-danger';

                        echo '
                        <div class="col">
                            <div class="card">
                                <img style="width: 200px; height: 200px; display: block; margin-left: auto; margin-right: auto; margin-top: 20px;" src="../media_restaurantes/' . $restaurante['img_R'] . '" class="rounded float-start" alt="Imagen de ' . $restaurante['Nombre_R'] . '"> <br>
                                <div class="card-body">
                                    <h5 class="card-title"> NOMBRE: '. $restaurante['Nombre_R'] . '</h5> 
                                    <p class="card-text"> Dirección: ' . $restaurante['Direccion'] . '</p>
                                    <p class="card-text"> Teléfono: '  . $restaurante['Telefono'] . '</p>
                                    <p class="card-text ' . $estadoClase . '"> Estado: '  . $estado . '</p>
                                </div>
                            </div>
                        </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
