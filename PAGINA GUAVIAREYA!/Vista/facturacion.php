<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['correo']) || empty($_SESSION['correo'])) {
    header("location: ../Controladores/controlador.php?seccion=login");
    exit();
}

require_once "../Modelos/Direccion_Entregas.php";
require_once "../Modelos/mostrar_productos.php";
require_once '../Modelos/Cupones.php';

// Obtener las direcciones de entrega del usuario.
$addresses = Modelo_Direccion_Entregas::obtenerDireccionesPorUsuario($_SESSION['correo']);
// Inicializar el objeto para obtener los nombres de los restaurantes
$mostrarProductos = new mostrar_productos();
// Obtener el cupón asociado con el correo del usuario
$cupon = Cupones::ObtenerCuponPorCorreo($_SESSION['correo']);
// Verificar si el cupón se ha obtenido correctamente
if ($cupon) {
    // Guarda el cupón en la sesión
    $_SESSION['cupon'] = $cupon;
} else {
    $_SESSION['cupon'] = null;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GuaviareYa!</title>
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-12 text-center ico-carro">
                <a href="controlador.php?seccion=carrito"><i class="fa-solid fa-circle-arrow-left"></i></a>
            </div>

            <div class="col-md-3 mb-4"> <!-- Añadido mb-4 para margen inferior -->
                <button type="submit" class="btn btn-primary modal-btn-validate" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="width: auto; padding: 0.5em 1em; white-space: nowrap;">
                    Validar cupón
                </button>
            </div>

            <div class="col-12 mb-4">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                ¿Dónde quieres que entreguemos tu pedido?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <form id="direccionForm" method="post"
                                    action="../Controladores/controlador_guardar_direccion.php">
                                    <table class="table table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th scope="col">Seleccionar</th>
                                                <th scope="col">Dirección</th>
                                                <th scope="col">Barrio</th>
                                                <th scope="col">Descripción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($addresses) {
                                                foreach ($addresses as $address) {
                                                    echo '<tr>';
                                                    echo '<td><input class="form-check-input" type="radio" name="direccion_seleccionada" value="' . htmlspecialchars($address['ID_Dire_Entre']) . '" required></td>';
                                                    echo '<td>' . htmlspecialchars($address['Direccion']) . '</td>';
                                                    echo '<td>' . htmlspecialchars($address['Barrio']) . '</td>';
                                                    echo '<td>' . htmlspecialchars($address['Descripcion']) . '</td>';
                                                    echo '</tr>';
                                                }
                                                echo '<tr><td colspan="4"><button type="submit" class="btn-pagar">Seleccionar Dirección</button></td></tr>'; // Ajustar colspan
                                            } else {
                                                echo '<tr><td colspan="4" style="text-align:center;"><a href="../Controladores/controlador.php?seccion=Perfil_Direcciones" class="btn btn-link">No se encontraron direcciones de entrega.</a></td></tr>'; // Ajustar colspan
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mb-4">
                <div class="accordion" id="accordionExample">
                    <?php
                    // Inicializar la variable para productos por restaurante
                    $productosPorRestaurante = [];

                    if (!empty($_SESSION['carrito'])) {
                        foreach ($_SESSION['carrito'] as $ID_Restaurante => $restaurante) {
                            $nombre_restaurante = $mostrarProductos->obtenerNombreRestaurante($ID_Restaurante);
                            $productosPorRestaurante[$ID_Restaurante] = [
                                'nombre_restaurante' => $nombre_restaurante,
                                'productos' => $restaurante['productos']
                            ];
                        }

                        foreach ($productosPorRestaurante as $id_restaurante => $datos) {
                            echo '<div class="accordion-item">';
                            echo '<h2 class="accordion-header">';
                            echo '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRestaurante' . $id_restaurante . '" aria-expanded="true" aria-controls="collapseRestaurante' . $id_restaurante . '">';
                            echo htmlspecialchars($datos['nombre_restaurante']);
                            echo '</button>';
                            echo '</h2>';
                            echo '<div id="collapseRestaurante' . $id_restaurante . '" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">';
                            echo '<div class="accordion-body">';

                            foreach ($datos['productos'] as $producto) {
                                echo '<div class="product-row">';
                                echo '<div class="product-details">';
                                echo '<img src="../media_productos/' . htmlspecialchars($producto['img_P']) . '" alt="' . htmlspecialchars($producto['Nombre_P']) . '" width="100px">';
                                echo '<p>' . htmlspecialchars($producto['cantidad']) . ' ' . htmlspecialchars($producto['Nombre_P']) . '</p>';
                                echo '<p>$' . number_format($producto['Valor_P'], 0, ',', '.') . ' COP</p>';
                                echo '</div>';
                                echo '</div>';
                            }

                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No hay productos en el carrito.</p>';
                    }
                    ?>
                </div>
            </div>

            <div class="col-12 estimada">
                <h6 class="esti">Entrega estimada:</h6>
                <b>
                    <p class="esti-tiempo">35-50 minutos</p>
                </b>
            </div>

            <div class="col-12 esti-tiempo">
                <div class="flex-container">
                    <input type="radio" name="envio" id="Prioritaria" value="Prioritaria"
                        onclick="updateEstimatedTimeAndFees()">
                    <div class="label-container">
                        <b><label for="Prioritaria">Prioritaria 🚀</label></b>
                        <h6>envío directo</h6>
                    </div>
                    <div class="precio">
                        <h6>+5.000</h6>
                    </div>
                </div>

                <div class="flex-container">
                    <input type="radio" name="envio" id="Básica" value="Básica" checked
                        onclick="updateEstimatedTimeAndFees()">
                    <div class="label-container">
                        <b><label for="Básica">Básica 🍔</label></b>
                        <h6>Entrega habitual</h6>
                    </div>
                    <div class="precio">
                        <h6>3.000</h6>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header"> <!-- Corregido el error -->
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="../Controladores/controlador_validar_cupon.php">
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="Codigo_Cupon" placeholder="Código del cupón" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Validar</button>
                                <p id="mensaje_cupon" class="mt-3">
                                    <?php
                                    // Muestra el mensaje del cupón si está disponible
                                    if (isset($_SESSION['mensaje_cupon'])) {
                                        echo htmlspecialchars($_SESSION['mensaje_cupon']);
                                        unset($_SESSION['mensaje_cupon']);
                                    }
                                    ?>
                                </p>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mb-4">
                <div class="accordion" id="accordionSummary">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSummary" aria-expanded="true" aria-controls="collapseSummary">
                                Resumen
                            </button>
                        </h2>
                        <div id="collapseSummary" class="accordion-collapse collapse show"
                            data-bs-parent="#accordionSummary">
                            <div class="accordion-body">
                                <div class="resumen_total">
                                    <?php
                                    // Inicializar variables para el resumen
                                    $descuentoCupon = 0;
                                    $subtotal = 0;
                                    $costoEnvio = 3000;
                                    $impuestosTarifas = 2000;

                                    if ($cupon) {
                                        $descuentoCupon = $cupon['descuento']; // Porcentaje de descuento
                                    }

                                    if (!empty($productosPorRestaurante)) {
                                        foreach ($productosPorRestaurante as $restaurante) {
                                            foreach ($restaurante['productos'] as $producto) {
                                                $subtotal += $producto['Valor_P'] * $producto['cantidad'];
                                            }
                                        }
                                    }

                                    // Calcular el total antes de aplicar el descuento
                                    $total = $subtotal + $costoEnvio + $impuestosTarifas;

                                    // Aplicar el descuento del cupón
                                    $totalConDescuento = $total - ($total * ($descuentoCupon / 100));
                                    ?>

                                    <div class="resumen">
                                        <h6>Costo de productos</h6>
                                        <i>
                                            <p class="subtotal">$<?php echo number_format($subtotal, 0, ',', '.'); ?>
                                            </p>
                                        </i>
                                    </div>
                                    <div class="resumen">
                                        <h6>Envío</h6>
                                        <i>
                                            <p class="costo-envio">
                                                +$<?php echo number_format($costoEnvio, 0, ',', '.'); ?></p>
                                        </i>
                                    </div>
                                    <div class="resumen">
                                        <h6>Impuestos y tarifas</h6>
                                        <i>
                                            <p class="impuestos">
                                                +$<?php echo number_format($impuestosTarifas, 0, ',', '.'); ?></p>
                                        </i>
                                    </div>
                                    <div class="resumen">
                                        <h6>Total</h6>
                                        <i>
                                            <p class="total">
                                                $<?php echo number_format($totalConDescuento, 0, ',', '.'); ?></p>
                                        </i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form method="post" action="../Controladores/controlador_pedidos.php">
                <input type="hidden" name="costo_envio" id="costo_envio" value="3000">
                <input type="hidden" name="total" id="total" value="<?php echo htmlspecialchars($totalConDescuento); ?>">
                <input type="hidden" name="descuento_cupon" id="descuento_cupon" value="<?php echo htmlspecialchars($descuentoCupon); ?>">
                <input type="hidden" name="cupon" id="cupon" value="<?php echo htmlspecialchars($_SESSION['cupon']['codigo'] ?? ''); ?>">

                <?php
                foreach ($productosPorRestaurante as $id_restaurante => $datos) {
                    echo '<input type="hidden" name="restaurantes[' . htmlspecialchars($id_restaurante) . '][nombre]" value="' . htmlspecialchars($datos['nombre_restaurante']) . '">';
                    foreach ($datos['productos'] as $producto) {
                        echo '<input type="hidden" name="restaurantes[' . htmlspecialchars($id_restaurante) . '][productos][]" value="' . htmlspecialchars($producto['ID_Producto']) . '">';
                        echo '<input type="hidden" name="restaurantes[' . htmlspecialchars($id_restaurante) . '][cantidad][]" value="' . htmlspecialchars($producto['cantidad']) . '">';
                        echo '<input type="hidden" name="restaurantes[' . htmlspecialchars($id_restaurante) . '][precio][]" value="' . htmlspecialchars($producto['Valor_P']) . '">';
                    }
                }
                ?>
                <input type="hidden" name="tipo_envio" id="tipo_envio" value="Básica">
                <button type="submit" id="confirmarPedidoBtn" class="btn-pagar">Confirmar pedido</button>
            </form>
        </div>
    </div>

</body>

<script src="../JS/actualizar_tiempo_entrega.js"></script>
<script src="../JS/guardar_direccion_seleccionada.js"></script>
<script src="../JS/confirmar_pedido.js"></script>

</html>