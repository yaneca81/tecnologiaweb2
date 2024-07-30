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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `contraseña`, `imagen`, `estado`, `rol`, `fecha_creacion`) VALUES
(1, 'grupo7', 'grupo7@gmail.com', 'admin123', NULL, 'Estudiante', 'admin', '2024-07-29 00:00:00');

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcado de datos para la tabla `ofertas`
--

INSERT INTO `ofertas` (`id`, `titulo`, `descripcion`, `categoria`, `empresa`, `email_contacto`, `imagen`, `activa`, `fecha_creacion`) VALUES
(1, 'Programador Junior Java', 'Desarrollo de aplicaciones en Java.', 'Estudiante', 'TecnoSoft', 'contacto@tecnosoft.com', 'imagen1.png', 1, '2024-07-29 22:08:49'),
(2, 'Analista de Sistemas', 'Análisis y diseño de sistemas informáticos.', 'Estudiante', 'CAS', 'contacto@cas.com', 'imagen2.png', 1, '2024-07-29 22:08:49'),
(3, 'Desarrollador Backend', 'Desarrollo de APIs y servicios backend.', 'Egresado', 'Innovatech', 'contacto@innovatech.com', 'imagen3.png', 1, '2024-07-29 22:08:49'),
(4, 'Programador Junior Java', 'Desarrollo de aplicaciones en Java.', 'Estudiante', 'Netsolutions', 'info@netsolutions.com', 'imagen4.png', 1, '2024-07-29 22:08:49');

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
  KEY `id_oferta` (`id_oferta`),
  CONSTRAINT `fk_postulaciones_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `fk_postulaciones_oferta` FOREIGN KEY (`id_oferta`) REFERENCES `ofertas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
