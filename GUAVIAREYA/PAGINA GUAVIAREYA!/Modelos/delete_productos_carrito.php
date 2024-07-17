<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si se ha enviado el ID del producto a borrar
if (isset($_GET['id_producto'])) {
    $id_producto = $_GET['id_producto'];

    // Verificar si el carrito existe en la sesión
    if (isset($_SESSION['carrito'])) {
        // Recorrer el carrito y eliminar el producto con el ID especificado
        foreach ($_SESSION['carrito'] as $key => $producto) {
            if ($producto['ID_Producto'] == $id_producto) {
                unset($_SESSION['carrito'][$key]);
                break; // Salir del bucle después de eliminar el producto
            }
        }
        // Reindexar el carrito para evitar claves desordenadas
        $_SESSION['carrito'] = array_values($_SESSION['carrito']);
    }
}

// Redirigir de vuelta al carrito
header("Location: controlador.php?seccion=carrito");
exit();
?>
