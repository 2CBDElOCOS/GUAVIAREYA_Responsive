<?php
include '../config/Conexion.php';

/**
 * Clase Login
 * 
 * Esta clase maneja las operaciones relacionadas con el inicio de sesión de usuarios.
 */
class Login {
    /**
     * Verifica si un correo electrónico existe en la base de datos.
     * 
     * @param string $correo Correo electrónico del usuario.
     * @return bool Retorna true si el correo existe, false si no.
     */
    static function VerificarCorreoExistente($correo) {
        // Crear conexión usando la función Conexion
        $conn = Conexion::conectar();

        // Preparar la consulta SQL para verificar si el correo existe
        $sql = "SELECT Correo FROM Usuarios WHERE Correo = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $conn->error);
        }

        // Vincular los parámetros a la consulta preparada
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->store_result();

        // Verificar si se encontraron resultados
        $exists = $stmt->num_rows > 0;

        // Cerrar la conexión y retornar el resultado
        $stmt->close();
        $conn->close();

        return $exists; // Retornar true si existe, false si no
    }

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
        if (!isset($_SESSION['intentos'])) {
            $_SESSION['intentos'] = 0;
        }
    
        // Crear conexión usando la función Conexion
        $conn = Conexion::conectar();
    
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
                // Reiniciar el contador de intentos al iniciar sesión exitosamente
                unset($_SESSION['intentos']);
                unset($_SESSION['bloqueado_hasta']);
                
                // Guardar el apodo en la sesión
                $_SESSION['Apodo'] = $apodo;
    
                // Cerrar la conexión y retornar éxito
                $stmt->close();
                $conn->close();
                return 1; // Indicar que el inicio de sesión fue exitoso
            } else {
                // Incrementar el contador de intentos fallidos
                $_SESSION['intentos']++;
    
                // Verificar si se han superado los intentos permitidos
                if ($_SESSION['intentos'] >= 3) {
                    // Bloquear temporalmente si hay 3 intentos fallidos
                    $_SESSION['bloqueado_hasta'] = time() + 30; // Bloqueado por 30 segundos
                    unset($_SESSION['intentos']);
                    $stmt->close();
                    $conn->close();
                    return 2; // Indicar que está bloqueado
                }
    
                // Contraseña incorrecta
                $stmt->close();
                $conn->close();
                return 0; // Indicar que los datos de inicio de sesión son incorrectos
            }
        } else {
            // Correo no encontrado
            $stmt->close();
            $conn->close();
            return 0; // Indicar que los datos de inicio de sesión son incorrectos
        }
    }
}
?>