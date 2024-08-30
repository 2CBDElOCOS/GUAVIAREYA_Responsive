<?php
session_start();

// Incluye el archivo de configuración y el archivo con la clase GuardarPedido
require_once("../config/Conexion.php");
require_once("../Modelos/guardar_pedido.php");

// Verifica si el usuario está autenticado
if (!isset($_SESSION['correo']) || empty($_SESSION['correo'])) {
    header("Location: ../Controladores/controlador.php?seccion=login");
    exit();
}

// Verifica si se ha recibido un ID de pedido
if (!isset($_GET['pedido_id']) || empty($_GET['pedido_id'])) {
    header("Location: ../Controladores/controlador.php?seccion=error&error=5");
    exit();
}

$pedido_id = intval($_GET['pedido_id']);

try {
    // Inicia el buffer de salida para evitar cualquier salida previa
    ob_start();

    // Crea una instancia de la clase GuardarPedido
    $guardarPedido = new GuardarPedido(Conexion::conectar());

    // Llama a la función para generar la factura
    $guardarPedido->generarFactura($pedido_id);

    // Limpiar el buffer de salida (importante para evitar salida previa)
    ob_end_clean();
} catch (Exception $e) {
    // Manejo de excepciones
    error_log("Error al generar la factura: " . $e->getMessage());
    header("Location: ../Controladores/controlador.php?seccion=error&error=6");
    exit();
}
