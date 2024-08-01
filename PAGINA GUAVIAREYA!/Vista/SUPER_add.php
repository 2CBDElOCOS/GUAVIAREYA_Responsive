<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Restaurante - Administrador</title>
</head>
<body>
    <form id="productForm" enctype="multipart/form-data" method="POST" action="controlador_Super.php" class="card">
        <h1>Agregar Restaurante</h1>

        <div class="mb-3">
            <label for="Nombre_R" class="form-label">
                <h4>Nombre del Restaurante:</h4>
            </label>
            <input type="text" id="Nombre_R" name="Nombre_R" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="Direccion" class="form-label">
                <h4>Dirección:</h4>
            </label>
            <input type="text" id="Direccion" name="Direccion" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="Telefono" class="form-label">
                <h4>Teléfono:</h4>
            </label>
            <input type="text" id="Telefono" name="Telefono" class="form-control" inputmode="numeric" required>
        </div>

        <div class="mb-3">
            <label for="img_R" class="form-label">
                <h4>Imagen del Restaurante:</h4>
            </label>
            <input type="file" id="img_R" name="img_R" class="form-control-file" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-primary">Agregar</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-rbsA0UkP0NQUp+nOtEPO6r/Y4X9kJ8i1PQ/3CIMxtmZR3eK/jHcFCE3P9AXMyjb" crossorigin="anonymous"></script>
</body>
</html>
