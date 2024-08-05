<?php
// Incluir el archivo de conexión a la base de datos
include '../config/Conexion.php';

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

            // Encriptar la contraseña
            $hashed_password = md5($contrasena);

            // Crear conexión usando la función Conexion
            $conn = Conexion::conectar();

            // Verificar la conexión
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Preparar la consulta SQL para insertar los datos en la tabla Usuarios
            $sql = "INSERT INTO Usuarios (Apodo, Nombre, Apellido, Correo, Contrasena, Telefono) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $apodo, $nombre, $apellido, $correo, $hashed_password, $telefono);

            // Ejecutar la consulta y verificar si fue exitosa
            if ($stmt->execute()) {
                // Guardar el apodo y correo en la sesión después de registrar los datos
                $_SESSION['Apodo'] = $apodo;
                $_SESSION['correo'] = $correo;

                // Redirigir a la página de inicio de sesión después de registrar los datos
                $stmt->close();
                $conn->close();
                return true;
            } else {
                // Mostrar un mensaje de error si no se pudo registrar el usuario
                $error = "Error al registrar los datos: " . $stmt->error;
                $stmt->close();
                $conn->close();
                return $error;
            }
        } else {
            // Mostrar un mensaje si no se recibieron los datos del formulario
            return "No se recibieron los datos del formulario";
        }
    }
}
?>
