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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Numero_Casa']) && isset($_POST['CL_Cra_AV']) && isset($_POST['Barrio'])) {
    $correo = $_SESSION['correo'];
    $numeroCasa = $_POST['Numero_Casa'];
    $clCraAv = $_POST['CL_Cra_AV'];
    $barrio = $_POST['Barrio'];

    // Insertar la nueva dirección de entrega
    $success = $modeloDireccion->insertarDireccion($correo, $numeroCasa, $clCraAv, $barrio);

    if ($success) {
        header("location: controlador.php?seccion=pedidos_per");
        exit();
    } else {
        header("location: controlador.php?seccion=pedidos_per&error=1");
        exit();
    }
}

// Otras acciones relacionadas con las direcciones de entrega pueden ser añadidas aquí según sea necesario
?>
