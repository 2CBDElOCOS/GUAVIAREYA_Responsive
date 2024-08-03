<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$response = ['success' => false, 'contador' => 0];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ID_Producto = $_POST['ID_Producto'];
    $Nombre_P = $_POST['Nombre_P'];
    $Descripcion = $_POST['Descripcion'];
    $img_P = $_POST['img_P'];
    $Valor_P = $_POST['Valor_P'];
    $ID_Restaurante = $_POST['ID_Restaurante'];
    $Nombre_Restaurante = $_POST['Nombre_Restaurante'];
    $fromSearch = isset($_POST['from_search']) && $_POST['from_search'] == '1';

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    if (!isset($_SESSION['carrito'][$ID_Restaurante])) {
        $_SESSION['carrito'][$ID_Restaurante] = [
            'Nombre_Restaurante' => $Nombre_Restaurante,
            'productos' => []
        ];
    }

    $productoExiste = false;

    foreach ($_SESSION['carrito'][$ID_Restaurante]['productos'] as &$producto) {
        if ($producto['ID_Producto'] == $ID_Producto) {
            $producto['cantidad']++;
            $productoExiste = true;
            break;
        }
    }

    if (!$productoExiste) {
        $_SESSION['carrito'][$ID_Restaurante]['productos'][] = [
            'ID_Producto' => $ID_Producto,
            'Nombre_P' => $Nombre_P,
            'Descripcion' => $Descripcion,
            'img_P' => $img_P,
            'Valor_P' => $Valor_P,
            'cantidad' => 1
        ];
    }

    // Calcular el nuevo contador del carrito
    $contador_carrito = 0;
    foreach ($_SESSION['carrito'] as $restaurante) {
        foreach ($restaurante['productos'] as $item) {
            $contador_carrito += $item['cantidad'];
        }
    }

    $response['success'] = true;
    $response['contador'] = $contador_carrito;

    if (!$fromSearch) {
        // Devolver la respuesta como JSON
        echo json_encode($response);
    }
}
?>
