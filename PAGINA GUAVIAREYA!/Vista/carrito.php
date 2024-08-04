<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GuaviareYa!</title>
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-12 text-center my-3 ico-carro">
                <a href="controlador.php?seccion=comida">
                    <i class="fa-solid fa-circle-arrow-left"></i>
                </a>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Tu Carrito</h3>

                        <?php
                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }

                        include('../Modelos/mostrar_productos.php');
                        $mostrarProductos = new mostrar_productos();

                        $isEmpty = !isset($_SESSION['carrito']) || empty($_SESSION['carrito']);
                        $subtotal = 0;

                        if ($isEmpty) {
                            echo '<div class="col-12 text-center"><h3 class="name-car">Tu carrito está vacío</h3></div>';
                        } else {
                            foreach ($_SESSION['carrito'] as $ID_Restaurante => $restaurante) {
                                echo '<div class="col-12"><h6 class="fw-bold text-uppercase pt-3">' . htmlspecialchars($restaurante['Nombre_Restaurante']) . '</h6></div>';
                                foreach ($restaurante['productos'] as $producto) {
                                    $subtotal += $producto['Valor_P'] * $producto['cantidad'];
                                    echo '
                                    <div class="row carrito" data-id="' . htmlspecialchars($producto['ID_Producto']) . '">
                                        <div class="col-4 col-md-2">
                                            <img src="../media_productos/' . htmlspecialchars($producto['img_P']) . '" alt="' . htmlspecialchars($producto['Nombre_P']) . '" class="img-fluid">
                                        </div>
                                        <div class="col-8 col-md-5">
                                            <p>' . htmlspecialchars($producto['Descripcion']) . '</p>
                                        </div>
                                        <div class="col-12 col-md-2">
                                            <input type="number" name="cantidad" min="1" max="20" value="' . $producto['cantidad'] . '" class="form-control cantidad" data-id="' . $producto['ID_Producto'] . '">
                                        </div>
                                        <div class="col-12 col-md-3 text-end">
                                            <p class="precio-unitario" data-precio="' . $producto['Valor_P'] . '">COP ' . number_format($producto['Valor_P'], 0, ',', '.') . '</p>
                                            <a href="controlador_eliminar_procarrito.php?id_producto=' . $producto['ID_Producto'] . '&id_restaurante=' . $ID_Restaurante . '">
                                                <i class="fa-solid fa-trash" style="color: orange; font-size: 25px;"></i>
                                            </a>
                                        </div>
                                    </div>';
                                }
                            }

                            echo '
                            <div class="col-12 subtotal">
                                <h3 class="text-center">SUBTOTAL</h3>
                                <p class="valor text-center" id="subtotal" style="font-weight: bold;">COP ' . number_format($subtotal, 0, ',', '.') . '</p>
                            </div>';
                        }
                        ?>

                        <div class="col-12 text-center">
                            <a href="controlador.php?seccion=facturacion">
                                <button class="btn-pagar <?php echo $isEmpty ? 'btn-disabled' : ''; ?>" <?php echo $isEmpty ? 'disabled' : ''; ?>>Pagar</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../JS/actualizar_carrito.js"></script>
</body>

</html>
