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
    ID_Restaurante INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    Nombre_R VARCHAR(50) NOT NULL,
    Direccion VARCHAR(50) NOT NULL,
    Telefono VARCHAR(15) NOT NULL,
    img_R VARCHAR(200) NOT NULL
);

-- Agregar columna Estado a la tabla Restaurantes
ALTER TABLE Restaurantes 
ADD COLUMN Estado VARCHAR(15) NOT NULL;



-- Tabla Administrador
CREATE TABLE administradores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    correo VARCHAR(50) NOT NULL UNIQUE,
    apodo VARCHAR(50) NOT NULL,
    ID_Restaurante INT NULL,
    contrasena VARCHAR(255) NOT NULL,
    rol ENUM('administrador', 'super_administrador') NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    img_A VARCHAR(200) NULL,
    CONSTRAINT FK_Restaurantes_Administradores FOREIGN KEY (ID_Restaurante) REFERENCES Restaurantes (ID_Restaurante)
);



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

-- Tabla Direccion_Entregas
CREATE TABLE Direccion_Entregas (
    ID_Dire_Entre INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    Correo VARCHAR(50) NOT NULL,
    Direccion VARCHAR(15) NOT NULL,
    Barrio VARCHAR(50) NOT NULL,
    fecha_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Descripcion VARCHAR(50) NOT NULL,
    CONSTRAINT FK_Usuarios_Direccion_Entregas FOREIGN KEY (Correo) REFERENCES Usuarios (Correo)
);

-- Tabla Domiciliarios
CREATE TABLE Domiciliarios (
    ID_Domiciliario INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    Correo VARCHAR(50) NOT NULL,
    Nombre_Domiciliario VARCHAR(20) NOT NULL,
    Telefono_Domi VARCHAR(15) NOT NULL,
    img_do VARCHAR(200) NOT NULL,
    CONSTRAINT FK_Usuarios_Domiciliarios FOREIGN KEY (Correo) REFERENCES Usuarios (Correo)
);

-- Tabla metodos_pago
CREATE TABLE metodos_pago (
    id_pago INT AUTO_INCREMENT PRIMARY KEY,
    numero VARCHAR(16) NOT NULL,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    expiracion VARCHAR(4) NOT NULL,
    cvv VARCHAR(3) NOT NULL,
    correo VARCHAR(50) NOT NULL,
    CONSTRAINT fk_usuarios_metodos_pago FOREIGN KEY (correo) REFERENCES usuarios (correo)
);

-- Tabla Pedidos
CREATE TABLE Pedidos (
    ID_pedido INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    ID_Restaurante INT NOT NULL,
    ID_Producto INT NOT NULL,
    Correo VARCHAR(50) NOT NULL,
    Descripcion VARCHAR(300) NOT NULL,
    cantidad INT NOT NULL,
    Sub_total DOUBLE NOT NULL,
    CONSTRAINT FK_Productos_Pedidos FOREIGN KEY (ID_Producto) REFERENCES Productos (ID_Producto),
    CONSTRAINT FK_Restaurantes_Pedidos FOREIGN KEY (ID_Restaurante) REFERENCES Restaurantes (ID_Restaurante),
    CONSTRAINT FK_Usuarios_Pedidos FOREIGN KEY (Correo) REFERENCES Usuarios (Correo)
);


-- Tabla Pedidos_factura
CREATE TABLE Pedidos_factura (
    ID_Pedifac INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    ID_pedido INT NOT NULL,
    Correo VARCHAR(50) NOT NULL,
    ID_Restaurante INT NOT NULL,
    ID_Producto INT NOT NULL,
    ID_Dire_Entre INT NOT NULL,
    id_pago INT NOT NULL,
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
    CONSTRAINT FK_Pagos_Pedidos_factura FOREIGN KEY (id_pago) REFERENCES metodos_pago (id_pago)
);

-- Seleccionar todas las tablas
SELECT * FROM Usuarios;
SELECT * FROM Restaurantes;
SELECT * FROM administradores;
SELECT * FROM Productos;
SELECT * FROM Direccion_Entregas;
SELECT * FROM Domiciliarios;
SELECT * FROM metodos_pago;
SELECT * FROM Pedidos;
SELECT * FROM Pedidos_factura;
