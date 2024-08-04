<?php
include '../config/Conexion.php';

/**
 * Clase Login
 * 
 * Esta clase maneja las operaciones relacionadas con el inicio de sesión de administradores.
 */
class Login {
    /**
     * Método estático para iniciar sesión de un administrador.
     *
     * @param string $correo Correo electrónico del administrador.
     * @param string $contrasena Contraseña del administrador.
     * @return mixed Retorna el ID del restaurante si el inicio de sesión fue exitoso, o false si falló.
     * @throws Exception Si hay un error en la preparación de la consulta SQL.
     */
    static function IniciarSesion($correo, $contrasena) {
        // Incrementar el contador de intentos
        if (isset($_SESSION['intentos_admi'])) {
            $_SESSION['intentos_admi']++;
        } else {
            $_SESSION['intentos_admi'] = 1;
        }

        // Verificar si se superó el número máximo de intentos fallidos
        if ($_SESSION['intentos_admi'] >= 3) {
            // Bloquear temporalmente si hay 3 intentos fallidos
            $_SESSION['bloqueado_hasta_admi'] = time() + 30; // Bloquear por 30 segundos (ajustable)
            unset($_SESSION['intentos_admi']);
            return false; // Indicar que está bloqueado
        }

        $conn = Conexion();

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // La consulta solo selecciona la contraseña almacenada
        $sql = "SELECT apodo, ID_Restaurante, rol, contrasena FROM administradores WHERE correo = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Error en la preparación de la consulta: " . $conn->error);
        }

        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($apodo, $id_restaurante, $rol, $hashed_password);
            $stmt->fetch();

            // Comparar la contraseña ingresada con la almacenada en la base de datos
            if (md5($contrasena) === $hashed_password) {
                // Reiniciar el contador de intentos
                unset($_SESSION['intentos_admi']);

                $_SESSION['apodo'] = $apodo;
                $_SESSION['id_restaurante'] = $id_restaurante;
                $_SESSION['rol'] = $rol;

                $stmt->close();
                $conn->close();

                return $rol; // Retorna el rol
            } else {
                $stmt->close();
                $conn->close();
                return false;
            }
        } else {
            $stmt->close();
            $conn->close();
            return false;
        }
    }
}
?>
