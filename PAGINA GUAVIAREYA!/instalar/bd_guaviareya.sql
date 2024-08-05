-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-08-2024 a las 23:05:47
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_guaviareya`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar_administrador` (IN `p_correo` VARCHAR(50), IN `p_apodo` VARCHAR(50), IN `p_contrasena` VARCHAR(255), IN `p_rol` ENUM('administrador','super_administrador'), IN `p_ID_Restaurante` INT, IN `p_img_A` VARCHAR(200))   BEGIN
		INSERT INTO Administradores (correo, apodo, contrasena, rol, ID_Restaurante, img_A)
		VALUES (p_correo, p_apodo, MD5(p_contrasena), p_rol, p_ID_Restaurante, p_img_A);
	END$$

--
-- Funciones
--
CREATE DEFINER=`root`@`localhost` FUNCTION `verificar_estado_restaurante` (`id_restaurante` INT) RETURNS VARCHAR(15) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  BEGIN
		DECLARE estado VARCHAR(15);
		
		SELECT Estado INTO estado
		FROM Restaurantes
		WHERE ID_Restaurante = id_restaurante;
		
		RETURN estado;
	END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `id` int(11) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `apodo` varchar(50) NOT NULL,
  `ID_Restaurante` int(11) DEFAULT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` enum('administrador','super_administrador') NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `img_A` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id`, `correo`, `apodo`, `ID_Restaurante`, `contrasena`, `rol`, `fecha_creacion`, `img_A`) VALUES
(1, 'guaviareya@gmail.com', 'GuaviareYa', NULL, 'aad0163fa0f3c29e0145b15ac783b50d', 'super_administrador', '2024-08-04 20:59:13', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cupones`
--

CREATE TABLE `cupones` (
  `ID_Cupon` int(11) NOT NULL,
  `Correo` varchar(50) NOT NULL,
  `Codigo_Cupon` varchar(20) NOT NULL,
  `Descuento` int(11) NOT NULL,
  `Fecha_Expiracion` date NOT NULL,
  `Fecha_Usado` timestamp NULL DEFAULT NULL,
  `Fecha_Creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccion_entregas`
--

CREATE TABLE `direccion_entregas` (
  `ID_Dire_Entre` int(11) NOT NULL,
  `Correo` varchar(50) NOT NULL,
  `Direccion` varchar(100) NOT NULL,
  `Barrio` varchar(50) NOT NULL,
  `fecha_pedido` timestamp NOT NULL DEFAULT current_timestamp(),
  `Descripcion` varchar(50) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos_identificacion`
--

CREATE TABLE `documentos_identificacion` (
  `ID_Documento` int(11) NOT NULL,
  `Correo` varchar(50) NOT NULL,
  `Tipo_Documento` enum('DNI','Pasaporte','Licencia','Otro') NOT NULL,
  `Foto_Documento` varchar(255) NOT NULL,
  `Fecha_Subida` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likes_dislikes`
--

CREATE TABLE `likes_dislikes` (
  `ID` int(11) NOT NULL,
  `Correo` varchar(50) NOT NULL,
  `ID_Restaurante` int(11) NOT NULL,
  `Tipo` enum('like','dislike') NOT NULL,
  `Fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodos_pago`
--

CREATE TABLE `metodos_pago` (
  `id_pago` int(11) NOT NULL,
  `numero` varchar(16) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `expiracion` varchar(4) NOT NULL,
  `cvv` varchar(3) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `ID_pedido` int(11) NOT NULL,
  `ID_Restaurante` int(11) NOT NULL,
  `ID_Producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `Sub_total` double NOT NULL,
  `ID_Dire_Entre` int(11) NOT NULL,
  `Correo` varchar(50) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `Tipo_Envio` enum('Prioritaria','Básica') NOT NULL DEFAULT 'Básica',
  `Estado` enum('Pendiente','Enviado','Entregado','Cancelado') NOT NULL DEFAULT 'Pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_factura`
--

CREATE TABLE `pedidos_factura` (
  `ID_Pedifac` int(11) NOT NULL,
  `ID_pedido` int(11) NOT NULL,
  `Correo` varchar(50) NOT NULL,
  `ID_Restaurante` int(11) NOT NULL,
  `ID_Producto` int(11) NOT NULL,
  `ID_Dire_Entre` int(11) NOT NULL,
  `id_pago` int(11) NOT NULL,
  `Estado_Pedido` varchar(50) NOT NULL,
  `Subtotal` int(11) NOT NULL,
  `Valor_Domi` int(11) NOT NULL DEFAULT 5000,
  `Valor_Pagar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `ID_Producto` int(11) NOT NULL,
  `ID_Restaurante` int(11) NOT NULL,
  `Nombre_P` varchar(50) NOT NULL,
  `Descripcion` varchar(300) NOT NULL,
  `Valor_P` int(11) NOT NULL,
  `img_P` varchar(200) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restaurantes`
--

CREATE TABLE `restaurantes` (
  `ID_Restaurante` int(11) NOT NULL,
  `Nombre_R` varchar(50) NOT NULL,
  `Direccion` varchar(50) NOT NULL,
  `Telefono` varchar(15) NOT NULL,
  `img_R` varchar(200) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `Estado` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `Correo` varchar(50) NOT NULL,
  `Apodo` varchar(50) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Apellido` varchar(50) NOT NULL,
  `Contrasena` varchar(255) NOT NULL,
  `Telefono` varchar(15) NOT NULL,
  `Fec_Regis` timestamp NOT NULL DEFAULT current_timestamp(),
  `img_U` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Disparadores `usuarios`
--
DELIMITER $$
CREATE TRIGGER `after_usuario_insert` AFTER INSERT ON `usuarios` FOR EACH ROW BEGIN
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
	END
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `FK_Restaurantes_Administradores` (`ID_Restaurante`);

--
-- Indices de la tabla `cupones`
--
ALTER TABLE `cupones`
  ADD PRIMARY KEY (`ID_Cupon`),
  ADD UNIQUE KEY `Codigo_Cupon` (`Codigo_Cupon`),
  ADD KEY `idx_Correo_Cupones` (`Correo`);

--
-- Indices de la tabla `direccion_entregas`
--
ALTER TABLE `direccion_entregas`
  ADD PRIMARY KEY (`ID_Dire_Entre`),
  ADD KEY `idx_Correo` (`Correo`);

--
-- Indices de la tabla `documentos_identificacion`
--
ALTER TABLE `documentos_identificacion`
  ADD PRIMARY KEY (`ID_Documento`),
  ADD KEY `idx_Correo_Documentos_Identificacion` (`Correo`);

--
-- Indices de la tabla `likes_dislikes`
--
ALTER TABLE `likes_dislikes`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Correo` (`Correo`,`ID_Restaurante`,`Tipo`),
  ADD KEY `FK_Restaurantes_Likes_Dislikes` (`ID_Restaurante`);

--
-- Indices de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `idx_correo_metodos_pago` (`correo`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`ID_pedido`),
  ADD KEY `FK_Direccion_Entregas_Pedidos` (`ID_Dire_Entre`),
  ADD KEY `idx_ID_Restaurante_Pedidos` (`ID_Restaurante`),
  ADD KEY `idx_ID_Producto_Pedidos` (`ID_Producto`),
  ADD KEY `idx_Correo_Pedidos` (`Correo`);

--
-- Indices de la tabla `pedidos_factura`
--
ALTER TABLE `pedidos_factura`
  ADD PRIMARY KEY (`ID_Pedifac`),
  ADD KEY `FK_Pedidos_Pedidos_factura` (`ID_pedido`),
  ADD KEY `idx_Correo_Pedidos_factura` (`Correo`),
  ADD KEY `idx_ID_Restaurante_Pedidos_factura` (`ID_Restaurante`),
  ADD KEY `idx_ID_Producto_Pedidos_factura` (`ID_Producto`),
  ADD KEY `idx_ID_Dire_Entre_Pedidos_factura` (`ID_Dire_Entre`),
  ADD KEY `idx_id_pago_Pedidos_factura` (`id_pago`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`ID_Producto`),
  ADD KEY `idx_ID_Restaurante` (`ID_Restaurante`);

--
-- Indices de la tabla `restaurantes`
--
ALTER TABLE `restaurantes`
  ADD PRIMARY KEY (`ID_Restaurante`),
  ADD UNIQUE KEY `Nombre_R` (`Nombre_R`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`Correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cupones`
--
ALTER TABLE `cupones`
  MODIFY `ID_Cupon` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `direccion_entregas`
--
ALTER TABLE `direccion_entregas`
  MODIFY `ID_Dire_Entre` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `documentos_identificacion`
--
ALTER TABLE `documentos_identificacion`
  MODIFY `ID_Documento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `likes_dislikes`
--
ALTER TABLE `likes_dislikes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `ID_pedido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos_factura`
--
ALTER TABLE `pedidos_factura`
  MODIFY `ID_Pedifac` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `ID_Producto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `restaurantes`
--
ALTER TABLE `restaurantes`
  MODIFY `ID_Restaurante` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD CONSTRAINT `FK_Restaurantes_Administradores` FOREIGN KEY (`ID_Restaurante`) REFERENCES `restaurantes` (`ID_Restaurante`);

--
-- Filtros para la tabla `cupones`
--
ALTER TABLE `cupones`
  ADD CONSTRAINT `FK_Usuarios_Cupones` FOREIGN KEY (`Correo`) REFERENCES `usuarios` (`Correo`);

--
-- Filtros para la tabla `direccion_entregas`
--
ALTER TABLE `direccion_entregas`
  ADD CONSTRAINT `FK_Usuarios_Direccion_Entregas` FOREIGN KEY (`Correo`) REFERENCES `usuarios` (`Correo`);

--
-- Filtros para la tabla `documentos_identificacion`
--
ALTER TABLE `documentos_identificacion`
  ADD CONSTRAINT `FK_Usuarios_Documentos_Identificacion` FOREIGN KEY (`Correo`) REFERENCES `usuarios` (`Correo`);

--
-- Filtros para la tabla `likes_dislikes`
--
ALTER TABLE `likes_dislikes`
  ADD CONSTRAINT `FK_Restaurantes_Likes_Dislikes` FOREIGN KEY (`ID_Restaurante`) REFERENCES `restaurantes` (`ID_Restaurante`),
  ADD CONSTRAINT `FK_Usuarios_Likes_Dislikes` FOREIGN KEY (`Correo`) REFERENCES `usuarios` (`Correo`);

--
-- Filtros para la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  ADD CONSTRAINT `fk_usuarios_metodos_pago` FOREIGN KEY (`correo`) REFERENCES `usuarios` (`Correo`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `FK_Direccion_Entregas_Pedidos` FOREIGN KEY (`ID_Dire_Entre`) REFERENCES `direccion_entregas` (`ID_Dire_Entre`),
  ADD CONSTRAINT `FK_Productos_Pedidos` FOREIGN KEY (`ID_Producto`) REFERENCES `productos` (`ID_Producto`),
  ADD CONSTRAINT `FK_Restaurantes_Pedidos` FOREIGN KEY (`ID_Restaurante`) REFERENCES `restaurantes` (`ID_Restaurante`),
  ADD CONSTRAINT `FK_Usuarios_Pedidos` FOREIGN KEY (`Correo`) REFERENCES `usuarios` (`Correo`);

--
-- Filtros para la tabla `pedidos_factura`
--
ALTER TABLE `pedidos_factura`
  ADD CONSTRAINT `FK_Direccion_Entregas_Pedidos_factura` FOREIGN KEY (`ID_Dire_Entre`) REFERENCES `direccion_entregas` (`ID_Dire_Entre`),
  ADD CONSTRAINT `FK_Pagos_Pedidos_factura` FOREIGN KEY (`id_pago`) REFERENCES `metodos_pago` (`id_pago`),
  ADD CONSTRAINT `FK_Pedidos_Pedidos_factura` FOREIGN KEY (`ID_pedido`) REFERENCES `pedidos` (`ID_pedido`),
  ADD CONSTRAINT `FK_Productos_Pedidos_factura` FOREIGN KEY (`ID_Producto`) REFERENCES `productos` (`ID_Producto`),
  ADD CONSTRAINT `FK_Restaurantes_Pedidos_factura` FOREIGN KEY (`ID_Restaurante`) REFERENCES `restaurantes` (`ID_Restaurante`),
  ADD CONSTRAINT `FK_Usuarios_Pedidos_factura` FOREIGN KEY (`Correo`) REFERENCES `usuarios` (`Correo`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `FK_Restaurantes_Productos` FOREIGN KEY (`ID_Restaurante`) REFERENCES `restaurantes` (`ID_Restaurante`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
