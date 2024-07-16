<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['correo']) || $_SESSION['correo'] == "") {
    header("location: ../Controladores/controlador.php?seccion=login");
    exit();
}

include_once '../Modelos/Direccion_Entregas.php';

$modeloDireccion = new Modelo_Direccion_Entregas();

// Acción para agregar una nueva dirección de entrega
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Direccion']) && isset($_POST['Barrio']) && isset($_POST['Descripcion_Ubicacion'])) {
    $correo = $_SESSION['correo'];
    $direccion = $_POST['Direccion'];
    $barrio = $_POST['Barrio'];
    $descripcionUbicacion = $_POST['Descripcion_Ubicacion'];

    // Insertar la nueva dirección de entrega
    $success = $modeloDireccion->updatedireccion($correo, $direccion, $barrio, $descripcionUbicacion);

    if ($success) {
        header("location: controlador.php?seccion=Perfil_Direcciones");
        exit();
    } else {
        header("location: controlador.php?seccion=Perfil_Direcciones&error=1");
        exit();
    }
}

// Otras acciones relacionadas con las direcciones de entrega pueden ser añadidas aquí según sea necesario
?>
