
create database EmpleosBD;
use EmpleosBD;
--
-- Estructura de tabla para la tabla `empleo`
--

CREATE TABLE `empleo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(20) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `categoria` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
);

--creacion de un empleo test
insert into empleo (titulo, descripcion, categoria) values ('Test', 'este es la descripcion de test', 'test');
select * from empleo;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postulacion`
--

CREATE TABLE `postulacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_empleo` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `estado` enum('espera','aceptado','rechazado') NOT NULL DEFAULT 'espera',
  PRIMARY KEY (`id`),
  KEY `fk_usuario_postulacion` (`id_usuario`),
  KEY `fk_empleo_postulacion` (`id_empleo`),
  CONSTRAINT `fk_empleo_postulacion` FOREIGN KEY (`id_empleo`) REFERENCES `empleo` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_usuario_postulacion` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellido` varchar(20) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `telefono` int(8) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `rol` enum('estudiante','admin') NOT NULL DEFAULT 'estudiante',
  PRIMARY KEY (`id`, `user`)
);


-- creacion de un usuario admin
insert into usuario (user, password, nombre, apellido, correo, telefono, direccion, foto, rol) values ('admin', '$2y$10$wHPAaj8oKnpYFEpfDbG9xeb/WpnpEy80yS0EiN9lhNoJ4xJ8nLXeq', 'admin', 'admin', 'admin@empleos.com', 00000000, 'admin', 'Sin foto', 'admin');

--proximos cambios a la base de datos
-- 1. añadir un campo a postulacion para subir archivos pdf
-- 2. añadir un campo varchar para foto, en la tabla empleo para poder hacer mas diseño