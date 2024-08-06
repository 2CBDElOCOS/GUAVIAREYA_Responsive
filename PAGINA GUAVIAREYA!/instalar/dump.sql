-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: bd_guaviareya
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `administradores`
--

DROP TABLE IF EXISTS `administradores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `administradores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `correo` varchar(50) NOT NULL,
  `apodo` varchar(50) NOT NULL,
  `ID_Restaurante` int(11) DEFAULT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` enum('administrador','super_administrador') NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `img_A` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `correo` (`correo`),
  KEY `FK_Restaurantes_Administradores` (`ID_Restaurante`),
  CONSTRAINT `FK_Restaurantes_Administradores` FOREIGN KEY (`ID_Restaurante`) REFERENCES `restaurantes` (`ID_Restaurante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administradores`
--

LOCK TABLES `administradores` WRITE;
/*!40000 ALTER TABLE `administradores` DISABLE KEYS */;
/*!40000 ALTER TABLE `administradores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cupones`
--

DROP TABLE IF EXISTS `cupones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cupones` (
  `ID_Cupon` int(11) NOT NULL AUTO_INCREMENT,
  `Correo` varchar(50) NOT NULL,
  `Codigo_Cupon` varchar(20) NOT NULL,
  `Descuento` int(11) NOT NULL,
  `Fecha_Expiracion` date NOT NULL,
  `Fecha_Usado` timestamp NULL DEFAULT NULL,
  `Fecha_Creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ID_Cupon`),
  UNIQUE KEY `Codigo_Cupon` (`Codigo_Cupon`),
  KEY `idx_Correo_Cupones` (`Correo`),
  CONSTRAINT `FK_Usuarios_Cupones` FOREIGN KEY (`Correo`) REFERENCES `usuarios` (`Correo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cupones`
--

LOCK TABLES `cupones` WRITE;
/*!40000 ALTER TABLE `cupones` DISABLE KEYS */;
/*!40000 ALTER TABLE `cupones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `direccion_entregas`
--

DROP TABLE IF EXISTS `direccion_entregas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `direccion_entregas` (
  `ID_Dire_Entre` int(11) NOT NULL AUTO_INCREMENT,
  `Correo` varchar(50) NOT NULL,
  `Direccion` varchar(100) NOT NULL,
  `Barrio` varchar(50) NOT NULL,
  `fecha_pedido` timestamp NOT NULL DEFAULT current_timestamp(),
  `Descripcion` varchar(50) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ID_Dire_Entre`),
  KEY `idx_Correo` (`Correo`),
  CONSTRAINT `FK_Usuarios_Direccion_Entregas` FOREIGN KEY (`Correo`) REFERENCES `usuarios` (`Correo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `direccion_entregas`
--

LOCK TABLES `direccion_entregas` WRITE;
/*!40000 ALTER TABLE `direccion_entregas` DISABLE KEYS */;
/*!40000 ALTER TABLE `direccion_entregas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documentos_identificacion`
--

DROP TABLE IF EXISTS `documentos_identificacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `documentos_identificacion` (
  `ID_Documento` int(11) NOT NULL AUTO_INCREMENT,
  `Correo` varchar(50) NOT NULL,
  `Tipo_Documento` enum('DNI','Pasaporte','Licencia','Otro') NOT NULL,
  `Foto_Documento` varchar(255) NOT NULL,
  `Fecha_Subida` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ID_Documento`),
  KEY `idx_Correo_Documentos_Identificacion` (`Correo`),
  CONSTRAINT `FK_Usuarios_Documentos_Identificacion` FOREIGN KEY (`Correo`) REFERENCES `usuarios` (`Correo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documentos_identificacion`
--

LOCK TABLES `documentos_identificacion` WRITE;
/*!40000 ALTER TABLE `documentos_identificacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `documentos_identificacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likes_dislikes`
--

DROP TABLE IF EXISTS `likes_dislikes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `likes_dislikes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Correo` varchar(50) NOT NULL,
  `ID_Restaurante` int(11) NOT NULL,
  `Tipo` enum('like','dislike') NOT NULL,
  `Fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Correo` (`Correo`,`ID_Restaurante`,`Tipo`),
  KEY `FK_Restaurantes_Likes_Dislikes` (`ID_Restaurante`),
  CONSTRAINT `FK_Restaurantes_Likes_Dislikes` FOREIGN KEY (`ID_Restaurante`) REFERENCES `restaurantes` (`ID_Restaurante`),
  CONSTRAINT `FK_Usuarios_Likes_Dislikes` FOREIGN KEY (`Correo`) REFERENCES `usuarios` (`Correo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes_dislikes`
--

LOCK TABLES `likes_dislikes` WRITE;
/*!40000 ALTER TABLE `likes_dislikes` DISABLE KEYS */;
/*!40000 ALTER TABLE `likes_dislikes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metodos_pago`
--

DROP TABLE IF EXISTS `metodos_pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `metodos_pago` (
  `id_pago` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(16) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `expiracion` varchar(4) NOT NULL,
  `cvv` varchar(3) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_pago`),
  KEY `idx_correo_metodos_pago` (`correo`),
  CONSTRAINT `fk_usuarios_metodos_pago` FOREIGN KEY (`correo`) REFERENCES `usuarios` (`Correo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metodos_pago`
--

LOCK TABLES `metodos_pago` WRITE;
/*!40000 ALTER TABLE `metodos_pago` DISABLE KEYS */;
/*!40000 ALTER TABLE `metodos_pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedidos` (
  `ID_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Restaurante` int(11) NOT NULL,
  `ID_Producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `Sub_total` double NOT NULL,
  `ID_Dire_Entre` int(11) NOT NULL,
  `Correo` varchar(50) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `Tipo_Envio` enum('Prioritaria','Básica') NOT NULL DEFAULT 'Básica',
  `Estado` enum('Pendiente','Enviado','Entregado','Cancelado') NOT NULL DEFAULT 'Pendiente',
  `total` double NOT NULL,
  PRIMARY KEY (`ID_pedido`),
  KEY `FK_Direccion_Entregas_Pedidos` (`ID_Dire_Entre`),
  KEY `idx_ID_Restaurante_Pedidos` (`ID_Restaurante`),
  KEY `idx_ID_Producto_Pedidos` (`ID_Producto`),
  KEY `idx_Correo_Pedidos` (`Correo`),
  CONSTRAINT `FK_Direccion_Entregas_Pedidos` FOREIGN KEY (`ID_Dire_Entre`) REFERENCES `direccion_entregas` (`ID_Dire_Entre`),
  CONSTRAINT `FK_Productos_Pedidos` FOREIGN KEY (`ID_Producto`) REFERENCES `productos` (`ID_Producto`),
  CONSTRAINT `FK_Restaurantes_Pedidos` FOREIGN KEY (`ID_Restaurante`) REFERENCES `restaurantes` (`ID_Restaurante`),
  CONSTRAINT `FK_Usuarios_Pedidos` FOREIGN KEY (`Correo`) REFERENCES `usuarios` (`Correo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos`
--

LOCK TABLES `pedidos` WRITE;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `ID_Producto` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Restaurante` int(11) NOT NULL,
  `Nombre_P` varchar(50) NOT NULL,
  `Descripcion` varchar(300) NOT NULL,
  `Valor_P` int(11) NOT NULL,
  `img_P` varchar(200) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ID_Producto`),
  KEY `idx_ID_Restaurante` (`ID_Restaurante`),
  CONSTRAINT `FK_Restaurantes_Productos` FOREIGN KEY (`ID_Restaurante`) REFERENCES `restaurantes` (`ID_Restaurante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `restaurantes`
--

DROP TABLE IF EXISTS `restaurantes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `restaurantes` (
  `ID_Restaurante` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre_R` varchar(50) NOT NULL,
  `Direccion` varchar(50) NOT NULL,
  `Telefono` varchar(15) NOT NULL,
  `img_R` varchar(200) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `Estado` varchar(15) NOT NULL,
  PRIMARY KEY (`ID_Restaurante`),
  UNIQUE KEY `Nombre_R` (`Nombre_R`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restaurantes`
--

LOCK TABLES `restaurantes` WRITE;
/*!40000 ALTER TABLE `restaurantes` DISABLE KEYS */;
/*!40000 ALTER TABLE `restaurantes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `Correo` varchar(50) NOT NULL,
  `Apodo` varchar(50) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Apellido` varchar(50) NOT NULL,
  `Contrasena` varchar(255) NOT NULL,
  `Telefono` varchar(15) NOT NULL,
  `Fec_Regis` timestamp NOT NULL DEFAULT current_timestamp(),
  `img_U` varchar(200) NOT NULL,
  PRIMARY KEY (`Correo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-08-06  1:25:33
