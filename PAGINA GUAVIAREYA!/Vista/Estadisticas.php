<?php
require_once '../Modelos/DataSuperAdmi.php';

$fecha_inicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : null;
$fecha_fin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : null;

$dataRestaurantes = DataSuperAdmi::obtenerEstadisticasPedidosPorRestaurante($fecha_inicio, $fecha_fin);
$dataProductos = DataSuperAdmi::obtenerProductoMasPopular($fecha_inicio, $fecha_fin);
$dataUsuarioMasPedidos = DataSuperAdmi::obtenerUsuarioMasPedidos($fecha_inicio, $fecha_fin);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas de Restaurantes y Productos Populares</title>

</head>
<body>
    <div class="container mt-5">
                <div class="col-md-12 ico-footer 1">
                    <a href="controlador.php?seccion=Perfil_SuperAdmi"><i class="fa-solid fa-tent-arrow-turn-left"></i></a>
                </div>

        <!-- Formulario de Filtro -->
        <form method="POST" action="" class="row g-3 mb-5">
            <div class="col-md-6">
                <label for="fecha_inicio" class="form-label">Fecha de Inicio:</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" value="<?php echo htmlspecialchars($fecha_inicio); ?>">
            </div>
            <div class="col-md-6">
                <label for="fecha_fin" class="form-label">Fecha de Fin:</label>
                <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" value="<?php echo htmlspecialchars($fecha_fin); ?>">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </form>

        <!-- Card de Carga -->
        <div class="card" id="loading-card" style="display: none;">
            <div class="card-body">
                <h5 class="card-title placeholder-glow">
                    <span class="placeholder col-6"></span>
                </h5>
                <p class="card-text placeholder-glow">
                    <span class="placeholder col-7"></span>
                    <span class="placeholder col-4"></span>
                    <span class="placeholder col-4"></span>
                    <span class="placeholder col-6"></span>
                    <span class="placeholder col-8"></span>
                </p>
                <a class="btn btn-primary disabled placeholder col-6" aria-disabled="true"></a>
            </div>
        </div>

        <!-- Card de Contenido -->
        <div class="card" id="content-card">
            <div class="card-body">
                <!-- Tabla de Estadísticas de Restaurantes -->
                <div class="mt-5">
                    <h4 class="text-center">Estadísticas de Restaurantes</h4>
                    <?php if (!empty($dataRestaurantes)): ?>
                        <table class="table table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>Restaurante</th>
                                    <th>Número de Pedidos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dataRestaurantes as $row): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row[0]); ?></td>
                                        <td><?php echo htmlspecialchars($row[1]); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="alert alert-warning" role="alert">
                            No hay datos disponibles.
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Tabla de Productos Más Populares -->
                <div class="mt-5">
                    <h4 class="text-center">Productos Más Populares</h4>
                    <?php if (!empty($dataProductos)): ?>
                        <table class="table table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Número de Ventas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dataProductos as $row): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row[0]); ?></td>
                                        <td><?php echo htmlspecialchars($row[1]); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="alert alert-warning" role="alert">
                            No hay datos disponibles.
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Tabla de Usuario que Más Hace Pedidos -->
                <div class="mt-5">
                    <h4 class="text-center">Usuario que Más Hace Pedidos</h4>
                    <?php if (!empty($dataUsuarioMasPedidos)): ?>
                        <table class="table table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Número de Pedidos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo htmlspecialchars($dataUsuarioMasPedidos['Usuario']); ?></td>
                                    <td><?php echo htmlspecialchars($dataUsuarioMasPedidos['Numero_Pedidos']); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="alert alert-warning" role="alert">
                            No hay datos disponibles.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="  ../JS/charging_card.js"></script>
</body>
</html>
