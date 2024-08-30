<?php
require_once '../config/Conexion.php';

/**
 * Clase para manejar la validación y obtención de cupones.
 */
class Cupones {
    /**
     * Obtiene un cupón asociado a un correo electrónico, si está disponible y no ha sido usado.
     *
     * @param string $correo El correo electrónico del usuario para buscar el cupón.
     * @return array|null Retorna un array con el código del cupón y el descuento si el cupón existe y es válido, o null si no existe.
     */
    public static function ObtenerCuponPorCorreo($correo) {
        // Establecer la conexión a la base de datos
        $conn = Conexion::conectar();
        
        // Consulta SQL para obtener el código del cupón y el descuento para un correo específico
        $sql = "SELECT Codigo_Cupon, Descuento FROM Cupones WHERE Correo = ? AND Fecha_Usado IS NULL AND Fecha_Expiracion > NOW()";
        $stmt = $conn->prepare($sql);

        // Verificar si hubo un error al preparar la consulta
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $conn->error);
        }

        // Vincular el parámetro del correo a la consulta
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->store_result();
        
        // Verificar si se encontraron resultados
        if ($stmt->num_rows > 0) {
            // Obtener los resultados del cupón
            $stmt->bind_result($codigo_cupon, $descuento);
            $stmt->fetch();
            $stmt->close();
            $conn->close();
            return [
                'codigo' => $codigo_cupon,
                'descuento' => $descuento
            ];
        } else {
            // No se encontraron cupones válidos
            $stmt->close();
            $conn->close();
            return null;
        }
    }

    /**
     * Valida un cupón según su código y el correo del usuario.
     *
     * @param string $codigoCupon El código del cupón a validar.
     * @param string $correoUsuario El correo electrónico del usuario que intenta usar el cupón.
     * @return array Un array que indica si el cupón es válido y el descuento asociado.
     */
    public static function validarCupon($codigoCupon, $correoUsuario) {
        // Establecer la conexión a la base de datos
        $conn = Conexion::conectar();
        
        // Consulta SQL para validar el cupón según el código y el correo del usuario
        $sql = "SELECT Descuento FROM Cupones WHERE Codigo_Cupon = ? AND Correo = ? AND Fecha_Usado IS NULL AND Fecha_Expiracion > NOW()";
        $stmt = $conn->prepare($sql);

        // Verificar si hubo un error al preparar la consulta
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $conn->error);
        }

        // Vincular los parámetros del cupón y del correo a la consulta
        $stmt->bind_param('ss', $codigoCupon, $correoUsuario);
        $stmt->execute();
        $stmt->bind_result($descuento);

        // Verificar si se obtuvo un resultado válido
        if ($stmt->fetch()) {
            $stmt->close();
            $conn->close();
            return [
                'valido' => true,
                'descuento' => $descuento
            ];
        } else {
            // El cupón no es válido
            $stmt->close();
            $conn->close();
            return [
                'valido' => false
            ];
        }
    }
}
?>
