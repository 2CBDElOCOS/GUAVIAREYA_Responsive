<?php
include("../Modelos/guardar_pedido.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['correo']) || empty($_SESSION['correo'])) {
    header("location: ../Controladores/controlador.php?seccion=login");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_direccion_entrega = isset($_SESSION['direccion_seleccionada']) ? intval($_SESSION['direccion_seleccionada']) : null;
    $id_restaurante = isset($_POST['ID_Restaurante']) ? intval($_POST['ID_Restaurante']) : null;
    $correo = isset($_SESSION['correo']) ? $_SESSION['correo'] : null;
    $tipo_envio = isset($_POST['tipo_envio']) ? $_POST['tipo_envio'] : 'Básica';

    if ($id_restaurante === null || empty($correo) || $id_direccion_entrega === null) {
        die('Datos de formulario inválidos o dirección no seleccionada.');
    }

    // Inicializar el objeto GuardarPedido
    $guardarPedido = new GuardarPedido();

    // Verificar si el restaurante existe
    if (!$guardarPedido->verificarRestaurante($id_restaurante)) {
        die('El restaurante no existe.');
    }

    // Insertar el pedido en la base de datos
    foreach ($_SESSION['carrito'] as $restaurante) {
        foreach ($restaurante['productos'] as $producto) {
            $id_producto = intval($producto['ID_Producto']);
            $cantidad = intval($producto['cantidad']);
            $subtotal = floatval($producto['Valor_P'] * $cantidad);

            // Llamada al método para insertar el pedido
            $guardarPedido->insertarPedido($correo, $id_restaurante, $id_producto, $cantidad, $subtotal, $id_direccion_entrega, $tipo_envio);
        }
    }

    // Limpiar el carrito después de realizar el pedido
    unset($_SESSION['carrito']);
    unset($_SESSION['direccion_seleccionada']);

    // Redirigir al usuario a la página de confirmación
    header('Location: ../Controladores/controlador.php?seccion=tarjeta');
    exit();
} else {
    die('Método de solicitud no permitido.');
}
?>
