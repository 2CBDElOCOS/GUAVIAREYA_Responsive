
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
</head>

<body class="bg-light d-flex justify-content-center align-items-center min-vh-100">
    <div class="card" style="width: 350px; max-width: 500px; padding: 20px;">
        <h1 class="card-title mb-4">Agregar Producto</h1>

        <form id="productForm" enctype="multipart/form-data" method="POST" action="controlador_productos.php">
            <div class="mb-3">
                <label for="Nombre_P" class="form-label">Nombre del Producto:</label>
                <input type="text" id="Nombre_P" name="Nombre_P" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="4" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label for="Valor_P" class="form-label">Valor:</label>
                <input type="text" id="Valor_P" name="Valor_P" class="form-control" inputmode="numeric" required>
            </div>

            <div class="mb-3">
                <label for="img_P" class="form-label">Imagen del Producto:</label>
                <input type="file" id="img_P" name="img_P" class="form-control" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Agregar</button>
        </form>
    </div>


</body>

</html>
