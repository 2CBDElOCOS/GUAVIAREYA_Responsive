<?php
// Modelos/mostrar_productos.php
include 'Conexion.php';

class mostrar_productos {
    /**
     * Método para obtener todos los productos por ID_Restaurante
     * @param int $id_restaurante El ID del restaurante del cual se obtendrán los productos
     * @return array Arreglo de productos obtenidos
     */
    public function obtenerProductosPorRestaurante($id_restaurante) {
        $conn = Conexion();

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Preparar la consulta SQL para obtener productos por ID_Restaurante
        $sql = "SELECT * FROM Productos WHERE ID_Restaurante = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $conn->error);
        }
        
        // Vincular el parámetro $id_restaurante a la consulta preparada
        $stmt->bind_param("i", $id_restaurante);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado de la consulta
        $result = $stmt->get_result();

        // Crear un array para almacenar los productos
        $productos = [];
        while ($row = $result->fetch_assoc()) {
            $productos[] = $row;
        }

        // Cerrar la consulta y la conexión
        $stmt->close();
        $conn->close();

        // Retornar los productos obtenidos
        return $productos;
    }

    /**
     * Método para obtener el nombre de restaurante por ID_Restaurante
     * @param int $id_restaurante El ID del restaurante del cual se obtendrá el nombre
     * @return string Nombre del restaurante
     */
    public function obtenerNombreRestaurante($id_restaurante) {
        $conn = Conexion();

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Preparar la consulta SQL para obtener el nombre del restaurante
        $query = "SELECT Nombre_R FROM restaurantes WHERE ID_Restaurante = ?";
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $conn->error);
        }
        
        // Vincular el parámetro $id_restaurante a la consulta preparada
        $stmt->bind_param("i", $id_restaurante);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado de la consulta
        $result = $stmt->get_result();

        // Obtener el nombre del restaurante
        $row = $result->fetch_assoc();

        // Cerrar la consulta y la conexión
        $stmt->close();
        $conn->close();

        // Retornar el nombre del restaurante
        return $row['Nombre_R'];
    }

    /**
     * Método para obtener un producto por su ID_Producto
     * @param int $id_producto El ID del producto que se desea obtener
     * @return array|null Arreglo asociativo con los datos del producto o null si no se encuentra
     */
    public function obtenerProductoPorId($id_producto) {
        $conn = Conexion();

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Preparar la consulta SQL para obtener un producto por su ID_Producto
        $sql = "SELECT * FROM Productos WHERE ID_Producto = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $conn->error);
        }
        
        // Vincular el parámetro $id_producto a la consulta preparada
        $stmt->bind_param("i", $id_producto);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado de la consulta
        $result = $stmt->get_result();

        // Obtener el producto
        $producto = $result->fetch_assoc();

        // Cerrar la consulta y la conexión
        $stmt->close();
        $conn->close();

        // Retornar el producto obtenido
        return $producto;
    }
}

?>
