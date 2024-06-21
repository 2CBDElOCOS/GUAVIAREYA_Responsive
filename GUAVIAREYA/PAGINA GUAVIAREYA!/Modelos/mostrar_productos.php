<?php
include 'Conexion.php';

class mostrar_productos {
    private $conn;

    public function __construct() {
        $this->conn = Conexion(); // Utilizar la función Conexion
    }

    public function obtenerProductos() {
        $sql = "SELECT * FROM Productos";
        $result = $this->conn->query($sql);
        $productos = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $productos[] = $row;
            }
        }

        return $productos;
    }

    public function __destruct() {
        $this->conn->close();
    }
}
?>
