<?php
include 'Conexion.php';

/**
 * Clase para manejar operaciones relacionadas con los usuarios
 */
Class DataUser {
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
        $stmt = $conn->prepare("UPDATE Usuarios SET Contrasena = ? WHERE Correo = ?");
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

    public function obtenerPedidosPorUsuario($correo) {
        $query = "SELECT p.ID_pedido, p.Descripcion, p.cantidad, p.Sub_total, p.fecha_pedido
                  FROM Pedidos p
                  WHERE p.Correo = ?
                  ORDER BY p.Sub_total DESC"; // O usa otro campo para ordenar si lo prefieres
    
        $stmt = $this->conn->prepare($query);
    
        // Verificar si prepare falló
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->conn->error);
        }
    
        // Vincular el parámetro
        $stmt->bind_param("s", $correo);
    
        // Ejecutar la consulta
        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }
    
        // Obtener resultados
        $result = $stmt->get_result();
        $pedidos = $result->fetch_all(MYSQLI_ASSOC);
    
        // Cerrar la declaración
        $stmt->close();
    
        return $pedidos;
    }
    
    

}
?>