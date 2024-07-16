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
                'cantidad' => 1 // Puedes ajustar la cantidad según tus necesidades
            ];

            // Si la sesión del carrito no existe, crearla
            if (!isset($_SESSION['carrito'])) {
                $_SESSION['carrito'] = [];
            }

            // Agregar el producto al carrito
            $_SESSION['carrito'][] = $producto;

            // Redirigir al carrito
            header('Location: controlador.php?seccion=carrito');
            exit();

        case 'carrito':
            // Mostrar la página del carrito
            header('Location: controlador.php?seccion=carrito');
            break;

    }
}
?>
