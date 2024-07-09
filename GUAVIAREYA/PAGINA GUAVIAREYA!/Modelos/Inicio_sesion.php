<?php
include 'Conexion.php';

class Login {
    static function IniciarSesion($correo, $contrasena) {
        if (isset($_SESSION['intentos'])) {
            $_SESSION['intentos']++;
        } else {
            $_SESSION['intentos'] = 1;
        }

        if ($_SESSION['intentos'] >= 3) {
            // Si hay 3 intentos fallidos, bloquear temporalmente
            $_SESSION['bloqueado_hasta'] = time() + 30; // Bloquear por 30 segundos (ajustable según necesidades)
            unset($_SESSION['intentos']);
            return 2; // Indicar que está bloqueado
        }

        // Crear conexión usando la función getConnection
        $conn = Conexion();

        // Preparar la consulta SQL para seleccionar los datos de la tabla Usuarios
        $sql = "SELECT Apodo, Nombre FROM Usuarios WHERE Correo = '$correo' AND Contrasena = '$contrasena'";

        // Ejecutar la consulta
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['Apodo'] = $row['Apodo'];

            // Reiniciar contador de intentos al iniciar sesión exitosamente
            unset($_SESSION['intentos']);

            // Cerrar la conexión y redirigir a otra página después de registrar los datos
            $conn->close();
            return 1; // Indicar que el inicio de sesión fue exitoso
        } else {
            // Cerrar la conexión
            $conn->close();
            return 0; // Indicar que los datos de inicio de sesión son incorrectos
        }
    }
}
?>
