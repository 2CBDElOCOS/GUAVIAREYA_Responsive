<?php

require_once '../config/Conexion.php';

class add_metodo_pago
{
    private static $encryption_key = 'your-secret-encryption-key'; // Cambia esto a una clave secreta segura
    private static $cipher = 'aes-256-cbc'; // Algoritmo de cifrado

    // Función para cifrar datos
    private static function encrypt($data) {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(self::$cipher));
        $encrypted = openssl_encrypt($data, self::$cipher, self::$encryption_key, 0, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }

    public static function add_metodo_pago($numero, $nombre, $apellido, $expiracion, $cvv, $correo)
    {
        // Cifrar los datos
        $numero_encrypted = self::encrypt($numero);
        $nombre_encrypted = self::encrypt($nombre);
        $apellido_encrypted = self::encrypt($apellido);
        $expiracion_encrypted = self::encrypt($expiracion);
        $cvv_encrypted = self::encrypt($cvv);

        // Obtener la conexión a la base de datos
        $conn = Conexion();

        // Preparar la declaración SQL
        $sql = "INSERT INTO metodos_pago (numero, nombre, apellido, expiracion, cvv, correo) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Vincular parámetros
        $stmt->bind_param("ssssss", $numero_encrypted, $nombre_encrypted, $apellido_encrypted, $expiracion_encrypted, $cvv_encrypted, $correo);

        // Ejecutar la declaración
        if ($stmt->execute()) {
            // Cerrar la declaración y la conexión
            $stmt->close();
            $conn->close();
            return true;
        } else {
            // Cerrar la declaración y la conexión
            $stmt->close();
            $conn->close();
            return false;
        }
    }
}
?>
