<?php
session_start();

if (isset($_POST['id_producto']) && isset($_POST['cantidad'])) {
    $id_producto = $_POST['id_producto'];
    $cantidad = intval($_POST['cantidad']);

    if (isset($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $ID_Restaurante => &$restaurante) {
            foreach ($restaurante['productos'] as &$producto) {
                if ($producto['ID_Producto'] == $id_producto) {
                    $producto['cantidad'] = $cantidad;
                    break 2;
                }
            }
        }

        // Recalcular subtotal
        include('../Modelos/carrito.php');
        $subtotal = CarritoModelo::calcularSubtotal($_SESSION['carrito']);
        
        // Devolver el subtotal en formato JSON
        echo json_encode(['subtotal' => $subtotal]);
        exit();
    }
}
?>
