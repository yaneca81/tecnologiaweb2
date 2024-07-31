-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS ofertas
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

-- Seleccionar la base de datos para usarla
USE ofertas;

-- Estructura de tabla para la tabla `usuarios`
CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `correo` varchar(255) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `rol` enum('candidato','empresa','admin') NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Estructura de tabla para la tabla `candidatos`
CREATE TABLE `candidatos` (
  `id_candidato` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_candidato`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `candidatos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Estructura de tabla para la tabla `curriculums`
CREATE TABLE `curriculums` (
  `id_curriculum` int(11) NOT NULL AUTO_INCREMENT,
  `id_candidato` int(11) NOT NULL,
  `archivo` varchar(255) NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id_curriculum`),
  KEY `id_candidato` (`id_candidato`),
  CONSTRAINT `curriculums_ibfk_1` FOREIGN KEY (`id_candidato`) REFERENCES `candidatos` (`id_candidato`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Estructura de tabla para la tabla `empresas`
CREATE TABLE `empresas` (
  `id_empresa` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_empresa`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `empresas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Estructura de tabla para la tabla `ofertas_trabajo`
CREATE TABLE `ofertas_trabajo` (
  `id_oferta` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `requisitos` text DEFAULT NULL,
  `fecha` date NOT NULL,
  `salario` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_oferta`),
  KEY `id_empresa` (`id_empresa`),
  CONSTRAINT `ofertas_trabajo_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id_empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Estructura de tabla para la tabla `entrevistas`
CREATE TABLE `entrevistas` (
  `id_entrevista` int(11) NOT NULL AUTO_INCREMENT,
  `id_oferta` int(11) NOT NULL,
  `id_candidato` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `estado` enum('pendiente','confirmada','rechazada') NOT NULL,
  PRIMARY KEY (`id_entrevista`),
  KEY `id_oferta` (`id_oferta`),
  KEY `id_candidato` (`id_candidato`),
  CONSTRAINT `entrevistas_ibfk_1` FOREIGN KEY (`id_oferta`) REFERENCES `ofertas_trabajo` (`id_oferta`),
  CONSTRAINT `entrevistas_ibfk_2` FOREIGN KEY (`id_candidato`) REFERENCES `candidatos` (`id_candidato`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
