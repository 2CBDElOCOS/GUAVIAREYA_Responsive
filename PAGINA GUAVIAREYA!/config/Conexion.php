<?php
class Conexion {
    public static function conectar() {
        $servidor = "127.0.0.1";
        $usuario = "root";
        $password = "";
        $base_datos = "bd_guaviareya";

        $conn = new mysqli($servidor, $usuario, $password, $base_datos);

        if ($conn->connect_error) {
            die("La conexión ha fallado: " . $conn->connect_error);
        }

        return $conn;
    }
}
?>
