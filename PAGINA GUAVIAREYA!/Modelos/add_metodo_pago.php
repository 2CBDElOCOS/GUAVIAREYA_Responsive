<?php


require_once 'Conexion.php';

class add_metodo_pago
{
    public static function add_metodo_pago($numero, $nombre, $apellido, $expiracion, $cvv, $correo)
    {
        // Get the database connection
        $conn = Conexion();

        // Prepare SQL statement
        $sql = "INSERT INTO metodos_pago (numero, nombre, apellido, expiracion, cvv, correo) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("ssssss", $numero, $nombre, $apellido, $expiracion, $cvv, $correo);

        // Execute statement
        if ($stmt->execute()) {
            // Close the statement and connection
            $stmt->close();
            $conn->close();
            return true;
        } else {
            // Close the statement and connection
            $stmt->close();
            $conn->close();
            return false;
        }
    }
}

?>
