<?php
include 'Conexion.php';

/**
 * Clase para manejar operaciones relacionadas con los usuarios
 */
Class DataAdmi {
    private $conn; // Propiedad para almacenar la conexión

    /**
     * Constructor para inicializar la conexión
     */
    public function __construct() {
        $this->conn = Conexion(); // Establecer la conexión en el constructor
    }

    /**
     * Método estático para obtener un usuario por su correo electrónico
     *
     * @param string $email Correo electrónico del usuario a buscar
     * @return array|null Retorna un array asociativo con los datos del usuario si se encuentra, o null si no se encuentra
     * @throws Exception Si hay un error preparando la consulta SQL
     */
    public static function getUserByEmail($email) {
        $conn = Conexion();
        $user = null;

        $stmt = $conn->prepare("
            SELECT 
                administrador.correo, 
                administrador.contrasena, 
                administrador.ID_Restaurante, 
                Restaurantes.Estado, 
                administrador.img_A, 
                Restaurantes.Nombre_R, 
                Restaurantes.Direccion, 
                Restaurantes.Telefono 
            FROM administrador 
            JOIN Restaurantes ON administrador.ID_Restaurante = Restaurantes.ID_Restaurante 
            WHERE administrador.correo = ?
        ");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . $conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
        }

        $stmt->close();
        $conn->close();

        return $user;
    }

    /**
     * Método estático para actualizar un usuario por su correo electrónico
     *
     * @param string $email Correo electrónico del usuario a actualizar
     * @param string $nombre Nuevo nombre del usuario
     * @param string $apellido Nuevo apellido del usuario
     * @param string $telefono Nuevo teléfono del usuario
     * @return bool Retorna true si la actualización fue exitosa, o false si falló
     * @throws Exception Si hay un error preparando la consulta SQL
        */
    public static function updateadmi($email, $nombre, $telefono, $direccion) {
        // Crear conexión
        $conn = Conexion();

        // Obtener el ID del restaurante asociado al administrador
        $stmt = $conn->prepare("SELECT ID_Restaurante FROM administrador WHERE correo = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . $conn->error);
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($id_restaurante);
        $stmt->fetch();
        $stmt->close();

        if (!$id_restaurante) {
            throw new Exception("No se encontró un restaurante asociado al administrador.");
        }

        // Preparar y ejecutar la consulta SQL para actualizar los datos del restaurante
        $stmt = $conn->prepare("UPDATE Restaurantes SET Nombre_R = ?, Direccion = ?, Telefono = ? WHERE ID_Restaurante = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . $conn->error);
        }

        // Vincular los parámetros a la consulta preparada
        $stmt->bind_param("sssi", $nombre, $direccion, $telefono, $id_restaurante);
        $success = $stmt->execute();

        // Cerrar la conexión
        $stmt->close();
        $conn->close();

        // Retornar si la actualización fue exitosa
        return $success;
    }

    
    /**
     * Método para subir la foto de perfil del usuario
     *
     * @param string $userEmail Correo electrónico del usuario
     * @param array $file Array que representa el archivo subido ($_FILES['img_U'])
     * @return bool|string Retorna true si la subida fue exitosa, o un mensaje de error si falla
     */
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

    /**
     * Método estático para actualizar la contraseña de un usuario por su correo electrónico
     *
     * @param string $email Correo electrónico del usuario
     * @param string $newPassword Nueva contraseña del usuario
     * @return bool Retorna true si la actualización fue exitosa, o false si falló
     * @throws Exception Si hay un error preparando la consulta SQL
     */
    public static function updatePassword($email, $newPassword) {
        // Crear conexión
        $conn = Conexion();

        // Preparar y ejecutar la consulta SQL para actualizar la contraseña
        $stmt = $conn->prepare("UPDATE Administrador SET Contrasena = ? WHERE Correo = ?");
        if ($stmt === false) {
            // Lanzar una excepción si hay un error preparando la consulta
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

    public static function updateRestaurantStatus($id_restaurante, $estado) {
        $conn = Conexion();

        $stmt = $conn->prepare("UPDATE Restaurantes SET Estado = ? WHERE ID_Restaurante = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . $conn->error);
        }

        $stmt->bind_param("si", $estado, $id_restaurante);
        $success = $stmt->execute();

        $stmt->close();
        $conn->close();

        return $success;
    }

    
}
?>