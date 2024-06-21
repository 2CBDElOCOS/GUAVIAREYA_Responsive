<?php
include 'Conexion.php';

class delete_productos {
    static function delete_productos() {
        // Verificar si se ha enviado el ID del producto a borrar
        if (isset($_POST['ID_Producto'])) {
            // Obtener el ID del producto a borrar
            $id_producto = $_POST['ID_Producto'];

            // Crear conexión usando la función Conexion
            $conn = Conexion();

            // Preparar la consulta SQL para borrar el producto de la tabla Productos
            $sql = "DELETE FROM Productos WHERE ID_Producto = ?";

            // Preparar la declaración
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_producto);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Redirigir a otra página después de borrar el producto
                $conn->close();
                header("location: ../Vista/ADMI_Productos_A.php");
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
