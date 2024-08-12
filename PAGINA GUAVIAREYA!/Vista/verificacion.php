<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación</title>
</head>

<body class="bg-light d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-sm" style="width: 100%; max-width: 500px; padding: 20px;">
        <h1 class="card-title mb-4 text-center">Agregar Foto Del Documento</h1>

        <form id="productForm" enctype="multipart/form-data" method="POST" action="../Controladores/controlador_verificar.php">
            <div class="mb-3">
                <label for="correo" class="form-label">Correo:</label>
                <input type="email" id="correo" name="correo" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label for="tipo_documento" class="form-label">Tipo de Documento:</label>
                <select id="tipo_documento" name="tipo_documento" class="form-select" required>
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

            <!-- Mensaje de error -->
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary w-100">Agregar</button>
        </form>
    </div>
</body>

</html>
