<?php
require_once '../Modelos/DataSuperAdmi.php'; // Ajusta la ruta según tu estructura de carpetas

$data = DataSuperAdmi::obtenerEstadisticasPedidosPorRestaurante();
$productosPop = DataSuperAdmi::obtenerProductoMasPopular();

// Prepara los datos en formato JSON para el JavaScript
$dataRestaurantes = json_encode($data);
$dataProductos = json_encode($productosPop);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas de Restaurantes y Productos Populares</title>
    <script src="../JS/Estadisticas.js"></script>

    
</head>
<body>
    <div class="container">
        <div class="back-link mb-3">
            <div class="col-md-12 ico-footer1">
                <a href="controlador.php?seccion=SuperAdmin_Panel"><i class="fa-solid fa-tent-arrow-turn-left"></i></a>
            </div>
        </div>
        <div class="container  mt-5">
            <i class="bi bi-calendar-event icon-style"><input type="date" id="start" name="trip-start" value="2018-07-22" min="2018-01-01" max="2018-12-31" /></i>
        </div>

        <div class="row chart-container">
            <div class="col-lg-6 mb-4">
                <div class="chart-card">
                    <h4 class="text-center">Restaurante con mas ventas</h4>
                    <div id="chart_div_restaurantes" style="width: 100%; height: 500px;"></div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="chart-card">
                    <h4 class="text-center">Productos Más Populares</h4>
                    <div id="chart_div_productos" style="width: 100%; height: 500px;"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Pasa los datos a JavaScript
        var dataRestaurantes = <?php echo $dataRestaurantes; ?>;
        var dataProductos = <?php echo $dataProductos; ?>;
    </script>
</body>
</html>
