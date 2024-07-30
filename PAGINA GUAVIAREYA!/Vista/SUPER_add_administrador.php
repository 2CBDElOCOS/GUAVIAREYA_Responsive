<!DOCTYPE html>
<html lang="en">
<head>
    <title>Agregar Administrador</title>
</head>
<body style="max-width: 400px; justify-content: center; margin: 0 auto;">
    <form id="registerForm" enctype="multipart/form-data" method="POST" action="controlador_Super_admi.php" class="card" style="margin-top: 100px;">
        <h1>Agregar Administrador</h1>

        <input type="hidden" id="ID_Restaurante" name="ID_Restaurante" value="<?php echo htmlspecialchars($_GET['ID_Restaurante']); ?>" required>

        <label for="Correo" class="label">
            <h4>Correo:</h4>
        </label>
        <input type="email" id="Correo" name="Correo" required>

        <label for="Apodo" class="label">
            <h4>Apodo:</h4>
        </label>
        <input type="text" id="Apodo" name="Apodo" required>

        <label for="Contrasena" class="label">
            <h4>Contraseña:</h4>
        </label>
        <input type="password" id="Contrasena" name="Contrasena" required>
        <p id="password-strength" style="display:none;"></p>

        <button type="submit">Agregar</button>
    </form>
    <script src="../JS/mensaje_contraseña.js"></script>
</body>
</html>
