<?php

class Registrar {
    static function Registrar() {
        $servername = "127.0.0.1";
        $username = "root";
        $password = "";
        $dbname = "bd_guaviareya";

        // Verificar si se han enviado los datos del formulario
        if (isset($_POST['Apodo']) && isset($_POST['Nombre']) && isset($_POST['Apellido']) && isset($_POST['Correo']) && isset($_POST['Contrasena']) && isset($_POST['Telefono'])) {

            // Obtener los datos del formulario
            $apodo = $_POST['Apodo'];
            $nombre = $_POST['Nombre'];
            $apellido = $_POST['Apellido'];
            $correo = $_POST['Correo'];
            $contrasena = $_POST['Contrasena'];
            $telefono = $_POST['Telefono'];

            // Crear conexión
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verificar conexión
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Preparar la consulta SQL para insertar los datos en la tabla tb_Personas
            $sql = "INSERT INTO Usuarios (Apodo, Nombre, Apellido, Correo, Contrasena, Telefono) VALUES ('$apodo', '$nombre', '$apellido', '$correo', '$contrasena', '$telefono')";

            // Ejecutar la consulta
            if ($conn->query($sql) === TRUE) {
                // Guardar el apodo y correo en la sesión después de registrar los datos
                $_SESSION['Apodo'] = $apodo;
                $_SESSION['correo'] = $correo;

                // Redirigir a la tienda después de registrar los datos
                $conn->close();
                header("location: ../Controladores/controlador.php?seccion=login");
                exit(); // Salir del script después de redirigir
            } else {
                echo "Error al registrar los datos: " . $conn->error;
            }

            // Cerrar la conexión
            $conn->close();
        } else {
            echo "No se recibieron los datos del formulario";
        }
    }
}
?>
