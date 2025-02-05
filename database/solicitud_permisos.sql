-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307
-- Tiempo de generación: 05-02-2025 a las 15:25:40
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
(1, 'Tecnología Informática', 4),
(2, 'Academicas', 7),
(3, 'Almacen y logistica', 14),
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
  `estado_porteria` text DEFAULT NULL,
  `estado_revision` text DEFAULT NULL,
  `fecha_cambio` timestamp NOT NULL DEFAULT current_timestamp(),
  `identificador_solicitud` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_solicitudes`
--

INSERT INTO `historial_solicitudes` (`id_historial`, `id_solicitud`, `id_departamento`, `fecha_permiso`, `estado`, `estado_porteria`, `estado_revision`, `fecha_cambio`, `identificador_solicitud`) VALUES
(1, 17, 1, '2025-01-29', 'aprobada', NULL, NULL, '2025-01-22 23:37:43', 'SOLICITUD-00017'),
(2, 17, 1, '2025-01-29', 'rechazada', NULL, NULL, '2025-01-22 23:37:45', 'SOLICITUD-00017'),
(3, 17, 3, '2025-01-29', 'eliminada', NULL, NULL, '2025-01-22 23:37:46', 'SOLICITUD-00017'),
(4, 17, 1, '2025-01-29', 'aprobada', NULL, NULL, '2025-01-22 23:37:47', 'SOLICITUD-00017'),
(5, 17, 1, '2025-01-29', 'rechazada', NULL, NULL, '2025-01-22 23:37:48', 'SOLICITUD-00017'),
(6, 0, 1, '2025-01-23', 'aprobada', NULL, NULL, '2025-01-22 23:48:13', 'SOLICITUD-00008'),
(7, 0, 1, '2025-01-23', 'rechazada', NULL, NULL, '2025-01-22 23:48:14', 'SOLICITUD-00008'),
(8, 0, 1, '2025-01-23', 'eliminada', NULL, NULL, '2025-01-22 23:48:15', 'SOLICITUD-00008'),
(9, 0, 1, '2025-01-23', 'aprobada', NULL, NULL, '2025-01-22 23:48:18', 'SOLICITUD-00008'),
(10, 0, 1, '2025-01-23', 'rechazada', NULL, NULL, '2025-01-22 23:48:19', 'SOLICITUD-00008'),
(11, 0, 1, '2025-01-23', 'eliminada', NULL, NULL, '2025-01-22 23:48:21', 'SOLICITUD-00008'),
(12, 0, 1, '2025-01-23', 'aprobada', NULL, NULL, '2025-01-22 23:48:23', 'SOLICITUD-00008'),
(13, 19, 2, '2025-02-14', 'aprobada', NULL, NULL, '2025-01-30 01:31:25', 'SOLICITUD-00019'),
(14, 20, 2, '2025-02-14', 'rechazada', NULL, NULL, '2025-01-30 01:32:32', 'SOLICITUD-00020'),
(15, 21, 2, '2025-02-14', 'eliminada', NULL, NULL, '2025-01-30 01:33:12', 'SOLICITUD-00021'),
(16, 22, 2, '2025-02-14', 'rechazada', NULL, NULL, '2025-01-30 03:09:48', 'SOLICITUD-00022'),
(17, 23, 2, '2025-02-28', 'aprobada', NULL, NULL, '2025-01-30 03:16:55', 'SOLICITUD-00023'),
(18, 24, 2, '2025-02-28', 'eliminada', NULL, NULL, '2025-01-30 03:20:39', 'SOLICITUD-00024'),
(19, 28, 2, '2025-02-03', 'aprobada', NULL, NULL, '2025-01-30 19:56:35', 'SOLICITUD-00028'),
(20, 28, 2, '2025-02-03', 'aprobada', NULL, NULL, '2025-01-30 20:01:18', 'SOLICITUD-00028'),
(21, 28, 2, '2025-02-03', 'aprobada', NULL, NULL, '2025-01-30 20:03:49', 'SOLICITUD-00028'),
(22, 28, 2, '2025-02-03', 'aprobada', NULL, NULL, '2025-01-30 20:03:57', 'SOLICITUD-00028'),
(23, 28, 2, '2025-02-03', 'aprobada', NULL, NULL, '2025-01-30 20:04:43', 'SOLICITUD-00028'),
(24, 28, 2, '2025-02-03', 'aprobada', NULL, NULL, '2025-01-30 20:04:49', 'SOLICITUD-00028'),
(25, 28, 2, '2025-02-03', 'aprobada', NULL, NULL, '2025-01-30 20:21:55', 'SOLICITUD-00028'),
(26, 28, 2, '2025-02-03', 'aprobada', NULL, NULL, '2025-01-30 20:24:52', 'SOLICITUD-00028'),
(27, 28, 2, '2025-02-03', 'aprobada', NULL, NULL, '2025-01-30 20:27:44', 'SOLICITUD-00028'),
(28, 28, 2, '2025-02-03', 'aprobada', NULL, NULL, '2025-01-30 21:12:06', 'SOLICITUD-00028'),
(29, 28, 2, '2025-02-03', 'aprobada', NULL, NULL, '2025-01-30 21:13:36', 'SOLICITUD-00028'),
(30, 28, 2, '2025-02-03', 'aprobada', NULL, NULL, '2025-01-30 21:14:47', 'SOLICITUD-00028'),
(31, 28, 2, '2025-02-03', 'aprobada', NULL, NULL, '2025-01-30 21:15:32', 'SOLICITUD-00028');

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
  `motivo_del_desplazamiento` varchar(150) DEFAULT NULL,
  `departamento_del_desplazamiento` varchar(150) DEFAULT NULL,
  `municipio_del_desplazamiento` varchar(150) DEFAULT NULL,
  `lugar_del_desplazamiento` varchar(150) DEFAULT NULL,
  `medio_de_transporte` enum('MOTOCICLETA','AUTOMOVIL','TRANSPORTE PUBLICO','AVION') DEFAULT NULL,
  `placa_vehiculo` varchar(20) DEFAULT NULL,
  `comentario` varchar(100) DEFAULT NULL,
  `estado` enum('pendiente','aprobada','rechazada','eliminada') DEFAULT 'pendiente',
  `estado_porteria` enum('pendiente','terminada') CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'pendiente',
  `estado_revision` enum('pendiente','terminada') DEFAULT 'pendiente',
  `fecha_estado` datetime DEFAULT NULL,
  `fecha_estado_vigilancia` datetime DEFAULT NULL,
  `fecha_estado_revision` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`id_solicitud`, `identificador_solicitud`, `nombre`, `cedula`, `correo`, `id_departamento`, `fecha_solicitud`, `fecha_permiso`, `hora_salida`, `hora_ingreso`, `observaciones`, `tipo_permiso`, `evidencia`, `motivo_del_desplazamiento`, `departamento_del_desplazamiento`, `municipio_del_desplazamiento`, `lugar_del_desplazamiento`, `medio_de_transporte`, `placa_vehiculo`, `comentario`, `estado`, `estado_porteria`, `estado_revision`, `fecha_estado`, `fecha_estado_vigilancia`, `fecha_estado_revision`) VALUES
(1, 'SOLICITUD-00001', 'yeffer', 1078460223, 'ycuesta@providenciacfi.com', 1, '2025-01-09 12:36:27', '2025-01-09', '14:35:10', '09:09:00', 'na', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, NULL, 'pendiente', 'pendiente', 'pendiente', NULL, NULL, NULL),
(2, 'SOLICITUD-00002', 'prueba', 12345678, 'ejemplo@gmail.com', 1, '2025-01-22 08:58:07', '2025-01-23', '09:58:07', '15:58:07', 'n/a', 'personal', '', NULL, NULL, NULL, NULL, 'MOTOCICLETA', 'CQW-5F', NULL, 'pendiente', 'pendiente', 'pendiente', NULL, NULL, NULL),
(3, 'SOLICITUD-00003', 'yeffer cuesta mena', 1078460223, 'ycuesta@providenciacfi.com', 1, '2025-01-23 00:00:00', '2025-01-23', '09:12:00', '21:12:00', 'h', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, NULL, 'rechazada', 'pendiente', 'pendiente', NULL, NULL, NULL),
(4, 'SOLICITUD-00004', 'yeffer cuesta mena', 1078460223, 'ycuesta@providenciacfi.com', 1, '2025-01-23 00:00:00', '2025-01-23', '09:12:00', '21:12:00', 'h', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, NULL, 'aprobada', 'pendiente', 'pendiente', NULL, NULL, NULL),
(5, 'SOLICITUD-00005', 'yeffer cuesta mena', 1078460223, 'ycuesta@providenciacfi.com', 2, '2025-01-23 00:00:00', '2025-01-23', '09:12:00', '21:12:00', 'h', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, NULL, 'pendiente', 'pendiente', 'pendiente', NULL, NULL, NULL),
(6, 'SOLICITUD-00006', 'yeffer cuesta mena', 1078460223, 'ycuesta@providenciacfi.com', 1, '2025-01-23 00:00:00', '2025-01-23', '09:12:00', '21:12:00', 'h', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, NULL, 'aprobada', 'pendiente', 'pendiente', NULL, NULL, NULL),
(7, 'SOLICITUD-00007', 'yeffer cuesta mena', 1078460223, 'ycuesta@providenciacfi.com', 1, '2025-01-23 00:00:00', '2025-01-23', '09:12:00', '21:12:00', 'h', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, NULL, 'rechazada', 'pendiente', 'pendiente', NULL, NULL, NULL),
(8, 'SOLICITUD-00008', 'yeffer cuesta mena', 1078460223, 'ycuesta@providenciacfi.com', 1, '2025-01-23 00:00:00', '2025-01-23', '09:12:00', '21:12:00', 'h', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, NULL, 'aprobada', 'pendiente', 'pendiente', NULL, NULL, NULL),
(9, 'SOLICITUD-00009', 'yeffer cuesta mena', 1078460223, 'ycuesta@providenciacfi.com', 1, '2025-01-23 00:00:00', '2025-01-23', '09:12:00', '00:00:00', 'h', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, NULL, 'rechazada', 'pendiente', 'pendiente', NULL, NULL, NULL),
(10, 'SOLICITUD-00010', 'yeffer cuesta mena', 1078460223, 'ycuesta@providenciacfi.com', 1, '2025-01-23 00:00:00', '2025-01-23', '09:12:00', '21:12:00', 'h', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, NULL, 'aprobada', 'pendiente', 'pendiente', NULL, NULL, NULL),
(11, 'SOLICITUD-00011', 'yeffer cuesta mena', 1078460223, 'ycuesta@providenciacfi.com', 1, '2025-01-23 00:00:00', '2025-01-23', '09:12:00', '21:12:00', 'h', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, NULL, 'aprobada', 'pendiente', 'pendiente', NULL, NULL, NULL),
(12, 'SOLICITUD-00012', 'yeffer cuesta mena', 1078460223, 'ycuesta@providenciacfi.com', 1, '2025-01-23 00:00:00', '2025-01-23', '09:12:00', '21:12:00', 'h', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, NULL, 'eliminada', 'pendiente', 'pendiente', NULL, NULL, NULL),
(13, 'SOLICITUD-00013', 'yeffer cuesta mena', 1078460223, 'ycuesta@providenciacfi.com', 1, '2025-01-31 00:00:00', '2025-01-31', '11:07:00', '23:07:00', 'o', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, NULL, 'rechazada', 'pendiente', 'pendiente', NULL, NULL, NULL),
(14, 'SOLICITUD-00014', 'yeffer cuesta mena', 1078460223, 'ycuesta@providenciacfi.com', 1, '2025-01-31 00:00:00', '2025-01-31', '11:07:00', '11:59:00', 'o', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, NULL, 'pendiente', 'pendiente', 'pendiente', NULL, NULL, NULL),
(15, 'SOLICITUD-00015', 'yeffer cuesta mena', 1078460223, 'ycuesta@providenciacfi.com', 1, '2025-01-31 00:00:00', '2025-01-31', '11:07:00', '23:07:00', 'o', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, NULL, 'rechazada', 'pendiente', 'pendiente', NULL, NULL, NULL),
(16, 'SOLICITUD-00016', 'yeffer cuesta mena', 1078460223, 'ycuesta@providenciacfi.com', 1, '2025-01-31 00:00:00', '2025-01-31', '11:07:00', '11:59:00', 'o', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, NULL, 'aprobada', 'terminada', 'pendiente', NULL, NULL, NULL),
(17, 'SOLICITUD-00017', 'yeffer cuesta mena', 1078460223, 'ycuesta@providenciacfi.com', 1, '2025-01-29 00:00:00', '2025-01-29', '11:13:00', '23:14:00', 'a', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, NULL, 'rechazada', 'pendiente', 'pendiente', NULL, NULL, NULL),
(18, 'SOLICITUD-00018', 'Jonathan David Hoyos Valencia', 1114812664, 'jhonatandavidhv@gmail.com', 1, '2025-01-14 00:00:00', '2025-02-14', '15:23:00', '16:23:00', 'a', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, 'hola', 'pendiente', 'pendiente', 'pendiente', NULL, NULL, NULL),
(19, 'SOLICITUD-00019', 'Jonathan David Hoyos Valencia', 1114812664, 'jhonatandavidhv@gmail.com', 2, '2025-01-14 00:00:00', '2025-02-14', '15:23:00', '16:23:00', 'a', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, NULL, 'aprobada', 'pendiente', 'pendiente', NULL, NULL, NULL),
(20, 'SOLICITUD-00020', 'Jonathan David Hoyos Valencia', 1114812664, 'jhoyos@providenciacfi.com', 2, '2025-01-29 18:30:25', '2025-02-14', '10:00:00', '15:00:00', 'Examen general', 'cita medica', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, NULL, 'rechazada', 'pendiente', 'pendiente', NULL, NULL, NULL),
(21, 'SOLICITUD-00021', 'Jonathan David Hoyos Valencia', 1114812664, 'jhoyos@providenciacfi.com', 2, '2025-01-29 18:30:25', '2025-02-14', '10:00:00', '15:00:00', 'Examen general', 'cita medica', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, NULL, 'eliminada', 'pendiente', 'pendiente', NULL, NULL, NULL),
(22, 'SOLICITUD-00022', 'Jonathan David Hoyos Valencia', 1114812664, 'jhoyos@providenciacfi.com', 2, '2025-01-29 18:30:25', '2025-02-14', '10:00:00', '15:00:00', 'Examen general', 'cita medica', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, NULL, 'rechazada', 'pendiente', 'pendiente', NULL, NULL, NULL),
(23, 'SOLICITUD-00023', 'Jonathan David Hoyos Valencia', 1114812664, 'jhoyos@providenciacfi.com', 2, '2025-01-29 18:35:45', '2025-02-28', '14:00:00', '15:00:00', 'Recoger vehículo del taller', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, NULL, 'aprobada', 'pendiente', 'pendiente', NULL, NULL, NULL),
(24, 'SOLICITUD-00024', 'Jonathan David Hoyos Valencia', 1114812664, 'jhoyos@providenciacfi.com', 2, '2025-01-29 18:35:45', '2025-02-28', '14:00:00', '15:00:00', 'Recoger vehículo del taller', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, NULL, 'eliminada', 'pendiente', 'pendiente', NULL, NULL, NULL),
(25, 'SOLICITUD-00025', 'Jonathan David Hoyos Valencia', 1114812664, 'jhoyos@providenciacfi.com', 2, '2025-01-29 18:35:45', '2025-02-28', '14:00:00', '15:00:00', 'Recoger vehículo del taller', 'personal', NULL, NULL, NULL, NULL, NULL, 'MOTOCICLETA', NULL, NULL, 'aprobada', 'pendiente', 'pendiente', '2025-01-31 12:23:53', NULL, NULL),
(26, 'SOLICITUD-00026', 'Jonathan David Hoyos Valencia', 1114812664, 'jhoyos@providenciacfi.com', 2, '2025-01-29 18:45:05', '2025-02-01', '09:00:00', '11:57:00', 't', 'personal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pendiente', 'pendiente', 'pendiente', NULL, NULL, NULL),
(27, 'SOLICITUD-00027', 'Jonathan David Hoyos Valencia', 1114812664, 'jhoyos@providenciacfi.com', 2, '2025-01-29 18:45:05', '2025-02-01', '09:00:00', '14:00:00', 't', 'personal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pendiente', 'pendiente', 'pendiente', '2025-01-31 12:38:26', NULL, NULL),
(28, 'SOLICITUD-00028', 'Jonathan David Hoyos Valencia', 1114812664, 'jhoyos@providenciacfi.com', 2, '2025-01-30 08:30:44', '2025-02-03', '08:31:00', '15:30:00', 'prueba laboral', 'laboral', 'C:\\xampp\\htdocs\\solicitud_de_permisos_laborales\\app\\controller/../assets/evidencias/solicitud_67a1026d2b56f9.05314204.png', 'laboral1', 'Valle del cauca', 'El cerrito', 'Colegio de providencia', 'AUTOMOVIL', 'VWE64G', NULL, 'aprobada', 'terminada', 'terminada', '2025-01-30 15:28:23', '2025-01-30 15:30:42', '2025-01-30 15:38:04'),
(29, 'SOLICITUD-00029', 'Jonathan David Hoyos Valencia', 1114812664, 'jhoyos@providenciacfi.com', 2, '2025-01-31 11:22:29', '2025-02-08', '11:22:00', '15:22:00', 'No se registraron observaciones en esta solicitud ', 'personal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'rechazada', 'pendiente', 'pendiente', '2025-01-31 12:25:31', NULL, NULL),
(30, 'SOLICITUD-00030', 'Jonathan David Hoyos Valencia', 1114812664, 'jhoyos@providenciacfi.com', 2, '2025-01-31 11:29:06', '2025-02-03', '11:29:00', '15:29:00', 'prueba modal', 'personal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'aprobada', 'pendiente', 'pendiente', '2025-01-31 12:28:43', NULL, NULL),
(31, 'SOLICITUD-00031', 'Jonathan David Hoyos Valencia', 1114812664, 'jhoyos@providenciacfi.com', 2, '2025-01-31 11:29:06', '2025-02-03', '11:29:00', '15:29:00', 'prueba modal', 'personal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'rechazada', 'pendiente', 'pendiente', '2025-01-31 12:28:47', NULL, NULL),
(32, 'SOLICITUD-00032', 'Jonathan David Hoyos Valencia', 1114812664, 'jhoyos@providenciacfi.com', 2, '2025-01-31 11:37:19', '2025-02-06', '11:37:00', '15:37:00', 'prueba modal 2', 'personal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'aprobada', 'pendiente', 'pendiente', '2025-01-31 12:51:42', NULL, NULL),
(33, 'SOLICITUD-00033', 'Jonathan David Hoyos Valencia', 1114812664, 'jhoyos@providenciacfi.com', 2, '2025-01-31 11:37:19', '2025-02-06', '11:37:00', '15:37:00', 'prueba modal 2', 'personal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'aprobada', 'pendiente', 'pendiente', '2025-01-31 12:52:22', NULL, NULL),
(34, 'SOLICITUD-00034', 'Jonathan David Hoyos Valencia', 1114812664, 'jhoyos@providenciacfi.com', 2, '2025-01-31 11:37:19', '2025-02-06', '11:37:00', '15:37:00', 'prueba modal 2', 'personal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'aprobada', 'pendiente', 'pendiente', '2025-01-31 12:59:38', NULL, NULL),
(35, 'SOLICITUD-00035', 'Jonathan David Hoyos Valencia', 1114812664, 'jhoyos@providenciacfi.com', 2, '2025-01-31 11:37:19', '2025-02-06', '11:37:00', '15:37:00', 'prueba modal 2', 'personal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'aprobada', 'pendiente', 'pendiente', '2025-01-31 12:58:04', NULL, NULL),
(36, 'SOLICITUD-00036', 'Jonathan David Hoyos Valencia', 1114812664, 'jhoyos@providenciacfi.com', 2, '2025-01-31 12:00:42', '2025-02-04', '13:04:00', '15:04:00', 'prueba modal 3', 'personal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'aprobada', 'pendiente', 'pendiente', '2025-01-31 12:50:01', NULL, NULL),
(37, 'SOLICITUD-00037', 'Jonathan David Hoyos Valencia', 1114812664, 'jhoyos@providenciacfi.com', 2, '2025-01-31 12:11:11', '2025-02-05', '13:11:00', '14:11:00', 'prueba modal 4', 'cita medica', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'aprobada', 'pendiente', 'pendiente', '2025-01-31 12:46:56', NULL, NULL),
(38, 'SOLICITUD-00038', 'Jonathan David Hoyos Valencia', 1114812664, 'jhoyos@providenciacfi.com', 2, '2025-01-31 15:29:07', '2025-01-31', '15:29:00', '15:42:00', 'HOLA', 'personal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pendiente', 'pendiente', 'pendiente', NULL, NULL, NULL),
(39, 'SOLICITUD-00039', 'Jonathan David Hoyos Valencia', 1114812664, 'jhoyos@providenciacfi.com', 1, '2025-01-31 15:38:12', '2025-02-07', '09:38:00', '15:38:00', 'hola', 'personal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pendiente', 'pendiente', 'pendiente', NULL, NULL, NULL),
(40, 'SOLICITUD-00040', 'Jonathan David Hoyos Valencia', 1114812664, 'jhoyos@providenciacfi.com', 1, '2025-02-03 11:42:37', '2025-02-14', '10:00:00', '14:00:00', 'hola', 'personal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pendiente', 'pendiente', 'pendiente', NULL, NULL, NULL),
(41, 'SOLICITUD-00041', 'Jonathan David Hoyos Valencia', 1114812664, 'jhoyos@providenciacfi.com', 1, '2025-02-03 11:52:31', '2025-02-17', '11:53:00', '13:53:00', 'hola2', 'personal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pendiente', 'pendiente', 'pendiente', NULL, NULL, NULL),
(42, 'SOLICITUD-00042', 'Jonathan David Hoyos Valencia', 1114812664, 'jhoyos@providenciacfi.com', 1, '2025-02-03 11:55:49', '2025-02-06', '11:56:00', '12:56:00', 'hola3', 'personal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pendiente', 'pendiente', 'pendiente', NULL, NULL, NULL),
(43, 'SOLICITUD-00043', 'Jonathan David Hoyos Valencia', 1114812664, 'jhoyos@providenciacfi.com', 1, '2025-02-03 11:59:14', '2025-02-18', '11:59:00', '13:59:00', 'hola4', 'personal', 'C:\\xampp\\htdocs\\solicitud_de_permisos_laborales\\app\\controller/../assets/evidencias/solicitud_67a132367615f2.15924154.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pendiente', 'pendiente', 'pendiente', NULL, NULL, NULL),
(44, 'SOLICITUD-00044', 'Jonathan David Hoyos Valencia', 1114812664, 'jhoyos@providenciacfi.com', 1, '2025-02-03 11:59:40', '2025-02-11', '08:00:00', '12:01:00', 'hola5', 'personal', 'C:\\xampp\\htdocs\\solicitud_de_permisos_laborales\\app\\controller/../assets/evidencias/solicitud_67a0f659209fa9.72044276.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pendiente', 'pendiente', 'pendiente', NULL, NULL, NULL),
(45, 'SOLICITUD-00045', 'Jonathan David Hoyos Valencia', 1114812664, 'jhoyos@providenciacfi.com', 1, '2025-02-03 12:06:48', '2025-02-05', '09:06:00', '12:07:00', 'hola6', 'personal', 'C:\\xampp\\htdocs\\solicitud_de_permisos_laborales\\app\\controller/../assets/evidencias/solicitud_67a12d66b37e60.00384856.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pendiente', 'pendiente', 'pendiente', NULL, NULL, NULL),
(46, 'SOLICITUD-00046', 'Jonathan David Hoyos Valencia', 1114812664, 'jhoyos@providenciacfi.com', 1, '2025-02-03 12:09:56', '2025-02-18', '10:10:00', '12:10:00', 'hola7', 'personal', 'C:\\xampp\\htdocs\\solicitud_de_permisos_laborales\\app\\controller/../assets/evidencias/solicitud_67a0f88ab8d660.68685689.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pendiente', 'pendiente', 'pendiente', NULL, NULL, NULL),
(47, 'SOLICITUD-00047', 'Jonathan David Hoyos Valencia', 1114812664, 'jhoyos@providenciacfi.com', 1, '2025-02-03 12:52:26', '2025-02-04', '12:52:00', '15:52:00', 'hola7', 'personal', 'C:\\xampp\\htdocs\\solicitud_de_permisos_laborales\\app\\controller/../assets/evidencias/solicitud_67a1026d2b56f9.05314204.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pendiente', 'pendiente', 'pendiente', '2025-02-04 09:31:11', NULL, NULL),
(48, 'SOLICITUD-00048', 'Jonathan David Hoyos Valencia', 1114812664, 'jhoyos@providenciacfi.com', 1, '2025-02-04 10:32:22', '2025-02-27', '10:32:00', '14:32:00', 'prueba imagen pequeña', 'personal', 'C:\\xampp\\htdocs\\solicitud_de_permisos_laborales\\app\\controller/../assets/evidencias/solicitud_67a23320c2d9c3.68277935.png', NULL, NULL, NULL, NULL, NULL, NULL, '', 'aprobada', 'pendiente', 'pendiente', '2025-02-04 10:36:34', NULL, NULL);

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
  `rol` enum('solicitante','lider_aprobador','administrador','seguridad','sistem_admin','visualizar') NOT NULL,
  `estado` enum('activo','inactivo','suspendido') DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `cedula`, `nombres`, `apellidos`, `usuario`, `contrasena`, `correo`, `id_departamento`, `rol`, `estado`) VALUES
(1, 12345678, 'prueba', 'primera', 'pruebas', '78d01695043d2c2fa35561ab3f4b663aaf8332cac666f0d59124a0ace3b49f4e5f003997c7168c67a5dac2bf68a54c786d91d30763c173edda3c799b3eae4977', 'ycuesta@provid', 1, 'lider_aprobador', 'activo'),
(4, 1078460223, 'yeffer', 'cuesta mena', 'ycuesta', '78d01695043d2c2fa35561ab3f4b663aaf8332cac666f0d59124a0ace3b49f4e5f003997c7168c67a5dac2bf68a54c786d91d30763c173edda3c799b3eae4977', 'ycuesta@providenciacfi.com', 1, 'administrador', 'activo'),
(7, 1114812664, 'Jonathan David', 'Hoyos Valencia', 'john1', '78d01695043d2c2fa35561ab3f4b663aaf8332cac666f0d59124a0ace3b49f4e5f003997c7168c67a5dac2bf68a54c786d91d30763c173edda3c799b3eae4977', 'jhoyos@providenciacfi.com', 1, 'administrador', 'activo'),
(8, 77763273, 'Juan Manuel', 'Hernan Castro', 'juanm', '78d01695043d2c2fa35561ab3f4b663aaf8332cac666f0d59124a0ace3b49f4e5f003997c7168c67a5dac2bf68a54c786d91d30763c173edda3c799b3eae4977', 'correoprueba@gmail.com', 3, 'visualizar', 'activo'),
(9, 22222222, 'prueba ', 'dos', 'prueba2', '78d01695043d2c2fa35561ab3f4b663aaf8332cac666f0d59124a0ace3b49f4e5f003997c7168c67a5dac2bf68a54c786d91d30763c173edda3c799b3eae4977', 'correoprueba2@gmail.com', 5, 'solicitante', 'activo'),
(10, 33333333, 'prueba ', 'tres', 'prueba3', '78d01695043d2c2fa35561ab3f4b663aaf8332cac666f0d59124a0ace3b49f4e5f003997c7168c67a5dac2bf68a54c786d91d30763c173edda3c799b3eae4977', 'correoprueba3@gmail.com', 4, 'solicitante', 'activo'),
(11, 44444444, 'prueba', 'cuatro', 'prueba4', '78d01695043d2c2fa35561ab3f4b663aaf8332cac666f0d59124a0ace3b49f4e5f003997c7168c67a5dac2bf68a54c786d91d30763c173edda3c799b3eae4977', 'prueba4@gmail.com', 10, 'solicitante', 'activo'),
(12, 55555555, 'prueba', 'cinco', 'prueba5', '78d01695043d2c2fa35561ab3f4b663aaf8332cac666f0d59124a0ace3b49f4e5f003997c7168c67a5dac2bf68a54c786d91d30763c173edda3c799b3eae4977', 'prueba5@gmail.com', 6, 'solicitante', 'activo'),
(13, 66666666, 'prueba', 'seis', 'prueba6', '78d01695043d2c2fa35561ab3f4b663aaf8332cac666f0d59124a0ace3b49f4e5f003997c7168c67a5dac2bf68a54c786d91d30763c173edda3c799b3eae4977', 'prueba6@gmail.com', 7, 'solicitante', 'activo'),
(14, 77777777, 'prueba', 'siete', 'prueba7', '78d01695043d2c2fa35561ab3f4b663aaf8332cac666f0d59124a0ace3b49f4e5f003997c7168c67a5dac2bf68a54c786d91d30763c173edda3c799b3eae4977', 'prueba7@gmail.com', 8, 'solicitante', 'activo'),
(15, 88888888, 'prueba', 'ocho', 'prueba8', '78d01695043d2c2fa35561ab3f4b663aaf8332cac666f0d59124a0ace3b49f4e5f003997c7168c67a5dac2bf68a54c786d91d30763c173edda3c799b3eae4977', 'correoejeplo8@gmail.com', 3, 'solicitante', 'activo');

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
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
