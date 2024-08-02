<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['correo']) || empty($_SESSION['correo'])) {
    header("location: ../Controladores/controlador.php?seccion=login");
    exit();
}

include '../Modelos/Direccion_Entregas.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $required_fields = ['Direccion', 'Barrio', 'Descripcion_Ubicacion'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            header("location: ../Controladores/controlador.php?seccion=Perfil_Direcciones&error=1");
            exit();
        }
    }

    $correo = $_SESSION['correo'];
    $direccion = $_POST['Direccion'];
    $barrio = $_POST['Barrio'];
    $descripcion = $_POST['Descripcion_Ubicacion'];

    // Crear una instancia del modelo
    $modeloDireccion = new Modelo_Direccion_Entregas();

    // Insertar la nueva dirección de entrega
    $success = $modeloDireccion->insertarDireccion($correo, $direccion, $barrio, $descripcion);

    if ($success) {
        header("location: controlador.php?seccion=Perfil_Direcciones");
    } else {
        header("location: controlador.php?seccion=Perfil_Direcciones&error=2");
    }
    exit();
} else {
    header("location: controlador.php?seccion=Perfil_Direcciones");
    exit();
}
?>
