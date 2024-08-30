<?php
include '../config/Conexion.php';

class Registrar
{
    /**
     * Método estático para registrar un usuario en la base de datos.
     * 
     * @return mixed Devuelve true si el registro fue exitoso, 
     *                un mensaje de error si hubo algún problema,
     *                o un mensaje si no se recibieron todos los datos.
     */
    public static function registrarUsuario()
    {
        // Verificar si todos los datos del formulario están presentes
        if (isset($_POST['Apodo'], $_POST['Nombre'], $_POST['Apellido'], $_POST['Correo'], $_POST['Contrasena'], $_POST['Telefono'])) {
            
            // Obtener los datos del formulario
            $apodo = $_POST['Apodo'];
            $nombre = $_POST['Nombre'];
            $apellido = $_POST['Apellido'];
            $correo = $_POST['Correo'];
            $contrasena = $_POST['Contrasena'];
            $telefono = $_POST['Telefono'];

            // Encriptar la contraseña usando md5
            $hashed_password = md5($contrasena);

            // Crear conexión usando la función Conexion
            $conn = Conexion::conectar();

            // Verificar si la conexión fue exitosa
            if ($conn->connect_error) {
                throw new Exception("Conexión fallida: " . $conn->connect_error);
            }

            // Consultar si el correo electrónico ya existe en la base de datos
            $checkEmailSql = "SELECT 1 FROM Usuarios WHERE Correo = ?";
            $checkStmt = $conn->prepare($checkEmailSql);
            if ($checkStmt === false) {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }
            $checkStmt->bind_param("s", $correo);
            $checkStmt->execute();
            $checkStmt->store_result();

            // Verificar si el correo ya está registrado
            if ($checkStmt->num_rows > 0) {
                $checkStmt->close();
                $conn->close();
                return "Usuario ya existente";
            }

            // Preparar la consulta SQL para insertar el nuevo usuario
            $sql = "INSERT INTO Usuarios (Apodo, Nombre, Apellido, Correo, Contrasena, Telefono) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }
            $stmt->bind_param("ssssss", $apodo, $nombre, $apellido, $correo, $hashed_password, $telefono);

            // Ejecutar la consulta y verificar si fue exitosa
            if ($stmt->execute()) {
                // Guardar el apodo y el correo en la sesión
                $_SESSION['Apodo'] = $apodo;
                $_SESSION['Correo'] = $correo;

                // Cerrar la consulta y la conexión
                $stmt->close();
                $conn->close();
                return true;
            } else {
                // Retornar un mensaje de error si no se pudo registrar el usuario
                $error = "Error al registrar los datos: " . $stmt->error;
                $stmt->close();
                $conn->close();
                return $error;
            }
        } else {
            // Retornar un mensaje si no se recibieron todos los datos del formulario
            return "No se recibieron todos los datos del formulario";
        }
    }
}
?>
