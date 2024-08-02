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
        // Verificar si se ha enviado el ID del producto a borrar
        if (isset($_POST['ID_Producto'])) {
            // Obtener el ID del producto a borrar
            $id_producto = $_POST['ID_Producto'];

            // Crear conexión
            $conn = Conexion();

            // Verificar conexión
            if ($conn->connect_error) {
                // Terminar la ejecución y mostrar un mensaje de error si la conexión falló
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Obtener el nombre del archivo de imagen del producto
            $sql = $conn->prepare("SELECT img_P FROM Productos WHERE ID_Producto = ?");
            if ($sql === false) {
                // Terminar la ejecución y mostrar un mensaje de error si hay un error preparando la consulta
                die("Error preparando la consulta: " . $conn->error);
            }

            // Vincular el parámetro $id_producto a la consulta preparada
            $sql->bind_param("i", $id_producto);
            $sql->execute();
            $result = $sql->get_result();
            $row = $result->fetch_assoc();
            $img_P = $row['img_P'];

            // Borrar el archivo de imagen
            $image_path = "../media_productos/" . $img_P;
            if (file_exists($image_path)) {
                // Eliminar el archivo de imagen si existe
                unlink($image_path);
            }

            // Preparar la consulta SQL para borrar el producto de la tabla Productos
            $sql = $conn->prepare("DELETE FROM Productos WHERE ID_Producto = ?");
            if ($sql === false) {
                // Terminar la ejecución y mostrar un mensaje de error si hay un error preparando la consulta
                die("Error preparando la consulta: " . $conn->error);
            }

            // Vincular el parámetro $id_producto a la consulta preparada
            $sql->bind_param("i", $id_producto);

            // Ejecutar la consulta
            if ($sql->execute()) {
                // Redirigir a otra página después de borrar el producto
                $conn->close();
                header("location: controlador.php?seccion=ADMI_Productos_A");
                exit(); // Salir del script después de redirigir
            } else {
                // Mostrar un mensaje de error si no se pudo borrar el producto
                echo "Error al borrar el producto: " . $conn->error;
            }

            // Cerrar la conexión
            $conn->close();
        } else {
            // Mostrar un mensaje si no se recibió el ID del producto a borrar
            echo "No se recibió el ID del producto a borrar";
        }
    }
}
?>
