-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-10-2024 a las 23:21:54
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `prueba`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `id_departamento` int(11) NOT NULL,
  `nombre_departamento` varchar(100) NOT NULL,
  `id_lider` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id_departamento`, `nombre_departamento`, `id_lider`) VALUES
(1, 'Tecnología Informática', NULL),
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
  `estado_anterior` enum('pendiente','aprobada','rechazada') DEFAULT NULL,
  `estado_nuevo` enum('pendiente','aprobada','rechazada') DEFAULT NULL,
  `fecha_cambio` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas_solicitudes`
--

CREATE TABLE `respuestas_solicitudes` (
  `id_respuesta` int(11) NOT NULL,
  `id_solicitud` int(11) NOT NULL,
  `id_lider_aprobador` int(11) NOT NULL,
  `respuesta` enum('aprobada','rechazada') NOT NULL,
  `comentarios` text DEFAULT NULL,
  `fecha_respuesta` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id_solicitud` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `cedula` int(11) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `fecha_solicitud` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_permiso` date NOT NULL,
  `hora_salida` time NOT NULL,
  `hora_ingreso` time NOT NULL,
  `observaciones` text DEFAULT NULL,
  `estado` enum('pendiente','aprobada','rechazada') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `cedula` int(16) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `usuario` varchar(128) NOT NULL,
  `contrasena` varchar(128) NOT NULL,
  `correo` varchar(64) NOT NULL,
  `id_departamento` int(11) DEFAULT NULL,
  `rol` enum('solicitante','lider_aprobador','administrador','seguridad','TI') NOT NULL,
  `estado` int(11) DEFAULT 'activo' NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `cedula`, `nombres`, `apellidos`, `usuario`, `contrasena`, `correo`, `id_departamento`, `rol`) VALUES
(1, 123456789, 'yeffer', 'cuesta', 'e0555b3daf9e2047692287a6b44fb1fd9e56d65b4ea2927075443b587227b6ac95f06422117856b450ee8eeaa38d939cac8fe79b6749c9ad77905b59ba81971b', '$2y$10$2xAGkXndiKPw4yNnideU5eFk8WPW9v8vdZ7loIYB2s5DhG44DW3qi', 'yecuesta@providenciacfi.com', 1, 'solicitante'),
(2, 12345678, 'prueba', 'primera', 'e0555b3daf9e2047692287a6b44fb1fd9e56d65b4ea2927075443b587227b6ac95f06422117856b450ee8eeaa38d939cac8fe79b6749c9ad77905b59ba81971b', '78d01695043d2c2fa35561ab3f4b663aaf8332cac666f0d59124a0ace3b49f4e5f003997c7168c67a5dac2bf68a54c786d91d30763c173edda3c799b3eae4977', 'prueba123@prueba.com', 1, 'lider_aprobador'),
(4, 1078460223, 'yeffer', 'cuesta mena', 'ycuesta', '78d01695043d2c2fa35561ab3f4b663aaf8332cac666f0d59124a0ace3b49f4e5f003997c7168c67a5dac2bf68a54c786d91d30763c173edda3c799b3eae4977', 'ycuesta@providenciacfi.com', 2, 'administrador');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id_departamento`),
  ADD KEY `id_lider` (`id_lider`);

--
-- Indices de la tabla `historial_solicitudes`
--
ALTER TABLE `historial_solicitudes`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `id_solicitud` (`id_solicitud`);

--
-- Indices de la tabla `respuestas_solicitudes`
--
ALTER TABLE `respuestas_solicitudes`
  ADD PRIMARY KEY (`id_respuesta`),
  ADD KEY `id_solicitud` (`id_solicitud`),
  ADD KEY `id_lider_aprobador` (`id_lider_aprobador`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`id_solicitud`),
  ADD KEY `id_departamento` (`id_departamento`),
  ADD KEY `cedula` (`cedula`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `cedula` (`cedula`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `historial_solicitudes`
--
ALTER TABLE `historial_solicitudes`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `respuestas_solicitudes`
--
ALTER TABLE `respuestas_solicitudes`
  MODIFY `id_respuesta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD CONSTRAINT `departamentos_ibfk_1` FOREIGN KEY (`id_lider`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `historial_solicitudes`
--
ALTER TABLE `historial_solicitudes`
  ADD CONSTRAINT `historial_solicitudes_ibfk_1` FOREIGN KEY (`id_solicitud`) REFERENCES `solicitudes` (`id_solicitud`);

--
-- Filtros para la tabla `respuestas_solicitudes`
--
ALTER TABLE `respuestas_solicitudes`
  ADD CONSTRAINT `respuestas_solicitudes_ibfk_1` FOREIGN KEY (`id_solicitud`) REFERENCES `solicitudes` (`id_solicitud`),
  ADD CONSTRAINT `respuestas_solicitudes_ibfk_2` FOREIGN KEY (`id_lider_aprobador`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD CONSTRAINT `solicitudes_ibfk_1` FOREIGN KEY (`id_departamento`) REFERENCES `departamentos` (`id_departamento`),
  ADD CONSTRAINT `solicitudes_ibfk_2` FOREIGN KEY (`cedula`) REFERENCES `usuarios` (`cedula`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
