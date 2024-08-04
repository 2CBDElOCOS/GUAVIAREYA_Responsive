<?php
include 'Modelos/Conexion.php';

// Verifica si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $servername = $_POST['server'];
    $username = $_POST['username'];
    $password = isset($_POST['password']) ? $_POST['password'] : ''; // Contraseña opcional
    $dbname = $_POST['database'];

    // Conectar a la base de datos usando la función Conexion
    $conn = Conexion($servername, $username, $password, '');

    // Crear la base de datos si no existe
    $sql = "CREATE DATABASE IF NOT EXISTS `$dbname`";
    if ($conn->query($sql) === TRUE) {
        echo "Base de datos creada o ya existe.<br>";
    } else {
        die("Error creando base de datos: " . $conn->error);
    }

    // Cerrar la conexión actual y reabrir con la base de datos seleccionada
    $conn->close();
    $conn = Conexion($servername, $username, $password, $dbname);

    // Crear las tablas y estructuras
    $queries = [
        "CREATE TABLE Usuarios (
            Correo VARCHAR(50) NOT NULL PRIMARY KEY,
            Apodo VARCHAR(50) NOT NULL,
            Nombre VARCHAR(50) NOT NULL,
            Apellido VARCHAR(50) NOT NULL,
            Contrasena VARCHAR(255) NOT NULL,
            Telefono VARCHAR(15) NOT NULL,
            Fec_Regis TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
            img_U VARCHAR(200) NOT NULL
        );",

        "CREATE TABLE Restaurantes (
            ID_Restaurante INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            Nombre_R VARCHAR(50) NOT NULL UNIQUE,
            Direccion VARCHAR(50) NOT NULL,
            Telefono VARCHAR(15) NOT NULL,
            img_R VARCHAR(200) NOT NULL,
            fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            Estado VARCHAR(15) NOT NULL
        );",

        "CREATE TABLE Administradores (
            id INT AUTO_INCREMENT PRIMARY KEY,
            correo VARCHAR(50) NOT NULL UNIQUE,
            apodo VARCHAR(50) NOT NULL,
            ID_Restaurante INT NULL,
            contrasena VARCHAR(255) NOT NULL,
            rol ENUM('administrador', 'super_administrador') NOT NULL,
            fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            img_A VARCHAR(200) NULL,
            CONSTRAINT FK_Restaurantes_Administradores FOREIGN KEY (ID_Restaurante) REFERENCES Restaurantes (ID_Restaurante)
        );",

        "CREATE TABLE Productos (
            ID_Producto INT AUTO_INCREMENT PRIMARY KEY,
            ID_Restaurante INT NOT NULL,
            Nombre_P VARCHAR(50) NOT NULL,
            Descripcion VARCHAR(300) NOT NULL,
            Valor_P INT NOT NULL,
            img_P VARCHAR(200) NOT NULL,
            fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            CONSTRAINT FK_Restaurantes_Productos FOREIGN KEY (ID_Restaurante) REFERENCES Restaurantes (ID_Restaurante)
        );",

        "CREATE INDEX idx_ID_Restaurante ON Productos (ID_Restaurante);",

        "CREATE TABLE Direccion_Entregas (
            ID_Dire_Entre INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            Correo VARCHAR(50) NOT NULL,
            Direccion VARCHAR(100) NOT NULL,
            Barrio VARCHAR(50) NOT NULL,
            fecha_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            Descripcion VARCHAR(50) NOT NULL,
            fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            CONSTRAINT FK_Usuarios_Direccion_Entregas FOREIGN KEY (Correo) REFERENCES Usuarios (Correo)
        );",

        "CREATE INDEX idx_Correo ON Direccion_Entregas (Correo);",

        "CREATE TABLE metodos_pago (
            id_pago INT AUTO_INCREMENT PRIMARY KEY,
            numero VARCHAR(16) NOT NULL,
            nombre VARCHAR(50) NOT NULL,
            apellido VARCHAR(50) NOT NULL,
            expiracion VARCHAR(4) NOT NULL,
            cvv VARCHAR(3) NOT NULL,
            correo VARCHAR(50) NOT NULL,
            fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            CONSTRAINT fk_usuarios_metodos_pago FOREIGN KEY (correo) REFERENCES Usuarios (Correo)
        );",

        "CREATE INDEX idx_correo_metodos_pago ON metodos_pago (correo);",

        "CREATE TABLE Pedidos (
            ID_pedido INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            ID_Restaurante INT NOT NULL,
            ID_Producto INT NOT NULL,
            cantidad INT NOT NULL,
            Sub_total DOUBLE NOT NULL,
            ID_Dire_Entre INT NOT NULL,
            Correo VARCHAR(50) NOT NULL,
            fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            Estado ENUM('Pendiente', 'Enviado', 'Entregado', 'Cancelado') NOT NULL DEFAULT 'Pendiente',
            CONSTRAINT FK_Productos_Pedidos FOREIGN KEY (ID_Producto) REFERENCES Productos (ID_Producto),
            CONSTRAINT FK_Restaurantes_Pedidos FOREIGN KEY (ID_Restaurante) REFERENCES Restaurantes (ID_Restaurante),
            CONSTRAINT FK_Direccion_Entregas_Pedidos FOREIGN KEY (ID_Dire_Entre) REFERENCES Direccion_Entregas (ID_Dire_Entre),
            CONSTRAINT FK_Usuarios_Pedidos FOREIGN KEY (Correo) REFERENCES Usuarios (Correo)
        );",

        "CREATE INDEX idx_ID_Restaurante_Pedidos ON Pedidos (ID_Restaurante);",
        "CREATE INDEX idx_ID_Producto_Pedidos ON Pedidos (ID_Producto);",
        "CREATE INDEX idx_Correo_Pedidos ON Pedidos (Correo);",

        "CREATE TABLE Pedidos_factura (
            ID_Pedifac INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            ID_pedido INT NOT NULL,
            Correo VARCHAR(50) NOT NULL,
            ID_Restaurante INT NOT NULL,
            ID_Producto INT NOT NULL,
            ID_Dire_Entre INT NOT NULL,
            id_pago INT NOT NULL,
            Estado_Pedido VARCHAR(50) NOT NULL,
            Subtotal INT NOT NULL,
            Valor_Domi INT NOT NULL DEFAULT 5000,
            Valor_Pagar INT NOT NULL,
            CONSTRAINT FK_Pedidos_Pedidos_factura FOREIGN KEY (ID_pedido) REFERENCES Pedidos (ID_pedido),
            CONSTRAINT FK_Usuarios_Pedidos_factura FOREIGN KEY (Correo) REFERENCES Usuarios (Correo),
            CONSTRAINT FK_Direccion_Entregas_Pedidos_factura FOREIGN KEY (ID_Dire_Entre) REFERENCES Direccion_Entregas (ID_Dire_Entre),
            CONSTRAINT FK_Productos_Pedidos_factura FOREIGN KEY (ID_Producto) REFERENCES Productos (ID_Producto),
            CONSTRAINT FK_Restaurantes_Pedidos_factura FOREIGN KEY (ID_Restaurante) REFERENCES Restaurantes (ID_Restaurante),
            CONSTRAINT FK_Pagos_Pedidos_factura FOREIGN KEY (id_pago) REFERENCES metodos_pago (id_pago)
        );",

        "CREATE INDEX idx_Correo_Pedidos_factura ON Pedidos_factura (Correo);",
        "CREATE INDEX idx_ID_Restaurante_Pedidos_factura ON Pedidos_factura (ID_Restaurante);",
        "CREATE INDEX idx_ID_Producto_Pedidos_factura ON Pedidos_factura (ID_Producto);",
        "CREATE INDEX idx_ID_Dire_Entre_Pedidos_factura ON Pedidos_factura (ID_Dire_Entre);",
        "CREATE INDEX idx_id_pago_Pedidos_factura ON Pedidos_factura (id_pago);",

        "CREATE TABLE Cupones (
            ID_Cupon INT AUTO_INCREMENT PRIMARY KEY,
            Correo VARCHAR(50) NOT NULL,
            Codigo_Cupon VARCHAR(20) NOT NULL UNIQUE,
            Descuento INT NOT NULL,
            Fecha_Expiracion DATE NOT NULL,
            Fecha_Usado TIMESTAMP NULL DEFAULT NULL,
            Fecha_Creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            CONSTRAINT FK_Usuarios_Cupones FOREIGN KEY (Correo) REFERENCES Usuarios (Correo)
        );",

        "CREATE INDEX idx_Correo_Cupones ON Cupones (Correo);",

        "CREATE TRIGGER after_usuario_insert
        AFTER INSERT ON Usuarios
        FOR EACH ROW
        BEGIN
            DECLARE cupon_codigo VARCHAR(20);
            DECLARE cupon_descuento INT;
            DECLARE cupon_expiracion DATE;

            -- Generar un código de cupón único
            SET cupon_codigo = CONCAT('CUPON', NEW.Correo, UNIX_TIMESTAMP());
            -- Establecer el descuento y la fecha de expiración
            SET cupon_descuento = 10; -- Descuento del 10%
            SET cupon_expiracion = DATE_ADD(CURRENT_DATE, INTERVAL 30 DAY); -- 30 días de validez

            -- Insertar el nuevo cupón en la tabla Cupones
            INSERT INTO Cupones (Correo, Codigo_Cupon, Descuento, Fecha_Expiracion)
            VALUES (NEW.Correo, cupon_codigo, cupon_descuento, cupon_expiracion);
        END;",

        "CREATE PROCEDURE insertar_administrador(
            IN p_correo VARCHAR(50),
            IN p_apodo VARCHAR(50),
            IN p_contrasena VARCHAR(255),
            IN p_rol ENUM('administrador', 'super_administrador'),
            IN p_ID_Restaurante INT,
            IN p_img_A VARCHAR(200)
        )
        BEGIN
            INSERT INTO Administradores (correo, apodo, ID_Restaurante, contrasena, rol, img_A)
            VALUES (p_correo, p_apodo, p_ID_Restaurante, MD5(p_contrasena), p_rol, p_img_A);
        END;",

        "CREATE FUNCTION calcular_total_pedido(p_id_pedido INT) RETURNS DOUBLE
        BEGIN
            DECLARE total DOUBLE;

            SELECT SUM(cantidad * Valor_P) INTO total
            FROM Pedidos p
            JOIN Productos pr ON p.ID_Producto = pr.ID_Producto
            WHERE p.ID_pedido = p_id_pedido;

            RETURN total;
        END;",
        "CREATE TABLE Documentos_Identificacion (
            ID_Documento INT AUTO_INCREMENT PRIMARY KEY,
            Correo VARCHAR(50) NOT NULL,
            Tipo_Documento ENUM('DNI', 'Pasaporte', 'Licencia', 'Otro') NOT NULL,
            Foto_Documento VARCHAR(255) NOT NULL,
            Fecha_Subida TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            CONSTRAINT FK_Usuarios_Documentos_Identificacion FOREIGN KEY (Correo) REFERENCES Usuarios (Correo)
        );",

        
        "CREATE TABLE Likes_Dislikes (
            ID INT AUTO_INCREMENT PRIMARY KEY,
            Correo VARCHAR(50) NOT NULL,
            ID_Restaurante INT NOT NULL,
            Tipo ENUM('like', 'dislike') NOT NULL,
            Fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            CONSTRAINT FK_Usuarios_Likes_Dislikes FOREIGN KEY (Correo) REFERENCES Usuarios (Correo),
            CONSTRAINT FK_Restaurantes_Likes_Dislikes FOREIGN KEY (ID_Restaurante) REFERENCES Restaurantes (ID_Restaurante),
            UNIQUE (Correo, ID_Restaurante, Tipo)  -- Asegura que un usuario no pueda hacer multiple likes/dislikes en el mismo restaurante
        );",
        
        
        "CREATE INDEX idx_Correo_Documentos_Identificacion ON Documentos_Identificacion (Correo);",
    ];

    foreach ($queries as $query) {
        if ($conn->multi_query($query)) {
            do {
                if ($result = $conn->store_result()) {
                    $result->free();
                }
            } while ($conn->more_results() && $conn->next_result());
            echo "Consulta ejecutada correctamente.<br>";
        } else {
            die("Error en la consulta: " . $conn->error);
        }
    }

    // Llamar al procedimiento almacenado para insertar un administrador
    $callProcedure = "CALL insertar_administrador(
        'guaviareya@gmail.com',
        'GuaviareYa',
        '12345678Aa@',
        'super_administrador',
        NULL, -- Si no hay restaurante asociado
        NULL  -- Si no hay imagen asociada
    );";

    if ($conn->query($callProcedure) === TRUE) {
        echo "Administrador insertado correctamente.<br>";
    } else {
        die("Error al insertar administrador: " . $conn->error);
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Instalación</title>
</head>
<body>
    <h1>Instalación de la Base de Datos</h1>
    <form action="install.php" method="post">
        <label for="server">Servidor:</label>
        <input type="text" id="server" name="server" required><br>
        <label for="username">Usuario:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" ><br>
        <label for="database">Nombre de la Base de Datos:</label>
        <input type="text" id="database" name="database" required><br>
        <button type="submit">Instalar</button>
    </form>
</body>
</html>
