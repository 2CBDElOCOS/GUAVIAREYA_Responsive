<?php
include 'Conexion.php';

/**
 * Clase para manejar operaciones relacionadas con los usuarios
 */
class DataAdmi
{
    private $conn; // Propiedad para almacenar la conexión

    /**
     * Constructor para inicializar la conexión
     */
    public function __construct()
    {
        $this->conn = Conexion(); // Establecer la conexión en el constructor
    }

    /**
     * Método estático para obtener un usuario por su correo electrónico
     *
     * @param string $email Correo electrónico del usuario a buscar
     * @return array|null Retorna un array asociativo con los datos del usuario si se encuentra, o null si no se encuentra
     * @throws Exception Si hay un error preparando la consulta SQL
     */
    public static function getUserByEmail($email)
{
    $conn = Conexion();
    $user = null;

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
    public static function updatePassword($email, $newPassword)
    {
        $conn = Conexion();
    
        // Cifrar la nueva contraseña con md5
        $hashedPassword = md5($newPassword);
    
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
public static function obtenerOrdenes($correo) {
    $conn = Conexion();

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

    // Preparar y ejecutar la consulta para obtener las órdenes del restaurante específico
    $stmt = $conn->prepare("
        SELECT p.ID_pedido, u.Nombre AS Nombre_Usuario, u.Correo, pr.Nombre_P AS Nombre_Producto, p.cantidad, d.Direccion, p.fecha_creacion, p.Estado
        FROM Pedidos p
        JOIN Usuarios u ON p.Correo = u.Correo
        JOIN Productos pr ON p.ID_Producto = pr.ID_Producto
        JOIN Direccion_Entregas d ON p.ID_Dire_Entre = d.ID_Dire_Entre
        WHERE p.ID_Restaurante = ?
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

public static function actualizarEstadoPedido($pedido_id, $estado) {
        $conn = Conexion();
        
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

    public static function updateRestaurantStatus($id_restaurante, $estado)
    {
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

    public static function eliminarAdministrador($idRestaurante) {
        // Obtener la conexión a la base de datos
        $conexion = Conexion();
        
        // Consulta para eliminar el administrador
        $query = "DELETE FROM Administradores WHERE ID_Restaurante = ?";
        
        // Preparar y ejecutar la consulta
        if ($stmt = $conexion->prepare($query)) {
            $stmt->bind_param("i", $idRestaurante);
            
            if ($stmt->execute()) {
                $stmt->close();
                $conexion->close();
                return true;
            } else {
                $stmt->close();
                $conexion->close();
                return false;
            }
        } else {
            $conexion->close();
            return false;
        }
    }

    // Función para eliminar un restaurante
    public static function eliminarRestaurante($idRestaurante) {
        // Obtener la conexión a la base de datos
        $conexion = Conexion();
        
        // Consulta para eliminar el restaurante
        $query = "DELETE FROM Restaurantes WHERE ID_Restaurante = ?";
        
        // Preparar y ejecutar la consulta
        if ($stmt = $conexion->prepare($query)) {
            $stmt->bind_param("i", $idRestaurante);
            
            if ($stmt->execute()) {
                $stmt->close();
                $conexion->close();
                return true;
            } else {
                $stmt->close();
                $conexion->close();
                return false;
            }
        } else {
            $conexion->close();
            return false;
        }
    }


}
