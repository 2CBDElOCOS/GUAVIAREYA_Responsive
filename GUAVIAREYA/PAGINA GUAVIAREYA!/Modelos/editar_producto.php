<?php
include('Conexion.php');

class editar_producto {

    public function editarProducto($id_producto, $nombre, $descripcion, $valor, $imagen) {
        $conn = Conexion();

        // Actualizar los datos del producto
        $query = "UPDATE Productos SET Nombre_P = ?, Descripcion = ?, Valor_P = ?";
        $types = "ssd";
        $params = [$nombre, $descripcion, $valor];

        // Si hay una nueva imagen, agregarla a la consulta
        if ($imagen !== null) {
            $query .= ", img_P = ?";
            $types .= "s";
            $params[] = $imagen;
        }

        $query .= " WHERE ID_Producto = ?";
        $types .= "i";
        $params[] = $id_producto;

        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $conn->error);
        }

        $stmt->bind_param($types, ...$params);
        $stmt->execute();

        $stmt->close();
        $conn->close();
    }
}
?>
