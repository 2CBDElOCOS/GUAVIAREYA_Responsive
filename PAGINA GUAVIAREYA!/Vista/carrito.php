<!DOCTYPE html>
<html lang="en">
<head>
    <title>GuaviareYa!</title>
</head>
<body>
    <div class="container">
        <div class="col-md-12 ico-carro">
            <a href="controlador.php?seccion=comida"><i class="fa-solid fa-circle-arrow-left"></i></a>
        </div>
        <div class="subcontainer3">
            <div class="row">
                <div class="col-md-12 carrito">
                    <h3 class="name-ca">Tu Carrito</h3>
                </div>
            </div>

            <?php
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            include('../Modelos/mostrar_productos.php');
            $mostrarProductos = new mostrar_productos();

            $isEmpty = !isset($_SESSION['carrito']) || empty($_SESSION['carrito']);
            $subtotal = 0;

            if ($isEmpty) {
                echo '<div class="row"><div class="col-md-12"><h3 class="name-car">Tu carrito está vacío</h3></div></div>';
            } else {
                foreach ($_SESSION['carrito'] as $ID_Restaurante => $restaurante) {
                    echo '<h6 style="font-weight: bold; text-transform: uppercase; padding-top:10px">' . htmlspecialchars($restaurante['Nombre_Restaurante']) . '</h6>';
                    foreach ($restaurante['productos'] as $producto) {
                        $subtotal += $producto['Valor_P'] * $producto['cantidad'];
                        echo '
                        <div class="row carrito" data-id="' . htmlspecialchars($producto['ID_Producto']) . '">
                            <div class="col-md-2">
                                <img src="../media_productos/' . htmlspecialchars($producto['img_P']) . '" alt="' . htmlspecialchars($producto['Nombre_P']) . '" width="100px">
                            </div>
                            <div class="col-md-5">
                                <p>' . htmlspecialchars($producto['Descripcion']) . '</p>
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="cantidad" min="1" max="20" value="' . $producto['cantidad'] . '" class="cantidad" data-id="' . $producto['ID_Producto'] . '">
                            </div>
                            <div class="col-md-3 precio">
                                <p class="precio-unitario" data-precio="' . $producto['Valor_P'] . '">COP ' . number_format($producto['Valor_P'], 0, ',', '.') . '</p>
                                <a href="controlador_eliminar_procarrito.php?id_producto=' . $producto['ID_Producto'] . '&id_restaurante=' . $ID_Restaurante . '"><i class="fa-solid fa-trash" style="color: orange; font-size: 25px;"></i></a>
                            </div>
                        </div>';
                    }
                }

                echo '
                <div class="row">
                    <div class="col-md-12 subtotal">
                        <h3 class="name-car">SUBTOTAL</h3>
                        <p class="valor" id="subtotal" style="font-weight: bold;">COP ' . number_format($subtotal, 0, ',', '.') . '</p>
                    </div>
                </div>';
            }
            ?>

            <div class="row">
                <div class="col-md-12">
                    <a href="controlador.php?seccion=facturacion">
                        <button class="btn-pagar <?php echo $isEmpty ? 'btn-disabled' : ''; ?>" <?php echo $isEmpty ? 'disabled' : ''; ?>>Pagar</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="../JS/actualizar_carrito.js"></script>
</body>
</html>
