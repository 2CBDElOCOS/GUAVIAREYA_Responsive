<?php

include('Conexion.php');

class add_metodo_pago
{
    public static function add_metodo_pago($numero, $nombre, $apellido, $expiracion, $cvv)
    {
        // Get the database connection
        $conn = Conexion();

        // Prepare SQL statement
        $sql = "INSERT INTO metodos_pago (numero, nombre, apellido, expiracion, cvv) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("sssss", $numero, $nombre, $apellido, $expiracion, $cvv);

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
