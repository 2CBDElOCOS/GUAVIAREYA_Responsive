<?php
function Conexion() {
    $servername = "localhost";
    $username = "root"; // O el nombre de usuario que utilices
    $password = ""; // O la contraseña que utilices
    $dbname = "bd_guaviareya"; // Asegúrate de que esta base de datos exista

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar si la conexión tuvo éxito
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    return $conn;
}
?>
