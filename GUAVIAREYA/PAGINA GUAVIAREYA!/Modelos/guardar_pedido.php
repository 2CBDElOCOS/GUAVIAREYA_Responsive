<?php
class GuardarPedido {

    private $conexion;

    public function __construct() {
        // Incluir el archivo de conexión
        require_once 'Conexion.php';
        $this->conexion = Conexion();
    }

    public function verificarRestaurante($id_restaurante) {
        $sql = "SELECT COUNT(*) as count FROM Restaurantes WHERE ID_Restaurante = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('i', $id_restaurante);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }
    
    // Insertar pedido con dirección de entrega
    public function insertarPedido($correo, $id_restaurante, $id_producto, $cantidad, $subtotal, $id_direccion_entrega) {
        $query = "INSERT INTO Pedidos (ID_Restaurante, ID_Producto, Correo, cantidad, Sub_total, ID_Dire_Entre) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("iisidi", $id_restaurante, $id_producto, $correo, $cantidad, $subtotal, $id_direccion_entrega);
        $stmt->execute();
        if ($stmt->error) {
            throw new Exception("Error al insertar pedido: " . $stmt->error);
        }
    }
    
}

?>
