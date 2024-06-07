<!DOCTYPE html>
<html lang="en">
<head>

    <title>Agregar Bebida</title>
</head>
<body style="max-width: 400px; justify-content: center; margin: 0 auto;">
    

    <form id="productForm" enctype="multipart/form-data" method="POST" class="card" style="margin-top: 100px;">
        <h1>Agregar bebida</h1>
        <label for="nombre" class="label"><h4>Nombre de la Producto:</h4></label>
        <input type="text" id="nombre" name="nombre">

        <label for="descripcion" class="label"><h4>Descripción:</h4></label>
        <textarea id="descripcion" name="descripcion" rows="4"></textarea>

        <label for="precio" class="label"><h4>Precio:</h4></label>
        <input type="text" id="precio" name="precio" inputmode="numeric">

        <label for="imagen" class="label"><h4>Imagen de la bebida:</h4></label>
        <input type="file" id="imagen" name="img" accept="image/*">

        <button><a href="?seccion=ADMI_Bebidas_A" style="color: white;">Agregar</a></button>
    </form>
</body>
</html>
