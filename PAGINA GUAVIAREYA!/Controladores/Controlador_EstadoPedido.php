<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['correo']) || $_SESSION['correo'] == "") {
    header("location: ../Controladores/controlador.php?seccion=login");
    exit();
}

// Incluir el archivo del modelo
include '../Modelos/DataAdmi.php';

// Obtener el ID del pedido y el nuevo estado del formulario
$pedido_id = $_POST['pedido_id'];
$estado = $_POST['estado'];

// Validar y actualizar el estado del pedido
if (!empty($pedido_id) && in_array($estado, ['Pendiente', 'Enviado', 'Entregado', 'Cancelado'])) {
    try {
        DataAdmi::actualizarEstadoPedido($pedido_id, $estado);
        // Redirigir a la página de órdenes con un mensaje de éxito
        header("location: ../Controladores/controlador.php?seccion=ADMI_Ordenes&mensaje=Estado+actualizado");
        exit();
    } catch (Exception $e) {
        // Manejar el error, por ejemplo, redirigiendo a una página de error
        header("location: ../Controladores/controlador.php?seccion=ADMI_Ordenes&error=Error+al+actualizar+estado");
        exit();
    }
} else {
    // Redirigir con un mensaje de error si los datos no son válidos
    header("location: ../Controladores/controlador.php?seccion=ADMI_Ordenes&error=Datos+del+formulario+no+válidos");
    exit();
}
?>
