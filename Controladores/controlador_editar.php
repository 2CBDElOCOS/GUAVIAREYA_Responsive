<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ID_Producto'])) {
    include_once('../Modelos/editar_producto.php');

    $id_producto = $_POST['ID_Producto'];

    // Llama a la función para editar el producto en el modelo
    $editarProducto = new editar_producto();
    $editarProducto->editarProducto($id_producto, $nombre, $descripcion, $valor, $imagen);

    // Redirecciona a la página de administración de productos u otra página relevante
    header("Location: controlador.php?seccion=ADMI_Shop_A");
    exit(); // Asegura que el script se detenga después de la redirección
} else {
    // Manejar el caso si no se reciben datos válidos
    echo "Error: Datos de producto no recibidos correctamente.";
}
?>
