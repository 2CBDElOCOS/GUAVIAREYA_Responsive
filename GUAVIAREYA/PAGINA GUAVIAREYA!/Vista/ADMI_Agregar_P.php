<!DOCTYPE html>
<html lang="en">
<head>
    <title>Agregar Producto</title>
</head>
<body style="max-width: 400px; justify-content: center; margin: 0 auto;">

    <form id="productForm" enctype="multipart/form-data" method="POST" class="card" style="margin-top: 100px;" >
        <h1>Agregar Producto</h1>
        <label for="id_producto" class="label"><h4>ID_Producto</h4></label>
        <input type="text" id="id_producto" name="id_producto">

        <label for="id_producto" class="label"><h4>ID_Restaurante</h4></label>
        <input type="text" id="id_producto" name="id_producto">

        <label for="nombre" class="label"><h4>Nombre del Producto:</h4></label>
        <input type="text" id="nombre" name="nombre">

        <label for="descripcion" class="label"><h4>Descripción:</h4></label>
        <textarea id="descripcion" name="descripcion" rows="4"></textarea>

        <label for="precio" class="label"><h4>Valor:</h4></label>
        <input type="text" id="precio" name="precio" inputmode="numeric">

        <label for="imagen" class="label"><h4>Imagen del Producto:</h4></label>
        <input type="file" id="imagen" name="img" accept="image/*">

        <button><a href="controlador.php?seccion=ADMI_Productos_A" style="color: white;">Agregar</a></button>
    </form>
</body>
</html>
