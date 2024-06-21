<!DOCTYPE html>
<html lang="en">

<head>
    <title>GuaviareYa!</title>
    <!-- Add the necessary styles and scripts -->
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="path/to/bootstrap/css/bootstrap.min.css">
    <script src="path/to/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>

<body class="body">
    <div class="container py-5">
        <div class="col-md-12 ico-header">
            <a href="controlador.php?seccion=ADMI_Shop_A"><i class="fa fa-circle-arrow-left"></i></a>
        </div>

        <h1 style="text-align: center; color: white;">#RESTAURANTE</h1>

        <div class="row row-cols-1 row-cols-md-3 g-4 py-5">
            <?php
            include('../Modelos/mostrar_productos.php');

            $mostrarProductos = new mostrar_productos();
            $productos = $mostrarProductos->obtenerProductos();

            foreach ($productos as $i => $producto) {   
                echo '
                <div class="col">
                    <div class="card">
                        <i class="fa fa-trash"></i>
                        <img style="width: 200px;height: 200px;display: block; margin-left: auto; margin-right: auto;margin-top: 20px;" src="../media/pi1.png" class="rounded float-start" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">' . $producto['Nombre_P'] . '</h5>
                            <p class="card-text">' . $producto['Descripcion'] . '</p>
                        </div>
                        <div class="mb-5 d-flex justify-content-around">
                            <h3>' . $producto['Valor_P'] . '</h3>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>

        <div class="col-md-12 ico-header">
            <a href="controlador.php?seccion=ADMI_Agregar_P"><i class="fa fa-plus"></i></a>
        </div>
    </div>
</body>

</html>

