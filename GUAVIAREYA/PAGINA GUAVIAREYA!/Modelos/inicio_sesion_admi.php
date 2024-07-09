<?php
include 'Conexion.php';

class Login {
    static function IniciarSesion($correo, $contrasena) {
        $conn = Conexion();

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        $sql = "SELECT apodo, ID_Restaurante FROM administrador WHERE correo = ? AND contrasena = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $conn->error);
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
