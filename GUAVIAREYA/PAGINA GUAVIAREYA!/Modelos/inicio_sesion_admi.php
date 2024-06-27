<?php
include 'Conexion.php';

// Clase para manejar el inicio de sesión
class Login {
    // Método estático para iniciar sesión
    static function IniciarSesion() {
        // Verificar si se han enviado los datos del formulario
        if (isset($_POST['correo']) && isset($_POST['contrasena'])) {
            // Obtener los datos del formulario
            $correo = $_POST['correo'];
            $contrasena = $_POST['contrasena'];

            // Crear conexión usando la función Conexion
            $conn = Conexion();

            // Preparar la consulta SQL para seleccionar los datos de la tabla administrador
            $sql = "SELECT apodo, ID_Restaurante FROM administrador WHERE correo = ? AND contrasena = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $correo, $contrasena);
            $stmt->execute();
            $stmt->store_result();

            // Verificar si se encontró un administrador con las credenciales dadas
            if ($stmt->num_rows > 0) {
                // Vincular los resultados a variables
                $stmt->bind_result($apodo, $id_restaurante);

                // Obtener el primer (y único) resultado
                $stmt->fetch();

                // Iniciar sesión y guardar datos necesarios en la sesión
                session_start();
                $_SESSION['apodo'] = $apodo;
                $_SESSION['id_restaurante'] = $id_restaurante;

                // Cerrar la declaración y la conexión
                $stmt->close();
                $conn->close();

                // Retornar verdadero indicando éxito
                return true;
            } else {
                // Si no se encontraron resultados, retornar falso indicando credenciales incorrectas
                $stmt->close();
                $conn->close();
                return false;
            }
        }
    }
}
?>
