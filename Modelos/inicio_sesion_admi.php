<?php
include 'Conexion.php';

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
        $conn = Conexion();

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        $sql = "SELECT apodo, ID_Restaurante FROM administrador WHERE correo = ? AND contrasena = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Error en la preparación de la consulta: " . $conn->error);
        }

        $stmt->bind_param("ss", $correo, $contrasena);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($apodo, $id_restaurante);
            $stmt->fetch();

            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['apodo'] = $apodo;
            $_SESSION['id_restaurante'] = $id_restaurante;

            $stmt->close();
            $conn->close();

            return $id_restaurante; // Retorna el id_restaurante
        } else {
            $stmt->close();
            $conn->close();
            return false;
        }
    }
}
?>
