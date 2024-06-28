<?php
include 'Conexion.php';

// Clase para manejar operaciones relacionadas con los usuarios
Class DataUser {

    // Método estático para obtener un usuario por su correo electrónico
    public static function getUserByEmail($email) {
        // Crear conexión
        $conn = Conexion();

        // Inicializar la variable $user
        $user = null;

        // Preparar y ejecutar la consulta SQL para obtener el usuario por correo electrónico
        $stmt = $conn->prepare("SELECT Correo, Apodo, Nombre, Apellido, Telefono, img_U FROM Usuarios WHERE Correo = ?");
        if ($stmt === false) {
            // Lanzar una excepción si hay un error preparando la consulta
            throw new Exception("Error preparando la consulta: " . $conn->error);
        }

        // Vincular el parámetro $email a la consulta preparada
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verificar si se obtuvo un resultado
        if ($result && $result->num_rows > 0) {
            // Obtener el resultado como un array asociativo
            $user = $result->fetch_assoc();
        }

        // Cerrar la conexión
        $stmt->close();
        $conn->close();

        // Retornar el usuario obtenido
        return $user;
    }

    // Método estático para actualizar un usuario por su correo electrónico
    public static function updateUser($email, $nombre, $apellido, $telefono) {
        // Crear conexión
        $conn = Conexion();

        // Preparar y ejecutar la consulta SQL para actualizar el usuario por correo electrónico
        $stmt = $conn->prepare("UPDATE Usuarios SET Nombre = ?, Apellido = ?, Telefono = ? WHERE Correo = ?");
        if ($stmt === false) {
            // Lanzar una excepción si hay un error preparando la consulta
            throw new Exception("Error preparando la consulta: " . $conn->error);
        }

        // Vincular los parámetros a la consulta preparada
        $stmt->bind_param("ssss", $nombre, $apellido, $telefono, $email);
        $success = $stmt->execute();

        // Cerrar la conexión
        $stmt->close();
        $conn->close();

        // Retornar si la actualización fue exitosa
        return $success;
    }

    // Método para validar la clave
    function validar_clave($clave, &$error_clave) {
        // Verificar si la clave tiene al menos 6 caracteres
        if (strlen($clave) < 6) {
            $error_clave = "La clave debe tener al menos 6 caracteres";
            return false;
        }
        // Verificar si la clave tiene más de 16 caracteres
        if (strlen($clave) > 16) {
            $error_clave = "La clave no puede tener más de 16 caracteres";
            return false;
        }
        // Verificar si la clave tiene al menos una letra minúscula
        if (!preg_match('`[a-z]`', $clave)) {
            $error_clave = "La clave debe tener al menos una letra minúscula";
            return false;
        }
        // Verificar si la clave tiene al menos una letra mayúscula
        if (!preg_match('`[A-Z]`', $clave)) {
            $error_clave = "La clave debe tener al menos una letra mayúscula";
            return false;
        }
        // Verificar si la clave tiene al menos un carácter numérico
        if (!preg_match('`[0-9]`', $clave)) {
            $error_clave = "La clave debe tener al menos un carácter numérico";
            return false;
        }
        // Si todas las validaciones son correctas, no hay error
        $error_clave = "";
        return true;
    }
}
?>
