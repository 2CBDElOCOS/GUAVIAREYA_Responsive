<?php
require_once 'Conexion.php';

/**
 * Clase Modelo_Direccion_Entregas
 * 
 * Esta clase maneja operaciones relacionadas con las direcciones de entrega de usuarios.
 */
class Modelo_Direccion_Entregas {
    private static $conn; // Propiedad estática para almacenar la conexión

    /**
     * Método privado para inicializar la conexión si aún no está establecida.
     *
     * @return void
     */
    private static function initConnection() {
        if (!self::$conn) {
            self::$conn = Conexion();
        }
    }

    /**
     * Constructor para inicializar la conexión.
     */
    public function __construct() {
        self::initConnection();
    }

    /**
     * Método para insertar una nueva dirección de entrega en la base de datos.
     *
     * @param string $correo Correo del usuario al que pertenece la dirección.
     * @param string $direccion Dirección de la entrega.
     * @param string $barrio Barrio de la dirección.
     * @param string $descripcion Descripción adicional de la dirección.
     * @return bool Retorna true si la inserción fue exitosa, false en caso contrario.
     * @throws Exception Si hay un error preparando la consulta SQL.
     */
    public function insertarDireccion($correo, $direccion, $barrio, $descripcion) {
        self::initConnection();

        // Preparar la consulta SQL para insertar la dirección
        $sql = "INSERT INTO Direccion_Entregas (Correo, Direccion, Barrio, Descripcion) VALUES (?, ?, ?, ?)";
        $stmt = self::$conn->prepare($sql);

        if ($stmt === false) {
            // Lanzar una excepción si hay un error preparando la consulta
            throw new Exception("Error preparando la consulta: " . self::$conn->error);
        }

        // Vincular los parámetros a la consulta preparada
        $stmt->bind_param("ssss", $correo, $direccion, $barrio, $descripcion);

        // Ejecutar la consulta
        $success = $stmt->execute();

        // Cerrar la consulta
        $stmt->close();

        // Retornar si la inserción fue exitosa
        return $success;
    }

    /**
     * Método estático para obtener todas las direcciones de entrega de un usuario por su correo.
     *
     * @param string $correo Correo del usuario del que se quieren obtener las direcciones.
     * @return array|null Retorna un array de direcciones de entrega obtenidas, o null si no hay resultados.
     * @throws Exception Si hay un error preparando la consulta SQL.
     */
    public static function obtenerDireccionesPorUsuario($correo) {
        self::initConnection();

        // Preparar la consulta SQL para obtener las direcciones por correo de usuario
        $sql = "SELECT ID_Dire_Entre, Direccion, Barrio, Descripcion FROM Direccion_Entregas WHERE Correo = ?";
        $stmt = self::$conn->prepare($sql);

        if ($stmt === false) {
            // Lanzar una excepción si hay un error preparando la consulta
            throw new Exception("Error preparando la consulta: " . self::$conn->error);
        }

        // Vincular el parámetro $correo a la consulta preparada
        $stmt->bind_param("s", $correo);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado de la consulta
        $result = $stmt->get_result();

        // Obtener las filas como un array asociativo
        $direcciones = $result->fetch_all(MYSQLI_ASSOC);

        // Cerrar la consulta
        $stmt->close();

        // Retornar las direcciones obtenidas o null si no hay resultados
        return $direcciones ? $direcciones : null;
    }

    // Método para cerrar la conexión si es necesario
    public function __destruct() {
        if (self::$conn) {
            self::$conn->close();
        }
    }

    /**
 * Método para eliminar una dirección de entrega de la base de datos.
 *
 * @param int $id Identificador de la dirección a eliminar.
 * @return bool Retorna true si la eliminación fue exitosa, false en caso contrario.
 * @throws Exception Si hay un error preparando la consulta SQL.
 */
public function eliminarDireccion($id) {
    self::initConnection();

    // Preparar la consulta SQL para eliminar la dirección
    $sql = "DELETE FROM Direccion_Entregas WHERE ID_Dire_Entre = ?";
    $stmt = self::$conn->prepare($sql);

    if ($stmt === false) {
        // Lanzar una excepción si hay un error preparando la consulta
        throw new Exception("Error preparando la consulta: " . self::$conn->error);
    }

    // Vincular el parámetro $id a la consulta preparada
    $stmt->bind_param("i", $id);

    // Ejecutar la consulta
    $success = $stmt->execute();

    // Cerrar la consulta
    $stmt->close();

    // Retornar si la eliminación fue exitosa
    return $success;
}

}
?>
