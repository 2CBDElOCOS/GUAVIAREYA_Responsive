<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Recuperar datos de sesión
$pedido_id = isset($_SESSION['pedido_id']) ? intval($_SESSION['pedido_id']) : 0;

// Depuración
error_log("ID del Pedido en confirmacion.php: " . $pedido_id);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GuaviareYa!</title>
    <script>
        // Redirigir a "shop" después de 9 segundos
        setTimeout(function() {
            window.location.href = "../Controladores/controlador.php?seccion=shop";
        }, 9000);
    </script>
</head>

<body class="bg-light d-flex flex-column min-vh-100">
    <div class="container my-4">
        <div class="ico-carro">
            <a href="controlador.php?seccion=shop" class="btn btn-link">
                <i class="bx bxs-home"></i>
            </a>
        </div>

        <div class="d-flex flex-column align-items-center">
            <h1 class="mb-4">Gracias por tu compra</h1>
            <img src="../media/check.png" alt="listo" class="img-fluid" style="max-width: 400px;">

            <!-- Botón para descargar la factura -->
            <a href="../Controladores/descargar_factura.php?pedido_id=<?php echo $pedido_id; ?>" class="btn btn-primary mt-4">
                Descargar Factura
            </a>

        </div>
    </div>
</body>

</html>
