<?php
include 'Conexion.php';

// Clase para mostrar las bebidas
class mostrar_bebidas {
    private $conn;

    // Constructor para inicializar la conexión
    public function __construct() {
        // Utilizar la función Conexion para establecer la conexión
        $this->conn = Conexion();
    }

    // Método para obtener los productos de la base de datos
    public function obtenerProductos() {
        // Consulta SQL para seleccionar todos los productos
        $sql = "SELECT * FROM Productos";
        
        // Ejecutar la consulta
        $result = $this->conn->query($sql);
        
        // Inicializar el array de productos
        $productos = [];

        // Verificar si se obtuvieron resultados
        if ($result->num_rows > 0) {
            // Recorrer los resultados y agregarlos al array de productos
            while ($row = $result->fetch_assoc()) {
                $productos[] = $row;
            }
        }

        // Retornar el array de productos
        return $productos;
    }

    // Destructor para cerrar la conexión
    public function __destruct() {
        // Cerrar la conexión
        $this->conn->close();
    }
}
?>
