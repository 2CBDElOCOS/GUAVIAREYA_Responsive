<?php
include '../config/Conexion.php';

/**
 * Clase para manejar operaciones relacionadas con los usuarios administradores y sus restaurantes.
 */
class DataAdmi
{
    private $conn; // Propiedad para almacenar la conexión

    /**
     * Constructor para inicializar la conexión a la base de datos.
     */
    public function __construct()
    {
        $this->conn = Conexion::conectar(); // Establecer la conexión en el constructor
    }

    /**
     * Obtiene un usuario administrador por su correo electrónico.
     *
     * @param string $email Correo electrónico del usuario a buscar.
     * @return array|null Retorna un array asociativo con los datos del usuario si se encuentra, o null si no se encuentra.
     * @throws Exception Si hay un error preparando la consulta SQL.
     */
    public static function getUserByEmail($email)
    {
        $conn = Conexion::conectar();
        $user = null;

        // Consulta SQL para obtener los datos del usuario y del restaurante asociado
        $stmt = $conn->prepare("
            SELECT 
                administradores.correo, 
                administradores.contrasena, 
                administradores.ID_Restaurante, 
                Restaurantes.Estado, 
                Restaurantes.img_R,  
                Restaurantes.Nombre_R, 
                Restaurantes.Direccion, 
                Restaurantes.Telefono 
            FROM administradores 
            JOIN Restaurantes ON administradores.ID_Restaurante = Restaurantes.ID_Restaurante 
            WHERE administradores.correo = ?
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
     * Actualiza los datos del restaurante asociado a un administrador por su correo electrónico.
     *
     * @param string $email Correo electrónico del administrador.
     * @param string $nombre Nuevo nombre del restaurante.
     * @param string $telefono Nuevo teléfono del restaurante.
     * @param string $direccion Nueva dirección del restaurante.
     * @return bool Retorna true si la actualización fue exitosa, o false si falló.
     * @throws Exception Si hay un error preparando la consulta SQL.
     */
    public static function updateadmi($email, $nombre, $telefono, $direccion)
    {
        // Establecer la conexión a la base de datos
        $conn = Conexion::conectar();

        // Obtener el ID del restaurante asociado al administrador
        $stmt = $conn->prepare("SELECT ID_Restaurante FROM administradores WHERE correo = ?");
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

        $stmt->bind_param("sssi", $nombre, $direccion, $telefono, $id_restaurante);
        $success = $stmt->execute();

        $stmt->close();
        $conn->close();

        return $success;
    }

    /**
     * Sube la foto de perfil del restaurante asociado al usuario administrador.
     *
     * @param string $userEmail Correo electrónico del administrador.
     * @param array $file Array que representa el archivo subido ($_FILES['img_U']).
     * @return bool|string Retorna true si la subida fue exitosa, o un mensaje de error si falla.
     */
    public function subirFotoPerfil($userEmail, $file)
    {
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
        $sql = "UPDATE Restaurantes SET img_R = ? WHERE ID_Restaurante = (SELECT ID_Restaurante FROM administradores WHERE correo = ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ss', $uploadFilePath, $userEmail);

        if ($stmt->execute()) {
            return true; // Subida exitosa
        } else {
            return 'Error al actualizar la base de datos.';
        }
    }

    /**
     * Actualiza la contraseña de un administrador por su correo electrónico.
     *
     * @param string $email Correo electrónico del administrador.
     * @param string $newPassword Nueva contraseña del administrador.
     * @return bool Retorna true si la actualización fue exitosa, o false si falló.
     * @throws Exception Si hay un error preparando la consulta SQL.
     */
    public static function updatePassword($email, $newPassword)
    {
        $conn = Conexion::conectar();

        // Cifrar la nueva contraseña con md5
        $hashedPassword = md5($newPassword);

        // Consulta SQL para actualizar la contraseña
        $stmt = $conn->prepare("UPDATE administradores SET contrasena = ? WHERE correo = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . $conn->error);
        }

        $stmt->bind_param("ss", $hashedPassword, $email);
        $success = $stmt->execute();

        $stmt->close();
        $conn->close();

        return $success;
    }

    /**
     * Obtiene todas las órdenes del restaurante asociado al administrador.
     *
     * @param string $correo Correo electrónico del administrador.
     * @return array Retorna un array con las órdenes del restaurante.
     * @throws Exception Si hay un error preparando la consulta SQL.
     */
    public static function obtenerOrdenes($correo)
    {
        $conn = Conexion::conectar();

        // Obtener el ID del restaurante asociado al administrador
        $stmt = $conn->prepare("SELECT ID_Restaurante FROM administradores WHERE correo = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . $conn->error);
        }
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->bind_result($id_restaurante);
        $stmt->fetch();
        $stmt->close();

        if (!$id_restaurante) {
            throw new Exception("No se encontró un restaurante asociado al administrador.");
        }

        // Preparar y ejecutar la consulta para obtener las órdenes del restaurante
        $stmt = $conn->prepare("
            SELECT 
                p.ID_pedido, 
                u.Nombre AS Nombre_Usuario, 
                u.Correo, 
                pr.Nombre_P AS Nombre_Producto, 
                p.cantidad, 
                d.Direccion, 
                p.fecha_creacion, 
                p.Estado, 
                p.tipo_envio
            FROM Pedidos p
            JOIN Usuarios u ON p.Correo = u.Correo
            JOIN Productos pr ON p.ID_Producto = pr.ID_Producto
            JOIN Direccion_Entregas d ON p.ID_Dire_Entre = d.ID_Dire_Entre
            WHERE p.ID_Restaurante = ?
            ORDER BY p.tipo_envio DESC, p.fecha_creacion DESC
        ");

        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . $conn->error);
        }

        $stmt->bind_param("i", $id_restaurante);
        $stmt->execute();
        $result = $stmt->get_result();
        $ordenes = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();
        $conn->close();

        return $ordenes;
    }

    /**
     * Actualiza el estado de un pedido por su ID.
     *
     * @param int $pedido_id ID del pedido a actualizar.
     * @param string $estado Nuevo estado del pedido.
     * @return void
     * @throws Exception Si hay un error preparando la consulta SQL o si no se actualizó el estado.
     */
    public static function actualizarEstadoPedido($pedido_id, $estado)
    {
        $conn = Conexion::conectar();

        // Consulta SQL para actualizar el estado del pedido
        $stmt = $conn->prepare("UPDATE Pedidos SET Estado = ? WHERE ID_pedido = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . $conn->error);
        }

        $stmt->bind_param("si", $estado, $pedido_id);
        $stmt->execute();

        if ($stmt->affected_rows === 0) {
            throw new Exception("No se actualizó el estado del pedido. Verifique el ID del pedido.");
        }

        $stmt->close();
        $conn->close();
    }

    /**
     * Actualiza el estado de un restaurante por su ID.
     *
     * @param int $id_restaurante ID del restaurante a actualizar.
     * @param string $estado Nuevo estado del restaurante.
     * @return bool Retorna true si la actualización fue exitosa, o false si falló.
     */
    public static function updateRestaurantStatus($id_restaurante, $estado)
    {
        $conn = Conexion::conectar();

        // Consulta SQL para actualizar el estado del restaurante
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

    /**
     * Elimina un administrador por el ID del restaurante asociado.
     *
     * @param int $idRestaurante ID del restaurante asociado al administrador.
     * @return bool Retorna true si la eliminación fue exitosa, o false si falló.
     */
    public static function eliminarAdministrador($idRestaurante)
    {
        $conexion = Conexion::conectar();

        // Consulta SQL para eliminar el administrador
        $query = "DELETE FROM Administradores WHERE ID_Restaurante = ?";

        $stmt = $conexion->prepare($query);
        if ($stmt === false) {
            $conexion->close();
            return false;
        }

        $stmt->bind_param("i", $idRestaurante);
        $success = $stmt->execute();

        $stmt->close();
        $conexion->close();

        return $success;
    }

    /**
     * Elimina un restaurante por su ID.
     *
     * @param int $idRestaurante ID del restaurante a eliminar.
     * @return bool Retorna true si la eliminación fue exitosa, o false si falló.
     */
    public static function eliminarRestaurante($idRestaurante)
    {
        $conexion = Conexion::conectar();

        // Consulta SQL para eliminar el restaurante
        $query = "DELETE FROM Restaurantes WHERE ID_Restaurante = ?";

        $stmt = $conexion->prepare($query);
        if ($stmt === false) {
            $conexion->close();
            return false;
        }

        $stmt->bind_param("i", $idRestaurante);
        $success = $stmt->execute();

        $stmt->close();
        $conexion->close();

        return $success;
    }
}
