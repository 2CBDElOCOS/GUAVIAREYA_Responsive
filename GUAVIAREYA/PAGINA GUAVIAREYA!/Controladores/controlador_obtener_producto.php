<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    include_once('../Modelos/mostrar_productos.php');

    $id_producto = $_GET['id'];
    $mostrarProductos = new mostrar_productos();
    $producto = $mostrarProductos->obtenerProductoPorId($id_producto);

    echo json_encode($producto);
} else {
    echo json_encode(['error' => 'No se ha recibido un ID de producto válido.']);
}
?>
