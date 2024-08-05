<?php
require('../FPDF/fpdf.php'); 

class GuardarPedido {
    private $conexion;

    public function __construct() {
        require_once '../config/Conexion.php';
        $this->conexion = Conexion::conectar();
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

    public function insertarPedido($correo, $id_restaurante, $id_producto, $cantidad, $subtotal, $id_direccion_entrega, $tipo_envio, $total) {
        $query = "INSERT INTO Pedidos (ID_Restaurante, ID_Producto, Correo, cantidad, Sub_total, ID_Dire_Entre, tipo_envio, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
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
    
        // Configura FPDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
    
        // Título
        $pdf->Cell(0, 10, 'Factura de Compra', 0, 1, 'C');
        $pdf->Ln(10);
    
        // Información del pedido
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'ID Pedido: ' . $pedido['ID_pedido'], 0, 1);
        $pdf->Cell(0, 10, 'Correo: ' . $pedido['Correo'], 0, 1);
        $pdf->Cell(0, 10, 'Restaurante ID: ' . $pedido['ID_Restaurante'], 0, 1);
        $pdf->Cell(0, 10, 'Producto ID: ' . $pedido['ID_Producto'], 0, 1);
        $pdf->Cell(0, 10, 'Cantidad: ' . $pedido['cantidad'], 0, 1);
        $pdf->Cell(0, 10, 'Subtotal: $' . $pedido['Sub_total'], 0, 1);
        $pdf->Cell(0, 10, 'Dirección de Entrega ID: ' . $pedido['ID_Dire_Entre'], 0, 1);
        $pdf->Cell(0, 10, 'Tipo de Envío: ' . $pedido['Tipo_Envio'], 0, 1);
        $pdf->Cell(0, 10, 'Total: $' . $pedido['total'], 0, 1);
    
        // Output del PDF
        $pdf->Output('F', __DIR__ . '/../facturas/factura_' . $pedido_id . '.pdf'); // Guarda el PDF en el servidor
    }
    
    
}
?>
