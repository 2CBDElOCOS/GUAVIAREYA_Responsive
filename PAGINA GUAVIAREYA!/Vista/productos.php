<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GuaviareYa!</title>
</head>

<body class="body">
    <div class="container py-5">
        <div class="productos-container">
            <div class="col-md-12 gp-ico-header d-flex justify-content-between mb-4">
                <a href="controlador.php?seccion=comida"><i class="fa fa-circle-arrow-left"></i></a>
                <a style="text-decoration: none;" href="controlador.php?seccion=carrito">
                    <i class="bx bx-cart"></i>
                    <span id="gp-contador-carrito" class="gp-contador-carrito">
                        <?php
                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }

                        $contador_carrito = 0;
                        if (isset($_SESSION['carrito'])) {
                            foreach ($_SESSION['carrito'] as $restaurante) {
                                foreach ($restaurante['productos'] as $item) {
                                    $contador_carrito += $item['cantidad'];
                                }
                            }
                        }
                        echo $contador_carrito;
                        ?>
                    </span>
                </a>
            </div>

            <?php
            include('../Modelos/mostrar_productos.php');

            $mostrarProductos = new mostrar_productos();

            if (isset($_GET['id_restaurante'])) {
                $id_restaurante = $_GET['id_restaurante'];
                $nombre_restaurante = $mostrarProductos->obtenerNombreRestaurante($id_restaurante);
                echo '<h1 class="text-center text-white">' . htmlspecialchars($nombre_restaurante) . '</h1>';

                echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 py-5">';
                $productos = $mostrarProductos->obtenerProductosPorRestaurante($id_restaurante);

                foreach ($productos as $producto) {
                    echo '
                    <div class="col">
                        <div class="gp-card h-100">
                            <img src="../media_productos/' . htmlspecialchars($producto['img_P']) . '" class="gp-card-img-top" alt="Imagen de ' . htmlspecialchars($producto['Nombre_P']) . '">
                            <div class="gp-card-body d-flex flex-column">
                                <h5 class="gp-card-title">' . htmlspecialchars($producto['Nombre_P']) . '</h5>
                                <p class="gp-card-text">' . htmlspecialchars($producto['Descripcion']) . '</p>
                                <h3 class="mt-auto mb-3">' . htmlspecialchars($producto['Valor_P']) . '</h3>
                                <form method="post" action="controlador_carrito.php?seccion=carrito" class="gp-form-agregar">
                                    <input type="hidden" name="ID_Producto" value="' . htmlspecialchars($producto['ID_Producto']) . '">
                                    <input type="hidden" name="Nombre_P" value="' . htmlspecialchars($producto['Nombre_P']) . '">
                                    <input type="hidden" name="Descripcion" value="' . htmlspecialchars($producto['Descripcion']) . '">
                                    <input type="hidden" name="img_P" value="' . htmlspecialchars($producto['img_P']) . '">
                                    <input type="hidden" name="Valor_P" value="' . htmlspecialchars($producto['Valor_P']) . '">
                                    <input type="hidden" name="ID_Restaurante" value="' . htmlspecialchars($id_restaurante) . '">
                                    <input type="hidden" name="Nombre_Restaurante" value="' . htmlspecialchars($nombre_restaurante) . '">
                                    <button type="submit" class="btn btn-primary gp-btn-agregar">Agregar</button>
                                </form>
                            </div>
                        </div>
                    </div>';
                }
                echo '</div>';
            } else {
                echo '<h1 class="text-center text-white">No se ha especificado un restaurante válido.</h1>';
            }
            ?>
        </div>
    </div>

    <script src="../JS/conteo_carrito.js"></script>
</body>

</html>
