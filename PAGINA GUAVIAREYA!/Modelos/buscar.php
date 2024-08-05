<?php

include '../config/Conexion.php';

/**
 * Clase para manejar las búsquedas de productos.
 */
class Busqueda {
    private $conn;

    /**
     * Constructor de la clase.
     * Establece la conexión a la base de datos.
     */
    public function __construct() {
        $this->conn = Conexion::conectar();
    }

    /**
     * Busca productos en la base de datos según el término de búsqueda proporcionado.
     *
     * @param string $searchTerm El término de búsqueda.
     * @return array Un array con los productos encontrados o un mensaje de error.
     */
    public function buscarProductos($searchTerm) {
        // Escapar el término de búsqueda para evitar inyecciones SQL
        $searchTerm = $this->conn->real_escape_string($searchTerm);

        // Consulta SQL para buscar productos que coincidan con el término de búsqueda
        $query = "SELECT * FROM Productos WHERE Descripcion LIKE '%$searchTerm%'";
        $result = $this->conn->query($query);

        // Verificar si la consulta fue exitosa
        if ($result) {
            $productos = [];
            // Recuperar los resultados de la consulta
            while ($row = $result->fetch_assoc()) {
                $productos[] = $row;
            }
            return $productos;
        } else {
            // Devolver un mensaje de error si la consulta falló
            return ['error' => 'Error en la búsqueda: ' . $this->conn->error];
        }
    }
}
?>
