<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GuaviareYa!</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>

<body class="body bg-dark text-white">
    <div class="container py-5">
        <div class="d-flex justify-content-between mb-4">
            <a href="controlador.php?seccion=comida" class="text-white"><i class="fa fa-circle-arrow-left fa-2x"></i></a>
            <a href="controlador.php?seccion=carrito" class="text-white">
                <i class="fa fa-shopping-cart fa-2x"></i>
                <span id="contador-carrito" class="badge bg-secondary">
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
            echo '<h1 class="text-center text-white mb-4">' . htmlspecialchars($nombre_restaurante) . '</h1>';

            echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">';
            $productos = $mostrarProductos->obtenerProductosPorRestaurante($id_restaurante);

            foreach ($productos as $producto) {
                echo '
                <div class="col d-flex justify-content-center">
                    <div class="card" style="width: 18rem; margin-bottom: 1.5rem;">
                        <img src="../media_productos/' . htmlspecialchars($producto['img_P']) . '" class="card-img-top" alt="Imagen de ' . htmlspecialchars($producto['Nombre_P']) . '">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">' . htmlspecialchars($producto['Nombre_P']) . '</h5>
                            <p class="card-text">' . htmlspecialchars($producto['Descripcion']) . '</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Precio: ' . htmlspecialchars($producto['Valor_P']) . '</li>
                        </ul>
                        <div class="card-body d-flex justify-content-between mt-auto">
                            <form method="post" action="../Controladores/controlador_eliminar.php" onsubmit="return confirm(\'¿Estás seguro de que quieres eliminar este producto?\');" class="d-inline">
                                <input type="hidden" name="ID_Producto" value="' . htmlspecialchars($producto['ID_Producto']) . '">
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                            </form>
                            <form method="get" action="../Controladores/controlador.php?" onsubmit="return confirm(\'¿Estás seguro de que quieres editar este producto?\');" class="d-inline">
                                <input type="hidden" name="seccion" value="ADMI_editar_Producto">
                                <input type="hidden" name="id" value="' . htmlspecialchars($producto['ID_Producto']) . '">
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></button>
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

        <div class="d-flex justify-content-center mt-4">
            <a href="controlador.php?seccion=ADMI_Agregar_P" class="btn btn-success btn-lg"><i class="fa fa-plus"></i> Agregar Producto</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>
