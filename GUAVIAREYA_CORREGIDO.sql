CREATE SCHEMA bd_guaviareya;
USE bd_guaviareya;

-- Tabla Usuarios
CREATE TABLE Usuarios (
    Correo VARCHAR(50) NOT NULL PRIMARY KEY,
    Apodo VARCHAR(50) NOT NULL,
    Nombre VARCHAR(50) NOT NULL,
    Apellido VARCHAR(50) NOT NULL,
    Contrasena VARCHAR(50) NOT NULL,
    Telefono VARCHAR(15) NOT NULL,
    Fec_Regis DATETIME NOT NULL,
    img_U VARCHAR(200) NOT NULL
);

-- Tabla Restaurantes
CREATE TABLE Restaurantes (
    ID_Restaurante INT NOT NULL PRIMARY KEY,
    Nombre_R VARCHAR(50) NOT NULL,
    Direccion VARCHAR(50) NOT NULL,
    Telefono VARCHAR(15) NOT NULL,
    img_R VARCHAR(200) NOT NULL
);

select * from Restaurantes;
-- Tabla Administrador
CREATE TABLE administrador (
    correo VARCHAR(50) NOT NULL PRIMARY KEY,
    apodo VARCHAR(50) NOT NULL,
    ID_Restaurante INT NOT NULL,
    contrasena VARCHAR(50) NOT NULL,
    CONSTRAINT FK_Restaurantes_Administrador FOREIGN KEY (ID_Restaurante) REFERENCES Restaurantes (ID_Restaurante)
);

select * from administrador;

SELECT * FROM Productos WHERE ID_Restaurante = 2;

-- Tabla Productos
CREATE TABLE Productos (
    ID_Producto INT AUTO_INCREMENT PRIMARY KEY,
    ID_Restaurante INT NOT NULL,
    Nombre_P VARCHAR(50) NOT NULL,
    Descripcion VARCHAR(300) NOT NULL,
    Valor_P INT NOT NULL,
    img_P VARCHAR(200) NOT NULL,
    CONSTRAINT FK_Restaurantes_Productos FOREIGN KEY (ID_Restaurante) REFERENCES Restaurantes (ID_Restaurante)
);

select * from Productos;
-- Tabla Direccion_Entregas
CREATE TABLE Direccion_Entregas (
    ID_Dire_Entre INT NOT NULL PRIMARY KEY,
    Correo VARCHAR(50) NOT NULL,
    Numero_Casa VARCHAR(10) NOT NULL,
    CL_Cra_AV VARCHAR(50) NOT NULL,
    Barrio VARCHAR(50) NOT NULL,
    CONSTRAINT FK_Usuarios_Direccion_Entregas FOREIGN KEY (Correo) REFERENCES Usuarios (Correo)
);

-- Tabla Pagos
CREATE TABLE Pagos (
    ID_Pago INT NOT NULL PRIMARY KEY,
    Correo VARCHAR(50) NOT NULL,
    Tipo_Pago VARCHAR(20) NOT NULL,
    Monto_Final INT NOT NULL,
    Fecha_Pago DATETIME NOT NULL,
    img_pa LONGBLOB NULL,
    CONSTRAINT FK_Usuarios_Pagos FOREIGN KEY (Correo) REFERENCES Usuarios (Correo)
);

-- Tabla Domiciliarios
CREATE TABLE Domiciliarios (
    ID_Domiciliario INT NOT NULL PRIMARY KEY,
    Correo VARCHAR(50) NOT NULL,
    Nombre_Domiciliario VARCHAR(20) NOT NULL,
    Telefono_Domi VARCHAR(15) NOT NULL,
    img_do VARCHAR(200) NOT NULL,
    CONSTRAINT FK_Usuarios_Domiciliarios FOREIGN KEY (Correo) REFERENCES Usuarios (Correo)
);

-- Tabla Pedidos
CREATE TABLE Pedidos (
    ID_pedido INT NOT NULL PRIMARY KEY,
    ID_Restaurante INT NOT NULL,
    ID_Producto INT NOT NULL,
    Descripcion VARCHAR(300) NOT NULL,
    cantidad INT NOT NULL,
    Sub_total DOUBLE NOT NULL,
    CONSTRAINT FK_Productos_Pedidos FOREIGN KEY (ID_Producto) REFERENCES Productos (ID_Producto),
    CONSTRAINT FK_Restaurantes_Pedidos FOREIGN KEY (ID_Restaurante) REFERENCES Restaurantes (ID_Restaurante)
);

-- Tabla Pedidos_factura
CREATE TABLE Pedidos_factura (
    ID_Pedifac INT NOT NULL PRIMARY KEY,
    ID_pedido INT NOT NULL,
    Correo VARCHAR(50) NOT NULL,
    ID_Restaurante INT NOT NULL,
    ID_Producto INT NOT NULL,
    ID_Dire_Entre INT NOT NULL,
    ID_Pago INT NOT NULL,
    ID_Domiciliario INT NOT NULL,
    Estado_Pedido VARCHAR(50) NOT NULL,
    Subtotal INT NOT NULL,
    Valor_Domi INT NOT NULL DEFAULT 5000,
    Valor_Pagar INT NOT NULL,
    CONSTRAINT FK_Pedidos_Pedidos_factura FOREIGN KEY (ID_pedido) REFERENCES Pedidos (ID_pedido),
    CONSTRAINT FK_Usuarios_Pedidos_factura FOREIGN KEY (Correo) REFERENCES Usuarios (Correo),
    CONSTRAINT FK_Direccion_Entregas_Pedidos_factura FOREIGN KEY (ID_Dire_Entre) REFERENCES Direccion_Entregas (ID_Dire_Entre),
    CONSTRAINT FK_Productos_Pedidos_factura FOREIGN KEY (ID_Producto) REFERENCES Productos (ID_Producto),
    CONSTRAINT FK_Domiciliarios_Pedidos_factura FOREIGN KEY (ID_Domiciliario) REFERENCES Domiciliarios (ID_Domiciliario),
    CONSTRAINT FK_Restaurantes_Pedidos_factura FOREIGN KEY (ID_Restaurante) REFERENCES Restaurantes (ID_Restaurante),
    CONSTRAINT FK_Pagos_Pedidos_factura FOREIGN KEY (ID_Pago) REFERENCES Pagos (ID_Pago)
);

-- Joins y selects

-- Join usuario-pago
SELECT * FROM Usuarios t1
JOIN Pagos t2 ON t2.Correo = t1.Correo;

-- Join de Usuario - n° pedidos
SELECT Usuarios.Correo, Usuarios.Nombre, Usuarios.Apellido, COUNT(Pedidos.ID_pedido) AS Num_Pedidos
FROM Usuarios
JOIN Pedidos ON Usuarios.Correo = Pedidos.Correo
GROUP BY Usuarios.Correo, Usuarios.Nombre, Usuarios.Apellido;

-- Seleccionar todas las tablas
SELECT * FROM Usuarios;
SELECT * FROM Restaurantes;
SELECT * FROM Productos;
SELECT * FROM Direccion_Entregas;
SELECT * FROM Domiciliarios;
SELECT * FROM Pagos;
SELECT * FROM Pedidos;
SELECT * FROM Pedidos_factura;
