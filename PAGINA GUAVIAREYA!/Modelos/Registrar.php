<?php
// Incluir el archivo de conexión a la base de datos
include 'Conexion.php';

// Clase para manejar el registro de usuarios
class Registrar {
    // Método estático para registrar un usuario
    static function registrarUsuario() {
        // Verificar si se han enviado los datos del formulario
        if (isset($_POST['Apodo']) && isset($_POST['Nombre']) && isset($_POST['Apellido']) && isset($_POST['Correo']) && isset($_POST['Contrasena']) && isset($_POST['Telefono'])) {
            // Obtener los datos del formulario
            $apodo = $_POST['Apodo'];
            $nombre = $_POST['Nombre'];
            $apellido = $_POST['Apellido'];
            $correo = $_POST['Correo'];
            $contrasena = $_POST['Contrasena'];
            $telefono = $_POST['Telefono'];

            // Crear conexión usando la función Conexion
            $conn = Conexion();

            // Verificar la conexión
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Preparar la consulta SQL para insertar los datos en la tabla Usuarios
            $sql = "INSERT INTO Usuarios (Apodo, Nombre, Apellido, Correo, Contrasena, Telefono) VALUES ('$apodo', '$nombre', '$apellido', '$correo', '$contrasena', '$telefono')";

            // Ejecutar la consulta y verificar si fue exitosa
            if ($conn->query($sql) === TRUE) {
                // Guardar el apodo y correo en la sesión después de registrar los datos
                $_SESSION['Apodo'] = $apodo;
                $_SESSION['correo'] = $correo;

                // Redirigir a la página de inicio de sesión después de registrar los datos
                $conn->close();
                header("location: ../Controladores/controlador.php?seccion=login");
                exit(); // Salir del script después de redirigir
            } else {
                // Mostrar un mensaje de error si no se pudo registrar el usuario
                echo "Error al registrar los datos: " . $conn->error;
            }

            // Cerrar la conexión
            $conn->close();
        } else {
            // Mostrar un mensaje si no se recibieron los datos del formulario
            echo "No se recibieron los datos del formulario";
        }
    }
}
?>
