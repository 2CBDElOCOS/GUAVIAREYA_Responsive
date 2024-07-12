<?php
// Modelos/mostrar_productos.php
include 'Conexion.php';

class mostrar_productos {
    public function obtenerProductosPorRestaurante($id_restaurante) {
        $conn = Conexion();

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Preparar la consulta SQL para obtener productos por ID_Restaurante
        $sql = "SELECT * FROM Productos WHERE ID_Restaurante = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $conn->error);
        }
        $stmt->bind_param("i", $id_restaurante);
        $stmt->execute();
        $result = $stmt->get_result();

        $productos = [];
        while ($row = $result->fetch_assoc()) {
            $productos[] = $row;
        }

        $stmt->close();
        $conn->close();
        return $productos;
    }

    public function obtenerNombreRestaurante($id_restaurante) {
        $conn = Conexion();

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Preparar la consulta SQL para obtener el nombre del restaurante
        $query = "SELECT Nombre_R FROM restaurantes WHERE ID_Restaurante = ?";
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $conn->error);
        }
        $stmt->bind_param("i", $id_restaurante);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $stmt->close();
        $conn->close();
        return $row['Nombre_R'];
    }

    public function obtenerProductoPorId($id_producto) {
        $conn = Conexion();

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Preparar la consulta SQL para obtener un producto por su ID
        $sql = "SELECT * FROM Productos WHERE ID_Producto = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $conn->error);
        }
        $stmt->bind_param("i", $id_producto);
        $stmt->execute();
        $result = $stmt->get_result();
        $producto = $result->fetch_assoc();

        $stmt->close();
        $conn->close();
        return $producto;
    }
}

?>
