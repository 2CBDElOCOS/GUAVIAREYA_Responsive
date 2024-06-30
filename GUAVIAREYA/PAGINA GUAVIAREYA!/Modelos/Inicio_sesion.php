<?php
include 'Conexion.php';

// Clase para manejar el inicio de sesión
class Login {
    // Método estático para iniciar sesión
    static function IniciarSesion($correo, $contrasena) {
        // Crear conexión usando la función Conexion
        $conn = Conexion();

        // Preparar la consulta SQL para seleccionar los datos de la tabla Usuarios
        $sql = "SELECT Apodo, Nombre FROM Usuarios WHERE Correo = ? AND Contrasena = ?";

        // Preparar la sentencia
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $correo, $contrasena);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verificar si se obtuvo un resultado
        if ($result->num_rows > 0) {
            // Obtener los datos del resultado
            $row = $result->fetch_assoc();
            // Guardar el apodo del usuario en la sesión
            $_SESSION['Apodo'] = $row['Apodo'];

            // Cerrar la conexión y retornar 1 indicando éxito
            $conn->close();
            return 1;
        } else {
            // Retornar 0 indicando que las credenciales son incorrectas
            $conn->close();
            return 0;
        }
    }
}
?>
