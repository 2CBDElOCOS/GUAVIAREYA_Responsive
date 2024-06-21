<?php
function Conexion() {
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "bd_guaviareya";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    return $conn;
}
?>
