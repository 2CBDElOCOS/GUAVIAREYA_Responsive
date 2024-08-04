<?php
class GuardarPedido {
    private $conexion;

    public function __construct() {
        require_once '../config/Conexion.php';
        $this->conexion = Conexion();
    }

    public function verificarRestaurante($id_restaurante) {
        $id_restaurante = intval($id_restaurante);

        $sql = "SELECT COUNT(*) as count FROM Restaurantes WHERE ID_Restaurante = ?";
        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->conexion->error);
        }

        $stmt->bind_param('i', $id_restaurante);
        $stmt->execute();

        $result = $stmt->get_result();
        if (!$result) {
            throw new Exception("Error al obtener el resultado: " . $this->conexion->error);
        }

        $row = $result->fetch_assoc();
        $stmt->close();

        // Puedes eliminar el var_dump para producción
        // var_dump($row);

        return $row['count'] > 0;
    }

    public function insertarPedido($correo, $id_restaurante, $id_producto, $cantidad, $subtotal, $id_direccion_entrega, $tipo_envio) {
        $query = "INSERT INTO Pedidos (ID_Restaurante, ID_Producto, Correo, cantidad, Sub_total, ID_Dire_Entre, tipo_envio) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($query);

        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->conexion->error);
        }

        // Asegúrate de que el tipo de datos corresponda con la base de datos
        $stmt->bind_param("iisidss", $id_restaurante, $id_producto, $correo, $cantidad, $subtotal, $id_direccion_entrega, $tipo_envio);
        $stmt->execute();

        if ($stmt->error) {
            throw new Exception("Error al insertar pedido: " . $stmt->error);
        }

        $stmt->close();
    }
}
?>
