<?php
class delete_productos {
    static function delete_productos() {
        $servername = "127.0.0.1";
        $username = "root";   
        $password = "";
        $dbname = "bd_guaviareya";
        
        // Verificar si se ha enviado el ID del producto a borrar
        if (isset($_POST['ID_Producto'])) {
            // Obtener el ID del producto a borrar
            $id_producto = $_POST['ID_Producto'];

            // Crear conexión
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verificar conexión
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }
            
            // Obtener el nombre del archivo de imagen del producto
            $sql = "SELECT img_P FROM Productos WHERE ID_Producto = '$id_producto'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $img_P = $row['img_P'];
            
            // Borrar el archivo de imagen
            $ruta_img = "../media_productos/" . $img_P;
            if (file_exists($ruta_img)) {
                unlink($ruta_img);
            }

            // Preparar la consulta SQL para borrar el producto de la tabla Productos
            $sql = "DELETE FROM Productos WHERE ID_Producto = '$id_producto'";

            // Ejecutar la consulta
            if ($conn->query($sql) === TRUE) {
                // Redirigir a otra página después de borrar el producto
                $conn->close();
                header("location: controlador.php?seccion=ADMI_Productos_A");
                exit(); // Salir del script después de redirigir
            } else {
                echo "Error al borrar el producto: " . $conn->error;
            }

            // Cerrar la conexión
            $conn->close();
        } else {
            echo "No se recibió el ID del producto a borrar";
        }
    }
}
?>
