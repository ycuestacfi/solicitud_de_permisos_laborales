-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-01-2025 a las 22:45:58
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
-- Base de datos: `solicitud_permisos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE departamentos (
  id_departamento INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nombre_departamento VARCHAR(100) NOT NULL,
  id_lider INT DEFAULT NULL,  -- La columna id_lider en departamentos debe ser del mismo tipo que id_usuario
  CONSTRAINT fk_lider FOREIGN KEY (id_lider) REFERENCES usuarios(id_usuario)  ON DELETE SET NULL
); ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id_departamento`, `nombre_departamento`, `id_lider`) VALUES
(1, 'Tecnología Informática', 1),
(2, 'Academicas', NULL),
(3, 'Almacen y logistica', NULL),
(4, 'Big bag', NULL),
(5, 'Calidad', NULL),
(6, 'Comercial', NULL),
(7, 'Contabilidad', NULL),
(8, 'Desarrollo de producto', NULL),
(9, 'Producción', NULL),
(10, 'Talento Humano', NULL),
(11, 'Administracion', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_solicitudes`
--

CREATE TABLE `historial_solicitudes` (
  `id_historial` int(11) NOT NULL,
  `id_solicitud` int(11) NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `fecha_permiso` date NOT NULL,
  `estado` text NOT NULL,
  `fecha_cambio` timestamp NOT NULL DEFAULT current_timestamp(),
  `identificador_solicitud` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id_solicitud` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `cedula` varchar(16) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `fecha_solicitud` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_permiso` date NOT NULL,
  `hora_salida` time NOT NULL,
  `hora_ingreso` time NOT NULL,
  `observaciones` text DEFAULT NULL,
  `estado` varchar(50) NOT NULL DEFAULT 'pendiente',
  `ultima_modificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `identificador_solicitud` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`id_solicitud`, `nombre`, `cedula`, `correo`, `id_departamento`, `fecha_solicitud`, `fecha_permiso`, `hora_salida`, `hora_ingreso`, `observaciones`, `estado`, `ultima_modificacion`, `identificador_solicitud`) VALUES
(2, 'Yeffer Cuesta', '1078460223', 'yecuesta@providenciacfi.com', 1, '2025-01-18 21:34:08', '2025-01-20', '09:00:00', '13:00:00', 'Necesito permiso para una cita médica.', 'pendiente', '2025-01-18 21:34:08', 'SOL-000001');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `cedula` varchar(16) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `id_departamento` int(11) DEFAULT NULL,
  `rol` enum('solicitante','lider_aprobador','administrador','seguridad','TI') NOT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `cedula`, `nombre`, `apellido`, `usuario`, `contrasena`, `correo`, `id_departamento`, `rol`, `estado`) VALUES
(1, '1078460223', 'yeffer', 'cuesta mena', 'ycuesta', '78d01695043d2c2fa35561ab3f4b663aaf8332cac666f0d59124a0ace3b49f4e5f003997c7168c67a5dac2bf68a54c786d91d30763c173edda3c799b3eae4977', 'ycuesta@providenciacfi.com', 1, 'administrador', 'activo'),
(2, '123456789', 'Juan', 'Perez', 'juanperez', '78d01695043d2c2fa35561ab3f4b663aaf8332cac666f0d59124a0ace3b49f4e5f003997c7168c67a5dac2bf68a54c786d91d30763c173edda3c799b3eae4977', 'juanperez@example.com', 1, 'solicitante', 'activo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id_departamento`);

--
-- Indices de la tabla `historial_solicitudes`
--
ALTER TABLE `historial_solicitudes`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `fk_historial_solicitud` (`id_solicitud`),
  ADD KEY `fk_historial_departamento` (`id_departamento`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`id_solicitud`),
  ADD UNIQUE KEY `identificador_solicitud` (`identificador_solicitud`),
  ADD KEY `fk_solicitud_departamento` (`id_departamento`),
  ADD KEY `fk_solicitud_usuario` (`cedula`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `cedula` (`cedula`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `fk_usuario_departamento` (`id_departamento`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `historial_solicitudes`
--
ALTER TABLE `historial_solicitudes`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `historial_solicitudes`
--
ALTER TABLE `historial_solicitudes`
  ADD CONSTRAINT `fk_historial_departamento` FOREIGN KEY (`id_departamento`) REFERENCES `departamentos` (`id_departamento`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_historial_solicitud` FOREIGN KEY (`id_solicitud`) REFERENCES `solicitudes` (`id_solicitud`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD CONSTRAINT `fk_solicitud_departamento` FOREIGN KEY (`id_departamento`) REFERENCES `departamentos` (`id_departamento`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_solicitud_usuario` FOREIGN KEY (`cedula`) REFERENCES `usuarios` (`cedula`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuario_departamento` FOREIGN KEY (`id_departamento`) REFERENCES `departamentos` (`id_departamento`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
