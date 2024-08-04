<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['correo']) || $_SESSION['correo'] == "") {
    header("location: ../Controladores/controlador.php?seccion=login");
    exit();
}

// Incluir el archivo del modelo
include '../Modelos/DataAdmi.php';

// Obtener las órdenes desde el modelo, filtradas por el restaurante del administrador
$ordenes = DataAdmi::obtenerOrdenes($_SESSION['correo']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
    
<body>
    <main class="table" id="customers_table">
        <div class="col-md-12 ico-footer">
            <a href="controlador.php?seccion=ADMI_Perfil_A"><i class="fa-solid fa-circle-arrow-left" style="color: #000000;"></i></a>
        </div>
        <section class="table__header">
            <h1>Ordenes</h1>
            <div class="input-group">
                <input type="search" placeholder="Desplázate para ver los resultados...">
                <img src="images/search.png" alt="">
            </div>
            <div class="export__file" >
                <label for="export-file" class="export__file-btn" title="Export File">🟣</label>
                <input type="checkbox" id="export-file">
                <div class="export__file-options">
                    <label>Export As &nbsp; &#10140;</label>
                    <label for="export-file" id="toPDF">PDF <img src="images/pdf.png" alt=""></label>
                    <label for="export-file" id="toJSON">JSON <img src="images/json.png" alt=""></label>
                    <label for="export-file" id="toCSV">CSV <img src="images/csv.png" alt=""></label>
                </div>
            </div>

        </section>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th> Usuario <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Correo <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Direccion de entrega <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Producto <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Cantidad <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Estado <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Prioridad <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Fecha <span class="icon-arrow">&UpArrow;</span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ordenes as $orden): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($orden['Nombre_Usuario']); ?></td>
                        <td><?php echo htmlspecialchars($orden['Correo']); ?></td>
                        <td><?php echo htmlspecialchars($orden['Direccion']); ?></td>
                        <td><?php echo htmlspecialchars($orden['Nombre_Producto']); ?></td>
                        <td><?php echo htmlspecialchars($orden['cantidad']); ?></td>
                        <td>
                            <div class="status-container">
                                <p class="status <?php echo strtolower($orden['Estado']); ?>">
                                    <?php echo htmlspecialchars($orden['Estado']); ?>
                                </p>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary btn-status"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal"
                                        data-pedido-id="<?php echo $orden['ID_pedido']; ?>"
                                        data-estado-actual="<?php echo htmlspecialchars($orden['Estado']); ?>">
                                    <i class='bx bx-history bx-flip-horizontal' ></i>
                                </button>
                            </div>
                        </td>
                        <td><?php echo htmlspecialchars($orden['tipo_envio']); ?></td> <!-- Nueva columna -->
                        <td><?php echo date('d M, Y', strtotime($orden['fecha_creacion'])); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Selecciona el estado del pedido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="../Controladores/Controlador_EstadoPedido.php" method="POST">
                    <div class="modal-body">
                        <!-- Campo oculto para el ID del pedido -->
                        <input type="hidden" id="pedidoId" name="pedido_id" value="">
                        <!-- Selector de estado -->
                        <div class="mb-3">
                            <label for="Estado" class="form-label">Estado</label>
                            <select class="form-select" id="Estado" name="estado">
                                <option value="Pendiente">Pendiente</option>
                                <option value="Enviado">Enviado</option>
                                <option value="Entregado">Entregado</option>
                                <option value="Cancelado">Cancelado</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class='bx bx-x'></i> Cerrar
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class='bx bx-history bx-flip-horizontal bx-burst'></i> Actualizar Estado
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../JS/Script_ordenes.js"></script>
    <script src="../JS/actualizar_estadop.js"></script>
</body>

</html>
