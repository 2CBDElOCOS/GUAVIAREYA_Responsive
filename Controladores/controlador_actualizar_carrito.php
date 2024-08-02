<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$response = array('success' => false);

if (isset($_POST['id_producto']) && isset($_POST['cantidad'])) {
    $id_producto = $_POST['id_producto'];
    $cantidad = (int)$_POST['cantidad']; // Asegúrate de que la cantidad es un entero

    // Verificar si el carrito existe en la sesión
    if (isset($_SESSION['carrito'])) {
        // Recorrer el carrito y actualizar la cantidad del producto con el ID especificado
        foreach ($_SESSION['carrito'] as &$restaurante) {
            foreach ($restaurante['productos'] as &$producto) {
                if ($producto['ID_Producto'] == $id_producto) {
                    $producto['cantidad'] = $cantidad;
                    $response['success'] = true;
                    $response['precio_unitario'] = $producto['Valor_P']; // No formatear aquí
                    break 2; // Salir del bucle después de actualizar el producto
                }
            }
        }

        // Recalcular el subtotal
        $subtotal = 0;
        foreach ($_SESSION['carrito'] as $restaurante) {
            foreach ($restaurante['productos'] as $producto) {
                $subtotal += $producto['Valor_P'] * $producto['cantidad'];
            }
        }
        $response['subtotal'] = $subtotal; // No formatear aquí
    }
}

echo json_encode($response);
?>
