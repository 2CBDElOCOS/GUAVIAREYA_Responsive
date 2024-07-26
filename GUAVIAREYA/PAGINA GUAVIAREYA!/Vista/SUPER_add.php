<!DOCTYPE html>
<html lang="en">
<head>
    <title>Agregar Restaurante-Administrador</title>
</head>
<body style="max-width: 400px; justify-content: center; margin: 0 auto;">
    <form id="productForm" enctype="multipart/form-data" method="POST" action="controlador_Super.php" class="card" style="margin-top: 100px;">
        <h1>Agregar Restaurante</h1>

        <label for="Nombre_R" class="label">
            <h4>Nombre del Restaurante:</h4>
        </label>
        <input type="text" id="Nombre_R" name="Nombre_R" required>

        <label for="Direccion" class="label">
            <h4>Direccion:</h4>
        </label>
        <input  type="text" id="Direccion" name="Direccion"  required>

        <label for="Telefono" class="label">
            <h4>Telefono:</h4>
        </label>
        <input type="text" id="Telefono" name="Telefono" inputmode="numeric" required>

        <label for="img_R" class="label">
            <h4>Imagen del Restaurante:</h4>
        </label>
        <input type="file" id="img_R" name="img_R" accept="image/*" required>

        <button type="submit">Agregar</button>
    </form>
</body>
</html>
