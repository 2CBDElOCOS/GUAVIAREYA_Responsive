<?php
require('../FPDF/fpdf.php');

class GuardarPedido {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
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

    public function insertarPedido($correo, $id_restaurante, $id_producto, $cantidad, $subtotal, $id_direccion_entrega, $tipo_envio, $total) {
        $query = "INSERT INTO Pedidos (ID_Restaurante, ID_Producto, Correo, cantidad, Sub_total, ID_Dire_Entre, Tipo_Envio, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($query);

        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->conexion->error);
        }

        $stmt->bind_param("iisidssd", $id_restaurante, $id_producto, $correo, $cantidad, $subtotal, $id_direccion_entrega, $tipo_envio, $total);
        $stmt->execute();

        if ($stmt->error) {
            throw new Exception("Error al insertar pedido: " . $stmt->error);
        }

        $pedido_id = $stmt->insert_id; // Obtén el ID del pedido recién insertado
        $stmt->close();

        // Genera la factura en PDF
        $this->generarFactura($pedido_id);
    }

    private function generarFactura($pedido_id) {
        // Obtén los detalles del pedido desde la base de datos
        $query = "SELECT * FROM Pedidos WHERE ID_pedido = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param('i', $pedido_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            throw new Exception("No se encontraron datos para el ID de pedido: " . $pedido_id);
        }
    
        $pedido = $result->fetch_assoc();
        $stmt->close();
    
        // Verifica si las claves existen en el array
        if (!isset($pedido['ID_pedido'])) {
            throw new Exception("El campo 'ID_pedido' no está definido en el resultado de la consulta.");
        }
        if (!isset($pedido['Tipo_Envio'])) {
            throw new Exception("El campo 'Tipo_Envio' no está definido en el resultado de la consulta.");
        }
        if (!isset($pedido['total'])) {
            throw new Exception("El campo 'total' no está definido en el resultado de la consulta.");
        }
    
        // Crear instancia de FPDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
    
        // Agrega contenido al PDF
        $pdf->Cell(40, 10, 'Factura del Pedido');
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'ID del Pedido: ' . $pedido['ID_pedido']);
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'Tipo de Envio: ' . $pedido['Tipo_Envio']);
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'Total: ' . $pedido['total']);
    
        // Guarda el PDF en un archivo
        $pdf->Output('F', '../facturas/factura_' . $pedido_id . '.pdf');
    }
}
?>
