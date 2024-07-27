<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Incluir el archivo del modelo
include('../Modelos/guardar_pedido.php');

// Crear una instancia del modelo
$guardarPedido = new GuardarPedido();

// Verificar si se han enviado los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $id_restaurante = isset($_POST['ID_Restaurante']) ? intval($_POST['ID_Restaurante']) : null;
    $descripciones = isset($_POST['Descripcion']) ? $_POST['Descripcion'] : [];
    $correo = $_SESSION['correo']; // Obtener el correo del usuario desde la sesión

    // Validar los datos del formulario
    if ($id_restaurante === null || empty($descripciones) || empty($correo)) {
        die('Datos de formulario inválidos.');
    }

    // Depurar el valor de ID_Restaurante
    echo 'ID_Restaurante: ' . $id_restaurante . '<br>';

    // Verificar si el carrito tiene productos
    if (!empty($_SESSION['carrito'])) {
        // Verificar si el ID_Restaurante existe en la tabla Restaurantes
        if (!$guardarPedido->verificarRestaurante($id_restaurante)) {
            die('El restaurante no existe.');
        }

        foreach ($_SESSION['carrito'] as $index => $producto) {
            $id_producto = intval($producto['ID_Producto']);
            $descripcion = isset($descripciones[$index]) ? trim($descripciones[$index]) : '';
            $cantidad = intval($producto['cantidad']);
            $subtotal = floatval($producto['Valor_P'] * $cantidad);

            // Llamar al método para insertar el pedido
            $guardarPedido->insertarPedido($correo, $id_restaurante, $id_producto, $descripcion, $cantidad, $subtotal);
        }

        // Limpiar el carrito después de realizar el pedido
        unset($_SESSION['carrito']);

        // Redirigir a una página de confirmación o mostrar un mensaje
        header('Location: ../Controladores/controlador.php?seccion=tarjeta');
        exit();
    } else {
        die('No hay productos en el carrito.');
    }
} else {
    die('Método de solicitud no permitido.');
}
?>
