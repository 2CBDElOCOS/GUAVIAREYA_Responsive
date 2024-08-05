<?php
require_once '../config/Conexion.php';

class Cupones {
    public static function ObtenerCuponPorCorreo($correo) {
        $conn = Conexion::conectar();
        $sql = "SELECT Codigo_Cupon, Descuento FROM Cupones WHERE Correo = ? AND Fecha_Usado IS NULL AND Fecha_Expiracion > NOW()";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $conn->error);
        }
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($codigo_cupon, $descuento);
            $stmt->fetch();
            $stmt->close();
            $conn->close();
            return ['codigo' => $codigo_cupon, 'descuento' => $descuento];
        } else {
            $stmt->close();
            $conn->close();
            return null;
        }
    }

    public static function validarCupon($codigoCupon, $correoUsuario) {
        $conn = Conexion::conectar();
        $sql = "SELECT Descuento FROM Cupones WHERE Codigo_Cupon = ? AND Correo = ? AND Fecha_Usado IS NULL AND Fecha_Expiracion > NOW()";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $codigoCupon, $correoUsuario);
        $stmt->execute();
        $stmt->bind_result($descuento);

        if ($stmt->fetch()) {
            $stmt->close();
            $conn->close();
            return ['valido' => true, 'descuento' => $descuento];
        } else {
            $stmt->close();
            $conn->close();
            return ['valido' => false];
        }
    }
}
?>
