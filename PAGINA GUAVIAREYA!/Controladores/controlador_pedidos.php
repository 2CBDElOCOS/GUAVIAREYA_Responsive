<?php
include("../Modelos/guardar_pedido.php");
require_once("../Modelos/conexion.php");

session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['correo']) || empty($_SESSION['correo'])) {
    header("Location: ../Controladores/controlador.php?seccion=login");
    exit();
}

// Verifica si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tipo_envio'], $_POST['restaurantes'])) {
        $tipo_envio = $_POST['tipo_envio'];
        $restaurantes = $_POST['restaurantes'];

        $id_direccion_entrega = isset($_SESSION['direccion_seleccionada']) ? intval($_SESSION['direccion_seleccionada']) : null;
        $correo = $_SESSION['correo'];

        if ($id_direccion_entrega === null) {
            exit();
        }

        // Inicializar el objeto GuardarPedido
        $guardarPedido = new GuardarPedido(Conexion());

        $total = 0;

        foreach ($restaurantes as $id_restaurante => $datos_restaurante) {
            if (!$guardarPedido->verificarRestaurante($id_restaurante)) {
                header("Location: ../Controladores/controlador.php?seccion=facturacion&error=2");
                exit();
            }

            $productos = $datos_restaurante['productos'];
            $cantidades = $datos_restaurante['cantidad'];
            $precios = $datos_restaurante['precio'];

            foreach ($productos as $index => $producto) {
                $cantidad = intval($cantidades[$index]);
                $precio = floatval($precios[$index]);
                $subtotal = $cantidad * $precio;
                $total += $subtotal;

                try {
                    $guardarPedido->insertarPedido($correo, $id_restaurante, $producto, $cantidad, $subtotal, $id_direccion_entrega, $tipo_envio);
                } catch (Exception $e) {
                    header("Location: ../Controladores/controlador.php?seccion=facturacion&error=3");
                    exit();
                }
            }
        }

        // Agregar costos adicionales (envío, impuestos, etc.)
        $costoEnvio = $tipo_envio === 'Prioritaria' ? 5000 : 3000;
        $impuestosTarifas = 2000;
        $total += $costoEnvio + $impuestosTarifas;

        // Limpiar el carrito después de realizar el pedido
        unset($_SESSION['carrito']);
        unset($_SESSION['direccion_seleccionada']);

        // Redirigir al usuario a la página de confirmación
        header("Location: ../Controladores/controlador.php?seccion=tarjeta");
        exit();
    } else {
        header("Location: ../Controladores/controlador.php?seccion=facturacion&error=1");
        exit();
    }
} else {
    header("Location: ../Controladores/controlador.php?seccion=facturacion&error=4");
    exit();
}
?>
