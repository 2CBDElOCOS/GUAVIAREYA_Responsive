<?php
 if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$response = array('success' => false);

if (isset($_POST['id_producto']) && isset($_POST['cantidad'])) {
    $id_producto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];

    // Verificar si el carrito existe en la sesión
    if (isset($_SESSION['carrito'])) {
        // Recorrer el carrito y actualizar la cantidad del producto con el ID especificado
        foreach ($_SESSION['carrito'] as &$producto) {
            if ($producto['ID_Producto'] == $id_producto) {
                $producto['cantidad'] = $cantidad;
                $response['success'] = true;
                $response['precio_unitario'] = '' . number_format($producto['Valor_P'], 0, ',', '.');
                break; // Salir del bucle después de actualizar el producto
            }
        }
        // Recalcular el subtotal
        $subtotal = 0;
        foreach ($_SESSION['carrito'] as $producto) {
            $subtotal += $producto['Valor_P'] * $producto['cantidad'];
        }
        $response['subtotal'] = ' ' . number_format($subtotal, 0, ',', '.');
    }
}

echo json_encode($response);
?>
