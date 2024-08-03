	-- Crear el esquema
	CREATE SCHEMA bd_guaviareya;
	USE bd_guaviareya;

	-- Tabla Usuarios
	CREATE TABLE Usuarios (
		Correo VARCHAR(50) NOT NULL PRIMARY KEY,
		Apodo VARCHAR(50) NOT NULL,
		Nombre VARCHAR(50) NOT NULL,
		Apellido VARCHAR(50) NOT NULL,
		Contrasena VARCHAR(255) NOT NULL,  -- Aumentado para mayor longitud
		Telefono VARCHAR(15) NOT NULL,
		Fec_Regis TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
		img_U VARCHAR(200) NOT NULL
	);

	-- Tabla Restaurantes
	CREATE TABLE Restaurantes (
		ID_Restaurante INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
		Nombre_R VARCHAR(50) NOT NULL UNIQUE,
		Direccion VARCHAR(50) NOT NULL,
		Telefono VARCHAR(15) NOT NULL,
		img_R VARCHAR(200) NOT NULL,
		fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		Estado VARCHAR(15) NOT NULL
	);

	-- Tabla Administradores
	CREATE TABLE Administradores (
		id INT AUTO_INCREMENT PRIMARY KEY,
		correo VARCHAR(50) NOT NULL UNIQUE,
		apodo VARCHAR(50) NOT NULL,
		ID_Restaurante INT NULL,
		contrasena VARCHAR(255) NOT NULL,  -- Aumentado para mayor longitud
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
		fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		CONSTRAINT FK_Restaurantes_Productos FOREIGN KEY (ID_Restaurante) REFERENCES Restaurantes (ID_Restaurante)
	);

	-- Crear índice en la columna ID_Restaurante para mejorar el rendimiento de las búsquedas
	CREATE INDEX idx_ID_Restaurante ON Productos (ID_Restaurante);

	-- Tabla Direccion_Entregas
	CREATE TABLE Direccion_Entregas (
		ID_Dire_Entre INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
		Correo VARCHAR(50) NOT NULL,
		Direccion VARCHAR(100) NOT NULL,  -- Aumentado para permitir direcciones más largas
		Barrio VARCHAR(50) NOT NULL,
		fecha_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		Descripcion VARCHAR(50) NOT NULL,
		fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		CONSTRAINT FK_Usuarios_Direccion_Entregas FOREIGN KEY (Correo) REFERENCES Usuarios (Correo)
	);

	-- Crear índice en la columna Correo para mejorar el rendimiento de las búsquedas
	CREATE INDEX idx_Correo ON Direccion_Entregas (Correo);

	-- Tabla metodos_pago
	CREATE TABLE metodos_pago (
		id_pago INT AUTO_INCREMENT PRIMARY KEY,
		numero VARCHAR(16) NOT NULL,
		nombre VARCHAR(50) NOT NULL,
		apellido VARCHAR(50) NOT NULL,
		expiracion VARCHAR(4) NOT NULL,
		cvv VARCHAR(3) NOT NULL,
		correo VARCHAR(50) NOT NULL,
		fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		CONSTRAINT fk_usuarios_metodos_pago FOREIGN KEY (correo) REFERENCES Usuarios (Correo)
	);

	-- Crear índice en la columna correo para mejorar el rendimiento de las búsquedas
	CREATE INDEX idx_correo_metodos_pago ON metodos_pago (correo);

	-- Tabla Pedidos
	CREATE TABLE Pedidos (
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
	);

	-- Crear índices en columnas que se usan en las búsquedas
	CREATE INDEX idx_ID_Restaurante_Pedidos ON Pedidos (ID_Restaurante);
	CREATE INDEX idx_ID_Producto_Pedidos ON Pedidos (ID_Producto);
	CREATE INDEX idx_Correo_Pedidos ON Pedidos (Correo);

	-- Tabla Pedidos_factura
	CREATE TABLE Pedidos_factura (
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
	);

	-- Crear índices en columnas que se usan en las búsquedas
	CREATE INDEX idx_Correo_Pedidos_factura ON Pedidos_factura (Correo);
	CREATE INDEX idx_ID_Restaurante_Pedidos_factura ON Pedidos_factura (ID_Restaurante);
	CREATE INDEX idx_ID_Producto_Pedidos_factura ON Pedidos_factura (ID_Producto);
	CREATE INDEX idx_ID_Dire_Entre_Pedidos_factura ON Pedidos_factura (ID_Dire_Entre);
	CREATE INDEX idx_id_pago_Pedidos_factura ON Pedidos_factura (id_pago);

	-- Tabla de cupones
	CREATE TABLE Cupones (
		ID_Cupon INT AUTO_INCREMENT PRIMARY KEY,
		Correo VARCHAR(50) NOT NULL,
		Codigo_Cupon VARCHAR(20) NOT NULL UNIQUE,
		Descuento INT NOT NULL,
		Fecha_Expiracion DATE NOT NULL,
		Fecha_Usado TIMESTAMP NULL DEFAULT NULL,
		Fecha_Creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		CONSTRAINT FK_Usuarios_Cupones FOREIGN KEY (Correo) REFERENCES Usuarios (Correo)
	);

	-- Crear índice en la columna Correo para mejorar el rendimiento de las búsquedas
	CREATE INDEX idx_Correo_Cupones ON Cupones (Correo);

	-- Trigger para generar un cupón después de insertar un usuario
	DELIMITER //

	CREATE TRIGGER after_usuario_insert
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
	END;
	//

	DELIMITER ;

	-- Procedimiento almacenado para insertar un administrador

	DELIMITER //

	CREATE PROCEDURE insertar_administrador(
		IN p_correo VARCHAR(50),
		IN p_apodo VARCHAR(50),
		IN p_contrasena VARCHAR(255),
		IN p_rol ENUM('administrador', 'super_administrador'),
		IN p_ID_Restaurante INT,
		IN p_img_A VARCHAR(200)
	)
	BEGIN
		INSERT INTO Administradores (correo, apodo, contrasena, rol, ID_Restaurante, img_A)
		VALUES (p_correo, p_apodo, MD5(p_contrasena), p_rol, p_ID_Restaurante, p_img_A);
	END;
	//

	DELIMITER ;

	-- Llamado del procedimiento almacenado
	CALL insertar_administrador(
		'guaviareya@gmail.com',
		'GuaviareYa',
		'12345678Aa@',
		'super_administrador',
		NULL, -- Si no hay restaurante asociado
		NULL  -- Si no hay imagen asociada
	);

	-- Función para verificar el estado del restaurante
	DELIMITER //

	CREATE FUNCTION verificar_estado_restaurante(id_restaurante INT) 
	RETURNS VARCHAR(15)
	BEGIN
		DECLARE estado VARCHAR(15);
		
		SELECT Estado INTO estado
		FROM Restaurantes
		WHERE ID_Restaurante = id_restaurante;
		
		RETURN estado;
	END;
	//

	DELIMITER ;
    
    -- Tabla Documentos_Identificacion
CREATE TABLE Documentos_Identificacion (
    ID_Documento INT AUTO_INCREMENT PRIMARY KEY,
    Correo VARCHAR(50) NOT NULL,
    Tipo_Documento ENUM('DNI', 'Pasaporte', 'Licencia', 'Otro') NOT NULL,
    Foto_Documento VARCHAR(255) NOT NULL,
    Fecha_Subida TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT FK_Usuarios_Documentos_Identificacion FOREIGN KEY (Correo) REFERENCES Usuarios (Correo)
);

-- Crear índice en la columna Correo para mejorar el rendimiento de las búsquedas
CREATE INDEX idx_Correo_Documentos_Identificacion ON Documentos_Identificacion (Correo);

	-- Seleccionar todas las tablas
		
	SELECT * FROM Restaurantes;
	SELECT * FROM administradores;
	SELECT * FROM Productos;
	SELECT * FROM Direccion_Entregas;
	SELECT * FROM metodos_pago;
	SELECT * FROM Pedidos;
	SELECT * FROM Pedidos_factura;
	SELECT * FROM Cupones;
    SELECT * FROM  Documentos_Identificacion;
