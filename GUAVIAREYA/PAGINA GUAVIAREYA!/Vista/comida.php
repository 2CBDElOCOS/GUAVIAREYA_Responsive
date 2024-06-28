<!DOCTYPE html>
<html lang="en">

<head>

    <title>GuaviareYa!</title>

</head>

<body class="body">

    <section id="hero3">
        <div class="subcontainer2">
            <div class="row hero2">
                <div class="col-md-12 ico-footer">
                    <a href="controlador.php?seccion=shop"><i class="fa-solid fa-tent-arrow-turn-left"></i></a>
                </div>

                <h1>RESTAURANTES</h1>

                <div class="row row-cols-1 row-cols-md-3 g-4 py-5">
                    <?php
                    include('../Modelos/mostrar_restaurantes.php');

                    $mostrarProductos = new mostrar_restaurantes();
                    $restaurantes = $mostrarProductos->obtenerRestaurantes();

                    foreach ($restaurantes as $restaurantes) {
                        echo '
                <div class="col">
                    <div class="card">
                        <img style="width: 200px;height: 200px;display: block; margin-left: auto; margin-right: auto;margin-top: 20px;" src="../media_restaurantes/' . $restaurantes['img_R'] . '" class="rounded float-start" alt="Imagen de ' . $restaurantes['Nombre_R'] . '">
                        <div class="card-body">
                            <h5 class="card-title"> NOMBRE: '. $restaurantes['Nombre_R'] . '</h5>
                            <p class="card-text">  Direcion: ' . $restaurantes['Direccion'] . '</p>
                            <p class="card-text">  Telefono: '  . $restaurantes['Telefono'] . '</p>
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