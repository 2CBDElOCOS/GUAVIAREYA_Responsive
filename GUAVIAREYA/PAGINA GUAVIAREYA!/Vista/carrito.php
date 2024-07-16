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
            if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
                $subtotal = 0;
                foreach ($_SESSION['carrito'] as $producto) {
                    $subtotal += $producto['Valor_P'];
                    echo '
                    <div class="row carrito">
                        <div class="col-md-2">
                            <img src="../media_productos/' . $producto['img_P'] . '" alt="' . $producto['Nombre_P'] . '" width="100px">
                        </div>
                        <div class="col-md-5">
                            <p>' . $producto['Descripcion'] . '</p>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="cantidad" min="1" max="20" value="' . $producto['cantidad'] . '" class="cantidad">
                        </div>
                        <div class="col-md-3 precio">
                            <p>COP ' . number_format($producto['Valor_P'], 0, ',', '.') . '</p>
                            <a href="controlador_eliminar_procarrito.php?id_producto=' . $producto['ID_Producto'] . '"><i class="fa-solid fa-trash" style="color: orange; font-size: 25px;"></i></a>
                        </div>
                    </div>';
                }

                echo '
                <div class="row">
                    <div class="col-md-12 subtotal">
                        <h3 class="name-car">SUBTOTAL</h3>
                        <p class="valor" style="font-weight: bold;">COP ' . number_format($subtotal, 0, ',', '.') . '</p>
                    </div>
                </div>';
            } else {
                echo '<div class="row"><div class="col-md-12"><h3 class="name-car">Tu carrito está vacío</h3></div></div>';
            }
            ?>

            <div class="row">
                <div class="col-md-12">
                    <a href="controlador.php?seccion=tarjeta"><button class="btn-pagar">Pagar</button></a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
