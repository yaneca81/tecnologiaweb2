
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

-- creacion del usuario admin
-- user : admin
-- password: admin
insert into usuario (user, password, nombre, apellido, correo, telefono, direccion, foto, rol) values ('admin', '$2y$10$wHPAaj8oKnpYFEpfDbG9xeb/WpnpEy80yS0EiN9lhNoJ4xJ8nLXeq', 'admin', 'admin', 'admin@empleos.com', 00000000, 'admin', '../uploads/usuarios/sinFoto.png', 'admin');


-- modificacion de la tabla empleo y postulacion
-- campo foto en empleo
-- campo archivo en postilacion
-- Añadir columna 'foto' a la tabla 'empleo'


-- revisar los inserts antes de actualizar a github


ALTER TABLE `empleo`
ADD COLUMN `foto` varchar(255) NOT NULL;

-- Añadir columna 'archivo' a la tabla 'postulacion'
ALTER TABLE `postulacion`
ADD COLUMN `archivo` varchar(255) NOT NULL AFTER `fecha`;

ALTER TABLE `postulacion`
ADD COLUMN `mensaje` varchar(220) NOT NULL AFTER `archivo`;

-- base de datos actualizada
