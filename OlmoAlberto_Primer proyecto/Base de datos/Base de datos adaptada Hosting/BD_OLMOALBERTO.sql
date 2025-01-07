-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: sql305.infinityfree.com
-- Tiempo de generación: 06-01-2025 a las 19:48:47
-- Versión del servidor: 10.6.19-MariaDB
-- Versión de PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `if0_38043594_db_olmo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` mediumtext NOT NULL,
  `precio` float NOT NULL,
  `id_oferta` int(11) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `categoria` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre`, `descripcion`, `precio`, `id_oferta`, `imagen`, `categoria`) VALUES
(1, 'Smash Burger Clasica', 'Hamburguesa con carne smash, queso cheddar, lechuga, tomate y salsa especial.', 8.5, 2, 'imagenes/Productos/hamburguesas/hamburguesa 1.webp', 'Hamburguesa'),
(2, 'Smash Burger Doble', 'Doble carne smash, doble queso cheddar, pepinillos y cebolla.', 10, NULL, 'imagenes/Productos/hamburguesas/hamburguesa 2.webp', 'Hamburguesa'),
(3, 'Smash Burger BBQ', 'Carne smash, queso cheddar, cebolla crujiente y salsa BBQ.', 9, NULL, 'imagenes/Productos/hamburguesas/hamburguesa 3.webp', 'Hamburguesa'),
(4, 'Smash Burger Bacon', 'Carne smash, queso cheddar, bacon crujiente y salsa especial.', 9.5, NULL, 'imagenes/Productos/hamburguesas/hamburguesa 4.webp', 'Hamburguesa'),
(5, 'Smash Burger Picante', 'Carne smash, queso pepper jack, jalapeños y salsa picante.', 9, NULL, 'imagenes/Productos/hamburguesas/hamburguesa 5.webp', 'Hamburguesa'),
(6, 'Smash Burger Vegetariana', 'Hamburguesa vegetariana con queso, lechuga, tomate y salsa especial.', 8, NULL, 'imagenes/Productos/hamburguesas/hamburguesa 6.webp', 'Hamburguesa'),
(7, 'Refresco Coca-Cola', 'Refresco Coca-Cola en lata (350 ml)', 2.5, NULL, 'imagenes/Productos/bebidas/bebida 1.webp', 'Bebida'),
(8, 'Refresco Pepsi', 'Refresco Pepsi en lata (350 ml)', 2.5, 2, 'imagenes/Productos/bebidas/bebida 2.webp', 'Bebida'),
(9, 'Agua Mineral', 'Agua mineral embotellada (500 ml)', 1.5, NULL, 'imagenes/Productos/bebidas/bebida 3.webp', 'Bebida'),
(10, 'Jugo de Naranja', 'Jugo de naranja natural (300 ml)', 3, NULL, 'imagenes/Productos/bebidas/bebida 4.webp', 'Bebida'),
(11, 'Jugo de Manzana', 'Jugo de manzana natural (300 ml)', 3, NULL, 'imagenes/Productos/bebidas/bebida 5.webp', 'Bebida'),
(12, 'Te Helado', 'Te helado con limon (300 ml)', 2.8, NULL, 'imagenes/Productos/bebidas/bebida 6.webp', 'Bebida'),
(13, 'Brownie de Chocolate', 'Brownie de chocolate casero', 4, 3, 'imagenes/Productos/postres/postre 1.webp', 'Postre'),
(14, 'Cheesecake', 'Pastel de queso estilo americano', 4.5, NULL, 'imagenes/Productos/postres/postre 2.webp', 'Postre'),
(15, 'Helado de Vainilla', 'Helado de vainilla en copa', 3, NULL, 'imagenes/Productos/postres/postre 3.webp', 'Postre'),
(16, 'Tarta de Manzana', 'Tarta de manzana con canela', 4.2, NULL, 'imagenes/Productos/postres/postre 4.webp', 'Postre'),
(17, 'Mousse de Chocolate', 'Mousse de chocolate con crema', 4.8, NULL, 'imagenes/Productos/postres/postre 5.webp', 'Postre'),
(18, 'Flan de Caramelo', 'Flan casero con caramelo', 3.5, NULL, 'imagenes/Productos/postres/postre 6.webp', 'Postre'),
(19, 'Clasicas', 'Patatas fritas con sal', 2.5, NULL, 'imagenes/Productos/patatas/patata 1.webp', 'Patata'),
(20, 'Gajo', 'Patatas gajo con especias', 3, NULL, 'imagenes/Productos/patatas/patata 2.webp', 'Patata'),
(21, 'Queso', 'Patatas fritas con salsa de queso', 3.5, NULL, 'imagenes/Productos/patatas/patata 3.webp', 'Patata'),
(22, 'Bacon & Queso', 'Patatas fritas con bacon y salsa de queso', 4, 2, 'imagenes/Productos/patatas/patata 4.webp', 'Patata'),
(23, 'Deluxe', 'Patatas fritas estilo deluxe', 3.2, NULL, 'imagenes/Productos/patatas/patata 5.webp', 'Patata'),
(24, 'Rusticas', 'Patatas rusticas con especias', 3.3, NULL, 'imagenes/Productos/patatas/patata 6.webp', 'Patata'),
(25, 'Aguardentaos murcianos', 'Dulce navideño tipico de la Region de Murcia', 3.5, NULL, 'imagenes/Productos/postres/postre 7.webp', 'Postre');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `fk_producto_oferta` (`id_oferta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_oferta` FOREIGN KEY (`id_oferta`) REFERENCES `oferta` (`id_oferta`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
