-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-06-2025 a las 08:02:10
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
-- Base de datos: `todocamisetas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `camisetas`
--

CREATE TABLE `camisetas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `club` varchar(100) DEFAULT NULL,
  `pais` varchar(100) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL CHECK (`precio` > 0),
  `detalles` text DEFAULT NULL,
  `codigo_producto` varchar(30) NOT NULL,
  `precio_oferta` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `camisetas`
--

INSERT INTO `camisetas` (`id`, `titulo`, `club`, `pais`, `tipo`, `color`, `precio`, `detalles`, `codigo_producto`, `precio_oferta`) VALUES
(1, 'Camiseta Barcelona', 'FC Barcelona', 'España', 'Local', 'Azulgrana', 79.99, 'Camiseta oficial del Barcelona', 'BCN001', 59.99),
(2, 'Camiseta Real Madrid', 'Real Madrid', 'España', 'Visitante', 'Blanco', 89.99, 'Camiseta oficial del Real Madrid', 'RM001', 69.99),
(3, 'Camiseta Manchester United', 'Manchester United', 'Inglaterra', 'Local', 'Rojo', 75.00, 'Camiseta oficial del Manchester United', 'MU001', 60.00),
(4, 'Camiseta Juventus', 'Juventus', 'Italia', 'Visitante', 'Negro', 85.00, 'Camiseta oficial de la Juventus', 'JUVE001', 70.00),
(5, 'Camiseta PSG', 'Paris Saint-Germain', 'Francia', 'Local', 'Azul', 95.00, 'Camiseta oficial del PSG', 'PSG001', 75.00),
(6, 'Camiseta Bayern Munich', 'Bayern Munich', 'Alemania', 'Local', 'Rojo', 80.00, 'Camiseta oficial del Bayern', 'BYN001', 65.00),
(7, 'Camiseta Boca Juniors', 'Boca Juniors', 'Argentina', 'Local', 'Amarillo y Azul', 70.00, 'Camiseta oficial de Boca', 'BOCA001', 55.00),
(8, 'Camiseta River Plate', 'River Plate', 'Argentina', 'Visitante', 'Blanco y Rojo', 85.00, 'Camiseta oficial de River Plate', 'RIVER001', 67.00),
(9, 'Camiseta Chivas', 'Chivas', 'México', 'Local', 'Rojo y Blanco', 65.00, 'Camiseta oficial de Chivas', 'CHIVAS001', 50.00),
(10, 'Camiseta Flamengo', 'Flamengo', 'Brasil', 'Local', 'Rojo y Negro', 72.00, 'Camiseta oficial de Flamengo', 'FLAM001', 58.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `camiseta_tallas`
--

CREATE TABLE `camiseta_tallas` (
  `id` int(11) NOT NULL,
  `camiseta_id` int(11) NOT NULL,
  `talla_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `camiseta_tallas`
--

INSERT INTO `camiseta_tallas` (`id`, `camiseta_id`, `talla_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 2, 3),
(5, 2, 4),
(6, 3, 2),
(7, 3, 3),
(8, 4, 4),
(9, 4, 5),
(10, 5, 1),
(11, 5, 2),
(12, 6, 3),
(13, 6, 4),
(15, 7, 2),
(14, 7, 5),
(16, 8, 4),
(17, 8, 5),
(18, 9, 1),
(19, 9, 2),
(20, 10, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre_comercial` varchar(100) NOT NULL,
  `rut` varchar(20) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `categoria` enum('regular','premium','vip') NOT NULL,
  `contacto_nombre` varchar(100) DEFAULT NULL,
  `contacto_email` varchar(100) DEFAULT NULL,
  `porcentaje_oferta` decimal(5,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre_comercial`, `rut`, `direccion`, `categoria`, `contacto_nombre`, `contacto_email`, `porcentaje_oferta`) VALUES
(1, 'Tienda Futbol', '12345678-9', 'Av. Siempre Viva 123', 'regular', 'Juan Pérez', 'juan@tiendafutbol.cl', 10.00),
(2, 'Camisetas Store', '98765432-1', 'Calle Falsa 456', 'premium', 'Maria Gómez', 'maria@camisetasstore.cl', 15.00),
(3, 'Deportes Chile', '13579246-3', 'Calle Central 789', 'vip', 'Pedro Fernández', 'pedro@deporteschile.cl', 20.00),
(4, 'Futbol Mania', '24681357-0', 'Av. Libertador 101', 'regular', 'Laura González', 'laura@futbolmania.cl', 5.00),
(5, 'Camisetas Fanaticos', '54321678-9', 'Calle del Sol 123', 'premium', 'Carlos Torres', 'carlos@fanaticos.cl', 25.00),
(6, 'Red Sports', '45678901-2', 'Calle 2 Norte 456', 'vip', 'Ana Martínez', 'ana@redsports.cl', 30.00),
(7, 'Futbol World', '87654321-0', 'Calle de la Paz 101', 'regular', 'Luis Pérez', 'luis@futbolworld.cl', 8.00),
(8, 'Mega Camisetas', '11223344-5', 'Calle Nueva 234', 'premium', 'Raúl Sánchez', 'raul@megacamisetas.cl', 12.00),
(9, 'Camisetas Pro', '22334455-6', 'Calle Real 345', 'vip', 'Elena Rodríguez', 'elena@camisetaspro.cl', 18.00),
(10, 'Futbol Total', '99887766-7', 'Av. Los Deportes 555', 'regular', 'Jorge Herrera', 'jorge@futboltotal.cl', 7.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tallas`
--

CREATE TABLE `tallas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tallas`
--

INSERT INTO `tallas` (`id`, `nombre`) VALUES
(3, 'L'),
(8, 'L-2'),
(2, 'M'),
(7, 'M-2'),
(1, 'S'),
(9, 'S-2'),
(4, 'XL'),
(10, 'XL-2'),
(6, 'XS'),
(5, 'XXL');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `camisetas`
--
ALTER TABLE `camisetas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo_producto` (`codigo_producto`);

--
-- Indices de la tabla `camiseta_tallas`
--
ALTER TABLE `camiseta_tallas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `camiseta_id` (`camiseta_id`,`talla_id`),
  ADD KEY `talla_id` (`talla_id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rut` (`rut`);

--
-- Indices de la tabla `tallas`
--
ALTER TABLE `tallas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `camisetas`
--
ALTER TABLE `camisetas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `camiseta_tallas`
--
ALTER TABLE `camiseta_tallas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `tallas`
--
ALTER TABLE `tallas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `camiseta_tallas`
--
ALTER TABLE `camiseta_tallas`
  ADD CONSTRAINT `camiseta_tallas_ibfk_1` FOREIGN KEY (`camiseta_id`) REFERENCES `camisetas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `camiseta_tallas_ibfk_2` FOREIGN KEY (`talla_id`) REFERENCES `tallas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
