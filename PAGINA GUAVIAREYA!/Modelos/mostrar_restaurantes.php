<?php
require_once 'Conexion.php';

// Clase para mostrar restaurantes
class mostrar_restaurantes {
    private $conn; // Variable privada para almacenar la conexión

    // Constructor para inicializar la conexión
    public function __construct() {
        $this->conn = Conexion(); // Utilizar la función Conexion para establecer la conexión
    }

    /**
     * Método para obtener todos los restaurantes desde la base de datos
     * @return array Arreglo de restaurantes obtenidos
     */
    public function obtenerRestaurantes() {
        $sql = "SELECT * FROM Restaurantes"; // Consulta SQL para seleccionar todos los restaurantes
        $result = $this->conn->query($sql); // Ejecutar la consulta SQL
        $restaurantes = []; // Inicializar un array para almacenar los restaurantes

        // Verificar si se obtuvieron resultados
        if ($result->num_rows > 0) {
            // Recorrer los resultados y agregar cada fila como un elemento al array de restaurantes
            while ($row = $result->fetch_assoc()) {
                $restaurantes[] = $row;
            }
        }

        // Retornar el array de restaurantes
        return $restaurantes;
    }

    // Destructor para cerrar la conexión cuando el objeto se destruye
    public function __destruct() {
        $this->conn->close(); // Cerrar la conexión
    }
}
?>
