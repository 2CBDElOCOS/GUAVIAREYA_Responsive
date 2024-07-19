CREATE SCHEMA bd_guaviareya;
USE bd_guaviareya;

-- Tabla usuarios
CREATE TABLE usuarios (
    correo VARCHAR(50) NOT NULL PRIMARY KEY,
    apodo VARCHAR(50) NOT NULL,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    contrasena VARCHAR(50) NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    fec_regis DATETIME NOT NULL,
    img_u VARCHAR(200) NOT NULL
);

-- Tabla restaurantes
CREATE TABLE restaurantes (
    id_restaurante INT AUTO_INCREMENT PRIMARY KEY,
    nombre_r VARCHAR(50) NOT NULL,
    direccion VARCHAR(50) NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    img_r VARCHAR(200) NOT NULL
);

-- Tabla administrador
CREATE TABLE administrador (
    correo VARCHAR(50) NOT NULL PRIMARY KEY,
    apodo VARCHAR(50) NOT NULL,
    id_restaurante INT NOT NULL,
    contrasena VARCHAR(50) NOT NULL,
    CONSTRAINT fk_restaurantes_administrador FOREIGN KEY (id_restaurante) REFERENCES restaurantes (id_restaurante)
);

-- Tabla productos
CREATE TABLE productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    id_restaurante INT NOT NULL,
    nombre_p VARCHAR(50) NOT NULL,
    descripcion VARCHAR(300) NOT NULL,
    valor_p INT NOT NULL,
    img_p VARCHAR(200) NOT NULL,
    CONSTRAINT fk_restaurantes_productos FOREIGN KEY (id_restaurante) REFERENCES restaurantes (id_restaurante)
);

-- Tabla direccion_entregas
CREATE TABLE direccion_entregas (
    id_dire_entre INT AUTO_INCREMENT PRIMARY KEY,
    correo VARCHAR(50) NOT NULL,
    numero_casa VARCHAR(10) NOT NULL,
    cl_cra_av VARCHAR(50) NOT NULL,
    barrio VARCHAR(50) NOT NULL,
    CONSTRAINT fk_usuarios_direccion_entregas FOREIGN KEY (correo) REFERENCES usuarios (correo)
);

-- Tabla domiciliarios
CREATE TABLE domiciliarios (
    id_domiciliario INT AUTO_INCREMENT PRIMARY KEY,
    correo VARCHAR(50) NOT NULL,
    nombre_domiciliario VARCHAR(20) NOT NULL,
    telefono_domi VARCHAR(15) NOT NULL,
    img_do VARCHAR(200) NOT NULL,
    CONSTRAINT fk_usuarios_domiciliarios FOREIGN KEY (correo) REFERENCES usuarios (correo)
);

-- Tabla pagos
CREATE TABLE pagos (
    id_pago INT AUTO_INCREMENT PRIMARY KEY,
    correo VARCHAR(50) NOT NULL,
    tipo_pago VARCHAR(20) NOT NULL,
    monto_final INT NOT NULL,
    fecha_pago DATETIME NOT NULL,
    img_pa LONGBLOB NULL,
    CONSTRAINT fk_usuarios_pagos FOREIGN KEY (correo) REFERENCES usuarios (correo)
);

-- Tabla metodos_pago
CREATE TABLE metodos_pago (
    id_pago INT AUTO_INCREMENT PRIMARY KEY,
    numero VARCHAR(20) NOT NULL,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    expiracion VARCHAR(7) NOT NULL,
    cvv VARCHAR(4) NOT NULL,
    correo VARCHAR(50) NOT NULL,
    CONSTRAINT fk_usuarios_metodos_pago FOREIGN KEY (correo) REFERENCES usuarios (correo)
);

-- Tabla pedidos
CREATE TABLE pedidos (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    id_restaurante INT NOT NULL,
    id_producto INT NOT NULL,
    descripcion VARCHAR(300) NOT NULL,
    cantidad INT NOT NULL,
    sub_total DOUBLE NOT NULL,
    CONSTRAINT fk_productos_pedidos FOREIGN KEY (id_producto) REFERENCES productos (id_producto),
    CONSTRAINT fk_restaurantes_pedidos FOREIGN KEY (id_restaurante) REFERENCES restaurantes (id_restaurante)
);

-- Tabla pedidos_factura
CREATE TABLE pedidos_factura (
    id_pedifac INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT NOT NULL,
    correo VARCHAR(50) NOT NULL,
    id_restaurante INT NOT NULL,
    id_producto INT NOT NULL,
    id_dire_entre INT NOT NULL,
    id_pago INT NOT NULL,
    id_domiciliario INT NOT NULL,
    estado_pedido VARCHAR(50) NOT NULL,
    subtotal INT NOT NULL,
    valor_domi INT NOT NULL DEFAULT 5000,
    valor_pagar INT NOT NULL,
    CONSTRAINT fk_pedidos_pedidos_factura FOREIGN KEY (id_pedido) REFERENCES pedidos (id_pedido),
    CONSTRAINT fk_usuarios_pedidos_factura FOREIGN KEY (correo) REFERENCES usuarios (correo),
    CONSTRAINT fk_direccion_entregas_pedidos_factura FOREIGN KEY (id_dire_entre) REFERENCES direccion_entregas (id_dire_entre),
    CONSTRAINT fk_productos_pedidos_factura FOREIGN KEY (id_producto) REFERENCES productos (id_producto),
    CONSTRAINT fk_domiciliarios_pedidos_factura FOREIGN KEY (id_domiciliario) REFERENCES domiciliarios (id_domiciliario),
    CONSTRAINT fk_restaurantes_pedidos_factura FOREIGN KEY (id_restaurante) REFERENCES restaurantes (id_restaurante),
    CONSTRAINT fk_pagos_pedidos_factura FOREIGN KEY (id_pago) REFERENCES pagos (id_pago)
);

-- Seleccionar todas las tablas
SELECT * FROM usuarios;
SELECT * FROM restaurantes;
SELECT * FROM productos;
SELECT * FROM direccion_entregas;
SELECT * FROM domiciliarios;
SELECT * FROM metodos_pago;
SELECT * FROM pagos;
SELECT * FROM pedidos;
SELECT * FROM pedidos_factura;
