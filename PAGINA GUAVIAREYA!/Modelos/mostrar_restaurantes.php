<?php
require_once '../config/Conexion.php';

class mostrar_restaurantes
{
    private $conn; // Variable privada para almacenar la conexión

    // Constructor para inicializar la conexión
    public function __construct()
    {
        $this->conn = Conexion::conectar(); // Utilizar la función Conexion para establecer la conexión
        if ($this->conn->connect_error) {
            throw new Exception("Conexión fallida: " . $this->conn->connect_error);
        }
    }

    /**
     * Método para obtener todos los restaurantes desde la base de datos
     * @return array Arreglo de restaurantes obtenidos
     * @throws Exception Si ocurre un error al ejecutar la consulta
     */
    public function obtenerRestaurantes()
    {
        $sql = "SELECT * FROM Restaurantes"; // Consulta SQL para seleccionar todos los restaurantes
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Error en la preparación de la consulta: " . $this->conn->error);
        }

        // Ejecutar la consulta
        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }

        $result = $stmt->get_result();
        $restaurantes = []; // Inicializar un array para almacenar los restaurantes

        // Verificar si se obtuvieron resultados
        if ($result->num_rows > 0) {
            // Recorrer los resultados y agregar cada fila como un elemento al array de restaurantes
            while ($row = $result->fetch_assoc()) {
                $restaurantes[] = $row;
            }
        }

        $stmt->close();
        // Retornar el array de restaurantes
        return $restaurantes;
    }

    // Destructor para cerrar la conexión cuando el objeto se destruye
    public function __destruct()
    {
        $this->conn->close(); // Cerrar la conexión
    }
}
?>
