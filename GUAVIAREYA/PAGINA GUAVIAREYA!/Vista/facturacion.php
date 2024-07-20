<!DOCTYPE html>
<html lang="en">

<head>
    <title>GuaviareYa!</title>
    <style>
        .error-message {
            color: red;
            display: none;
            margin-bottom: 10px;
        }
    </style>
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
                    <input class="detalles" type="text" placeholder="Detalles adicionales..">
                </div>
            </div>
        </div>

        <div class="subcontainer4">
            <div class="row">
                <div class="col-md-12">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Nombre Restaurante
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <!-- Aquí puedes mostrar los productos del carrito -->
                                    <?php
                                    if (!empty($_SESSION['carrito'])) {
                                        foreach ($_SESSION['carrito'] as $producto) {
                                            echo '<img src="../media_productos/' . htmlspecialchars($producto['img_P']) . '" alt="' . htmlspecialchars($producto['Nombre_P']) . '" width="110px">';
                                            echo '<p>' . htmlspecialchars($producto['cantidad']) . ' ' . htmlspecialchars($producto['Nombre_P']) . '</p>';
                                            echo '<p>$' . number_format($producto['Valor_P'], 0, ',', '.') . ' COP</p>';
                                        }
                                    } else {
                                        echo '<p>No hay productos en el carrito.</p>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 estimada">
                    <h6 class="esti">Entrega estimada:</h6>
                    <b>
                        <p class="esti-tiempo">30-45 minutos</p>
                    </b>
                </div>

                <div class="col-md-12 flex-container">
                    <input type="radio" name="envio" id="Prioritaria">
                    <div class="label-container">
                        <b><label for="Prioritaria">Prioritaria 🚀</label></b>
                        <h6>envio directo</h6>
                    </div>
                    <div class="precio">
                        <h6>+$5000</h6>
                    </div>
                </div>

                <div class="col-md-12 flex-container">
                    <input type="radio" name="envio" id="Básica" checked>
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
            <div class="row">
                <div class="col-md-12 metodo">
                    <b>
                        <h6>✅ Método de pago</h6>
                    </b>
                </div>
                <div class="col-md-6 tipos_metodo">
                    <label class="add_metodo">Agregar método de pago:</label>
                </div>
                <div class="col-md-3 tipos_metodos">
                    <input class="add_metodos" type="radio" name="metodo_pago"> <img src="../media/tarjeta.png" alt="" width="80px">
                </div>
                <div class="col-md-3 tipos_metodo">
                    <a href="controlador.php?seccion=tarjeta"><button style="border-radius: 30px; margin-top:15px">ir</button></a>
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

            <!-- Mensaje de error -->
            <div id="error-message" class="error-message">Debe seleccionar un método de pago.</div>

            <a href="javascript:void(0);"><button id="hacerPedidoBtn" style="border-radius: 15px; margin-top:30px;">Hacer Pedido</button></a>
        </div>
    </div>

    <script src="../JS/actualizar_tiempo_entrega.js"></script>
</body>

</html>