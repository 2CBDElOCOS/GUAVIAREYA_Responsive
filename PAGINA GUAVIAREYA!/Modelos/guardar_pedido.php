<?php
require_once 'conexion.php'; // Incluye la función de conexión

class GuardarPedido {
    private $conexion;

    // Constructor acepta la conexión como parámetro
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function getConexion() {
        return $this->conexion;
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

        return $row['count'] > 0;
    }

    public function verificarCupon($cuponCodigo) {
        $cuponCodigo = $this->conexion->real_escape_string($cuponCodigo);
    
        $sql = "SELECT descuento FROM Cupones WHERE Codigo_Cupon = ? AND Fecha_Expiracion >= NOW()";
        $stmt = $this->conexion->prepare($sql);
    
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->conexion->error);
        }
    
        $stmt->bind_param('s', $cuponCodigo);
        $stmt->execute();
    
        $result = $stmt->get_result();
        if (!$result) {
            throw new Exception("Error al obtener el resultado: " . $this->conexion->error);
        }
    
        if ($row = $result->fetch_assoc()) {
            $stmt->close();
            return $row['descuento']; // Retorna el porcentaje de descuento
        } else {
            $stmt->close();
            return false; // Cupón no válido
        }
    }

    public function actualizarFechaUsoCupon($cuponCodigo) {
        $cuponCodigo = $this->conexion->real_escape_string($cuponCodigo);
        
        $sql = "UPDATE Cupones SET Fecha_Usado = NOW() WHERE Codigo_Cupon = ?";
        $stmt = $this->conexion->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->conexion->error);
        }
        
        $stmt->bind_param('s', $cuponCodigo);
        $stmt->execute();
        
        if ($stmt->error) {
            throw new Exception("Error al actualizar la fecha de uso del cupón: " . $stmt->error);
        }
    
        $affectedRows = $stmt->affected_rows;
        $stmt->close();
    
        // Depuración
        if ($affectedRows === 0) {
            error_log("No se actualizó ninguna fila para el cupón: " . $cuponCodigo);
        } else {
            error_log("Fecha de uso actualizada para el cupón: " . $cuponCodigo);
        }
    }
    
    public function insertarPedido($correo, $id_restaurante, $id_producto, $cantidad, $subtotal, $id_direccion_entrega, $tipo_envio) {
        $query = "INSERT INTO Pedidos (ID_Restaurante, ID_Producto, Correo, cantidad, Sub_total, ID_Dire_Entre, tipo_envio) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($query);
    
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->conexion->error);
        }
    
        $stmt->bind_param("iisidss", $id_restaurante, $id_producto, $correo, $cantidad, $subtotal, $id_direccion_entrega, $tipo_envio);
        $stmt->execute();
    
        if ($stmt->error) {
            throw new Exception("Error al insertar pedido: " . $stmt->error);
        }
    
        $stmt->close();
    }
}
?>
