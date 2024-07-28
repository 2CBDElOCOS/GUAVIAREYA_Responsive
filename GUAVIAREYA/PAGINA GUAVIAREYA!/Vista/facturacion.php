
<?php
// Asegúrate de que la sesión esté iniciada y que el usuario esté autenticado.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['correo']) || $_SESSION['correo'] == "") {
    header("location: ../Controladores/controlador.php?seccion=login");
    exit();
}

require_once "../Modelos/Direccion_Entregas.php";

// Obtener las direcciones de entrega del usuario.
$addresses = Modelo_Direccion_Entregas::obtenerDireccionesPorUsuario($_SESSION['correo']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>GuaviareYa!</title>
    <link rel="stylesheet" href="path/to/bootstrap.min.css"> <!-- Asegúrate de incluir el archivo de Bootstrap -->
    <script src="path/to/jquery.min.js"></script> <!-- Asegúrate de incluir jQuery -->
    <script src="path/to/bootstrap.bundle.min.js"></script> <!-- Asegúrate de incluir Bootstrap JS -->
    <script src="../js/guardar_direccion_seleccionada.js"></script>
</head>
<body>
    <div class="container">
        <div class="subcontainer3">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            ¿Dónde quieres que entreguemos tu pedido?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <form id="direccionForm">
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
                                            echo '<tr><td colspan="4"><button type="submit" class="btn btn-primary">Seleccionar Dirección</button></td></tr>';
                                        } else {
                                            echo '<tr><td colspan="4"><p>No se encontraron direcciones de entrega.</p></td></tr>';
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

        <div class="subcontainer4">
            <div class="row">
                <div class="col-md-12">
                    <div class="accordion" id="accordionExample">
                        <?php
                        // Verificar si el carrito tiene productos
                        if (!empty($_SESSION['carrito'])) {
                            // Agrupar productos por restaurante
                            $productosPorRestaurante = [];
                            foreach ($_SESSION['carrito'] as $producto) {
                                $id_restaurante = $producto['ID_Restaurante'];
                                if (!isset($productosPorRestaurante[$id_restaurante])) {
                                    $productosPorRestaurante[$id_restaurante] = [
                                        'nombre_restaurante' => obtenerNombreRestaurante($id_restaurante),
                                        'productos' => []
                                    ];
                                }
                                $productosPorRestaurante[$id_restaurante]['productos'][] = $producto;
                            }

                            // Crear una sección en el acordeón por cada restaurante
                            foreach ($productosPorRestaurante as $id_restaurante => $datos) {
                                echo '<div class="accordion-item">';
                                echo '<h2 class="accordion-header">';
                                echo '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRestaurante' . $id_restaurante . '" aria-expanded="true" aria-controls="collapseRestaurante' . $id_restaurante . '">';
                                echo '<p style="font-weight: bold; text-transform: uppercase;">'. htmlspecialchars($datos['nombre_restaurante']);
                                echo '</button>';
                                echo '</h2>';
                                echo '<div id="collapseRestaurante' . $id_restaurante . '" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">';
                                echo '<div class="accordion-body">';
                                foreach ($datos['productos'] as $producto) {
                                    echo '<img src="../media_productos/' . htmlspecialchars($producto['img_P']) . '" alt="' . htmlspecialchars($producto['Nombre_P']) . '" width="110px">';
                                    echo '<p>' . htmlspecialchars($producto['cantidad']) . ' ' . htmlspecialchars($producto['Nombre_P']) . '</p>';
                                    echo '<p>$' . number_format($producto['Valor_P'], 0, ',', '.') . ' COP</p>';
                                }
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p>No hay productos en el carrito.</p>';
                        }

                        // Función para obtener el nombre del restaurante
                        function obtenerNombreRestaurante($id_restaurante) {
                            include('../Modelos/mostrar_productos.php');
                            $mostrarProductos = new mostrar_productos();
                            return $mostrarProductos->obtenerNombreRestaurante($id_restaurante);
                        }
                        ?>
                    </div>
                </div>

                <div class="col-md-12 estimada">
                    <h6 class="esti">Entrega estimada:</h6>
                    <b>
                        <p class="esti-tiempo">30-45 minutos</p>
                    </b>
                </div>

                <div class="col-md-12 flex-container">
                    <input type="radio" name="envio" id="Prioritaria" onclick="updateEstimatedTimeAndFees()">
                    <div class="label-container">
                        <b><label for="Prioritaria">Prioritaria 🚀</label></b>
                        <h6>envío directo</h6>
                    </div>
                    <div class="precio">
                        <h6>+$5000</h6>
                    </div>
                </div>

                <div class="col-md-12 flex-container">
                    <input type="radio" name="envio" id="Básica" checked onclick="updateEstimatedTimeAndFees()">
                    <div class="label-container">
                        <b><label for="Básica">Básica 🍔</label></b>
                        <h6>Entrega habitual</h6>
                    </div>
                    <div class="precio">
                        <h6>+$0</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="subcontainer4">
            <div class="col-md-12">
                <div class="accordion" id="accordionSummary">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSummary" aria-expanded="true" aria-controls="collapseSummary">
                                Resumen
                            </button>
                        </h2>
                        <div id="collapseSummary" class="accordion-collapse collapse show" data-bs-parent="#accordionSummary">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-md-12 resumen_total">
                                        <?php
                                        // Calcular el total dinámico del carrito
                                        $subtotal = 0;
                                        foreach ($_SESSION['carrito'] as $producto) {
                                            $subtotal += $producto['Valor_P'] * $producto['cantidad'];
                                        }
                                        $costoEnvio = 0; // Inicialmente sin costo
                                        $impuestosTarifas = 2000; // Ejemplo de impuestos y tarifas estáticos
                                        $total = $subtotal + $costoEnvio + $impuestosTarifas;
                                        ?>
                                        <div class="resumen">
                                            <h6>Costo de productos</h6>
                                            <i>
                                                <p class="subtotal">$<?php echo number_format($subtotal, 0, ',', '.'); ?></p>
                                            </i>
                                        </div>
                                        <div class="resumen">
                                            <h6>Costo de envío</h6>
                                            <i>
                                                <p class="costo-envio">$<?php echo number_format($costoEnvio, 0, ',', '.'); ?></p>
                                            </i>
                                        </div>
                                        <div class="resumen">
                                            <h6>Impuestos y Tarifas</h6>
                                            <i>
                                                <p class="impuestos-tarifas">$<?php echo number_format($impuestosTarifas, 0, ',', '.'); ?></p>
                                            </i>
                                        </div>
                                        <div class="resumen">
                                            <h6>Total</h6>
                                            <i>
                                                <p class="total">$<?php echo number_format($total, 0, ',', '.'); ?></p>
                                            </i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form method="post" action="../Controladores/controlador_pedidos.php" class="form-agregar">
                <input type="hidden" name="ID_Restaurante" value="<?php echo $id_restaurante; ?>">
                <?php foreach ($_SESSION['carrito'] as $index => $producto) : ?>
                    <input type="hidden" name="Descripcion[]" value="<?php echo htmlspecialchars($producto['Descripcion']); ?>">
                    <input type="hidden" name="ID_Producto[]" value="<?php echo htmlspecialchars($producto['ID_Producto']); ?>">
                    <input type="hidden" name="Nombre_P[]" value="<?php echo htmlspecialchars($producto['Nombre_P']); ?>">
                    <input type="hidden" name="img_P[]" value="<?php echo htmlspecialchars($producto['img_P']); ?>">
                    <input type="hidden" name="Valor_P[]" value="<?php echo htmlspecialchars($producto['Valor_P']); ?>">
                <?php endforeach; ?>
                <button type="submit" class="btn-pagar">Hacer Pedido</button>
            </form>
        </div>
    </div>

    <script src="../JS/actualizar_tiempo_entrega.js"></script>
</body>

</html>