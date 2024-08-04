<?php
include '../config/Conexion.php';

/**
 * Clase para manejar la eliminación de productos
 */
class delete_productos {
    /**
     * Método estático para borrar productos
     *
     * Este método verifica si se ha enviado el ID del producto a borrar, obtiene la información del producto
     * incluyendo la imagen, la elimina del servidor si existe, y luego borra el producto de la base de datos.
     * Finalmente, redirige a otra página después de borrar el producto.
     *
     * @return void
     */
    static function delete_productos() {
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
