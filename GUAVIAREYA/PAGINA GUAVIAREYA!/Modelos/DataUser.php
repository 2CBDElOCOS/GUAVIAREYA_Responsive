<?php
include 'Conexion.php';

// Clase para manejar operaciones relacionadas con los usuarios
Class DataUser {
    private $conn; // Propiedad para almacenar la conexión

    // Constructor para inicializar la conexión
    public function __construct() {
        $this->conn = Conexion(); // Establecer la conexión en el constructor
    }

    // Método estático para obtener un usuario por su correo electrónico
    public static function getUserByEmail($email) {
        // Crear conexión
        $conn = Conexion();

        // Inicializar la variable $user
        $user = null;

        // Preparar y ejecutar la consulta SQL para obtener el usuario por correo electrónico
        $stmt = $conn->prepare("SELECT Correo, Apodo, Nombre, Apellido, Telefono, img_U, Contrasena FROM Usuarios WHERE Correo = ?");
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
    
    // Método para subir la foto de perfil del usuario
    public function subirFotoPerfil($userEmail, $file) {
        // Verificar si hay algún error en el archivo subido
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return 'Error al subir el archivo.';
        }

        // Verificar el tamaño del archivo (máximo 5MB)
        if ($file['size'] > 5242880) {
            return 'El archivo es demasiado grande. El tamaño máximo permitido es de 5MB.';
        }

        // Verificar el tipo de archivo
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            return 'Tipo de archivo no permitido. Solo se permiten archivos JPG, PNG y GIF.';
        }

        // Mover el archivo subido a la carpeta de destino
        $uploadDir = '../media_profiles/';
        $fileName = basename($file['name']);
        $uploadFilePath = $uploadDir . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $uploadFilePath)) {
            return 'Error al mover el archivo subido.';
        }

        // Actualizar la base de datos con la nueva ruta de la foto de perfil
        $sql = "UPDATE Usuarios SET img_U = ? WHERE Correo = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ss', $uploadFilePath, $userEmail);

        if ($stmt->execute()) {
            return true; // Subida exitosa
        } else {
            return 'Error al actualizar la base de datos.';
        }
    }
    public static function updatePassword($email, $newPassword) {
        $conn = Conexion();

        // Preparar y ejecutar la consulta SQL para actualizar la contraseña
        $stmt = $conn->prepare("UPDATE Usuarios SET Contrasena = ? WHERE Correo = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . $conn->error);
        }

        // Vincular los parámetros a la consulta preparada
        $stmt->bind_param("ss", $newPassword, $email);
        $success = $stmt->execute();

        // Cerrar la conexión
        $stmt->close();
        $conn->close();

        // Retornar si la actualización fue exitosa
        return $success;
    }


}
?>
