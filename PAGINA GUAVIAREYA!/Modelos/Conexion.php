<?php
/**
 * Función para establecer una conexión con la base de datos
 *
 * Esta función crea y retorna un objeto de conexión `mysqli` utilizando los parámetros especificados.
 *
 * @return mysqli|false Retorna el objeto de conexión `mysqli` si la conexión es exitosa, o `false` si falla.
 */
function Conexion() {
    // Definir los parámetros de la conexión
    $servername = "127.0.0.1"; // Dirección del servidor de la base de datos (puede ser una IP o un nombre de dominio)
    $username = "root";        // Nombre de usuario para conectar a la base de datos
    $password = "";            // Contraseña del usuario de la base de datos
    $dbname = "bd_guaviareya"; // Nombre de la base de datos a la que se desea conectar

    // Crear una nueva conexión usando los parámetros definidos
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar si la conexión tuvo éxito
    if ($conn->connect_error) {
        // Terminar la ejecución y mostrar un mensaje de error si la conexión falló
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Retornar el objeto de conexión
    return $conn;
}
?>
