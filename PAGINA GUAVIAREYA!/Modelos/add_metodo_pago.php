<?php

require_once '../config/Conexion.php';

/**
 * Clase para manejar la adición de métodos de pago.
 */
class add_metodo_pago
{
    // Clave secreta para el cifrado. Cambia esto a una clave secreta segura.
    private static $encryption_key = 'your-secret-encryption-key'; 
    // Algoritmo de cifrado utilizado.
    private static $cipher = 'aes-256-cbc'; 

    /**
     * Función para cifrar datos.
     *
     * @param string $data Los datos a cifrar.
     * @return string Los datos cifrados en formato base64.
     */
    private static function encrypt($data) {
        // Generar un vector de inicialización (IV) aleatorio.
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(self::$cipher));
        // Cifrar los datos.
        $encrypted = openssl_encrypt($data, self::$cipher, self::$encryption_key, 0, $iv);
        // Codificar el resultado cifrado y el IV en base64.
        return base64_encode($encrypted . '::' . $iv);
    }

    /**
     * Función para agregar un método de pago a la base de datos.
     *
     * @param string $numero Número de tarjeta.
     * @param string $nombre Nombre del titular de la tarjeta.
     * @param string $apellido Apellido del titular de la tarjeta.
     * @param string $expiracion Fecha de expiración de la tarjeta.
     * @param string $cvv Código de seguridad de la tarjeta.
     * @param string $correo Correo electrónico del titular.
     * @return bool Devuelve true si la inserción fue exitosa, de lo contrario, false.
     */
    public static function add_metodo_pago($numero, $nombre, $apellido, $expiracion, $cvv, $correo)
    {
        // Cifrar los datos del método de pago.
        $numero_encrypted = self::encrypt($numero);
        $nombre_encrypted = self::encrypt($nombre);
        $apellido_encrypted = self::encrypt($apellido);
        $expiracion_encrypted = self::encrypt($expiracion);
        $cvv_encrypted = self::encrypt($cvv);

        // Obtener la conexión a la base de datos.
        $conn = Conexion::conectar();

        // Preparar la declaración SQL para insertar los datos cifrados.
        $sql = "INSERT INTO metodos_pago (numero, nombre, apellido, expiracion, cvv, correo) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Vincular los parámetros a la declaración SQL.
        $stmt->bind_param("ssssss", $numero_encrypted, $nombre_encrypted, $apellido_encrypted, $expiracion_encrypted, $cvv_encrypted, $correo);

        // Ejecutar la declaración SQL.
        if ($stmt->execute()) {
            // Cerrar la declaración y la conexión.
            $stmt->close();
            $conn->close();
            return true;
        } else {
            // Cerrar la declaración y la conexión.
            $stmt->close();
            $conn->close();
            return false;
        }
    }
}
?>
