<?php
include '../config/Conexion.php';

/**
 * Clase para manejar operaciones relacionadas con los usuarios
 */
Class DataUser {
    private $conn;

    public function __construct() {
        $this->conn = Conexion::conectar();
    }

    public static function getUserByEmail($email) {
        $conn = Conexion::conectar();

        $user = null;

        $stmt = $conn->prepare("SELECT Correo, Apodo, Nombre, Apellido, Telefono, img_U, Contrasena FROM Usuarios WHERE Correo = ?");
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
    public static function updateUser($email, $nombre, $apellido, $telefono) {
        // Crear conexión
        $conn = Conexion::conectar();

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
        $conn = Conexion::conectar();
    
        $stmt = $conn->prepare("UPDATE Usuarios SET Contrasena = ? WHERE Correo = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . $conn->error);
        }
    
        $stmt->bind_param("ss", $newPassword, $email);
        $success = $stmt->execute();
    
        $stmt->close();
        $conn->close();
    
        return $success;
    }

    public function actualizarContrasena($correo, $hashedPassword) {
        $query = "UPDATE Usuarios SET Contrasena = ? WHERE correo = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ss', $hashedPassword, $correo);
        return $stmt->execute();
    }


    public function obtenerPedidosPorUsuario($correo) {
        $query = "SELECT 
                    p.ID_pedido, 
                    p.fecha_creacion, 
                    p.Estado,  -- Incluimos el estado aquí
                    prod.Nombre_P AS Nombre_Producto, 
                    r.Nombre_R AS Nombre_Restaurante, 
                    CONCAT(d.Direccion, ' ', d.Barrio) AS Direccion_Entrega,
                    p.cantidad, 
                    p.Sub_total
                  FROM 
                    Pedidos p
                  JOIN 
                    Productos prod ON p.ID_Producto = prod.ID_Producto
                  JOIN 
                    Restaurantes r ON p.ID_Restaurante = r.ID_Restaurante
                  JOIN 
                    Direccion_Entregas d ON p.ID_Dire_Entre = d.ID_Dire_Entre
                  WHERE 
                    p.Correo = ?
                  ORDER BY 
                    p.fecha_creacion DESC";
    
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->conn->error);
        }
    
        $stmt->bind_param("s", $correo);
        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }
    
        $result = $stmt->get_result();
        $pedidos = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $pedidos;
    }

    public static function eliminarCuenta($email) {
        $conn = Conexion::conectar();
    
        // Iniciar una transacción
        $conn->begin_transaction();
    
        try {
            // Identificar y eliminar registros en tablas dependientes
            $tablasDependientes = [
                'Likes_Dislikes',
                'Documentos_Identificacion',
                'Cupones',
                'Pedidos_factura',
                'metodos_pago',
                'Pedidos',
                'Direccion_Entregas',
                'Usuarios' // La tabla principal debe ser la última
            ];
    
            foreach ($tablasDependientes as $tabla) {
                $sql = "DELETE FROM $tabla WHERE Correo = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $email);
    
                if (!$stmt->execute()) {
                    throw new Exception("Error al eliminar registros de la tabla $tabla: " . $stmt->error);
                }
            }
    
            // Si todo fue bien, confirmar la transacción
            $conn->commit();
            return true;
        } catch (Exception $e) {
            // Si hubo un error, revertir la transacción
            $conn->rollback();
            return $e->getMessage();
        } finally {
            $stmt->close();
            $conn->close();
        }
    }
    
    
    

}
?>