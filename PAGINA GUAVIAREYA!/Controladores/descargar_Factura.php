<?php
require_once '../config/Conexion.php'; // Incluye el archivo de conexión
require_once '../Modelos/guardar_pedido.php'; // Incluye el archivo de la clase GuardarPedido

// Verifica si el usuario está autenticado
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['correo']) || empty($_SESSION['correo'])) {
    header("location: ../Controladores/controlador.php?seccion=login");
    exit();
}

// Verificar si se ha enviado el parámetro 'pedido_id'
if (isset($_GET['pedido_id']) && !empty($_GET['pedido_id'])) {
    $pedido_id = intval($_GET['pedido_id']);
} else {
    die('Error: El ID del pedido no se ha especificado.');
}

// Obtener el ID del pedido de la URL y validarlo
if ($pedido_id <= 0) {
    die('Error: ID del pedido no válido.');
}

// Crear conexión
$conexion = Conexion::conectar();

// Crear instancia de GuardarPedido
$guardarPedido = new GuardarPedido($conexion);

try {
    // Intentar generar la factura
    $guardarPedido->generarFactura($pedido_id);
    
    // Preparar la ruta del archivo para la descarga
    $filePath = '../facturas/factura_' . $pedido_id . '.pdf';

    if (file_exists($filePath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    } else {
        die('Error: El archivo de factura no existe.');
    }
} catch (Exception $e) {
    die('Error al generar la factura: ' . $e->getMessage());
}
?>
