CREATE SCHEMA bd_guaviareya;
USE bd_guaviareya;
/*DROP SCHEMA bd_guaviareya;*/

-- Creación de tablas

-- Creación de tablas
CREATE TABLE Usuarios (
    Correo VARCHAR(50) NOT NULL PRIMARY KEY,
    Apodo VARCHAR(50) NOT NULL,
    Nombre VARCHAR(50) NOT NULL,
    Apellido VARCHAR(50) NOT NULL,
    Contrasena VARCHAR(50) NOT NULL,
    Telefono VARCHAR(15) NOT NULL,
    Fec_Regis DATETIME NOT NULL,
    img_U LONGBLOB NOT NULL
);
INSERT INTO Usuarios (Correo,Apodo) VALUES ('Luis@gmail.com', 'Luis', 'Zapata', '','123456','3219418416');

/*ALTER TABLE Usuarios
ADD Apodo VARCHAR(50) NOT NULL AFTER ID_User;*/

CREATE TABLE Restaurantes (
    ID_Restaurante INT NOT NULL PRIMARY KEY,
    ID_Producto INT NOT NULL,
    Nombre_R VARCHAR(50) NOT NULL,
    Dirrecion VARCHAR(50) NOT NULL,
    Telefono VARCHAR(15) NOT NULL,
    img_R LONGBLOB NOT NULL
);



CREATE TABLE Productos (
    ID_Producto INT NOT NULL PRIMARY KEY,
    ID_Restaurante INT NOT NULL,
    Nombre_P VARCHAR(50) NOT NULL,
    Valor_P INT NOT NULL,
    img_P LONGBLOB NOT NULL
    
);

CREATE TABLE Dirrecion_Entregas (
    ID_Dire_Entre INT NOT NULL PRIMARY KEY,
    Correo VARCHAR(50) NOT NULL,
    Numero_Casa VARCHAR(10) NOT NULL,
    CL_Cra_AV VARCHAR(50) NOT NULL,
    Barrio VARCHAR(50) NOT NULL
);

CREATE TABLE Pagos (
    ID_Pago INT NOT NULL PRIMARY KEY,
    Correo VARCHAR(50) NOT NULL,
    Tipo_Pago VARCHAR(20) NOT NULL,
    Monto_Final INT NOT NULL,
    Fecha_Pago DATETIME NOT NULL,
    img_pa LONGBLOB  NULL
);

CREATE TABLE Domiciliarios (
    ID_Domiciliario INT NOT NULL PRIMARY KEY,
    Correo VARCHAR(50) NOT NULL,
    ID_Pedido INT NOT NULL,
    Nombre_Domiciliario VARCHAR(20) NOT NULL,
    Telefono_Domi VARCHAR(15) NOT NULL,
    img_do LONGBLOB NOT NULL
);

CREATE TABLE Pedidos (
    ID_pedido INT NOT NULL PRIMARY KEY,
    ID_Producto INT NOT NULL,
    ID_Restaurante INT NOT NULL,
    Correo VARCHAR(50) NOT NULL,
    cantidad INT NOT NULL
);      

CREATE TABLE Pedidos_factura (
    ID_Pedifac INT NOT NULL PRIMARY KEY,
    ID_pedido INT NOT NULL,
    Correo VARCHAR(50) NOT NULL,
    ID_Restaurante INT NOT NULL,
	ID_Dire_Entre INT NOT NULL,
    ID_pago INT NOT NULL,
    ID_Domiciliario INT NOT NULL,
    Estado_Pedido VARCHAR(50) NOT NULL,
    Subtotal INT NOT NULL,
    Valor_Domi INT NOT NULL default 5000,
    Valor_Pagar int not null,
    img_pef LONGBLOB NOT NULL
);

-- CONSTRAINTS


ALTER TABLE Productos
ADD CONSTRAINT FK_Restaurantes_Productos
FOREIGN KEY (ID_Restaurante) REFERENCES Restaurantes (ID_Restaurante);

ALTER TABLE Pedidos
ADD CONSTRAINT FK_Productos_Pedidos
FOREIGN KEY (ID_Producto) REFERENCES Productos (ID_Producto);

ALTER TABLE Pedidos
ADD CONSTRAINT FK_Restaurantes_Pedidos
FOREIGN KEY (ID_Restaurante) REFERENCES Restaurantes (ID_Restaurante);

ALTER TABLE Pedidos_factura
ADD CONSTRAINT FK_Pedidos_Pedidos_factura
FOREIGN KEY (ID_pedido) REFERENCES Pedidos (ID_pedido);

ALTER TABLE Pedidos_factura
ADD CONSTRAINT FK_Usuarios_Pedidos_factura
FOREIGN KEY (Correo) REFERENCES Usuarios (Correo);

ALTER TABLE Pedidos_factura
ADD CONSTRAINT FK_Dirrecion_Entregas_Pedidos_factura
FOREIGN KEY (ID_Dire_Entre) REFERENCES Dirrecion_Entregas (ID_Dire_Entre);

ALTER TABLE Pedidos_factura
ADD CONSTRAINT FK_Domiciliarios_Pedidos_factura
FOREIGN KEY (ID_Domiciliario) REFERENCES Domiciliarios (ID_Domiciliario);

ALTER TABLE Pedidos_factura
ADD CONSTRAINT FK_Restaurantes_Pedidos_factura
FOREIGN KEY (ID_Restaurante) REFERENCES Restaurantes (ID_Restaurante);

ALTER TABLE Pedidos_factura
ADD CONSTRAINT FK_Pagos_Pedidos_factura
FOREIGN KEY (ID_Pago) REFERENCES Pagos (ID_Pago);

ALTER TABLE Dirrecion_Entregas
ADD CONSTRAINT FK_Usuarios_Dirrecion_Entregas
FOREIGN KEY (Correo) REFERENCES Usuarios (Correo);

ALTER TABLE Pagos
ADD CONSTRAINT FK_Usuarios_Pagos
FOREIGN KEY (Correo) REFERENCES Usuarios (Correo);

ALTER TABLE Domiciliarios
ADD CONSTRAINT FK_Usuarios_Domiciliarios
FOREIGN KEY (Correo) REFERENCES Usuarios (Correo);

-- Joins y selects

-- Join usuario-pago
SELECT * FROM Usuarios t1, Pagos t2
WHERE t2.correo = t1.correo;

-- Join de Usuario - n° pedidos
SELECT Usuarios.correo, Usuarios.Nombre, Usuarios.Apellido, COUNT(Pedidos.ID_pedido) AS Num_Pedidos
FROM Usuarios, Pedidos
WHERE Usuarios.correo = Pedidos.correo
GROUP BY Usuarios.correo, Usuarios.Nombre, Usuarios.Apellido;


-- Seleccionar todas las tablas
SELECT * FROM Usuarios;
SELECT * FROM Restaurantes;
SELECT * FROM Productos;
SELECT * FROM Dirrecion_Entregas;
SELECT * FROM Domiciliarios;
SELECT * FROM Pagos;
SELECT * FROM Pedidos;
select * from Pedidos_factura;

INSERT INTO Usuarios (Correo, Apodo, Nombre, Apellido,Contrasena,Telefono) VALUES ('Zapata', 'Luis', 'Zapata', 'Luis@gmail.com','123456','3219418416');







-- Drop de todas las tablas
#drop table if exists Pedidos_factura;
#DROP TABLE IF EXISTS Pedidos;
#DROP TABLE IF EXISTS Domiciliarios;
#DROP TABLE IF EXISTS Dirrecion_Entregas;
#DROP TABLE IF EXISTS Productos;
#DROP TABLE IF EXISTS Restaurantes;
#DROP TABLE IF EXISTS Pagos;
#DROP TABLE IF EXISTS Usuarios;