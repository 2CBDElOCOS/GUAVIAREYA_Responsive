<?php
require_once '../config/Conexion.php';

/**
 * Clase para manejar la validación de cupones.
 */
class Cupones {
    /**
     * Valida un cupón según su código.
     *
     * @param string $codigoCupon El código del cupón a validar.
     * @return array Un array con el estado de validez del cupón y mensajes de error si es necesario.
     */
    public static function validarCupon($codigoCupon) {
        // Establecer la conexión a la base de datos
        $conn = Conexion::conectar();
        
        // Verificar si hubo un error en la conexión
        if ($conn->connect_error) {
            return ['valido' => false, 'mensaje' => 'Error en la conexión a la base de datos.'];
        }

        // Escapar el código del cupón para evitar inyecciones SQL
        $codigoCupon = $conn->real_escape_string($codigoCupon);
        
        // Consulta SQL para seleccionar los detalles del cupón
        $query = "SELECT descuento, fecha_expiracion, usado FROM Cupones WHERE codigo = ?";
        $stmt = $conn->prepare($query);

        // Verificar si hubo un error al preparar la consulta
        if (!$stmt) {
            return ['valido' => false, 'mensaje' => 'Error al preparar la consulta.'];
        }

        // Vincular el parámetro de la consulta
        $stmt->bind_param("s", $codigoCupon);
        $stmt->execute();
        $stmt->store_result();
        
        // Verificar si el cupón no existe en la base de datos
        if ($stmt->num_rows === 0) {
            $stmt->close();
            $conn->close();
            return ['valido' => false, 'mensaje' => 'Código de cupón inválido.'];
        }

        // Obtener los resultados de la consulta
        $stmt->bind_result($descuento, $fechaExpiracion, $usado);
        $stmt->fetch();
        $stmt->close();
        $conn->close();
        
        // Verificar si el cupón ya ha sido usado
        if ($usado) {
            return ['valido' => false, 'mensaje' => 'El cupón ya ha sido usado.'];
        }
        
        // Verificar si el cupón ha expirado
        if (new DateTime() > new DateTime($fechaExpiracion)) {
            return ['valido' => false, 'mensaje' => 'El cupón ha expirado.'];
        }
        
        // Si el cupón es válido, devolver el descuento
        return ['valido' => true, 'descuento' => $descuento];
    }
}
?>
