<?php
require_once 'Conexion.php';

/**
 * Clase Login
 * 
 * Esta clase maneja las operaciones relacionadas con el inicio de sesión de usuarios.
 */
class Login {
    /**
     * Método estático para iniciar sesión de un usuario.
     *
     * @param string $correo Correo electrónico del usuario.
     * @param string $contrasena Contraseña del usuario.
     * @return int Retorna 1 si el inicio de sesión fue exitoso, 0 si los datos de inicio de sesión son incorrectos,
     *             o 2 si el usuario está bloqueado temporalmente.
     */
    static function IniciarSesion($correo, $contrasena) {
        // Incrementar el contador de intentos de inicio de sesión
        if (isset($_SESSION['intentos'])) {
            $_SESSION['intentos']++;
        } else {
            $_SESSION['intentos'] = 1;
        }

        // Verificar si se superó el número máximo de intentos fallidos
        if ($_SESSION['intentos'] >= 3) {
            // Bloquear temporalmente si hay 3 intentos fallidos
            $_SESSION['bloqueado_hasta'] = time() + 30; // Bloquear por 30 segundos (ajustable según necesidades)
            unset($_SESSION['intentos']);
            return 2; // Indicar que está bloqueado
        }

        // Crear conexión usando la función Conexion
        $conn = Conexion();

        // Preparar la consulta SQL para seleccionar los datos del usuario
        $sql = "SELECT Apodo, Nombre, Contrasena FROM Usuarios WHERE Correo = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $conn->error);
        }

        // Vincular los parámetros a la consulta preparada
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->store_result();

        // Verificar si se encontraron resultados
        if ($stmt->num_rows > 0) {
            // Obtener los datos del usuario
            $stmt->bind_result($apodo, $nombre, $hashed_password);
            $stmt->fetch();

            // Verificar la contraseña
            if (md5($contrasena) === $hashed_password) {
                // Guardar el apodo en la sesión
                $_SESSION['Apodo'] = $apodo;

                // Reiniciar el contador de intentos al iniciar sesión exitosamente
                unset($_SESSION['intentos']);

                // Cerrar la conexión y retornar éxito
                $stmt->close();
                $conn->close();
                return 1; // Indicar que el inicio de sesión fue exitoso
            } else {
                // Contraseña incorrecta, cerrar la conexión y retornar falla
                $stmt->close();
                $conn->close();
                return 0; // Indicar que los datos de inicio de sesión son incorrectos
            }
        } else {
            // Cerrar la conexión y retornar falla
            $stmt->close();
            $conn->close();
            return 0; // Indicar que los datos de inicio de sesión son incorrectos
        }
    }

    
}
?>
