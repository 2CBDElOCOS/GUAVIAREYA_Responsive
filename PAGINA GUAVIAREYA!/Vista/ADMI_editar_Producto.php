

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Editar Producto</title>
</head>

<body style="max-width: 400px; justify-content: center; margin: 0 auto;">
    <form id="productForm" enctype="multipart/form-data" method="POST" action="../Controladores/controlador_editar_produ.php" class="card" style="margin-top: 100px;">
        <h1 id="form-title">Agregar Producto</h1>

        <input type="hidden" id="ID_Producto" name="ID_Producto">

        <label for="Nombre_P" class="label">
            <h4>Nombre del Producto:</h4>
        </label>
        <input type="text" id="Nombre_P" name="Nombre_P">

        <label for="descripcion" class="label">
            <h4>Descripción:</h4>
        </label>
        <textarea id="descripcion" name="descripcion" rows="4"></textarea>

        <label for="Valor_P" class="label">
            <h4>Valor:</h4>
        </label>
        <input type="text" id="Valor_P" name="Valor_P" inputmode="numeric">

        <label for="img_P" class="label">
            <h4>Imagen del Producto:</h4>
        </label>
        <input type="file" id="img_P" name="img_P" accept="image/*">

        <button type="submit" id="form-button">Confirmar Cambios</button>
    </form>

    <script src="../JS/editar_producto.js"></script>
</body>

</html>
