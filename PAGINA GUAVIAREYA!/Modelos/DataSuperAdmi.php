<?php
require_once '../config/Conexion.php';

/**
 * Clase para gestionar operaciones relacionadas con los superadministradores y estadísticas.
 */
class DataSuperAdmi {

    /**
     * Obtiene la información de un superadministrador basado en el correo electrónico.
     *
     * @param string $email El correo electrónico del superadministrador.
     * @return array|null Información del superadministrador o null si no existe.
     * @throws Exception Si ocurre un error al preparar la consulta.
     */
    public static function obteneremail($email)
    {
        $conn = Conexion::conectar();
        $user = null;

        $stmt = $conn->prepare("
            SELECT 
                apodo AS Apodo,
                contrasena AS contrasena,  
                correo AS Correo
            FROM administradores 
            WHERE correo = ? AND rol = 'super_administrador'
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
     * Actualiza la contraseña de un superadministrador basado en el correo electrónico.
     *
     * @param string $email El correo electrónico del superadministrador.
     * @param string $newPassword La nueva contraseña.
     * @return bool Verdadero si la actualización fue exitosa, falso en caso contrario.
     */
    public static function updatePassword($email, $newPassword)
    {
        $conn = Conexion::conectar();

        $stmt = $conn->prepare("UPDATE administradores SET contrasena = ? WHERE correo = ? AND rol = 'super_administrador'");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . $conn->error);
        }

        $stmt->bind_param("ss", $newPassword, $email);
        $success = $stmt->execute();

        $stmt->close();
        $conn->close();

        return $success;
    }

    /**
     * Borra un producto basado en su ID y elimina su imagen asociada.
     *
     * @return void
     */
    static function borrar_restaurante() {
        // Verificar si se ha enviado el ID del producto a borrar
        if (isset($_POST['ID_Producto'])) {
            $id_producto = $_POST['ID_Producto'];
            $conn = Conexion::conectar();

            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Obtener el nombre del archivo de imagen del producto
            $sql = $conn->prepare("SELECT img_P FROM Productos WHERE ID_Producto = ?");
            if ($sql === false) {
                die("Error preparando la consulta: " . $conn->error);
            }

            $sql->bind_param("i", $id_producto);
            $sql->execute();
            $result = $sql->get_result();
            $row = $result->fetch_assoc();
            $img_P = $row['img_P'];

            // Borrar el archivo de imagen
            $image_path = "../media_productos/" . $img_P;
            if (file_exists($image_path)) {
                unlink($image_path);
            }

            // Preparar la consulta SQL para borrar el producto
            $sql = $conn->prepare("DELETE FROM Productos WHERE ID_Producto = ?");
            if ($sql === false) {
                die("Error preparando la consulta: " . $conn->error);
            }

            $sql->bind_param("i", $id_producto);

            if ($sql->execute()) {
                $conn->close();
                header("location: controlador.php?seccion=ADMI_Productos_A");
                exit();
            } else {
                echo "Error al borrar el producto: " . $conn->error;
            }

            $conn->close();
        } else {
            echo "No se recibió el ID del producto a borrar";
        }
    }

    /**
     * Obtiene estadísticas de pedidos por restaurante en un rango de fechas opcional.
     *
     * @param string|null $fecha_inicio Fecha de inicio para el rango de fechas (opcional).
     * @param string|null $fecha_fin Fecha de fin para el rango de fechas (opcional).
     * @return array Un array con el nombre del restaurante y el número de pedidos.
     */
    public static function obtenerEstadisticasPedidosPorRestaurante($fecha_inicio = null, $fecha_fin = null) {
        $conn = Conexion::conectar();
        $sql = "SELECT r.Nombre_R AS Restaurante, COUNT(p.ID_pedido) AS Numero_Pedidos
                FROM Restaurantes r
                LEFT JOIN Pedidos p ON r.ID_Restaurante = p.ID_Restaurante";
        
        if ($fecha_inicio && $fecha_fin) {
            $sql .= " WHERE DATE(p.fecha_creacion) BETWEEN ? AND ?";
        }
        
        $sql .= " GROUP BY r.ID_Restaurante
                  ORDER BY Numero_Pedidos DESC";
        
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
            echo "Error preparando la consulta: " . $conn->error;
            $conn->close();
            return [];
        }
        
        if ($fecha_inicio && $fecha_fin) {
            $stmt->bind_param("ss", $fecha_inicio, $fecha_fin);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result === false) {
            echo "Error en la consulta SQL: " . $conn->error;
            $conn->close();
            return [];
        }
        
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = [$row['Restaurante'], (int)$row['Numero_Pedidos']];
        }
        
        $conn->close();
        return $data;
    }

    /**
     * Obtiene el producto más popular basado en el número de ventas en un rango de fechas opcional.
     *
     * @param string|null $fecha_inicio Fecha de inicio para el rango de fechas (opcional).
     * @param string|null $fecha_fin Fecha de fin para el rango de fechas (opcional).
     * @return array Un array con el nombre del producto y el número de ventas.
     */
    public static function obtenerProductoMasPopular($fecha_inicio = null, $fecha_fin = null) {
        $conn = Conexion::conectar();
        $sql = "SELECT p.Nombre_P AS Producto, COUNT(d.ID_Producto) AS Numero_Ventas
                FROM Productos p
                JOIN Pedidos d ON p.ID_Producto = d.ID_Producto";
        
        if ($fecha_inicio && $fecha_fin) {
            $sql .= " WHERE DATE(d.fecha_creacion) BETWEEN ? AND ?";
        }
        
        $sql .= " GROUP BY p.ID_Producto
                  ORDER BY Numero_Ventas DESC";
        
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
            echo "Error preparando la consulta: " . $conn->error;
            $conn->close();
            return [];
        }
        
        if ($fecha_inicio && $fecha_fin) {
            $stmt->bind_param("ss", $fecha_inicio, $fecha_fin);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result === false) {
            echo "Error en la consulta SQL: " . $conn->error;
            $conn->close();
            return [];
        }
        
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = [$row['Producto'], (int)$row['Numero_Ventas']];
        }
        
        $conn->close();
        return $data;
    }

    /**
     * Obtiene el usuario con más pedidos en un rango de fechas opcional.
     *
     * @param string|null $fecha_inicio Fecha de inicio para el rango de fechas (opcional).
     * @param string|null $fecha_fin Fecha de fin para el rango de fechas (opcional).
     * @return array Información del usuario con más pedidos o un array vacío si no hay resultados.
     */
    public static function obtenerUsuarioMasPedidos($fecha_inicio = null, $fecha_fin = null) {
        $conn = Conexion::conectar();
        $sql = "SELECT u.Nombre AS Usuario, COUNT(p.ID_pedido) AS Numero_Pedidos
                FROM Usuarios u
                JOIN Pedidos p ON u.Correo = p.Correo";
        
        if ($fecha_inicio && $fecha_fin) {
            $sql .= " WHERE DATE(p.fecha_creacion) BETWEEN ? AND ?";
        }
        
        $sql .= " GROUP BY u.Correo
                  ORDER BY Numero_Pedidos DESC
                  LIMIT 1";
        
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
            echo "Error preparando la consulta: " . $conn->error;
            $conn->close();
            return [];
        }
        
        if ($fecha_inicio && $fecha_fin) {
            $stmt->bind_param("ss", $fecha_inicio, $fecha_fin);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result === false) {
            echo "Error en la consulta SQL: " . $conn->error;
            $conn->close();
            return [];
        }
        
        $data = $result->fetch_assoc();
        
        $conn->close();
        return $data;
    }
}
?>
