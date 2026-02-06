-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-11-2025 a las 03:03:32
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
-- Base de datos: `admision_mrap`
--
CREATE DATABASE IF NOT EXISTS `admision_mrap` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `admision_mrap`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `apoderados`
--

DROP TABLE IF EXISTS `apoderados`;
CREATE TABLE `apoderados` (
  `id` int(11) NOT NULL,
  `postulante_id` int(11) NOT NULL,
  `nombre_completo` varchar(200) NOT NULL,
  `dni_apoderado` varchar(8) NOT NULL,
  `parentesco` enum('padre','madre','tutor','otro') NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `direccion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `apoderados`
--

INSERT INTO `apoderados` (`id`, `postulante_id`, `nombre_completo`, `dni_apoderado`, `parentesco`, `telefono`, `email`, `direccion`) VALUES
(1, 1, 'Oscar Omar Zelada La Cerna', '40280075', 'padre', '984386080', NULL, NULL),
(2, 2, 'Leo', '40298023', 'padre', '', NULL, NULL),
(3, 3, 'Leo Falconi', '40280092', 'padre', '992764313', NULL, NULL),
(4, 4, 'Luis', '34039492', 'tutor', '', NULL, NULL),
(5, 5, 'Jorge ', '40293859', 'otro', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `declaraciones_juradas`
--

DROP TABLE IF EXISTS `declaraciones_juradas`;
CREATE TABLE `declaraciones_juradas` (
  `id` int(11) NOT NULL,
  `postulante_id` int(11) NOT NULL,
  `tipo_declaracion` enum('mayor_edad','menor_edad','no_devolucion','salud') NOT NULL,
  `aceptado` tinyint(1) DEFAULT 0,
  `fecha_aceptacion` timestamp NULL DEFAULT NULL,
  `ip_aceptacion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `declaraciones_juradas`
--

INSERT INTO `declaraciones_juradas` (`id`, `postulante_id`, `tipo_declaracion`, `aceptado`, `fecha_aceptacion`, `ip_aceptacion`) VALUES
(1, 1, 'mayor_edad', 1, '2025-11-22 04:38:49', '::1'),
(2, 1, 'salud', 1, '2025-11-22 04:38:49', '::1'),
(3, 2, 'mayor_edad', 1, '2025-11-23 02:59:52', '::1'),
(4, 2, 'salud', 1, '2025-11-23 02:59:52', '::1'),
(5, 3, 'mayor_edad', 1, '2025-11-23 18:44:27', '::1'),
(6, 3, 'salud', 1, '2025-11-23 18:44:27', '::1'),
(7, 4, 'mayor_edad', 1, '2025-11-23 21:12:21', '::1'),
(8, 4, 'salud', 1, '2025-11-23 21:12:21', '::1'),
(9, 5, 'mayor_edad', 1, '2025-11-24 00:16:04', '::1'),
(10, 5, 'salud', 1, '2025-11-24 00:16:04', '::1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

DROP TABLE IF EXISTS `documentos`;
CREATE TABLE `documentos` (
  `id` int(11) NOT NULL,
  `postulante_id` int(11) NOT NULL,
  `tipo_documento` enum('dni','certificados','declaracion_jurada','declaracion_salud','foto') NOT NULL,
  `nombre_archivo` varchar(255) NOT NULL,
  `ruta_archivo` varchar(500) NOT NULL,
  `fecha_subida` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado_verificacion` enum('pendiente','aprobado','rechazado') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `documentos`
--

INSERT INTO `documentos` (`id`, `postulante_id`, `tipo_documento`, `nombre_archivo`, `ruta_archivo`, `fecha_subida`, `estado_verificacion`) VALUES
(1, 1, 'dni', '1_dni_1763786329.pdf', 'uploads/dni/1_dni_1763786329.pdf', '2025-11-22 04:38:49', 'pendiente'),
(2, 1, 'certificados', '1_certificados_1763786329.pdf', 'uploads/certificados/1_certificados_1763786329.pdf', '2025-11-22 04:38:49', 'pendiente'),
(3, 1, 'declaracion_jurada', '1_declaracion_jurada_1763786329.pdf', 'uploads/declaracion_jurada/1_declaracion_jurada_1763786329.pdf', '2025-11-22 04:38:49', 'pendiente'),
(4, 2, 'dni', '2_dni_1763866792.pdf', 'uploads/dni/2_dni_1763866792.pdf', '2025-11-23 02:59:52', 'pendiente'),
(5, 2, 'certificados', '2_certificados_1763866792.pdf', 'uploads/certificados/2_certificados_1763866792.pdf', '2025-11-23 02:59:52', 'pendiente'),
(6, 2, 'declaracion_jurada', '2_declaracion_jurada_1763866792.pdf', 'uploads/declaracion_jurada/2_declaracion_jurada_1763866792.pdf', '2025-11-23 02:59:52', 'pendiente'),
(7, 3, 'dni', '3_dni_1763923467_3247.pdf', 'uploads/dni/3_dni_1763923467_3247.pdf', '2025-11-23 18:44:27', 'pendiente'),
(8, 3, 'certificados', '3_certificados_1763923467_7347.pdf', 'uploads/certificados/3_certificados_1763923467_7347.pdf', '2025-11-23 18:44:27', 'pendiente'),
(9, 3, 'declaracion_jurada', '3_declaracion_jurada_1763923467_7699.pdf', 'uploads/declaracion_jurada/3_declaracion_jurada_1763923467_7699.pdf', '2025-11-23 18:44:27', 'pendiente'),
(10, 3, 'declaracion_jurada', '3_declaracion_jurada_1763923467_3039.pdf', 'uploads/declaracion_jurada/3_declaracion_jurada_1763923467_3039.pdf', '2025-11-23 18:44:27', 'pendiente'),
(11, 4, 'dni', '4_dni_1763932341_2581.pdf', 'uploads/dni/4_dni_1763932341_2581.pdf', '2025-11-23 21:12:21', 'pendiente'),
(12, 4, 'certificados', '4_certificados_1763932341_3591.pdf', 'uploads/certificados/4_certificados_1763932341_3591.pdf', '2025-11-23 21:12:21', 'pendiente'),
(13, 4, 'declaracion_jurada', '4_declaracion_jurada_1763932341_1113.pdf', 'uploads/declaracion_jurada/4_declaracion_jurada_1763932341_1113.pdf', '2025-11-23 21:12:21', 'pendiente'),
(14, 4, 'declaracion_jurada', '4_declaracion_jurada_1763932341_4514.pdf', 'uploads/declaracion_jurada/4_declaracion_jurada_1763932341_4514.pdf', '2025-11-23 21:12:21', 'pendiente'),
(15, 5, 'dni', '5_dni_1763943364_6184.pdf', 'uploads/dni/5_dni_1763943364_6184.pdf', '2025-11-24 00:16:04', 'pendiente'),
(16, 5, 'certificados', '5_certificados_1763943364_6410.pdf', 'uploads/certificados/5_certificados_1763943364_6410.pdf', '2025-11-24 00:16:04', 'pendiente'),
(17, 5, 'declaracion_jurada', '5_declaracion_jurada_1763943364_9823.pdf', 'uploads/declaracion_jurada/5_declaracion_jurada_1763943364_9823.pdf', '2025-11-24 00:16:04', 'pendiente'),
(18, 5, 'declaracion_jurada', '5_declaracion_jurada_1763943364_6330.pdf', 'uploads/declaracion_jurada/5_declaracion_jurada_1763943364_6330.pdf', '2025-11-24 00:16:04', 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examenes_admision`
--

DROP TABLE IF EXISTS `examenes_admision`;
CREATE TABLE `examenes_admision` (
  `id` int(11) NOT NULL,
  `codigo_examen` varchar(20) NOT NULL,
  `fecha_examen` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `duracion_minutos` int(11) DEFAULT 120,
  `aula` varchar(50) DEFAULT NULL,
  `capacidad_maxima` int(11) DEFAULT 30,
  `estado` enum('programado','en_curso','finalizado','cancelado') DEFAULT 'programado',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `examenes_admision`
--

INSERT INTO `examenes_admision` (`id`, `codigo_examen`, `fecha_examen`, `hora_inicio`, `duracion_minutos`, `aula`, `capacidad_maxima`, `estado`, `fecha_creacion`) VALUES
(1, 'EX-2025-990', '2025-12-21', '09:00:00', 120, NULL, 30, 'programado', '2025-11-22 04:38:49'),
(2, 'EX-2026-113', '2026-01-28', '09:00:00', 120, '', 30, 'programado', '2025-11-23 22:18:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informacion_academica`
--

DROP TABLE IF EXISTS `informacion_academica`;
CREATE TABLE `informacion_academica` (
  `id` int(11) NOT NULL,
  `postulante_id` int(11) NOT NULL,
  `colegio_procedencia` varchar(200) NOT NULL,
  `grado_actual` enum('secundaria_incompleta','secundaria_completa','tecnica_curso','tecnica_completa','tecnica_incompleta','universitaria_curso','universitaria_completa','universitaria_incompleta') NOT NULL,
  `promedio_ultimo` decimal(4,2) DEFAULT NULL,
  `fecha_egreso` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `informacion_academica`
--

INSERT INTO `informacion_academica` (`id`, `postulante_id`, `colegio_procedencia`, `grado_actual`, `promedio_ultimo`, `fecha_egreso`) VALUES
(1, 1, 'Liceo San Agustin', 'secundaria_completa', 18.00, NULL),
(2, 2, 'Liceo San Agustin', 'secundaria_completa', 16.00, NULL),
(3, 3, 'Liceo San Agustin', 'secundaria_completa', 18.00, NULL),
(4, 4, 'Liceo San Juan', 'secundaria_completa', 18.00, NULL),
(5, 5, 'Callao', 'tecnica_curso', 17.00, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripciones_examen`
--

DROP TABLE IF EXISTS `inscripciones_examen`;
CREATE TABLE `inscripciones_examen` (
  `id` int(11) NOT NULL,
  `postulante_id` int(11) NOT NULL,
  `examen_id` int(11) NOT NULL,
  `codigo_inscripcion` varchar(20) NOT NULL,
  `fecha_inscripcion` timestamp NOT NULL DEFAULT current_timestamp(),
  `pago_realizado` tinyint(1) DEFAULT 0,
  `monto_pagado` decimal(10,2) DEFAULT 150.00,
  `fecha_pago` timestamp NULL DEFAULT NULL,
  `metodo_pago` enum('efectivo','transferencia','deposito') DEFAULT NULL,
  `numero_operacion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `inscripciones_examen`
--

INSERT INTO `inscripciones_examen` (`id`, `postulante_id`, `examen_id`, `codigo_inscripcion`, `fecha_inscripcion`, `pago_realizado`, `monto_pagado`, `fecha_pago`, `metodo_pago`, `numero_operacion`) VALUES
(1, 1, 1, 'MRAP-2025-18032', '2025-11-22 04:38:49', 0, 150.00, NULL, NULL, NULL),
(2, 2, 1, 'MRAP-2025-60960', '2025-11-23 02:59:52', 0, 150.00, NULL, NULL, NULL),
(3, 3, 1, 'MRAP-2025-99558', '2025-11-23 18:44:27', 0, 150.00, NULL, NULL, NULL),
(4, 4, 1, 'MRAP-2025-13562', '2025-11-23 21:12:22', 0, 150.00, NULL, NULL, NULL),
(5, 5, 1, 'MRAP-2025-00570', '2025-11-24 00:16:04', 0, 150.00, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs_sistema`
--

DROP TABLE IF EXISTS `logs_sistema`;
CREATE TABLE `logs_sistema` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `accion` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `fecha_hora` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `logs_sistema`
--

INSERT INTO `logs_sistema` (`id`, `usuario_id`, `accion`, `descripcion`, `ip_address`, `user_agent`, `fecha_hora`) VALUES
(1, NULL, 'inscripcion_nueva', 'Nueva inscripción: Alessandro Zelada (DNI: 73470109)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025-11-22 04:38:49'),
(2, NULL, 'inscripcion_nueva', 'Nueva inscripción: Alessandro Zelada (DNI: 73740192)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025-11-23 02:59:52'),
(3, NULL, 'inscripcion_nueva', 'Nueva inscripción: Paolo Falconi (DNI: 73470108)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025-11-23 18:44:27'),
(4, NULL, 'inscripcion_nueva', 'Nueva inscripción: dsa das (DNI: 83920392)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025-11-23 21:12:22'),
(5, 1, 'login', 'Inicio de sesión exitoso', '::1', NULL, '2025-11-23 22:01:22'),
(6, 1, 'logout', 'Cierre de sesión', '::1', NULL, '2025-11-23 22:10:49'),
(7, 1, 'login', 'Inicio de sesión exitoso', '::1', NULL, '2025-11-23 22:11:28'),
(8, NULL, 'inscripcion_nueva', 'Nueva inscripción: Jeffersom De La Cruz (DNI: 48293042)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025-11-24 00:16:04'),
(9, 1, 'logout', 'Cierre de sesión', '::1', NULL, '2025-11-24 00:16:52'),
(10, 1, 'login', 'Inicio de sesión exitoso', '::1', NULL, '2025-11-24 00:17:09'),
(11, 1, 'logout', 'Cierre de sesión', '::1', NULL, '2025-11-24 00:21:33'),
(12, 1, 'login', 'Inicio de sesión exitoso', '::1', NULL, '2025-11-24 00:22:02'),
(13, 1, 'logout', 'Cierre de sesión', '::1', NULL, '2025-11-24 01:21:51'),
(14, 4, 'login', 'Inicio de sesión exitoso', '::1', NULL, '2025-11-24 01:21:55'),
(15, 4, 'logout', 'Cierre de sesión', '::1', NULL, '2025-11-24 01:22:23'),
(16, 2, 'login', 'Inicio de sesión exitoso', '::1', NULL, '2025-11-24 01:22:27'),
(17, 2, 'logout', 'Cierre de sesión', '::1', NULL, '2025-11-24 01:22:49'),
(18, 3, 'login', 'Inicio de sesión exitoso', '::1', NULL, '2025-11-24 01:22:54'),
(19, 3, 'logout', 'Cierre de sesión', '::1', NULL, '2025-11-24 01:23:33'),
(20, 2, 'login', 'Inicio de sesión exitoso', '::1', NULL, '2025-11-24 01:23:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opciones_carrera`
--

DROP TABLE IF EXISTS `opciones_carrera`;
CREATE TABLE `opciones_carrera` (
  `id` int(11) NOT NULL,
  `postulante_id` int(11) NOT NULL,
  `programa_id` int(11) NOT NULL,
  `turno` enum('diurno','nocturno') NOT NULL,
  `orden_preferencia` enum('primera','segunda') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `opciones_carrera`
--

INSERT INTO `opciones_carrera` (`id`, `postulante_id`, `programa_id`, `turno`, `orden_preferencia`) VALUES
(1, 1, 4, 'diurno', 'primera'),
(2, 1, 8, 'diurno', 'segunda'),
(3, 2, 1, 'diurno', 'primera'),
(4, 2, 8, 'diurno', 'segunda'),
(5, 3, 4, 'diurno', 'primera'),
(6, 3, 8, 'diurno', 'segunda'),
(7, 4, 4, 'diurno', 'primera'),
(8, 4, 8, 'diurno', 'segunda'),
(9, 5, 4, 'diurno', 'primera'),
(10, 5, 7, 'diurno', 'segunda');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postulantes`
--

DROP TABLE IF EXISTS `postulantes`;
CREATE TABLE `postulantes` (
  `id` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `dni` varchar(8) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `fecha_nacimiento` date NOT NULL,
  `edad` int(11) NOT NULL,
  `es_menor_edad` tinyint(1) DEFAULT 0,
  `direccion` text DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado_inscripcion` enum('pendiente','completado','rechazado') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `postulantes`
--

INSERT INTO `postulantes` (`id`, `nombres`, `apellidos`, `dni`, `email`, `telefono`, `fecha_nacimiento`, `edad`, `es_menor_edad`, `direccion`, `fecha_registro`, `estado_inscripcion`) VALUES
(1, 'Alessandro', 'Zelada', '73470109', 'alepaolo.2003@gmail.com', '+51972140274', '2003-09-23', 22, 0, 'Av Los Diamantes Mz E Lote 42', '2025-11-22 04:38:49', 'pendiente'),
(2, 'Alessandro', 'Zelada', '73740192', 'alepao2309@gmail.com', '972140274', '2003-09-20', 22, 0, 'Av Los Diamantes Mz E Lt 42', '2025-11-23 02:59:52', 'pendiente'),
(3, 'Paolo', 'Falconi', '73470108', 'alepaolo.23.09@gmail.com', '972140274', '2003-09-23', 22, 0, 'Callao 2140', '2025-11-23 18:44:27', 'pendiente'),
(4, 'dsa', 'das', '83920392', 'araoz@gmail.com', '999999923', '2004-09-23', 21, 0, 'SMP', '2025-11-23 21:12:20', 'pendiente'),
(5, 'Jeffersom', 'De La Cruz', '48293042', 'jefry@araoz.com', '982389499', '2000-09-15', 25, 0, 'Bellavista 423', '2025-11-24 00:16:03', 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programas_estudio`
--

DROP TABLE IF EXISTS `programas_estudio`;
CREATE TABLE `programas_estudio` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `duracion_semestres` int(11) DEFAULT 6,
  `modalidad` enum('diurno','nocturno','ambos') DEFAULT 'ambos',
  `estado` tinyint(1) DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `programas_estudio`
--

INSERT INTO `programas_estudio` (`id`, `nombre`, `descripcion`, `duracion_semestres`, `modalidad`, `estado`, `fecha_creacion`) VALUES
(1, 'Administración de Empresas', 'Programa de formación en gestión empresarial', 6, 'ambos', 1, '2025-11-22 03:40:52'),
(2, 'Contabilidad', 'Programa de formación contable y financiera', 6, 'ambos', 1, '2025-11-22 03:40:52'),
(3, 'Construcción Civil', 'Programa de formación en construcción e infraestructura', 6, 'ambos', 1, '2025-11-22 03:40:52'),
(4, 'Desarrollo de Sistemas de Información', 'Programa de formación en desarrollo de software', 6, 'ambos', 1, '2025-11-22 03:40:52'),
(5, 'Diseño Gráfico', 'Programa de formación en diseño visual y comunicación', 6, 'ambos', 1, '2025-11-22 03:40:52'),
(6, 'Diseño Publicitario', 'Programa de formación en publicidad y marketing', 6, 'ambos', 1, '2025-11-22 03:40:52'),
(7, 'Mecánica Automotriz', 'Programa de formación en reparación y mantenimiento vehicular', 6, 'ambos', 1, '2025-11-22 03:40:52'),
(8, 'Mecánica de Producción', 'Programa de formación en procesos industriales', 6, 'ambos', 1, '2025-11-22 03:40:52'),
(9, 'Secretariado Ejecutivo', 'Programa de formación en asistencia administrativa', 6, 'ambos', 1, '2025-11-22 03:40:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_examen`
--

DROP TABLE IF EXISTS `resultados_examen`;
CREATE TABLE `resultados_examen` (
  `id` int(11) NOT NULL,
  `inscripcion_id` int(11) NOT NULL,
  `puntaje_obtenido` decimal(5,2) DEFAULT NULL,
  `estado_resultado` enum('aprobado','desaprobado','pendiente') DEFAULT 'pendiente',
  `observaciones` text DEFAULT NULL,
  `fecha_evaluacion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_admin`
--

DROP TABLE IF EXISTS `usuarios_admin`;
CREATE TABLE `usuarios_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `nombre_completo` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `rol` enum('admin','coordinador','evaluador') DEFAULT 'evaluador',
  `activo` tinyint(1) DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `ultimo_acceso` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios_admin`
--

INSERT INTO `usuarios_admin` (`id`, `username`, `password_hash`, `nombre_completo`, `email`, `rol`, `activo`, `fecha_creacion`, `ultimo_acceso`) VALUES
(1, 'admin', '$2y$10$YgPIU6jxI6nj8VAjDeITauR7sCWDNP2nnwHxQ5sw5nqAickL9CqPm', 'Administrador Sistema', 'admin@mrap.edu.pe', 'admin', 1, '2025-11-22 03:40:55', '2025-11-24 00:22:02'),
(2, 'ale', '$2y$10$bXa42gpeUk5aB/Lwzp/UR.HImr4vq0mzpz5QVHqhjWHKAVoSpAqjK', 'Alessandro Paolo Zelada Falconi', 'ale@araoz.com', 'admin', 1, '2025-11-24 01:19:09', '2025-11-24 01:23:36'),
(3, 'coordinador', '$2y$10$wuaYKVb4RJKjYfxaM5o96eWvRjKE.nABO2IxvE/UiYEcd3fS1vwwW', 'Jose Luis Rodriguez', 'jose@araoz.com', 'coordinador', 1, '2025-11-24 01:20:37', '2025-11-24 01:22:54'),
(4, 'evaluador', '$2y$10$aIiazTOR5KJrRPP60Jczyuhw3PF2d0qQ1hIlgwM8M76qLztKsfzay', 'Miguel Morán', 'miguel@araoz.com', 'evaluador', 1, '2025-11-24 01:21:39', '2025-11-24 01:21:55');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_postulantes_completo`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `vista_postulantes_completo`;
CREATE TABLE `vista_postulantes_completo` (
`id` int(11)
,`nombres` varchar(100)
,`apellidos` varchar(100)
,`dni` varchar(8)
,`email` varchar(150)
,`telefono` varchar(15)
,`fecha_nacimiento` date
,`edad` int(11)
,`es_menor_edad` tinyint(1)
,`estado_inscripcion` enum('pendiente','completado','rechazado')
,`fecha_registro` timestamp
,`colegio_procedencia` varchar(200)
,`grado_actual` enum('secundaria_incompleta','secundaria_completa','tecnica_curso','tecnica_completa','tecnica_incompleta','universitaria_curso','universitaria_completa','universitaria_incompleta')
,`promedio_ultimo` decimal(4,2)
,`programa_primera_opcion` varchar(100)
,`turno_primera_opcion` enum('diurno','nocturno')
,`programa_segunda_opcion` varchar(100)
,`turno_segunda_opcion` enum('diurno','nocturno')
,`nombre_apoderado` varchar(200)
,`parentesco` enum('padre','madre','tutor','otro')
,`telefono_apoderado` varchar(15)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_postulantes_completo`
--
DROP TABLE IF EXISTS `vista_postulantes_completo`;

DROP VIEW IF EXISTS `vista_postulantes_completo`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_postulantes_completo`  AS SELECT `p`.`id` AS `id`, `p`.`nombres` AS `nombres`, `p`.`apellidos` AS `apellidos`, `p`.`dni` AS `dni`, `p`.`email` AS `email`, `p`.`telefono` AS `telefono`, `p`.`fecha_nacimiento` AS `fecha_nacimiento`, `p`.`edad` AS `edad`, `p`.`es_menor_edad` AS `es_menor_edad`, `p`.`estado_inscripcion` AS `estado_inscripcion`, `p`.`fecha_registro` AS `fecha_registro`, `ia`.`colegio_procedencia` AS `colegio_procedencia`, `ia`.`grado_actual` AS `grado_actual`, `ia`.`promedio_ultimo` AS `promedio_ultimo`, `prog1`.`nombre` AS `programa_primera_opcion`, `oc1`.`turno` AS `turno_primera_opcion`, `prog2`.`nombre` AS `programa_segunda_opcion`, `oc2`.`turno` AS `turno_segunda_opcion`, `ap`.`nombre_completo` AS `nombre_apoderado`, `ap`.`parentesco` AS `parentesco`, `ap`.`telefono` AS `telefono_apoderado` FROM ((((((`postulantes` `p` left join `informacion_academica` `ia` on(`p`.`id` = `ia`.`postulante_id`)) left join `opciones_carrera` `oc1` on(`p`.`id` = `oc1`.`postulante_id` and `oc1`.`orden_preferencia` = 'primera')) left join `programas_estudio` `prog1` on(`oc1`.`programa_id` = `prog1`.`id`)) left join `opciones_carrera` `oc2` on(`p`.`id` = `oc2`.`postulante_id` and `oc2`.`orden_preferencia` = 'segunda')) left join `programas_estudio` `prog2` on(`oc2`.`programa_id` = `prog2`.`id`)) left join `apoderados` `ap` on(`p`.`id` = `ap`.`postulante_id`)) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `apoderados`
--
ALTER TABLE `apoderados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `postulante_id` (`postulante_id`);

--
-- Indices de la tabla `declaraciones_juradas`
--
ALTER TABLE `declaraciones_juradas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `postulante_id` (`postulante_id`);

--
-- Indices de la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_postulante_tipo` (`postulante_id`,`tipo_documento`);

--
-- Indices de la tabla `examenes_admision`
--
ALTER TABLE `examenes_admision`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo_examen` (`codigo_examen`);

--
-- Indices de la tabla `informacion_academica`
--
ALTER TABLE `informacion_academica`
  ADD PRIMARY KEY (`id`),
  ADD KEY `postulante_id` (`postulante_id`);

--
-- Indices de la tabla `inscripciones_examen`
--
ALTER TABLE `inscripciones_examen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo_inscripcion` (`codigo_inscripcion`),
  ADD UNIQUE KEY `unique_postulante_examen` (`postulante_id`,`examen_id`),
  ADD KEY `examen_id` (`examen_id`);

--
-- Indices de la tabla `logs_sistema`
--
ALTER TABLE `logs_sistema`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_fecha` (`fecha_hora`),
  ADD KEY `idx_usuario` (`usuario_id`);

--
-- Indices de la tabla `opciones_carrera`
--
ALTER TABLE `opciones_carrera`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_postulante_orden` (`postulante_id`,`orden_preferencia`),
  ADD KEY `programa_id` (`programa_id`);

--
-- Indices de la tabla `postulantes`
--
ALTER TABLE `postulantes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dni` (`dni`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_dni` (`dni`),
  ADD KEY `idx_email` (`email`);

--
-- Indices de la tabla `programas_estudio`
--
ALTER TABLE `programas_estudio`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `resultados_examen`
--
ALTER TABLE `resultados_examen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inscripcion_id` (`inscripcion_id`);

--
-- Indices de la tabla `usuarios_admin`
--
ALTER TABLE `usuarios_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `apoderados`
--
ALTER TABLE `apoderados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `declaraciones_juradas`
--
ALTER TABLE `declaraciones_juradas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `examenes_admision`
--
ALTER TABLE `examenes_admision`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `informacion_academica`
--
ALTER TABLE `informacion_academica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `inscripciones_examen`
--
ALTER TABLE `inscripciones_examen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `logs_sistema`
--
ALTER TABLE `logs_sistema`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `opciones_carrera`
--
ALTER TABLE `opciones_carrera`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `postulantes`
--
ALTER TABLE `postulantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `programas_estudio`
--
ALTER TABLE `programas_estudio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `resultados_examen`
--
ALTER TABLE `resultados_examen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios_admin`
--
ALTER TABLE `usuarios_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `apoderados`
--
ALTER TABLE `apoderados`
  ADD CONSTRAINT `apoderados_ibfk_1` FOREIGN KEY (`postulante_id`) REFERENCES `postulantes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `declaraciones_juradas`
--
ALTER TABLE `declaraciones_juradas`
  ADD CONSTRAINT `declaraciones_juradas_ibfk_1` FOREIGN KEY (`postulante_id`) REFERENCES `postulantes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD CONSTRAINT `documentos_ibfk_1` FOREIGN KEY (`postulante_id`) REFERENCES `postulantes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `informacion_academica`
--
ALTER TABLE `informacion_academica`
  ADD CONSTRAINT `informacion_academica_ibfk_1` FOREIGN KEY (`postulante_id`) REFERENCES `postulantes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `inscripciones_examen`
--
ALTER TABLE `inscripciones_examen`
  ADD CONSTRAINT `inscripciones_examen_ibfk_1` FOREIGN KEY (`postulante_id`) REFERENCES `postulantes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inscripciones_examen_ibfk_2` FOREIGN KEY (`examen_id`) REFERENCES `examenes_admision` (`id`);

--
-- Filtros para la tabla `logs_sistema`
--
ALTER TABLE `logs_sistema`
  ADD CONSTRAINT `logs_sistema_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios_admin` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `opciones_carrera`
--
ALTER TABLE `opciones_carrera`
  ADD CONSTRAINT `opciones_carrera_ibfk_1` FOREIGN KEY (`postulante_id`) REFERENCES `postulantes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `opciones_carrera_ibfk_2` FOREIGN KEY (`programa_id`) REFERENCES `programas_estudio` (`id`);

--
-- Filtros para la tabla `resultados_examen`
--
ALTER TABLE `resultados_examen`
  ADD CONSTRAINT `resultados_examen_ibfk_1` FOREIGN KEY (`inscripcion_id`) REFERENCES `inscripciones_examen` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
