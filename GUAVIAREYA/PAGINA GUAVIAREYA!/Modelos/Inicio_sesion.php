<?php
class Login{
    static function IniciarSesion(){
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "bd_guaviareya";

    // Verificar si se han enviado los datos del formulario
    if (isset($_POST['Correo']) && isset($_POST['Contrasena'])) {

        // Obtener los datos del formulario
        $correo = $_POST['Correo'];
        $contrasena = $_POST['Contrasena'];

        // Crear conexión
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
        
        // Preparar la consulta SQL para insertar los datos en la tabla tb_Personas
        $sql = "SELECT * FROM Usuarios WHERE Correo = '$correo' AND Contrasena = '$contrasena'";

        // Ejecutar la consulta
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            // Redirigir a otra página después de registrar los datos
            $conn->close();
            // Salir del script después de redirigir
            return 1;
        } else {
            return 0;
        }

        // Cerrar la conexión
        
}
    }} 