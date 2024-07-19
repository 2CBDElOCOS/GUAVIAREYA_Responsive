<?php
include '../Modelos/DataAdmi.php';

// Verificar que se haya enviado una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Imprimir datos recibidos para depuración
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';

    // Verificar que los datos necesarios estén presentes en la solicitud
    if (isset($_POST['estado']) && isset($_POST['id_restaurante'])) {
        $estado = $_POST['estado'];
        $id_restaurante = $_POST['id_restaurante'];

        // Validar el estado (debe ser 'Abierto' o 'Cerrado')
        if ($estado !== 'Abierto' && $estado !== 'Cerrado') {
            echo 'Estado inválido.';
            exit();
        }

        // Validar que el ID del restaurante sea un número entero
        if (!filter_var($id_restaurante, FILTER_VALIDATE_INT)) {
            echo 'ID de restaurante inválido.';
            exit();
        }

        // Actualizar el estado del restaurante en la base de datos
        $success = DataAdmi::updateRestaurantStatus($id_restaurante, $estado);
        
        if ($success) {
            header("location: controlador.php?seccion=ADMI_Perfil_A");
            exit();
        } else {
            echo 'Error al actualizar el estado del restaurante.';
        }
    } else {
        echo 'Datos incompletos. Asegúrate de que todos los campos están correctamente llenos.';
    }
} else {
    echo 'Método de solicitud no válido.';
}
?>
