<?php
require_once 'conexion.php';

class DataSuperAdmi {

    public static function obteneremail($email)
    {
        $conn = Conexion();
        $user = null;

        $stmt = $conn->prepare("
            SELECT 
                apodo AS Apodo,
                contrasena AS contrasena,  
                correo AS Correo
            FROM administradores 
            WHERE correo = ? AND rol = 'super_administrador'
        ");

        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . $conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
        }

        $stmt->close();
        $conn->close();

        return $user;
    }

    public static function updatePassword($email, $newPassword)
    {
        $conn = Conexion();

        $stmt = $conn->prepare("UPDATE administradores SET contrasena = ? WHERE correo = ? AND rol = 'super_administrador'");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . $conn->error);
        }

        $stmt->bind_param("ss", $newPassword, $email);
        $success = $stmt->execute();

        $stmt->close();
        $conn->close();

        return $success;
    }

    static function borrar_restaurante() {
        // Verificar si se ha enviado el ID del restaurante a borrar
        if (isset($_POST['ID_Restaurante'])) {
            // Obtener el ID del restaurante a borrar
            $id_restaurante = $_POST['ID_Restaurante'];

            // Crear conexión
            $conn = Conexion();

            // Verificar conexión
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Obtener el nombre del archivo de imagen del restaurante
            $sql = $conn->prepare("SELECT img_R FROM Restaurantes WHERE ID_Restaurante = ?");
            if ($sql === false) {
                die("Error preparando la consulta: " . $conn->error);
            }

            $sql->bind_param("i", $id_restaurante);
            $sql->execute();
            $result = $sql->get_result();
            $row = $result->fetch_assoc();
            $img_R = $row['img_R'];

            // Borrar el archivo de imagen
            $image_path = "../media_restaurantes/" . $img_R;
            if (file_exists($image_path)) {
                unlink($image_path);
            }

            // Borrar relaciones y luego el restaurante
            $conn->begin_transaction();

            try {
                // Borrar productos del restaurante
                $sql = $conn->prepare("DELETE FROM Productos WHERE ID_Restaurante = ?");
                $sql->bind_param("i", $id_restaurante);
                $sql->execute();

                // Borrar administradores del restaurante
                $sql = $conn->prepare("DELETE FROM administradores WHERE ID_Restaurante = ?");
                $sql->bind_param("i", $id_restaurante);
                $sql->execute();

                // Borrar el restaurante
                $sql = $conn->prepare("DELETE FROM Restaurantes WHERE ID_Restaurante = ?");
                $sql->bind_param("i", $id_restaurante);
                $sql->execute();

                // Confirmar transacción
                $conn->commit();

                header("location: controlador.php?seccion=SuperAdmin_Panel");
                exit(); // Salir del script después de redirigir

            } catch (Exception $e) {
                // Revertir transacción en caso de error
                $conn->rollback();
                echo "Error al borrar el restaurante: " . $e->getMessage();
            }

            // Cerrar la conexión
            $conn->close();
        } else {
            echo "No se recibió el ID del restaurante a borrar";
        }
    }
}
?>