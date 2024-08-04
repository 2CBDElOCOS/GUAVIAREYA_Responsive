<?php
// Modelos/like_dislike.php
require_once 'Conexion.php';

class LikeDislike {
    private $conn;

    public function __construct() {
        $this->conn = Conexion();
    }

    public function insertarLikeDislike($correo, $id_restaurante, $tipo) {
        // Verificar si ya existe un registro de like o dislike para este usuario y restaurante
        $sql = "SELECT * FROM Likes_Dislikes WHERE Correo = ? AND ID_Restaurante = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $correo, $id_restaurante);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Si ya existe, actualizar el tipo de like/dislike
            $sql = "UPDATE Likes_Dislikes SET Tipo = ?, Fecha = CURRENT_TIMESTAMP WHERE Correo = ? AND ID_Restaurante = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssi", $tipo, $correo, $id_restaurante);
        } else {
            // Si no existe, insertar un nuevo registro
            $sql = "INSERT INTO Likes_Dislikes (Correo, ID_Restaurante, Tipo) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sis", $correo, $id_restaurante, $tipo);
        }

        if ($stmt->execute()) {
            return "Success";
        } else {
            return "Error: " . $stmt->error;
        }
    }

    public function obtenerConteoLikes($id_restaurante) {
        $sql = "SELECT COUNT(*) as likes FROM Likes_Dislikes WHERE ID_Restaurante = ? AND Tipo = 'like'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_restaurante);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['likes'];
    }

    public function obtenerConteoDislikes($id_restaurante) {
        $sql = "SELECT COUNT(*) as dislikes FROM Likes_Dislikes WHERE ID_Restaurante = ? AND Tipo = 'dislike'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_restaurante);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['dislikes'];
    }

    public function __destruct() {
        $this->conn->close();
    }
}
?>
