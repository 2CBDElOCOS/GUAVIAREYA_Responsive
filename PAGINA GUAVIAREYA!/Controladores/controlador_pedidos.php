<?php
include("../Modelos/guardar_pedido.php");

session_start();

if (!isset($_SESSION['correo']) || empty($_SESSION['correo'])) {
    header("Location: ../Controladores/controlador.php?seccion=login");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tipo_envio'], $_POST['restaurantes'])) {
        $tipo_envio = $_POST['tipo_envio'];
        $restaurantes = $_POST['restaurantes'];

        $id_direccion_entrega = isset($_SESSION['direccion_seleccionada']) ? intval($_SESSION['direccion_seleccionada']) : null;
        $correo = $_SESSION['correo'];

        if ($id_direccion_entrega === null) {
            die('Dirección de entrega no seleccionada.');
        }

        // Inicializar el objeto GuardarPedido
        $guardarPedido = new GuardarPedido();

        foreach ($restaurantes as $id_restaurante => $datos_restaurante) {
            // Verificar si el restaurante existe
            if (!$guardarPedido->verificarRestaurante($id_restaurante)) {
                echo "El restaurante con ID $id_restaurante no existe.";
                exit();
            }

            $productos = $datos_restaurante['productos'];
            $cantidades = $datos_restaurante['cantidad'];
            $precios = $datos_restaurante['precio'];

            foreach ($productos as $index => $producto) {
                $cantidad = intval($cantidades[$index]);
                $precio = floatval($precios[$index]);
                $subtotal = $cantidad * $precio;

                try {
                    $guardarPedido->insertarPedido($correo, $id_restaurante, $producto, $cantidad, $subtotal, $id_direccion_entrega, $tipo_envio);
                } catch (Exception $e) {
                    echo "Error al guardar el pedido: " . $e->getMessage();
                    exit();
                }
            }
        }

        // Limpiar el carrito después de realizar el pedido
        unset($_SESSION['carrito']);
        unset($_SESSION['direccion_seleccionada']);

        // Redirigir al usuario a la página de confirmación
        header("Location: controlador.php?seccion=tarjeta");
        exit();
    } else {
        header("Location: controlador.php?seccion=facturacion&error=1");
        exit();
    }
} else {
    die('Método de solicitud no permitido.');
}
?>
