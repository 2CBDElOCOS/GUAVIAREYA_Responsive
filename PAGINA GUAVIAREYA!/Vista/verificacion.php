<!DOCTYPE html>
<html lang="en">

<head>
    <title>Verificación</title>
</head>

<body class="bg-light d-flex justify-content-center align-items-center min-vh-100">
    <div class="card" style="width: 350px; max-width: 500px; padding: 20px;">
        <h1 class="card-title mb-4">Agregar Foto Del Documento</h1>

        <form id="productForm" enctype="multipart/form-data" method="POST" action="../Controladores/controlador_verificar.php">
            <div class="mb-3">
                <label for="correo" class="form-label">Correo:</label>
                <input type="email" id="correo" name="correo" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label for="tipo_documento" class="form-label">Tipo de Documento:</label>
                <select id="tipo_documento" name="tipo_documento" class="form-control" required>
                    <option value="DNI">DNI</option>
                    <option value="Pasaporte">Pasaporte</option>
                    <option value="Licencia">Licencia</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="img_P" class="form-label">Imagen del Documento:</label>
                <input type="file" id="img_P" name="img_P" class="form-control" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Agregar</button>
        </form>
    </div>
</body>

</html>
