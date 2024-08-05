<?php
// Modelos/like_dislike.php
require_once '../config/Conexion.php';

class LikeDislike {
    private $conn;

    public function __construct() {
        $this->conn = Conexion::conectar();
    }

    /**
     * Inserta o actualiza un registro de like/dislike para un restaurante dado por el usuario.
     * 
     * @param string $correo El correo electrónico del usuario.
     * @param int $id_restaurante El ID del restaurante.
     * @param string $tipo El tipo de acción ('like' o 'dislike').
     * @return string "Success" en caso de éxito, o un mensaje de error en caso contrario.
     * @throws Exception Si ocurre un error al preparar o ejecutar la consulta.
     */
    public function insertarLikeDislike($correo, $id_restaurante, $tipo) {
        // Verificar si ya existe un registro para este usuario y restaurante
        $sql = "SELECT * FROM Likes_Dislikes WHERE Correo = ? AND ID_Restaurante = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->conn->error);
        }
        $stmt->bind_param("si", $correo, $id_restaurante);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Si ya existe, actualizar el tipo de like/dislike
            $sql = "UPDATE Likes_Dislikes SET Tipo = ?, Fecha = CURRENT_TIMESTAMP WHERE Correo = ? AND ID_Restaurante = ?";
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $this->conn->error);
            }
            $stmt->bind_param("ssi", $tipo, $correo, $id_restaurante);
        } else {
            // Si no existe, insertar un nuevo registro
            $sql = "INSERT INTO Likes_Dislikes (Correo, ID_Restaurante, Tipo) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $this->conn->error);
            }
            $stmt->bind_param("sis", $correo, $id_restaurante, $tipo);
        }

        if ($stmt->execute()) {
            return "Success";
        } else {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }
    }

    /**
     * Obtiene el conteo de likes para un restaurante específico.
     * 
     * @param int $id_restaurante El ID del restaurante.
     * @return int El número de likes.
     * @throws Exception Si ocurre un error al preparar o ejecutar la consulta.
     */
    public function obtenerConteoLikes($id_restaurante) {
        $sql = "SELECT COUNT(*) as likes FROM Likes_Dislikes WHERE ID_Restaurante = ? AND Tipo = 'like'";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->conn->error);
        }
        $stmt->bind_param("i", $id_restaurante);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return (int)$row['likes'];
    }

    /**
     * Obtiene el conteo de dislikes para un restaurante específico.
     * 
     * @param int $id_restaurante El ID del restaurante.
     * @return int El número de dislikes.
     * @throws Exception Si ocurre un error al preparar o ejecutar la consulta.
     */
    public function obtenerConteoDislikes($id_restaurante) {
        $sql = "SELECT COUNT(*) as dislikes FROM Likes_Dislikes WHERE ID_Restaurante = ? AND Tipo = 'dislike'";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->conn->error);
        }
        $stmt->bind_param("i", $id_restaurante);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return (int)$row['dislikes'];
    }

    public function __destruct() {
        $this->conn->close();
    }
}
?>
