<?php
class GuardarPedido {
    private $conexion;

    public function __construct() {
        require_once '../config/Conexion.php';
        $this->conexion = Conexion::conectar();
    }

    /**
     * Verifica si un restaurante con el ID proporcionado existe en la base de datos.
     * 
     * @param int $id_restaurante El ID del restaurante a verificar.
     * @return bool Retorna verdadero si el restaurante existe, falso en caso contrario.
     * @throws Exception Si ocurre un error al preparar o ejecutar la consulta.
     */
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

        return $row['count'] > 0;
    }

    /**
     * Inserta un nuevo pedido en la base de datos.
     * 
     * @param string $correo El correo electrónico del usuario que realiza el pedido.
     * @param int $id_restaurante El ID del restaurante del pedido.
     * @param int $id_producto El ID del producto en el pedido.
     * @param int $cantidad La cantidad del producto en el pedido.
     * @param float $subtotal El subtotal del pedido.
     * @param int $id_direccion_entrega El ID de la dirección de entrega.
     * @param string $tipo_envio El tipo de envío seleccionado.
     * @return void
     * @throws Exception Si ocurre un error al preparar o ejecutar la consulta.
     */
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
