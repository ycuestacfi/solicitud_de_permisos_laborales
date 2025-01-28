-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-01-2025 a las 20:45:42
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

CREATE TABLE `departamentos` (
  `id_departamento` int(11) NOT NULL,
  `nombre_departamento` varchar(100) NOT NULL,
  `id_lider` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id_departamento`, `nombre_departamento`, `id_lider`) VALUES
(1, 'Tecnología Informática', 1),
(2, 'Academicas', 7),
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

--
-- Volcado de datos para la tabla `historial_solicitudes`
--

INSERT INTO `historial_solicitudes` (`id_historial`, `id_solicitud`, `id_departamento`, `fecha_permiso`, `estado`, `fecha_cambio`, `identificador_solicitud`) VALUES
(1, 17, 1, '2025-01-29', 'aprobada', '2025-01-22 23:37:43', 'SOLICITUD-00017'),
(2, 17, 1, '2025-01-29', 'rechazada', '2025-01-22 23:37:45', 'SOLICITUD-00017'),
(3, 17, 3, '2025-01-29', 'eliminada', '2025-01-22 23:37:46', 'SOLICITUD-00017'),
(4, 17, 1, '2025-01-29', 'aprobada', '2025-01-22 23:37:47', 'SOLICITUD-00017'),
(5, 17, 1, '2025-01-29', 'rechazada', '2025-01-22 23:37:48', 'SOLICITUD-00017'),
(6, 0, 1, '2025-01-23', 'aprobada', '2025-01-22 23:48:13', 'SOLICITUD-00008'),
(7, 0, 1, '2025-01-23', 'rechazada', '2025-01-22 23:48:14', 'SOLICITUD-00008'),
(8, 0, 1, '2025-01-23', 'eliminada', '2025-01-22 23:48:15', 'SOLICITUD-00008'),
(9, 0, 1, '2025-01-23', 'aprobada', '2025-01-22 23:48:18', 'SOLICITUD-00008'),
(10, 0, 1, '2025-01-23', 'rechazada', '2025-01-22 23:48:19', 'SOLICITUD-00008'),
(11, 0, 1, '2025-01-23', 'eliminada', '2025-01-22 23:48:21', 'SOLICITUD-00008'),
(12, 0, 1, '2025-01-23', 'aprobada', '2025-01-22 23:48:23', 'SOLICITUD-00008');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id_solicitud` int(11) NOT NULL,
  `identificador_solicitud` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `cedula` int(11) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `fecha_solicitud` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_permiso` date NOT NULL,
  `hora_salida` time NOT NULL,
  `hora_ingreso` time NOT NULL,
  `observaciones` text DEFAULT NULL,
  `tipo_permiso` varchar(19) NOT NULL,
  `evidencia` varchar(255) DEFAULT NULL,
  `motivo_del_desplamiento` varchar(150) DEFAULT NULL,
  `departamento_de_desplazamiento` varchar(150) DEFAULT NULL,
  `municipio_desplazamiento` varchar(150) DEFAULT NULL,
  `lugar_desplazamiento` varchar(150) DEFAULT NULL,
  `medio_transporte` enum('MOTOCICLETA','AUTOMOVIL','TRANSPORTE PUBLICO','AVION') NOT NULL,
  `placa_vehiculo` varchar(20) DEFAULT NULL,
  `estado` enum('pendiente','aprobada','rechazada','eliminada') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`id_solicitud`, `identificador_solicitud`, `nombre`, `cedula`, `correo`, `id_departamento`, `fecha_solicitud`, `fecha_permiso`, `hora_salida`, `hora_ingreso`, `observaciones`, `tipo_permiso`, `evidencia`, `motivo_del_desplamiento`, `departamento_de_desplazamiento`, `municipio_desplazamiento`, `lugar_desplazamiento`, `medio_transporte`, `placa_vehiculo`, `estado`) VALUES
(1, 'SOLICITUD-00001', 'yeffer', 1078460223, 'ycuesta@providenciacfi.com', 1, '2025-01-09 12:36:27', '2025-01-09', '14:35:10', '09:09:00', 'na', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, 'pendiente'),
(2, 'SOLICITUD-00002', 'prueba', 12345678, 'ejemplo@gmail.com', 1, '2025-01-22 08:58:07', '2025-01-23', '09:58:07', '15:58:07', 'n/a', 'personal', '', NULL, NULL, NULL, NULL, 'MOTOCICLETA', 'CQW-5F', 'pendiente'),
(3, 'SOLICITUD-00003', 'yeffer cuesta mena', 1078460223, 'ycuesta@providenciacfi.com', 1, '2025-01-23 00:00:00', '2025-01-23', '09:12:00', '21:12:00', 'h', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, 'rechazada'),
(4, 'SOLICITUD-00004', 'yeffer cuesta mena', 1078460223, 'ycuesta@providenciacfi.com', 1, '2025-01-23 00:00:00', '2025-01-23', '09:12:00', '21:12:00', 'h', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, 'aprobada'),
(5, 'SOLICITUD-00005', 'yeffer cuesta mena', 1078460223, 'ycuesta@providenciacfi.com', 2, '2025-01-23 00:00:00', '2025-01-23', '09:12:00', '21:12:00', 'h', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, 'pendiente'),
(6, 'SOLICITUD-00006', 'yeffer cuesta mena', 1078460223, 'ycuesta@providenciacfi.com', 1, '2025-01-23 00:00:00', '2025-01-23', '09:12:00', '21:12:00', 'h', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, 'aprobada'),
(7, 'SOLICITUD-00007', 'yeffer cuesta mena', 1078460223, 'ycuesta@providenciacfi.com', 1, '2025-01-23 00:00:00', '2025-01-23', '09:12:00', '21:12:00', 'h', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, 'rechazada'),
(8, 'SOLICITUD-00008', 'yeffer cuesta mena', 1078460223, 'ycuesta@providenciacfi.com', 1, '2025-01-23 00:00:00', '2025-01-23', '09:12:00', '21:12:00', 'h', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, 'aprobada'),
(9, 'SOLICITUD-00009', 'yeffer cuesta mena', 1078460223, 'ycuesta@providenciacfi.com', 1, '2025-01-23 00:00:00', '2025-01-23', '09:12:00', '00:00:00', 'h', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, 'rechazada'),
(10, 'SOLICITUD-00010', 'yeffer cuesta mena', 1078460223, 'ycuesta@providenciacfi.com', 1, '2025-01-23 00:00:00', '2025-01-23', '09:12:00', '21:12:00', 'h', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, 'aprobada'),
(11, 'SOLICITUD-00011', 'yeffer cuesta mena', 1078460223, 'ycuesta@providenciacfi.com', 1, '2025-01-23 00:00:00', '2025-01-23', '09:12:00', '21:12:00', 'h', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, 'aprobada'),
(12, 'SOLICITUD-00012', 'yeffer cuesta mena', 1078460223, 'ycuesta@providenciacfi.com', 1, '2025-01-23 00:00:00', '2025-01-23', '09:12:00', '21:12:00', 'h', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, 'eliminada'),
(13, 'SOLICITUD-00013', 'yeffer cuesta mena', 1078460223, 'ycuesta@providenciacfi.com', 1, '2025-01-31 00:00:00', '2025-01-31', '11:07:00', '23:07:00', 'o', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, 'rechazada'),
(14, 'SOLICITUD-00014', 'yeffer cuesta mena', 1078460223, 'ycuesta@providenciacfi.com', 1, '2025-01-31 00:00:00', '2025-01-31', '11:07:00', '23:07:00', 'o', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, 'aprobada'),
(15, 'SOLICITUD-00015', 'yeffer cuesta mena', 1078460223, 'ycuesta@providenciacfi.com', 1, '2025-01-31 00:00:00', '2025-01-31', '11:07:00', '23:07:00', 'o', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, 'rechazada'),
(16, 'SOLICITUD-00016', 'yeffer cuesta mena', 1078460223, 'ycuesta@providenciacfi.com', 1, '2025-01-31 00:00:00', '2025-01-31', '11:07:00', '23:07:00', 'o', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, 'aprobada'),
(17, 'SOLICITUD-00017', 'yeffer cuesta mena', 1078460223, 'ycuesta@providenciacfi.com', 1, '2025-01-29 00:00:00', '2025-01-29', '11:13:00', '23:14:00', 'a', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, 'rechazada'),
(18, 'SOLICITUD-00018', 'Jonathan David Hoyos Valencia', 1114812664, 'jhonatandavidhv@gmail.com', 1, '2025-02-14 00:00:00', '2025-02-14', '15:23:00', '16:23:00', 'a', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, 'pendiente'),
(19, 'SOLICITUD-00019', 'Jonathan David Hoyos Valencia', 1114812664, 'jhonatandavidhv@gmail.com', 2, '2025-02-14 00:00:00', '2025-02-14', '15:23:00', '16:23:00', 'a', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `cedula` int(16) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `usuario` varchar(128) NOT NULL,
  `contrasena` varchar(128) NOT NULL,
  `correo` varchar(64) NOT NULL,
  `id_departamento` int(11) DEFAULT NULL,
  `rol` enum('solicitante','lider_aprobador','administrador','seguridad','sistem_admin') NOT NULL,
  `estado` enum('activo','inactivo','suspendido') DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `cedula`, `nombres`, `apellidos`, `usuario`, `contrasena`, `correo`, `id_departamento`, `rol`, `estado`) VALUES
(1, 12345678, 'prueba', 'primera', 'pruebas', '78d01695043d2c2fa35561ab3f4b663aaf8332cac666f0d59124a0ace3b49f4e5f003997c7168c67a5dac2bf68a54c786d91d30763c173edda3c799b3eae4977', 'prueba123@prueba.com', 1, 'lider_aprobador', 'activo'),
(4, 1078460223, 'yeffer', 'cuesta mena', 'ycuesta', '78d01695043d2c2fa35561ab3f4b663aaf8332cac666f0d59124a0ace3b49f4e5f003997c7168c67a5dac2bf68a54c786d91d30763c173edda3c799b3eae4977', 'ycuesta@providenciacfi.com', 1, 'administrador', 'activo'),
(7, 1114812664, 'Jonathan David', 'Hoyos Valencia', 'john1', '78d01695043d2c2fa35561ab3f4b663aaf8332cac666f0d59124a0ace3b49f4e5f003997c7168c67a5dac2bf68a54c786d91d30763c173edda3c799b3eae4977', 'jhonatandavidhv@gmail.com', 2, 'lider_aprobador', 'activo');

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
  ADD PRIMARY KEY (`id_historial`);

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
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD CONSTRAINT `departamentos_ibfk_1` FOREIGN KEY (`id_lider`) REFERENCES `usuarios` (`id_usuario`);

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
