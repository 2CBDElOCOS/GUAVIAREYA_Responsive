<?php
include('Conexion.php');

class editar_producto {

    public function editarProducto($id_producto) {
        $conn = Conexion();

        // Aquí deberías obtener los nuevos datos del formulario
        // Por ejemplo, para actualizar el nombre del producto:
        if (isset($_POST['nombre_producto'])) {
            $nuevo_nombre = $_POST['nombre_producto'];
            $query = "UPDATE Productos SET Nombre_p = '$nuevo_nombre' WHERE ID_productos = '$id_producto';";
            $conn->query($query);
        }

        // Puedes agregar más campos para actualizar según tus necesidades

        $conn->close();
    }
}
?>
