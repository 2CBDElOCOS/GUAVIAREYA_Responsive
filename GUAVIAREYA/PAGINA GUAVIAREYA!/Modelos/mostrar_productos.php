<?php
include 'Conexion.php';

// Clase para mostrar productos
class mostrar_productos {
    private $conn; // Variable privada para almacenar la conexión

    // Constructor para inicializar la conexión
    public function __construct() {
        $this->conn = Conexion(); // Utilizar la función Conexion para establecer la conexión
    }

    // Método para obtener todos los productos desde la base de datos
    public function obtenerProductos() {
        $sql = "SELECT * FROM Productos"; // Consulta SQL para seleccionar todos los productos
        $result = $this->conn->query($sql); // Ejecutar la consulta SQL
        $productos = []; // Inicializar un array para almacenar los productos

        // Verificar si se obtuvieron resultados
        if ($result->num_rows > 0) {
            // Recorrer los resultados y agregar cada fila como un elemento al array de productos
            while ($row = $result->fetch_assoc()) {
                $productos[] = $row;
            }
        }

        return $productos; // Retornar el array de productos
    }

    // Destructor para cerrar la conexión cuando el objeto se destruye
    public function __destruct() {
        $this->conn->close(); // Cerrar la conexión
    }
}
?>
