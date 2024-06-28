<?php
include 'Conexion.php';

// Clase para manejar el inicio de sesión
class Login {
    // Método estático para iniciar sesión
    static function IniciarSesion() {
        // Verificar si se han enviado los datos del formulario
        if (isset($_POST['Correo']) && isset($_POST['Contrasena'])) {

            // Obtener los datos del formulario
            $correo = $_POST['Correo'];
            $contrasena = $_POST['Contrasena'];

            // Crear conexión usando la función Conexion
            $conn = Conexion();

            // Preparar la consulta SQL para seleccionar los datos de la tabla Usuarios
            $sql = "SELECT Apodo, Nombre FROM Usuarios WHERE Correo = '$correo' AND Contrasena = '$contrasena'";

            // Ejecutar la consulta
            $result = $conn->query($sql);

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
                return 0;
            }

            // Cerrar la conexión
            $conn->close();
        }
    }
}
?>
