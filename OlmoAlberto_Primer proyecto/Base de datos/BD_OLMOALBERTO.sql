-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: OlmoAlberto_BD_Proyecto1
-- ------------------------------------------------------
-- Server version	9.1.0

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
-- Table structure for table `cantidad_ingredientes`
--

DROP TABLE IF EXISTS `cantidad_ingredientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cantidad_ingredientes` (
  `id_cingrediente` int NOT NULL AUTO_INCREMENT,
  `cantidad` int NOT NULL,
  `id_producto` int NOT NULL,
  `id_ingrediente` int NOT NULL,
  PRIMARY KEY (`id_cingrediente`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cantidad_ingredientes`
--

LOCK TABLES `cantidad_ingredientes` WRITE;
/*!40000 ALTER TABLE `cantidad_ingredientes` DISABLE KEYS */;
INSERT INTO `cantidad_ingredientes` VALUES (1,1,1,1),(2,1,1,3),(3,1,1,5),(4,1,1,6),(5,2,2,1),(6,2,2,3),(7,1,2,7),(8,1,2,8),(9,1,3,1),(10,1,3,3),(11,1,3,9),(12,1,3,10),(13,1,4,1),(14,1,4,3),(15,1,4,11),(16,1,4,12),(17,1,5,1),(18,1,5,13),(19,1,5,14),(20,1,5,15),(21,1,6,16),(22,1,6,3),(23,1,6,5),(24,1,6,6),(25,1,6,12),(26,1,19,17),(27,1,19,18),(28,1,19,19),(29,1,19,20),(30,1,19,21),(31,1,19,22),(32,1,20,17),(33,1,20,18),(34,1,20,19),(35,1,20,20),(36,1,20,21),(37,1,20,22),(38,1,21,17),(39,1,21,18),(40,1,21,19),(41,1,21,20),(42,1,21,21),(43,1,21,22),(44,1,22,17),(45,1,22,18),(46,1,22,19),(47,1,22,20),(48,1,22,21),(49,1,22,22),(50,1,23,17),(51,1,23,18),(52,1,23,19),(53,1,23,20),(54,1,23,21),(55,1,23,22),(56,1,24,17),(57,1,24,18),(58,1,24,19),(59,1,24,20),(60,1,24,21),(61,1,24,22);
/*!40000 ALTER TABLE `cantidad_ingredientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_pedido`
--

DROP TABLE IF EXISTS `detalle_pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_pedido` (
  `id_dpedido` int NOT NULL AUTO_INCREMENT,
  `cantidad` int NOT NULL,
  `id_pedido` int NOT NULL,
  `id_producto` int NOT NULL,
  PRIMARY KEY (`id_dpedido`),
  KEY `id_pedido_idx` (`id_pedido`),
  KEY `id_productos_idx` (`id_producto`),
  CONSTRAINT `fk_detallePedido_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`),
  CONSTRAINT `fk_detallePedido_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_pedido`
--

LOCK TABLES `detalle_pedido` WRITE;
/*!40000 ALTER TABLE `detalle_pedido` DISABLE KEYS */;
INSERT INTO `detalle_pedido` VALUES (2,1,2,1),(3,1,2,20),(4,1,2,8),(5,1,2,15),(6,1,3,1),(7,1,3,3),(8,1,3,7);
/*!40000 ALTER TABLE `detalle_pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingrediente`
--

DROP TABLE IF EXISTS `ingrediente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ingrediente` (
  `id_ingrediente` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `precio` float DEFAULT NULL,
  PRIMARY KEY (`id_ingrediente`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingrediente`
--

LOCK TABLES `ingrediente` WRITE;
/*!40000 ALTER TABLE `ingrediente` DISABLE KEYS */;
INSERT INTO `ingrediente` VALUES (1,'Carne',1.5),(2,'Bacon',1),(3,'Queso cheddar',0.5),(4,'Cebolla caramelizada',0.5),(5,'Lechuga',0.5),(6,'Tomate',0.7),(7,'Pepinillos',0.35),(8,'Cebolla',0.5),(9,'Cebolla crujiente',0.7),(10,'Salsa BBQ',0.5),(11,'Bacon crujiente',1),(12,'Salsa especial',0.65),(13,'Queso pepper jack',0.75),(14,'Jalapeños',0.45),(15,'Salsa picante',0.7),(16,'Carne vegetariana',2),(17,'Mayonesa',0.45),(18,'Ketchup',0.45),(19,'Mostaza',0.45),(20,'Salsa de queso',0.65),(21,'Bacon crujiente',1.2),(22,'Salsa deluxe',0.7);
/*!40000 ALTER TABLE `ingrediente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `log` (
  `id_log` int NOT NULL AUTO_INCREMENT,
  `correo` varchar(255) DEFAULT NULL,
  `mensaje` varchar(255) DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_log`),
  KEY `id_usuario` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
INSERT INTO `log` VALUES (1,'alberto@ibf.cat','Alberto Olmo Acevedo se ha registrado','2024-12-06 18:07:03'),(2,'alberto@ibf.cat','Alberto Olmo Acevedo ha iniciado sesión.','2024-12-06 18:14:10'),(3,'alberto@ibf.cat','Alberto Olmo Acevedo ha intentado iniciar sesión','2024-12-06 18:14:36'),(4,'alberto@ibf.cat','Alberto Olmo Acevedo ha intentado iniciar sesión','2024-12-06 18:14:47'),(5,'alberto@ibf.cat','Alberto Olmo Acevedo ha iniciado sesión.','2024-12-06 18:16:59'),(6,'alberto@ibf.cat','Albertito Olmo Acevedo ha tramitado un pedido.','2024-12-06 18:24:07'),(7,'alberto@ibf.cat','Albertito Olmo Acevedo ha cerrado sesion.','2024-12-06 18:26:34'),(8,'alberto@ibf.cat','Albertito Olmo Acevedo ha intentado iniciar sesión','2024-12-06 18:26:57'),(9,'alberto@ibf.cat','Albertito Olmo Acevedo ha iniciado sesión.','2024-12-06 18:27:07');
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modificar_ingredientes`
--

DROP TABLE IF EXISTS `modificar_ingredientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `modificar_ingredientes` (
  `id_mingrediente` int NOT NULL AUTO_INCREMENT,
  `cantidad` int NOT NULL,
  `id_dpedido` int NOT NULL,
  `id_ingrediente` int NOT NULL,
  PRIMARY KEY (`id_mingrediente`),
  KEY `id_oferta` (`id_mingrediente`) /*!80000 INVISIBLE */,
  KEY `id_dpedido` (`id_dpedido`),
  KEY `fk_ingrediente_producto` (`id_ingrediente`),
  CONSTRAINT `fk_ingrediente_producto` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingrediente` (`id_ingrediente`),
  CONSTRAINT `id_dpedido` FOREIGN KEY (`id_dpedido`) REFERENCES `detalle_pedido` (`id_dpedido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modificar_ingredientes`
--

LOCK TABLES `modificar_ingredientes` WRITE;
/*!40000 ALTER TABLE `modificar_ingredientes` DISABLE KEYS */;
/*!40000 ALTER TABLE `modificar_ingredientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oferta`
--

DROP TABLE IF EXISTS `oferta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oferta` (
  `id_oferta` int NOT NULL AUTO_INCREMENT,
  `categoria` varchar(45) NOT NULL,
  `porcentaje` int NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_final` date NOT NULL,
  PRIMARY KEY (`id_oferta`),
  KEY `id_oferta` (`id_oferta`) /*!80000 INVISIBLE */
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oferta`
--

LOCK TABLES `oferta` WRITE;
/*!40000 ALTER TABLE `oferta` DISABLE KEYS */;
INSERT INTO `oferta` VALUES (1,'3x2',33,'2024-11-10','2024-11-30'),(2,'2x1',50,'2024-11-12','2024-11-25'),(3,'4x2',50,'2024-11-15','2024-11-23');
/*!40000 ALTER TABLE `oferta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedido`
--

DROP TABLE IF EXISTS `pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedido` (
  `id_pedido` int NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `id_usuario` int NOT NULL,
  `total_pedido` float DEFAULT NULL,
  PRIMARY KEY (`id_pedido`),
  KEY `id_clientes_idx` (`id_usuario`),
  CONSTRAINT `fk_pedido_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedido`
--

LOCK TABLES `pedido` WRITE;
/*!40000 ALTER TABLE `pedido` DISABLE KEYS */;
INSERT INTO `pedido` VALUES (2,'2024-12-06',2,20.57),(3,'2024-12-06',2,24.2);
/*!40000 ALTER TABLE `pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto` (
  `id_producto` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` float NOT NULL,
  `id_oferta` int DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `categoria` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_producto`),
  KEY `fk_producto_oferta` (`id_oferta`),
  CONSTRAINT `fk_producto_oferta` FOREIGN KEY (`id_oferta`) REFERENCES `oferta` (`id_oferta`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` VALUES (1,'Smash Burger Clásica','Hamburguesa con carne smash, queso cheddar, lechuga, tomate y salsa especial.',8.5,2,'imagenes/Productos/hamburguesas/hamburguesa 1.webp','Hamburguesa'),(2,'Smash Burger Doble','Doble carne smash, doble queso cheddar, pepinillos y cebolla.',10,NULL,'imagenes/Productos/hamburguesas/hamburguesa 2.webp','Hamburguesa'),(3,'Smash Burger BBQ','Carne smash, queso cheddar, cebolla crujiente y salsa BBQ.',9,NULL,'imagenes/Productos/hamburguesas/hamburguesa 3.webp','Hamburguesa'),(4,'Smash Burger Bacon','Carne smash, queso cheddar, bacon crujiente y salsa especial.',9.5,NULL,'imagenes/Productos/hamburguesas/hamburguesa 4.webp','Hamburguesa'),(5,'Smash Burger Picante','Carne smash, queso pepper jack, jalapeños y salsa picante.',9,NULL,'imagenes/Productos/hamburguesas/hamburguesa 5.webp','Hamburguesa'),(6,'Smash Burger Vegetariana','Hamburguesa vegetariana con queso, lechuga, tomate y salsa especial.',8,NULL,'imagenes/Productos/hamburguesas/hamburguesa 6.webp','Hamburguesa'),(7,'Refresco Coca-Cola','Refresco Coca-Cola en lata (350 ml)',2.5,NULL,'imagenes/Productos/bebidas/bebida 1.webp','Bebida'),(8,'Refresco Pepsi','Refresco Pepsi en lata (350 ml)',2.5,2,'imagenes/Productos/bebidas/bebida 2.webp','Bebida'),(9,'Agua Mineral','Agua mineral embotellada (500 ml)',1.5,NULL,'imagenes/Productos/bebidas/bebida 3.webp','Bebida'),(10,'Jugo de Naranja','Jugo de naranja natural (300 ml)',3,NULL,'imagenes/Productos/bebidas/bebida 4.webp','Bebida'),(11,'Jugo de Manzana','Jugo de manzana natural (300 ml)',3,NULL,'imagenes/Productos/bebidas/bebida 5.webp','Bebida'),(12,'Té Helado','Té helado con limón (300 ml)',2.8,NULL,'imagenes/Productos/bebidas/bebida 6.webp','Bebida'),(13,'Brownie de Chocolate','Brownie de chocolate casero',4,3,'imagenes/Productos/postres/postre 1.webp','Postre'),(14,'Cheesecake','Pastel de queso estilo americano',4.5,NULL,'imagenes/Productos/postres/postre 2.webp','Postre'),(15,'Helado de Vainilla','Helado de vainilla en copa',3,NULL,'imagenes/Productos/postres/postre 3.webp','Postre'),(16,'Tarta de Manzana','Tarta de manzana con canela',4.2,NULL,'imagenes/Productos/postres/postre 4.webp','Postre'),(17,'Mousse de Chocolate','Mousse de chocolate con crema',4.8,NULL,'imagenes/Productos/postres/postre 5.webp','Postre'),(18,'Flan de Caramelo','Flan casero con caramelo',3.5,NULL,'imagenes/Productos/postres/postre 6.webp','Postre'),(19,'Clásicas','Patatas fritas con sal',2.5,NULL,'imagenes/Productos/patatas/patata 1.webp','Patata'),(20,'Gajo','Patatas gajo con especias',3,NULL,'imagenes/Productos/patatas/patata 2.webp','Patata'),(21,'Queso','Patatas fritas con salsa de queso',3.5,NULL,'imagenes/Productos/patatas/patata 3.webp','Patata'),(22,'Bacon & Queso','Patatas fritas con bacon y salsa de queso',4,2,'imagenes/Productos/patatas/patata 4.webp','Patata'),(23,'Deluxe','Patatas fritas estilo deluxe',3.2,NULL,'imagenes/Productos/patatas/patata 5.webp','Patata'),(24,'Rústicas','Patatas rústicas con especias',3.3,NULL,'imagenes/Productos/patatas/patata 6.webp','Patata');
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `apellidos` varchar(45) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `direccion` text,
  `rol` varchar(45) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `correo_UNIQUE` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'admin','admin','admin@ibf.cat','$2y$10$vRyqQRKjQEVzBF4pinsCXuQNz35UTmWInXVfeXzCOpL/PASOY2qta',NULL,'Admin'),(2,'Albertito','Olmo Acevedo','alberto@ibf.cat','$2y$10$hMF5JmjQDPUizojGz3ujgekAnpxBOkFKuDGYcmBf1ei0ctlsjbiX2','1234 prueba','Cliente');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-06 19:28:08
