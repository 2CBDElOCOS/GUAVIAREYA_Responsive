<?php
/**
 * Función para establecer una conexión con la base de datos
 *
 * @param string $servername Dirección del servidor
 * @param string $username Nombre de usuario de la base de datos
 * @param string $password Contraseña de la base de datos
 * @param string $dbname Nombre de la base de datos
 * @return mysqli|false Retorna el objeto de conexión mysqli si la conexión es exitosa, o false si falla.
 */
function Conexion($servername, $username, $password, $dbname) {
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
