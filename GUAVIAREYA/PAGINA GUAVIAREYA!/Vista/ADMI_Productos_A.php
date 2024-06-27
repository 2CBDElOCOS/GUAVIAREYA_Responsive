<!DOCTYPE html>
<html lang="en">

<head>
    <title>GuaviareYa!</title>
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

            // Verificar si el ID_Restaurante está almacenado en la sesión
            if (isset($_SESSION['id_restaurante'])) {
                $id_restaurante = $_SESSION['id_restaurante'];

                // Obtener los productos asociados a este ID_Restaurante
                $productos = $mostrarProductos->obtenerProductosPorRestaurante($id_restaurante);

                // Mostrar los productos
                foreach ($productos as $producto) {
                    echo '
        <div class="col">
            <div class="card">
                <form method="post" action="../Controladores/controlador_eliminar.php" onsubmit="return confirm(\'¿Estás seguro de que quieres eliminar este producto?\');">
                    <input type="hidden" name="ID_Producto" value="' . $producto['ID_Producto'] . '">
                    <button type="submit"><i class="fa fa-trash"></i></button>
                </form>
                <img style="width: 200px; height: 200px; display: block; margin-left: auto; margin-right: auto; margin-top: 20px;" src="../media_productos/' . $producto['img_P'] . '" class="rounded float-start" alt="Imagen de ' . $producto['Nombre_P'] . '">
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
            } else {
                // Manejar el caso donde el ID_Restaurante no está presente en la sesión
                echo "No se ha especificado un restaurante válido.";
            }
            ?>
        </div>

        <div class="col-md-12 ico-header">
            <a href="controlador.php?seccion=ADMI_Agregar_P"><i class="fa fa-plus"></i></a>
        </div>
    </div>
</body>

</html>