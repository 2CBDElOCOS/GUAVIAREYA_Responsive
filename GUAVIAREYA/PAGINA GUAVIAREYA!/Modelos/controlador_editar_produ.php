<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ID_Producto'])) {
    include_once('../Modelos/editar_producto.php');

    $id_producto = $_POST['ID_Producto'];
    $nombre = $_POST['Nombre_P'];
    $descripcion = $_POST['descripcion'];
    $valor = $_POST['Valor_P'];
    $imagen = isset($_FILES['img_P']['name']) && !empty($_FILES['img_P']['name']) ? $_FILES['img_P']['name'] : null;

    if ($imagen) {
        // Mover la imagen cargada al directorio de destino
        $destino = '../media_productos/' . basename($imagen);
        if (!move_uploaded_file($_FILES['img_P']['tmp_name'], $destino)) {
            die("Error al cargar la imagen.");
        }
    }

    // Llama a la función para editar el producto en el modelo
    $editarProducto = new editar_producto();
    $editarProducto->editarProducto($id_producto, $nombre, $descripcion, $valor, $imagen);

    // Redirecciona a la página de administración de productos u otra página relevante
    header("Location: controlador.php?seccion=ADMI_Productos_A");
    exit(); // Asegura que el script se detenga después de la redirección
} else {
    // Manejar el caso si no se reciben datos válidos
    echo "Error: Datos de producto no recibidos correctamente.";
}
?>
