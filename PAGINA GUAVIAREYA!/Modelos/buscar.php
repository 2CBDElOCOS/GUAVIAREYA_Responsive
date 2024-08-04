<?php

include '../config/Conexion.php';

class Busqueda {
    private $conn;

    public function __construct() {
        // Establecer la conexión a la base de datos
        $this->conn = Conexion();
    }

    public function buscarProductos($searchTerm) {
        // Escapar el término de búsqueda para evitar inyecciones SQL
        $searchTerm = $this->conn->real_escape_string($searchTerm);

        // Consulta SQL para buscar productos
        $query = "SELECT * FROM Productos WHERE Descripcion LIKE '%$searchTerm%'";
        $result = $this->conn->query($query);

        if ($result) {
            $productos = [];
            while ($row = $result->fetch_assoc()) {
                $productos[] = $row;
            }
            return $productos;
        } else {
            return ['error' => 'Error en la búsqueda: ' . $this->conn->error];
        }
    }
}
?>
