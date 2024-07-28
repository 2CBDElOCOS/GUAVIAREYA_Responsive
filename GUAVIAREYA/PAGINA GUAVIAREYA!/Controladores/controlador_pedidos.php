<?php
include("../Modelos/guardar_pedido.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_direccion_entrega = isset($_SESSION['direccion_seleccionada']) ? intval($_SESSION['direccion_seleccionada']) : null;
    $id_restaurante = isset($_POST['ID_Restaurante']) ? intval($_POST['ID_Restaurante']) : null;
    $correo = isset($_SESSION['correo']) ? $_SESSION['correo'] : null;

    // Depuración
    var_dump($id_restaurante);
    var_dump($correo);
    var_dump($id_direccion_entrega);

    // Validar los datos
    if ($id_restaurante === null || empty($correo) || $id_direccion_entrega === null) {
        die('Datos de formulario inválidos.');
    }

    // Verificar que el carrito no esté vacío
    if (empty($_SESSION['carrito'])) {
        die('No hay productos en el carrito.');
    }

    // Inicializar el objeto GuardarPedido
    $guardarPedido = new GuardarPedido();

    // Verificar si el restaurante existe
    if (!$guardarPedido->verificarRestaurante($id_restaurante)) {
        die('El restaurante no existe.');
    }

    // Insertar el pedido en la base de datos
    foreach ($_SESSION['carrito'] as $restaurante => $productos) {
        foreach ($productos['productos'] as $producto) {
            $id_producto = intval($producto['ID_Producto']);
            $cantidad = intval($producto['cantidad']);
            $subtotal = floatval($producto['Valor_P'] * $cantidad);

            // Llamada al método para insertar el pedido
            $guardarPedido->insertarPedido($correo, $id_restaurante, $id_producto, $cantidad, $subtotal, $id_direccion_entrega);
        }
    }

    // Limpiar el carrito después de realizar el pedido
    unset($_SESSION['carrito']);

    // Redirigir al usuario a la página de tarjeta
    header('Location: ../Controladores/controlador.php?seccion=tarjeta');
    exit();
} else {
    die('Método de solicitud no permitido.');
}
?>
