<?php
require_once '../Modelos/Cupones.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['codigo_cupon']) && !empty($_POST['codigo_cupon'])) {
        $codigoCupon = $_POST['codigo_cupon'];
        $correoUsuario = $_SESSION['correo']; // Obtener el correo del usuario desde la sesión

        // Verifica si el cupón es válido
        $resultado = Cupones::validarCupon($codigoCupon, $correoUsuario);

        if ($resultado['valido']) {
            // Guarda el cupón en la sesión antes de marcarlo como usado
            $_SESSION['cupon'] = ['codigo' => $codigoCupon, 'descuento' => $resultado['descuento']];
            $_SESSION['mensaje_cupon'] = "¡Cupón válido! Descuento: " . $resultado['descuento'] . "%";
        } else {
            $_SESSION['mensaje_cupon'] = "El cupón no es válido o ha expirado.";
        }
    } else {
        $_SESSION['mensaje_cupon'] = "No se ha proporcionado ningún código de cupón.";
    }
    
    header("Location: controlador.php?seccion=facturacion");
    exit();
}
?>
