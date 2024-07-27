<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['correo']) || $_SESSION['correo'] == "") {
    header("location: ../Controladores/controlador.php?seccion=login");
    exit();
}

include '../Modelos/DataUser.php';

$correo = $_SESSION['correo'];
$dataUser = new DataUser(); // Crear una instancia de DataUser
$pedidos = $dataUser->obtenerPedidosPorUsuario($correo); // Llamar al método de instancia
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Pedidos</title>
</head>
<body>
    <div class="container">
        <div class="main-body">
            <div class="row mb-3">
            <div class="col-md-12 ico-footer1">
                <a href="controlador.php?seccion=shop"><i class="fa-solid fa-tent-arrow-turn-left"></i></a>
            </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <h4>Tus Pedidos</h4>
                </div>
            </div>

            <!-- Tabla de pedidos -->
            <div class="row gutters-sm">
                <?php if (!empty($pedidos)): ?>
                    <div class="col-sm-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style>ID Pedido</th>
                                    <th>Descripción</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pedidos as $pedido): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($pedido['ID_pedido']); ?></td>
                                        <td><?php echo htmlspecialchars($pedido['Descripcion']); ?></td>
                                        <td><?php echo htmlspecialchars($pedido['cantidad']); ?></td>
                                        <td>$<?php echo htmlspecialchars($pedido['Sub_total']); ?></td>
                                        <td><?php echo htmlspecialchars($pedido['fecha_pedido']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="col-sm-12">
                        <div class="alert alert-info" role="alert">
                            ¡No tienes ningún pedido! ¡Cambiemos eso!
                            <a href="controlador.php?seccion=shop" class="btn btn-primary mt-2">¡Ordena ya!</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>
</html>
