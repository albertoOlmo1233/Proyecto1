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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_pedido`
--

LOCK TABLES `detalle_pedido` WRITE;
/*!40000 ALTER TABLE `detalle_pedido` DISABLE KEYS */;
INSERT INTO `detalle_pedido` VALUES (1,1,1,2),(2,1,1,3),(3,2,3,4),(4,1,3,5),(5,1,3,6),(6,1,4,1),(7,1,4,2),(8,1,4,3),(9,1,6,1),(10,2,6,4),(11,1,7,1),(12,5,7,7),(13,6,7,15),(15,1,3,8);
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
) ENGINE=InnoDB AUTO_INCREMENT=269 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
INSERT INTO `log` VALUES (1,'alberto@ibf.cat','Alberto Olmo Acevedo se ha registrado','2024-12-06 18:07:03'),(2,'alberto@ibf.cat','Alberto Olmo Acevedo ha iniciado sesión.','2024-12-06 18:14:10'),(3,'alberto@ibf.cat','Alberto Olmo Acevedo ha intentado iniciar sesión','2024-12-06 18:14:36'),(4,'alberto@ibf.cat','Alberto Olmo Acevedo ha intentado iniciar sesión','2024-12-06 18:14:47'),(5,'alberto@ibf.cat','Alberto Olmo Acevedo ha iniciado sesión.','2024-12-06 18:16:59'),(6,'alberto@ibf.cat','Albertito Olmo Acevedo ha tramitado un pedido.','2024-12-06 18:24:07'),(7,'alberto@ibf.cat','Albertito Olmo Acevedo ha cerrado sesion.','2024-12-06 18:26:34'),(8,'alberto@ibf.cat','Albertito Olmo Acevedo ha intentado iniciar sesión','2024-12-06 18:26:57'),(9,'alberto@ibf.cat','Albertito Olmo Acevedo ha iniciado sesión.','2024-12-06 18:27:07'),(10,'alberto@ibf.cat','Albertito Olmo Acevedo ha cerrado sesion.','2024-12-06 18:54:18'),(11,'admin@ibf.cat','admin admin ha iniciado sesión.','2024-12-06 18:54:23'),(12,'admin@ibf.cat','admin admin ha cerrado sesion.','2024-12-06 21:43:46'),(13,'alberto@ibf.cat','Albertito Olmo Acevedo ha intentado iniciar sesión','2024-12-06 21:44:22'),(14,'alberto@ibf.cat','Albertito Olmo Acevedo ha iniciado sesión.','2024-12-06 21:44:31'),(15,'alberto@ibf.cat','Albertito Olmo Acevedo ha tramitado un pedido.','2024-12-06 21:44:58'),(16,'alberto@ibf.cat','Albertito Olmo Acevedo ha cerrado sesion.','2024-12-06 21:45:04'),(17,'pancracio@ibf.cat','Pancracio Olmo se ha registrado','2024-12-06 21:45:29'),(18,'pancracio@ibf.cat','Pancracio Olmo ha iniciado sesión.','2024-12-06 21:45:35'),(19,'pancracio@ibf.cat','Pancracio Olmo ha modificado la direccion de entrega.','2024-12-06 21:45:41'),(20,'pancracio@ibf.cat','Pancracio Olmo ha tramitado un pedido.','2024-12-06 21:46:03'),(21,'pancracio@ibf.cat','Pancracio Olmo ha cerrado sesion.','2024-12-06 21:46:20'),(22,'admin@ibf.cat','admin admin ha iniciado sesión.','2024-12-06 21:46:25'),(23,'admin@ibf.cat','admin admin ha iniciado sesión.','2024-12-07 13:26:38'),(24,'admin@ibf.cat','admin admin ha iniciado sesión.','2024-12-15 09:44:39'),(25,'admin@ibf.cat','admin admin ha modificado la direccion de entrega.','2024-12-15 12:03:04'),(26,'admin@ibf.cat','admin admin ha tramitado un pedido.','2024-12-15 12:03:09'),(27,'admin@ibf.cat','admin admin ha cerrado sesion.','2024-12-15 13:51:27'),(28,'alberto@ibf.cat','Albertito Olmo Acevedo ha intentado iniciar sesión','2024-12-15 13:51:32'),(29,'alberto@ibf.cat','Albertito Olmo Acevedo ha iniciado sesión.','2024-12-15 13:51:40'),(30,'alberto@ibf.cat','Albertito Olmo Acevedo ha cerrado sesion.','2024-12-15 13:51:45'),(31,'admin@ibf.cat','admin admin ha iniciado sesión.','2024-12-15 13:51:51'),(32,'admin@ibf.cat','admin admin ha modificado la direccion de entrega.','2024-12-15 14:16:21'),(33,'admin@ibf.cat','admin admin ha modificado la direccion de entrega.','2024-12-15 14:20:32'),(34,'admin@ibf.cat','admin admin ha modificado la direccion de entrega.','2024-12-15 14:31:58'),(35,'admin@ibf.cat','admin admin ha cerrado sesion.','2024-12-15 14:44:40'),(36,'alberto@ibf.cat','Albertito Olmo Acevedo ha iniciado sesión.','2024-12-15 14:44:46'),(37,'admin@ibf.cat','admin admin ha iniciado sesión.','2024-12-15 15:08:23'),(38,'alberto@ibf.cat','Albertito Olmo Acevedo ha cerrado sesion.','2024-12-15 16:11:11'),(39,'admin@ibf.cat','admin admin ha intentado iniciar sesión','2024-12-15 16:11:16'),(40,'admin@ibf.cat','admin admin ha iniciado sesión.','2024-12-15 16:11:23'),(41,'admin@ibf.cat','admin admin ha iniciado sesión.','2024-12-22 16:08:20'),(42,'admin@ibf.cat','admin admin ha cerrado sesion.','2024-12-22 17:27:22'),(43,'admin@ibf.cat','admin admin ha iniciado sesión.','2024-12-22 17:28:17'),(44,'cristiano@ibf.cat','Cristiano Ronaldo se ha registrado.','2024-12-22 17:31:21'),(45,'cristiano@ibf.cat','Cristiano Ronaldo se ha registrado.','2024-12-22 17:34:30'),(46,'cristiano@ibf.cat','Cristiano Ronaldo se ha registrado.','2024-12-22 17:38:01'),(47,'pepe@ibf.cat','Pepe Rodrigez acevedo se ha registrado.','2024-12-22 17:39:57'),(48,'fsfsd@ibf.cat','Xcccccccccccccsd Fsdfdsfsdfsf se ha registrado.','2024-12-22 17:47:36'),(49,'peppa@ibf.cat','Peppa Pig se ha registrado.','2024-12-22 17:48:25'),(50,'gdgdfgdfg@ibf.cat','Dfsdfdfgdfgdfgdfgfdgfdgdfgd Dgdfgdfgfdgfdgdfgd se ha registrado.','2024-12-22 17:51:02'),(51,'enric@ibf.cat','Enric Ruiz se ha registrado.','2024-12-22 17:56:25'),(52,'admin@ibf.cat','admin admin ha intentado iniciar sesión','2024-12-26 10:41:20'),(53,'admin@ibf.cat','admin admin ha iniciado sesión.','2024-12-26 10:41:28'),(54,'admin@ibf.cat','admin admin ha eliminado el usuario con id 4','2024-12-26 10:56:38'),(55,'admin@ibf.cat','admin admin ha eliminado el usuario con id 3','2024-12-26 11:12:13'),(56,'admin@ibf.cat','admin admin ha iniciado sesión.','2024-12-27 17:11:13'),(57,'paco@ibf.cat','Paco Rodrigez acevedo se ha registrado.','2024-12-27 17:12:48'),(58,'admin@ibf.cat','admin admin ha iniciado sesión.','2024-12-28 15:32:49'),(59,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 16:39:24'),(60,'admin@ibf.cat','admin admin ha intentado iniciar sesión','2024-12-28 16:44:31'),(61,'admin@ibf.cat','admin admin ha intentado iniciar sesión','2024-12-28 16:44:39'),(62,'admin@ibf.cat','admin admin ha iniciado sesión.','2024-12-28 16:44:49'),(63,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 17:04:12'),(64,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 17:04:50'),(65,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 17:05:39'),(66,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 17:07:12'),(67,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 17:09:01'),(68,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 17:12:49'),(69,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 17:14:53'),(70,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 17:18:27'),(71,'enric@ibf.cat','El administrador ha creado un usuario','2024-12-28 17:43:24'),(72,'admin@ibf.cat','admin admin ha eliminado el usuario con id 10','2024-12-28 18:00:05'),(73,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 18:03:55'),(74,'admin@ibf.cat','admin admin ha intentado iniciar sesión','2024-12-28 18:50:56'),(75,'admin@ibf.cat','admin admin ha iniciado sesión.','2024-12-28 18:51:04'),(76,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 18:51:20'),(77,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 19:01:21'),(78,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 19:05:34'),(79,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 19:28:35'),(80,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 19:35:50'),(81,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 19:36:00'),(82,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 19:37:12'),(83,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 19:40:30'),(84,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 19:42:52'),(85,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 19:43:43'),(86,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 19:44:44'),(87,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 19:45:03'),(88,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 19:46:31'),(89,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 19:46:51'),(90,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 19:48:21'),(91,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 19:48:26'),(92,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 19:49:26'),(93,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 19:50:37'),(94,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 19:59:59'),(95,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 20:00:37'),(96,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 20:01:33'),(97,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 20:03:48'),(98,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 20:04:37'),(99,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 20:05:14'),(100,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 20:08:30'),(101,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 20:16:35'),(102,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 20:43:49'),(103,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 21:50:55'),(104,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 21:55:14'),(105,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 21:55:21'),(106,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 21:55:36'),(107,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 22:17:40'),(108,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 22:27:01'),(109,'admin@ibf.cat','admin admin ha iniciado sesión.','2024-12-28 22:31:43'),(110,'admin@ibf.cat','admin admin ha iniciado sesión.','2024-12-28 22:39:31'),(111,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 22:45:42'),(112,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 22:53:00'),(113,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 22:54:31'),(114,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 22:54:39'),(115,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 22:57:04'),(116,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 23:56:13'),(117,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 23:57:54'),(118,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-28 23:58:27'),(119,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-29 00:01:11'),(120,'admin@ibf.cat','admin admin ha iniciado sesión.','2024-12-29 09:52:41'),(121,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-29 10:14:37'),(122,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-29 10:19:32'),(123,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-29 10:20:39'),(124,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-29 10:22:19'),(125,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-29 10:30:58'),(126,'admin@ibf.cat','admin admin ha cerrado sesion.','2024-12-29 11:00:25'),(127,'alberto@ibf.cat','Albertito Olmo Acevedo ha iniciado sesión.','2024-12-29 11:00:31'),(128,'alberto@ibf.cat','Albertitoo ha modificado su nombre de usuario.','2024-12-29 11:01:51'),(129,'alberto@ibf.cat','Albertitoo Olmo Acevedo ha modificado su contraseña.','2024-12-29 11:03:32'),(130,'alberto@ibf.cat','Albertitoooo ha modificado su nombre de usuario.','2024-12-29 11:04:47'),(131,'alberto@ibf.cat','Olmo Acevedoo ha modificado su nombre de usuario.','2024-12-29 11:07:17'),(132,'alberto@ibf.cat','Albertitoooo Olmo Acevedoo ha cerrado sesion.','2024-12-29 11:11:11'),(133,'admin@ibf.cat','admin admin ha iniciado sesión.','2024-12-29 11:11:31'),(134,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-29 11:13:48'),(135,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-29 11:17:50'),(136,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2024-12-29 11:18:00'),(137,'admin@ibf.cat','El administrador ha modificado correctamente el correo del usuario.','2024-12-29 11:20:09'),(138,'admin@ibf.cat','El administrador ha modificado correctamente la direccion del usuario.','2024-12-29 11:20:20'),(139,'admin@ibf.cat','El administrador ha modificado correctamente la contraseña del usuario.','2024-12-29 11:20:45'),(140,'admin@ibf.cat','El administrador ha modificado correctamente los apellidos del usuario.','2024-12-29 11:37:06'),(141,'admin@ibf.cat','admin admin ha eliminado el usuario con id 11','2024-12-29 11:40:21'),(142,'peppa@ibf.cat','El administrador ha creado un usuario','2024-12-29 11:41:15'),(143,'admin@ibf.cat','admin admin ha eliminado el usuario con id 12','2024-12-29 11:41:24'),(144,'peppa@ibf.cat','El administrador ha creado un usuario','2024-12-29 11:42:24'),(145,'admin@ibf.cat','admin admin ha eliminado el usuario con id 13','2024-12-29 11:42:28'),(146,'pepe@ibf.cat','El administrador ha creado un usuario','2024-12-29 11:43:27'),(147,'admin@ibf.cat','admin admin ha eliminado el usuario con id 14','2024-12-29 11:43:34'),(148,'pepe@ibf.cat','El administrador ha creado un usuario','2024-12-29 11:46:17'),(149,'admin@ibf.cat','admin admin ha eliminado el usuario con id 15','2024-12-29 11:46:32'),(150,'admin@ibf.cat','admin admin ha intentado eliminar al usuario con id 15','2024-12-29 11:46:36'),(151,'pepe@ibf.cat','El administrador ha creado un usuario','2024-12-29 11:51:05'),(152,'admin@ibf.cat','admin admin ha eliminado el usuario con id 16','2024-12-29 11:51:12'),(153,'admin@ibf.cat','El administrador ha modificado correctamente los apellidos del usuario.','2024-12-29 11:55:39'),(154,'pablo@ibf.cat','El administrador ha creado un usuario','2024-12-29 12:52:55'),(155,'admin@ibf.cat','admin admin ha eliminado el usuario con id 17','2024-12-29 20:32:18'),(156,'pepe@ibf.cat','El administrador ha creado un usuario','2024-12-29 20:32:38'),(157,'admin@ibf.cat','admin admin ha intentado eliminar el usuario con id ','2024-12-29 20:55:33'),(158,'admin@ibf.cat','admin admin ha eliminado el usuario con id ','2024-12-29 20:56:24'),(159,'admin@ibf.cat','admin admin ha eliminado el usuario con id 25','2024-12-29 20:57:23'),(160,'admin@ibf.cat','admin admin ha eliminado el usuario con id 25','2024-12-29 21:00:56'),(161,'admin@ibf.cat','El administrador ha modificado correctamente el nombre del producto con el id 25.','2024-12-29 22:21:11'),(162,'admin@ibf.cat','El administrador ha modificado correctamente el precio del producto con el id 25.','2024-12-29 22:21:22'),(163,'admin@ibf.cat','admin admin ha intentado iniciar sesión','2024-12-30 19:48:35'),(164,'admin@ibf.cat','admin admin ha iniciado sesión.','2024-12-30 19:48:42'),(165,'admin@ibf.cat','admin admin ha intentado iniciar sesión','2024-12-31 13:43:12'),(166,'admin@ibf.cat','admin admin ha iniciado sesión.','2024-12-31 13:43:24'),(167,'admin@ibf.cat','admin admin ha tramitado un pedido.','2024-12-31 14:48:53'),(168,'admin@ibf.cat','admin admin ha tramitado un pedido.','2024-12-31 14:51:20'),(169,'admin@ibf.cat','admin admin ha intentado eliminar el pedido con id 1','2024-12-31 14:53:48'),(170,'admin@ibf.cat','admin admin ha tramitado un pedido.','2024-12-31 14:54:12'),(171,'admin@ibf.cat','admin admin ha eliminado el pedido con id 1','2024-12-31 14:54:21'),(172,'admin@ibf.cat','admin admin ha tramitado un pedido.','2024-12-31 14:54:40'),(173,'admin@ibf.cat','admin admin ha eliminado el pedido con id 1','2024-12-31 14:54:46'),(174,NULL,'  ha cerrado sesion.','2025-01-01 19:03:45'),(175,'admin@ibf.cat','admin admin ha iniciado sesión.','2025-01-01 19:03:53'),(176,'admin@ibf.cat','admin admin ha tramitado un pedido.','2025-01-01 19:07:03'),(177,'admin@ibf.cat','admin admin ha eliminado el pedido con id 2','2025-01-01 21:34:58'),(178,'admin@ibf.cat','admin admin ha eliminado el pedido con id 1','2025-01-01 21:36:16'),(179,'admin@ibf.cat','admin admin ha iniciado sesión.','2025-01-03 18:29:45'),(180,'admin@ibf.cat','admin admin ha eliminado el pedido de 1 con id 1','2025-01-03 18:39:14'),(181,'admin@ibf.cat','admin admin ha tramitado un pedido.','2025-01-03 18:50:07'),(182,'admin@ibf.cat','admin admin ha tramitado un pedido.','2025-01-03 18:50:39'),(183,'admin@ibf.cat','admin admin ha tramitado un pedido.','2025-01-03 18:51:20'),(184,'admin@ibf.cat','admin admin ha tramitado un pedido.','2025-01-03 18:58:06'),(185,'admin@ibf.cat','admin admin ha eliminado el pedido de 1 con id 4','2025-01-03 18:58:16'),(186,'admin@ibf.cat','admin admin ha cerrado sesion.','2025-01-03 19:52:13'),(187,'alberto@ibf.cat','Albertitoooo Ronaldo ha intentado iniciar sesión','2025-01-03 19:52:20'),(188,'alberto@ibf.cat','Albertitoooo Ronaldo ha iniciado sesión.','2025-01-03 19:52:27'),(189,'alberto@ibf.cat','Albertitoooo Ronaldo ha tramitado un pedido.','2025-01-03 19:52:40'),(190,'alberto@ibf.cat','Albertitoooo Ronaldo ha cerrado sesion.','2025-01-03 19:52:42'),(191,'admin@ibf.cat','admin admin ha iniciado sesión.','2025-01-03 19:52:47'),(192,'admin@ibf.cat','admin admin ha iniciado sesión.','2025-01-04 09:32:36'),(193,'admin@ibf.cat','admin admin ha tramitado un pedido.','2025-01-04 12:12:12'),(194,'admin@ibf.cat','admin admin ha intentado iniciar sesión','2025-01-04 18:11:30'),(195,'admin@ibf.cat','admin admin ha iniciado sesión.','2025-01-04 18:11:39'),(196,'admin@ibf.cat','El administrador ha modificado el ID del usuario para el pedido con ID 5.','2025-01-04 21:01:52'),(197,'admin@ibf.cat','El administrador ha modificado el ID del usuario para el pedido con ID 5.','2025-01-04 21:02:49'),(198,'admin@ibf.cat','El administrador ha modificado el ID del usuario para el pedido con ID 5.','2025-01-04 21:05:40'),(199,'admin@ibf.cat','El administrador ha modificado la fecha del pedido con ID 5.','2025-01-04 21:06:13'),(200,'admin@ibf.cat','El administrador ha modificado el ID del usuario para el pedido con ID 3.','2025-01-04 22:06:21'),(201,'admin@ibf.cat','admin admin ha iniciado sesión.','2025-01-05 08:28:03'),(202,'admin@ibf.cat','admin admin ha tramitado un pedido.','2025-01-05 09:30:15'),(203,'admin@ibf.cat','admin admin ha cerrado sesion.','2025-01-05 09:55:25'),(204,'alberto@ibf.cat','Albertitoooo Ronaldo ha iniciado sesión.','2025-01-05 09:55:31'),(205,'alberto@ibf.cat','Albertitoooo Ronaldo ha cerrado sesion.','2025-01-05 10:13:58'),(206,'admin@ibf.cat','admin admin ha iniciado sesión.','2025-01-05 10:14:05'),(207,'prueba@ibf.cat','El administrador ha creado un usuario','2025-01-05 10:22:49'),(208,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2025-01-05 10:23:27'),(209,'admin@ibf.cat','El administrador ha modificado correctamente los apellidos del usuario.','2025-01-05 10:23:27'),(210,'admin@ibf.cat','El administrador ha modificado correctamente la contraseña del usuario.','2025-01-05 10:23:28'),(211,'admin@ibf.cat','El administrador ha modificado correctamente el correo del usuario.','2025-01-05 10:23:28'),(212,'admin@ibf.cat','El administrador ha modificado correctamente la direccion del usuario.','2025-01-05 10:23:28'),(213,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2025-01-05 10:25:06'),(214,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2025-01-05 10:25:18'),(215,'admin@ibf.cat','El administrador ha modificado correctamente los apellidos del usuario.','2025-01-05 10:25:18'),(216,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2025-01-05 10:27:42'),(217,'admin@ibf.cat','El administrador ha modificado correctamente los apellidos del usuario.','2025-01-05 10:27:42'),(218,'admin@ibf.cat','El administrador ha modificado correctamente la contraseña del usuario.','2025-01-05 10:27:42'),(219,'admin@ibf.cat','El administrador ha modificado correctamente el correo del usuario.','2025-01-05 10:27:42'),(220,'admin@ibf.cat','El administrador ha modificado correctamente la direccion del usuario.','2025-01-05 10:27:42'),(221,'admin@ibf.cat','El administrador ha modificado correctamente el nombre de usuario.','2025-01-05 10:31:42'),(222,'admin@ibf.cat','El administrador ha modificado correctamente los apellidos del usuario.','2025-01-05 10:31:42'),(223,'admin@ibf.cat','El administrador ha modificado correctamente la contraseña del usuario.','2025-01-05 10:31:42'),(224,'admin@ibf.cat','El administrador ha modificado correctamente el correo del usuario.','2025-01-05 10:31:42'),(225,'admin@ibf.cat','El administrador ha modificado correctamente la dirección del usuario.','2025-01-05 10:31:42'),(226,'admin@ibf.cat','admin admin ha eliminado el usuario con id 4','2025-01-05 10:36:57'),(227,'admin@ibf.cat','admin admin ha eliminado el producto con id ','2025-01-05 10:41:12'),(228,'admin@ibf.cat','El administrador ha creado un producto','2025-01-05 10:42:42'),(229,'admin@ibf.cat','admin admin ha eliminado el producto con id ','2025-01-05 10:43:02'),(230,'admin@ibf.cat','admin admin ha eliminado el producto con id 28','2025-01-05 10:46:41'),(231,'admin@ibf.cat','El administrador ha modificado correctamente el nombre del producto con el id 27.','2025-01-05 10:47:59'),(232,'admin@ibf.cat','El administrador ha modificado correctamente la descripción del producto con el id 27.','2025-01-05 10:47:59'),(233,'admin@ibf.cat','El administrador ha modificado correctamente el precio del producto con el id 27.','2025-01-05 10:47:59'),(234,'admin@ibf.cat','El administrador ha modificado correctamente el nombre del producto con el id 27.','2025-01-05 10:50:14'),(235,'admin@ibf.cat','El administrador ha modificado correctamente la descripción del producto con el id 27.','2025-01-05 10:50:14'),(236,'admin@ibf.cat','El administrador ha modificado correctamente el precio del producto con el id 27.','2025-01-05 10:50:14'),(237,'admin@ibf.cat','El administrador ha modificado correctamente la categoría del producto con el id 27.','2025-01-05 10:50:14'),(238,'irene@ibf.cat','Irene Guerrero pesquera se ha registrado','2025-01-05 20:51:34'),(239,'irene@ibf.cat','Irene Guerrero pesquera ha iniciado sesión.','2025-01-05 20:51:47'),(240,'admin@ibf.cat','admin admin ha intentado iniciar sesión','2025-01-06 17:55:49'),(241,'admin@ibf.cat','admin admin ha iniciado sesión.','2025-01-06 17:55:56'),(242,'admin@ibf.cat','admin admin ha intentado eliminar el pedido de 2 con id 4','2025-01-06 18:34:02'),(243,'admin@ibf.cat','admin admin ha intentado eliminar el pedido de 2 con id 5','2025-01-06 18:34:23'),(244,'admin@ibf.cat','admin admin ha intentado eliminar el pedido de 1 con id 6','2025-01-06 18:35:39'),(245,'admin@ibf.cat','admin admin ha intentado eliminar el pedido de 3 con id 3','2025-01-06 18:35:50'),(246,'admin@ibf.cat','admin admin ha intentado eliminar el pedido de 3 con id 3','2025-01-06 18:36:22'),(247,'admin@ibf.cat','admin admin ha tramitado un pedido.','2025-01-06 18:36:36'),(248,'admin@ibf.cat','admin admin ha intentado eliminar el pedido de 1 con id 7','2025-01-06 19:12:55'),(249,'admin@ibf.cat','admin admin ha tramitado un pedido.','2025-01-06 19:21:35'),(250,'admin@ibf.cat','admin admin ha intentado eliminar el pedido de 1 con id 8','2025-01-06 19:21:51'),(251,'admin@ibf.cat','admin admin ha tramitado un pedido.','2025-01-06 19:22:06'),(252,'admin@ibf.cat','admin admin ha tramitado un pedido.','2025-01-06 19:22:21'),(253,'admin@ibf.cat','admin admin ha eliminado el pedido de 1 con id 10','2025-01-06 19:45:46'),(254,'admin@ibf.cat','admin admin ha tramitado un pedido.','2025-01-06 19:49:11'),(255,'admin@ibf.cat','admin admin ha tramitado un pedido.','2025-01-06 19:49:17'),(256,'admin@ibf.cat','admin admin ha intentado eliminar el pedido de 1 con id 2','2025-01-06 19:49:23'),(257,'admin@ibf.cat','admin admin ha intentado eliminar el pedido de 1 con id 2','2025-01-06 19:51:03'),(258,'admin@ibf.cat','admin admin ha eliminado el pedido de 1 con id 2','2025-01-06 19:52:04'),(259,'admin@ibf.cat','admin admin ha eliminado el pedido de 1 con id 2','2025-01-06 20:01:14'),(260,'admin@ibf.cat','admin admin ha tramitado un pedido.','2025-01-06 20:09:02'),(261,'admin@ibf.cat','admin admin ha tramitado un pedido.','2025-01-06 20:10:04'),(262,'admin@ibf.cat','admin admin ha tramitado un pedido.','2025-01-06 20:15:55'),(263,'admin@ibf.cat','admin admin ha tramitado un pedido.','2025-01-06 20:18:29'),(264,'admin@ibf.cat','El administrador ha modificado el ID del usuario para el pedido con ID 3.','2025-01-06 20:20:20'),(265,'admin@ibf.cat','El administrador ha modificado el ID del usuario para el pedido con ID 3.','2025-01-06 20:21:48'),(266,'admin@ibf.cat','admin admin ha eliminado el producto con id 27','2025-01-06 20:26:17'),(267,'admin@ibf.cat','admin admin ha eliminado el producto con id 25','2025-01-06 20:39:32'),(268,'admin@ibf.cat','El administrador ha creado un producto','2025-01-06 21:34:35');
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `logs` (
  `id_log` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int DEFAULT NULL,
  `mensaje` varchar(255) DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_log`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
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
  `Fecha` timestamp NOT NULL,
  `id_usuario` int NOT NULL,
  `total_pedido` float DEFAULT NULL,
  PRIMARY KEY (`id_pedido`),
  KEY `id_clientes_idx` (`id_usuario`),
  CONSTRAINT `fk_pedido_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedido`
--

LOCK TABLES `pedido` WRITE;
/*!40000 ALTER TABLE `pedido` DISABLE KEYS */;
INSERT INTO `pedido` VALUES (1,'2025-01-06 20:49:11',1,22.99),(3,'2025-01-06 21:09:02',4,29),(4,'2025-01-06 21:10:04',1,27.5),(6,'2025-01-06 21:15:54',3,18),(7,'2025-01-06 21:18:29',2,74);
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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` VALUES (1,'Smash Burger Clásica','Hamburguesa con carne smash, queso cheddar, lechuga, tomate y salsa especial.',8.5,2,'imagenes/Productos/hamburguesas/hamburguesa 1.webp','Hamburguesa'),(2,'Smash Burger Doble','Doble carne smash, doble queso cheddar, pepinillos y cebolla.',10,NULL,'imagenes/Productos/hamburguesas/hamburguesa 2.webp','Hamburguesa'),(3,'Smash Burger BBQ','Carne smash, queso cheddar, cebolla crujiente y salsa BBQ.',9,NULL,'imagenes/Productos/hamburguesas/hamburguesa 3.webp','Hamburguesa'),(4,'Smash Burger Bacon','Carne smash, queso cheddar, bacon crujiente y salsa especial.',9.5,NULL,'imagenes/Productos/hamburguesas/hamburguesa 4.webp','Hamburguesa'),(5,'Smash Burger Picante','Carne smash, queso pepper jack, jalapeños y salsa picante.',9,NULL,'imagenes/Productos/hamburguesas/hamburguesa 5.webp','Hamburguesa'),(6,'Smash Burger Vegetariana','Hamburguesa vegetariana con queso, lechuga, tomate y salsa especial.',8,NULL,'imagenes/Productos/hamburguesas/hamburguesa 6.webp','Hamburguesa'),(7,'Refresco Coca-Cola','Refresco Coca-Cola en lata (350 ml)',2.5,NULL,'imagenes/Productos/bebidas/bebida 1.webp','Bebida'),(8,'Refresco Pepsi','Refresco Pepsi en lata (350 ml)',2.5,2,'imagenes/Productos/bebidas/bebida 2.webp','Bebida'),(9,'Agua Mineral','Agua mineral embotellada (500 ml)',1.5,NULL,'imagenes/Productos/bebidas/bebida 3.webp','Bebida'),(10,'Jugo de Naranja','Jugo de naranja natural (300 ml)',3,NULL,'imagenes/Productos/bebidas/bebida 4.webp','Bebida'),(11,'Jugo de Manzana','Jugo de manzana natural (300 ml)',3,NULL,'imagenes/Productos/bebidas/bebida 5.webp','Bebida'),(12,'Té Helado','Té helado con limón (300 ml)',2.8,NULL,'imagenes/Productos/bebidas/bebida 6.webp','Bebida'),(13,'Brownie de Chocolate','Brownie de chocolate casero',4,3,'imagenes/Productos/postres/postre 1.webp','Postre'),(14,'Cheesecake','Pastel de queso estilo americano',4.5,NULL,'imagenes/Productos/postres/postre 2.webp','Postre'),(15,'Helado de Vainilla','Helado de vainilla en copa',3,NULL,'imagenes/Productos/postres/postre 3.webp','Postre'),(16,'Tarta de Manzana','Tarta de manzana con canela',4.2,NULL,'imagenes/Productos/postres/postre 4.webp','Postre'),(17,'Mousse de Chocolate','Mousse de chocolate con crema',4.8,NULL,'imagenes/Productos/postres/postre 5.webp','Postre'),(18,'Flan de Caramelo','Flan casero con caramelo',3.5,NULL,'imagenes/Productos/postres/postre 6.webp','Postre'),(19,'Clásicas','Patatas fritas con sal',2.5,NULL,'imagenes/Productos/patatas/patata 1.webp','Patata'),(20,'Gajo','Patatas gajo con especias',3,NULL,'imagenes/Productos/patatas/patata 2.webp','Patata'),(21,'Queso','Patatas fritas con salsa de queso',3.5,NULL,'imagenes/Productos/patatas/patata 3.webp','Patata'),(22,'Bacon & Queso','Patatas fritas con bacon y salsa de queso',4,2,'imagenes/Productos/patatas/patata 4.webp','Patata'),(23,'Deluxe','Patatas fritas estilo deluxe',3.2,NULL,'imagenes/Productos/patatas/patata 5.webp','Patata'),(24,'Rústicas','Patatas rústicas con especias',3.3,NULL,'imagenes/Productos/patatas/patata 6.webp','Patata'),(25,'Pepe','Te quiero jajaja',3.5,NULL,'imagenes/Productos/postres/postre 8.webp','Postre');
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'admin','admin','admin@ibf.cat','$2y$10$vRyqQRKjQEVzBF4pinsCXuQNz35UTmWInXVfeXzCOpL/PASOY2qta','34242','Admin'),(2,'Albertitoooo','Ronaldo','alberto@ibf.cat','$2y$10$Q5HwcZaX4l9Mu75xJgzjde9Q79yT43czFYR444PYqrgfhsjfdsl6a','1234 prueba','Cliente'),(3,'Pepe','Ronaldo','pepe@ibf.cat','$2y$10$EQLGTrQ62FXdkfzqiGb5ROsX3g20QW4lEhLRimtokuLHbcnLBdzkm','Prueba 123','Cliente'),(4,'Irene','Guerrero pesquera','irene@ibf.cat','$2y$10$hdHO94Lnc4U84ijUNAObzO/Oj3HLm5pPvVlvo5DxlKyMl1liQLdsi',NULL,'Cliente');
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

-- Dump completed on 2025-01-07  1:52:17
