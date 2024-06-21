<?php
class mostrar_productos {
    private $servername = "127.0.0.1";
    private $username = "root";
    private $password = "";
    private $dbname = "bd_guaviareya";
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }
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
