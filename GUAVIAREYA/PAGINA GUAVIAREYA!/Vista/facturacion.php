<!DOCTYPE html>
<html lang="es">

<head>
    <title>GuaviareYa!</title>
</head>

<body>
    <div class="container">
        <div class="subcontainer3">
            <div class="row">
                <div class="col-md-12 diren">
                    <h6>Dirección de entrega</h6>
                    <a href="controlador.php?seccion=perfil">Cambiar</a>
                </div>

                <div class="col-md-12 datos">
                    <h6 class="direccion">Cl. 17 #103A-45</h6>
                    <p class="instru_entrega">Instrucciones de entrega (opcional)</p>
                    <input class="detalles" type="text" name="descripcion" placeholder="Detalles adicionales..">
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
