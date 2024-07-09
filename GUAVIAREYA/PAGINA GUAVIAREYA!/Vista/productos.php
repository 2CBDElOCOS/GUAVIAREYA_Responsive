<!DOCTYPE html>
<html lang="en">

<head>
    <title>GuaviareYa!</title>
</head>

<body class="body">
    <div class="container py-5">
        <div class="col-md-12 ico-header">
            <a href="controlador.php?seccion=comida"><i class="fa fa-circle-arrow-left"></i></a>
            <a href="controlador.php?seccion=carrito"><i class="bx bx-cart"></i></a>
        </div>

        <?php
        include('../Modelos/mostrar_productos.php');

        $mostrarProductos = new mostrar_productos();

        // Verificar si el ID_Restaurante está almacenado en la sesión
        if (isset($_SESSION['ID_Restaurante'])) {
            $id_restaurante = $_SESSION['ID_Restaurante'];

            // Obtener el nombre del restaurante
            $nombre_restaurante = $mostrarProductos->obtenerNombreRestaurante($id_restaurante);
            echo '<h1 style="text-align: center; color: white;">' . $nombre_restaurante . '</h1>';

            echo '<div class="row row-cols-1 row-cols-md-3 g-4 py-5">';
            // Obtener los productos asociados a este ID_Restaurante
            $productos = $mostrarProductos->obtenerProductosPorRestaurante($id_restaurante);

            // Mostrar los productos
            foreach ($productos as $producto) {
                echo '
                <div class="col">
                    <div class="card">
                        <img style="width: 200px; height: 200px; display: block; margin-left: auto; margin-right: auto; margin-top: 20px;" src="../media_productos/' . $producto['img_P'] . '" class="rounded float-start" alt="Imagen de ' . $producto['Nombre_P'] . '">
                        <div class="card-body">
                            <h5 class="card-title">' . $producto['Nombre_P'] . '</h5>
                            <p class="card-text">' . $producto['Descripcion'] . '</p>
                        </div>
                        <div class="mb-5 d-flex justify-content-between align-items-center">
                            <h3>' . $producto['Valor_P'] . '</h3>
                            <form method="post" action="../Controladores/controlador_agregar.php">
                                <input type="hidden" name="ID_Producto" value="' . $producto['ID_Producto'] . '">
                                <button type="submit" class="btn btn-primary"> Agregar</button>
                            </form>
                        </div>
                    </div>
                </div>';
            }
            echo '</div>';
        } else {
            // Manejar el caso donde el ID_Restaurante no está presente en la sesión
            echo '<h1 style="text-align: center; color: white;">No se ha especificado un restaurante válido.</h1>';
        }
        ?>
    </div>
</body>

</html>
