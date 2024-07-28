<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Incluir el archivo del modelo
include('../Modelos/guardar_pedido.php');

// Crear una instancia del modelo
$guardarPedido = new GuardarPedido();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos de la solicitud POST y de la sesión
    $id_direccion_entrega = isset($_SESSION['direccion_seleccionada']) ? intval($_SESSION['direccion_seleccionada']) : null;
    $id_restaurante = isset($_POST['ID_Restaurante']) ? intval($_POST['ID_Restaurante']) : null; 
    $correo = isset($_SESSION['correo']) ? $_SESSION['correo'] : null;



    // Validar los datos
    if ($id_restaurante === null || empty($correo) || $id_direccion_entrega === null) {
        die('Datos de formulario inválidos.');
    }

    if (!empty($_SESSION['carrito'])) {
        if (!$guardarPedido->verificarRestaurante($id_restaurante)) {
            die('El restaurante no existe.');
        }

        foreach ($_SESSION['carrito'] as $index => $producto) {
            $id_producto = intval($producto['ID_Producto']);
            $cantidad = intval($producto['cantidad']);
            $subtotal = floatval($producto['Valor_P'] * $cantidad);

            $guardarPedido->insertarPedido($correo, $id_restaurante, $id_producto, $cantidad, $subtotal, $id_direccion_entrega);
        }

        // Limpiar el carrito después de realizar el pedido
        unset($_SESSION['carrito']);

        header('Location: ../Controladores/controlador.php?seccion=tarjeta');
        exit();
    } else {
        die('No hay productos en el carrito.');
    }
} else {
    die('Método de solicitud no permitido.');
}




?>
