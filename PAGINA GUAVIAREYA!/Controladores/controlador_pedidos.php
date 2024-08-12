<?php
include("../Modelos/guardar_pedido.php");
include_once("../config/Conexion.php");
include("../Modelos/Cupones.php");

session_start();

if (!isset($_SESSION['correo']) || empty($_SESSION['correo'])) {
    header("Location: ../Controladores/controlador.php?seccion=login");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tipo_envio'], $_POST['restaurantes'])) {
        $tipo_envio = $_POST['tipo_envio'];
        $restaurantes = $_POST['restaurantes'];
        $cuponCodigo = isset($_SESSION['Codigo_Cupon']) ? (string)$_SESSION['Codigo_Cupon'] : null;
        $cuponDescuento = isset($_SESSION['cupon_descuento']) ? (int)$_SESSION['cupon_descuento'] : 0;

        $id_direccion_entrega = isset($_SESSION['direccion_seleccionada']) ? intval($_SESSION['direccion_seleccionada']) : null;
        $correo = $_SESSION['correo'];

        if ($id_direccion_entrega === null) {
            header("Location: ../Controladores/controlador.php?seccion=facturacion&error=1");
            exit();
        }

        $guardarPedido = new GuardarPedido(Conexion::conectar());

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
            }
        }

        // Verificar y aplicar el descuento del cupón
        if ($cuponCodigo) {
            $cupon = Cupones::validarCupon($cuponCodigo, $correo);
            if ($cupon['valido']) {
                $cuponDescuento = $cupon['descuento'];
                $descuento = $total * ($cuponDescuento / 100);
                $totalConDescuento = $total - $descuento;
            } else {
                $cuponDescuento = 0;
                $totalConDescuento = $total;
            }
        } else {
            $totalConDescuento = $total;
        }

        $costoEnvio = $tipo_envio === 'Prioritaria' ? 5000 : 3000;
        $impuestosTarifas = 2000;
        $totalConDescuento += $costoEnvio + $impuestosTarifas;

        unset($_SESSION['carrito']);
        unset($_SESSION['direccion_seleccionada']);
        unset($_SESSION['Codigo_Cupon']);
        unset($_SESSION['cupon_descuento']);

        foreach ($restaurantes as $id_restaurante => $datos_restaurante) {
            $productos = $datos_restaurante['productos'];
            $cantidades = $datos_restaurante['cantidad'];
            $precios = $datos_restaurante['precio'];

            foreach ($productos as $index => $producto) {
                $cantidad = intval($cantidades[$index]);
                $precio = floatval($precios[$index]);
                $subtotal = $cantidad * $precio;

                $guardarPedido->insertarPedido($correo, $id_restaurante, $producto, $cantidad, $subtotal, $id_direccion_entrega, $tipo_envio, $totalConDescuento);
            }
        }

        // Actualizar la fecha de uso del cupón si es necesario
        if ($cuponCodigo && $cuponDescuento > 0) {
            $guardarPedido->actualizarFechaUsoCupon($cuponCodigo);
            header("Location: ../Controladores/controlador.php?seccion=confirmacion");
        } else {
            header("Location: ../Controladores/controlador.php?seccion=confirmacion"); // Cambiado el redireccionamiento al de verificación
        }
        exit();
    } else {
        header("Location: ../Controladores/controlador.php?seccion=facturacion&error=4");
        exit();
    }
}
?>
