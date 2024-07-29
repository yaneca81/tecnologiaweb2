-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 29-07-2024 a las 22:09:03
-- Versión del servidor: 8.2.0
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `practicas_profesionales`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ofertas`
--

DROP TABLE IF EXISTS `ofertas`;
CREATE TABLE IF NOT EXISTS `ofertas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `categoria` enum('Estudiante','Egresado','Tiempo Completo','Medio Tiempo','Freelance') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `empresa` varchar(100) DEFAULT NULL,
  `email_contacto` varchar(100) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `activa` tinyint(1) DEFAULT '1',
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `ofertas`
--

INSERT INTO `ofertas` (`id`, `titulo`, `descripcion`, `categoria`, `empresa`, `email_contacto`, `imagen`, `activa`, `fecha_creacion`) VALUES
(1, 'Programador Junior Java', 'Desarrollo de aplicaciones en Java.', 'Estudiante', 'TecnoSoft', 'contacto@tecnosoft.com', 'imagen1.png', 1, '2024-07-29 22:08:49'),
(2, 'Analista de Sistemas', 'Análisis y diseño de sistemas informáticos.', 'Estudiante', 'CAS', 'contacto@cas.com', 'imagen2.png', 1, '2024-07-29 22:08:49'),
(3, 'Desarrollador Backend', 'Desarrollo de APIs y servicios backend.', 'Egresado', 'Innovatech', 'contacto@innovatech.com', 'imagen3.png', 1, '2024-07-29 22:08:49'),
(4, 'Programador Junior Java', 'Desarrollo de aplicaciones en Java.', 'Estudiante', 'Netsolutions', 'info@netsolutions.com', 'imagen4.png', 1, '2024-07-29 22:08:49')


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postulaciones`
--

DROP TABLE IF EXISTS `postulaciones`;
CREATE TABLE IF NOT EXISTS `postulaciones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int DEFAULT NULL,
  `id_oferta` int DEFAULT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_oferta` (`id_oferta`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `estado` enum('Estudiante','Egresado') NOT NULL,
  `rol` enum('admin','usuario') DEFAULT 'usuario',
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `contraseña`, `imagen`, `estado`, `rol`, `fecha_creacion`) VALUES
(1, 'grupo7', 'grupo7@gmail.com', 'admin123', NULL, 'Estudiante', 'admin', '0000-00-00 00:00:00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
