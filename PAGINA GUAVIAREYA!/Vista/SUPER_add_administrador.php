<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
        }
        .card {
            max-width: 500px;
            width: 100%;
            padding: 1.5rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .card h1 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        .card h4 {
            margin-bottom: .5rem;
        }
        .form-control {
            margin-bottom: 1rem;
        }
        .btn-primary {
            width: 100%;
        }
    </style>
</head>
<body>
    <form id="registerForm" enctype="multipart/form-data" method="POST" action="controlador_Super_admi.php" class="card">
        <h1>Agregar Administrador</h1>

        <input type="hidden" id="ID_Restaurante" name="ID_Restaurante" value="<?php echo htmlspecialchars($_GET['ID_Restaurante']); ?>" required>

        <div class="mb-3">
            <label for="Correo" class="form-label">
                <h4>Correo:</h4>
            </label>
            <input type="email" id="Correo" name="Correo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="Apodo" class="form-label">
                <h4>Apodo:</h4>
            </label>
            <input type="text" id="Apodo" name="Apodo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="Contrasena" class="form-label">
                <h4>Contraseña:</h4>
            </label>
            <input type="password" id="Contrasena" name="Contrasena" class="form-control" required>
            <p id="password-strength" style="display:none;"></p>
        </div>

        <button type="submit" class="btn btn-primary">Agregar</button>
    </form>
    
    <script src="../JS/mensaje_contraseña.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-rbsA0UkP0NQUp+nOtEPO6r/Y4X9kJ8i1PQ/3CIMxtmZR3eK/jHcFCE3P9AXMyjb" crossorigin="anonymous"></script>
</body>
</html>
