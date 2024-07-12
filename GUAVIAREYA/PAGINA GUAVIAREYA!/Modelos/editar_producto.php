<?php
include('Conexion.php');

/**
 * Clase editar_producto
 * 
 * Esta clase maneja la edición de productos en la base de datos.
 */
class editar_producto {

    /**
     * Método para editar un producto en la base de datos.
     *
     * @param int $id_producto ID del producto a editar.
     * @param string $nombre Nuevo nombre del producto.
     * @param string $descripcion Nueva descripción del producto.
     * @param float $valor Nuevo valor del producto.
     * @param string|null $imagen Nueva imagen del producto, o null si no se cambia la imagen.
     * @return void
     * @throws Exception Si hay un error en la preparación de la consulta SQL.
     */
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
            throw new Exception("Error en la preparación de la consulta: " . $conn->error);
        }

        // Vincular los parámetros a la consulta preparada
        $stmt->bind_param($types, ...$params);

        // Ejecutar la consulta
        $stmt->execute();

        // Cerrar la consulta y la conexión
        $stmt->close();
        $conn->close();
    }
}
?>
