<?php
include('../config/Conexion.php');

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
    public function editarProducto($id_producto, $nombre, $descripcion, $valor, $imagen = null) {
        // Crear conexión
        $conn = Conexion::conectar();

        // Construir la consulta SQL para actualizar los datos del producto
        $query = "UPDATE Productos SET Nombre_P = ?, Descripcion = ?, Valor_P = ?";
        $types = "ssd"; // Tipos de datos para la consulta: s = string, d = double
        $params = [$nombre, $descripcion, $valor];

        // Si hay una nueva imagen, agregarla a la consulta
        if ($imagen !== null) {
            $query .= ", img_P = ?";
            $types .= "s"; // Agregar tipo string para la imagen
            $params[] = $imagen;
        }

        // Completar la consulta con la cláusula WHERE
        $query .= " WHERE ID_Producto = ?";
        $types .= "i"; // Agregar tipo integer para el ID del producto
        $params[] = $id_producto;

        // Preparar la consulta
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            throw new Exception("Error en la preparación de la consulta: " . $conn->error);
        }

        // Vincular los parámetros a la consulta preparada
        $stmt->bind_param($types, ...$params);

        // Ejecutar la consulta
        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }

        // Cerrar la consulta y la conexión
        $stmt->close();
        $conn->close();
    }
}
?>
