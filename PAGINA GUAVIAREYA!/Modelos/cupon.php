<?php
require_once '../config/Conexion.php';

class Cupones {
    public static function validarCupon($codigoCupon) {
        $conn = Conexion();
        if ($conn->connect_error) {
            return ['valido' => false, 'mensaje' => 'Error en la conexión a la base de datos.'];
        }

        $codigoCupon = $conn->real_escape_string($codigoCupon);
        $query = "SELECT descuento, fecha_expiracion, usado FROM Cupones WHERE codigo = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            return ['valido' => false, 'mensaje' => 'Error al preparar la consulta.'];
        }

        $stmt->bind_param("s", $codigoCupon);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows === 0) {
            $stmt->close();
            $conn->close();
            return ['valido' => false, 'mensaje' => 'Código de cupón inválido.'];
        }

        $stmt->bind_result($descuento, $fechaExpiracion, $usado);
        $stmt->fetch();
        $stmt->close();
        $conn->close();
        
        if ($usado) {
            return ['valido' => false, 'mensaje' => 'El cupón ya ha sido usado.'];
        }
        
        if (new DateTime() > new DateTime($fechaExpiracion)) {
            return ['valido' => false, 'mensaje' => 'El cupón ha expirado.'];
        }
        
        return ['valido' => true, 'descuento' => $descuento];
    }
}
?>
