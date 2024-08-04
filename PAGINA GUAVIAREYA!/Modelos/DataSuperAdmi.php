<?php
require_once '../config/Conexion.php';

class DataSuperAdmi {

    public static function obteneremail($email)
    {
        $conn = Conexion();
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

    public static function updatePassword($email, $newPassword)
    {
        $conn = Conexion();

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

        static function borrar_restaurante() {
        // Verificar si se ha enviado el ID del producto a borrar
        if (isset($_POST['ID_Producto'])) {
            // Obtener el ID del producto a borrar
            $id_producto = $_POST['ID_Producto'];

            // Crear conexión
            $conn = Conexion();

            // Verificar conexión
            if ($conn->connect_error) {
                // Terminar la ejecución y mostrar un mensaje de error si la conexión falló
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Obtener el nombre del archivo de imagen del producto
            $sql = $conn->prepare("SELECT img_P FROM Productos WHERE ID_Producto = ?");
            if ($sql === false) {
                // Terminar la ejecución y mostrar un mensaje de error si hay un error preparando la consulta
                die("Error preparando la consulta: " . $conn->error);
            }

            // Vincular el parámetro $id_producto a la consulta preparada
            $sql->bind_param("i", $id_producto);
            $sql->execute();
            $result = $sql->get_result();
            $row = $result->fetch_assoc();
            $img_P = $row['img_P'];

            // Borrar el archivo de imagen
            $image_path = "../media_productos/" . $img_P;
            if (file_exists($image_path)) {
                // Eliminar el archivo de imagen si existe
                unlink($image_path);
            }

            // Preparar la consulta SQL para borrar el producto de la tabla Productos
            $sql = $conn->prepare("DELETE FROM Productos WHERE ID_Producto = ?");
            if ($sql === false) {
                // Terminar la ejecución y mostrar un mensaje de error si hay un error preparando la consulta
                die("Error preparando la consulta: " . $conn->error);
            }

            // Vincular el parámetro $id_producto a la consulta preparada
            $sql->bind_param("i", $id_producto);

            // Ejecutar la consulta
            if ($sql->execute()) {
                // Redirigir a otra página después de borrar el producto
                $conn->close();
                header("location: controlador.php?seccion=ADMI_Productos_A");
                exit(); // Salir del script después de redirigir
            } else {
                // Mostrar un mensaje de error si no se pudo borrar el producto
                echo "Error al borrar el producto: " . $conn->error;
            }

            // Cerrar la conexión
            $conn->close();
        } else {
            // Mostrar un mensaje si no se recibió el ID del producto a borrar
            echo "No se recibió el ID del producto a borrar";
        }
    }

    public static function obtenerEstadisticasPedidosPorRestaurante($fecha_inicio = null, $fecha_fin = null) {
        $conn = Conexion();
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
    public static function obtenerProductoMasPopular($fecha_inicio = null, $fecha_fin = null) {
        $conn = Conexion();
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
    
    public static function obtenerUsuarioMasPedidos($fecha_inicio = null, $fecha_fin = null) {
        $conn = Conexion();
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
