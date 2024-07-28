<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['id_producto']) && isset($_GET['id_restaurante'])) {
    $id_producto = $_GET['id_producto'];
    $id_restaurante = $_GET['id_restaurante'];

    if (isset($_SESSION['carrito'][$id_restaurante])) {
        foreach ($_SESSION['carrito'][$id_restaurante]['productos'] as $index => $producto) {
            if ($producto['ID_Producto'] == $id_producto) {
                unset($_SESSION['carrito'][$id_restaurante]['productos'][$index]);
                // Reindexar el array para evitar problemas
                $_SESSION['carrito'][$id_restaurante]['productos'] = array_values($_SESSION['carrito'][$id_restaurante]['productos']);
                break;
            }
        }

        // Si ya no hay productos en este restaurante, eliminar la entrada del restaurante
        if (empty($_SESSION['carrito'][$id_restaurante]['productos'])) {
            unset($_SESSION['carrito'][$id_restaurante]);
        }
    }
    
    header('Location: ../Controladores/controlador.php?seccion=carrito'); // Redirigir de nuevo al carrito después de eliminar
    exit();
}
?>
