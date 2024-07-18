<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['seccion'])) {
    switch ($_GET['seccion']) {
        case 'carrito':
            // Lógica para agregar producto al carrito
            $producto = [
                'ID_Producto' => $_POST['ID_Producto'],
                'Nombre_P' => $_POST['Nombre_P'],
                'Descripcion' => $_POST['Descripcion'],
                'img_P' => $_POST['img_P'],
                'Valor_P' => $_POST['Valor_P'],
                'cantidad' => 1
            ];

            // Si la sesión del carrito no existe, crearla
            if (!isset($_SESSION['carrito'])) {
                $_SESSION['carrito'] = [];
            }

            // Buscar si el producto ya está en el carrito
            $encontrado = false;
            foreach ($_SESSION['carrito'] as &$item) {
                if ($item['ID_Producto'] == $producto['ID_Producto']) {
                    $item['cantidad'] += 1; // Incrementar la cantidad
                    $encontrado = true;
                    break;
                }
            }

            // Si el producto no está en el carrito, agregarlo
            if (!$encontrado) {
                $_SESSION['carrito'][] = $producto;
            }

            // Enviar respuesta de éxito
            echo json_encode(['success' => true]);
            exit();
    }
}
?>
