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
    $descripcion = $_POST['Descripcion_Ubicacion'];

    // Insertar la nueva dirección de entrega
    $success = $modeloDireccion->insertarDireccion($correo, $direccion, $barrio, $descripcion);

    if ($success) {
        header("location: controlador.php?seccion=Perfil_Direcciones");
        exit();
    } else {
        header("location: controlador.php?seccion=Perfil_Direcciones&error=2");
        exit();
    }
}

// Acción para eliminar una dirección de entrega
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Eliminar la dirección de entrega
    $success = $modeloDireccion->eliminarDireccion($id);

    if ($success) {
        header("location: controlador.php?seccion=Perfil_Direcciones");
        exit();
    } else {
        header("location: controlador.php?seccion=Perfil_Direcciones&error=3");
        exit();
    }
}
?>
