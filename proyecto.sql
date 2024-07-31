-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-07-2024 a las 04:45:01
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `Id` int(11) NOT NULL,
  `Id_usuario` int(11) NOT NULL,
  `Id_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`Id`, `Id_usuario`, `Id_rol`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificacion`
--

CREATE TABLE `calificacion` (
  `Id` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `Nota` int(11) NOT NULL,
  `Id_tarea` int(11) NOT NULL,
  `Calificacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `calificacion`
--

INSERT INTO `calificacion` (`Id`, `Fecha`, `Nota`, `Id_tarea`, `Calificacion`) VALUES
(1, '2024-07-01', 90, 1, NULL),
(2, '2024-07-15', 85, 2, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE `estudiante` (
  `Id` int(11) NOT NULL,
  `Curso` varchar(50) NOT NULL,
  `Id_persona` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estudiante`
--

INSERT INTO `estudiante` (`Id`, `Curso`, `Id_persona`) VALUES
(1, '1A', 3),
(2, '1B', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante_tarea`
--

CREATE TABLE `estudiante_tarea` (
  `Id` int(11) NOT NULL,
  `Id_estudiante` int(11) NOT NULL,
  `Id_tarea` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estudiante_tarea`
--

INSERT INTO `estudiante_tarea` (`Id`, `Id_estudiante`, `Id_tarea`) VALUES
(1, 1, 1),
(2, 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materia`
--

CREATE TABLE `materia` (
  `Id` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materia`
--

INSERT INTO `materia` (`Id`, `Nombre`) VALUES
(1, 'Matemáticas'),
(2, 'Ciencias'),
(3, 'Historia'),
(4, 'Lengua');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacion_calificacion`
--

CREATE TABLE `notificacion_calificacion` (
  `Id` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `Id_calificacion` int(11) NOT NULL,
  `Id_tutor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notificacion_calificacion`
--

INSERT INTO `notificacion_calificacion` (`Id`, `Fecha`, `Id_calificacion`, `Id_tutor`) VALUES
(1, '2024-07-01', 1, 1),
(2, '2024-07-15', 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacion_reunion`
--

CREATE TABLE `notificacion_reunion` (
  `Id` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `Id_reunion` int(11) NOT NULL,
  `Id_tutor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notificacion_reunion`
--

INSERT INTO `notificacion_reunion` (`Id`, `Fecha`, `Id_reunion`, `Id_tutor`) VALUES
(1, '2024-07-10', 1, 1),
(2, '2024-07-18', 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `Id` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Apellido` varchar(50) NOT NULL,
  `Telefono` int(11) NOT NULL,
  `Edad` int(11) NOT NULL,
  `Direccion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para laa tabla `persona`
--

INSERT INTO `persona` (`Id`, `Nombre`, `Apellido`, `Telefono`, `Edad`, `Direccion`) VALUES
(1, 'Juan', 'Pérez', 123456789, 35, 'Calle Falsa 123'),
(2, 'María', 'López', 987654321, 42, 'Avenida Siempreviva 742'),
(3, 'Carlos', 'Sánchez', 555123456, 29, 'Calle Luna 456'),
(4, 'Ana', 'García', 444555666, 25, 'Calle Sol 789');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor`
--

CREATE TABLE `profesor` (
  `Id` int(11) NOT NULL,
  `Id_persona` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesor`
--

INSERT INTO `profesor` (`Id`, `Id_persona`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reunion`
--

CREATE TABLE `reunion` (
  `Id` int(11) NOT NULL,
  `Titulo` varchar(50) NOT NULL,
  `Descripcion` varchar(50) DEFAULT NULL,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Id_profesor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reunion`
--

INSERT INTO `reunion` (`Id`, `Titulo`, `Descripcion`, `Fecha`, `Hora`, `Id_profesor`) VALUES
(1, 'Reunión general', 'Reunión para discutir temas importantes', '2024-07-20', '10:00:00', 1),
(2, 'Reunión de evaluación', 'Evaluación de los estudiantes', '2024-07-25', '12:00:00', 2),
(8, 'dsdsdsd', NULL, '2024-07-28', '16:36:00', 1),
(9, 'hola', NULL, '2024-07-11', '16:51:00', 2),
(10, 'dcdcrrfg', NULL, '2024-07-31', '19:22:00', 1),
(11, 'el chatin', NULL, '2024-07-31', '22:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `Id` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`Id`, `Nombre`) VALUES
(1, 'Administrador'),
(2, 'Profesor'),
(3, 'Estudiante'),
(4, 'Tutor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarea`
--

CREATE TABLE `tarea` (
  `Id` int(11) NOT NULL,
  `Titulo` varchar(50) NOT NULL,
  `Descripcion` varchar(50) NOT NULL,
  `Fecha_inicio` date NOT NULL,
  `Fecha_presentacion` date NOT NULL,
  `Id_profesor` int(11) NOT NULL,
  `Id_materia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tarea`
--

INSERT INTO `tarea` (`Id`, `Titulo`, `Descripcion`, `Fecha_inicio`, `Fecha_presentacion`, `Id_profesor`, `Id_materia`) VALUES
(1, 'jsdkjc', 'frtfvrgtv', '2024-08-01', '2024-08-01', 1, 1),
(2, 'Excursión escolar', 'Visita al museo de ciencias', '2024-08-15', '2024-08-15', 2, 2),
(3, 'perchas', 'dasdasd', '2024-07-28', '2024-07-28', 1, 1),
(4, 'fqeaftrg', 'tverftrgf', '2024-07-28', '2024-07-28', 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tutor`
--

CREATE TABLE `tutor` (
  `Id` int(11) NOT NULL,
  `Id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tutor`
--

INSERT INTO `tutor` (`Id`, `Id_usuario`) VALUES
(1, 3),
(2, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `Id` int(11) NOT NULL,
  `Correo` varchar(255) NOT NULL,
  `Contraseña` varchar(255) NOT NULL,
  `Id_persona` int(11) NOT NULL,
  `Rol` enum('tutor','encargado') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`Id`, `Correo`, `Contraseña`, `Id_persona`, `Rol`) VALUES
(1, 'juan', 'password1', 1, 'tutor'),
(2, 'maria', 'password2', 2, 'tutor'),
(3, 'carlos', 'password3', 3, 'tutor'),
(4, 'ana', 'password4', 4, 'tutor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `uusuario`
--

CREATE TABLE `uusuario` (
  `Id` int(11) NOT NULL,
  `Usuario` varchar(255) NOT NULL,
  `Contrasena` varchar(255) NOT NULL,
  `Rol` enum('tutor','encargado') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_usuario` (`Id_usuario`),
  ADD KEY `Id_rol` (`Id_rol`);

--
-- Indices de la tabla `calificacion`
--
ALTER TABLE `calificacion`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_tarea` (`Id_tarea`);

--
-- Indices de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_persona` (`Id_persona`);

--
-- Indices de la tabla `estudiante_tarea`
--
ALTER TABLE `estudiante_tarea`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_estudiante` (`Id_estudiante`),
  ADD KEY `Id_tarea` (`Id_tarea`);

--
-- Indices de la tabla `materia`
--
ALTER TABLE `materia`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `notificacion_calificacion`
--
ALTER TABLE `notificacion_calificacion`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_calificacion` (`Id_calificacion`),
  ADD KEY `Id_tutor` (`Id_tutor`);

--
-- Indices de la tabla `notificacion_reunion`
--
ALTER TABLE `notificacion_reunion`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_reunion` (`Id_reunion`),
  ADD KEY `Id_tutor` (`Id_tutor`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `profesor`
--
ALTER TABLE `profesor`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_persona` (`Id_persona`);

--
-- Indices de la tabla `reunion`
--
ALTER TABLE `reunion`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_profesor` (`Id_profesor`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `tarea`
--
ALTER TABLE `tarea`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_profesor` (`Id_profesor`),
  ADD KEY `Id_materia` (`Id_materia`);

--
-- Indices de la tabla `tutor`
--
ALTER TABLE `tutor`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_usuario` (`Id_usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_persona` (`Id_persona`);

--
-- Indices de la tabla `uusuario`
--
ALTER TABLE `uusuario`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Usuario` (`Usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `calificacion`
--
ALTER TABLE `calificacion`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estudiante_tarea`
--
ALTER TABLE `estudiante_tarea`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `materia`
--
ALTER TABLE `materia`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `notificacion_calificacion`
--
ALTER TABLE `notificacion_calificacion`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `notificacion_reunion`
--
ALTER TABLE `notificacion_reunion`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `profesor`
--
ALTER TABLE `profesor`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `reunion`
--
ALTER TABLE `reunion`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tarea`
--
ALTER TABLE `tarea`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tutor`
--
ALTER TABLE `tutor`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `uusuario`
--
ALTER TABLE `uusuario`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD CONSTRAINT `administrador_ibfk_1` FOREIGN KEY (`Id_usuario`) REFERENCES `usuario` (`Id`),
  ADD CONSTRAINT `administrador_ibfk_2` FOREIGN KEY (`Id_rol`) REFERENCES `rol` (`Id`);

--
-- Filtros para la tabla `calificacion`
--
ALTER TABLE `calificacion`
  ADD CONSTRAINT `calificacion_ibfk_1` FOREIGN KEY (`Id_tarea`) REFERENCES `tarea` (`Id`);

--
-- Filtros para la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD CONSTRAINT `estudiante_ibfk_1` FOREIGN KEY (`Id_persona`) REFERENCES `persona` (`Id`);

--
-- Filtros para la tabla `estudiante_tarea`
--
ALTER TABLE `estudiante_tarea`
  ADD CONSTRAINT `estudiante_tarea_ibfk_1` FOREIGN KEY (`Id_estudiante`) REFERENCES `estudiante` (`Id`),
  ADD CONSTRAINT `estudiante_tarea_ibfk_2` FOREIGN KEY (`Id_tarea`) REFERENCES `tarea` (`Id`);

--
-- Filtros para la tabla `notificacion_calificacion`
--
ALTER TABLE `notificacion_calificacion`
  ADD CONSTRAINT `notificacion_calificacion_ibfk_1` FOREIGN KEY (`Id_calificacion`) REFERENCES `calificacion` (`Id`),
  ADD CONSTRAINT `notificacion_calificacion_ibfk_2` FOREIGN KEY (`Id_tutor`) REFERENCES `tutor` (`Id`);

--
-- Filtros para la tabla `notificacion_reunion`
--
ALTER TABLE `notificacion_reunion`
  ADD CONSTRAINT `notificacion_reunion_ibfk_1` FOREIGN KEY (`Id_reunion`) REFERENCES `reunion` (`Id`),
  ADD CONSTRAINT `notificacion_reunion_ibfk_2` FOREIGN KEY (`Id_tutor`) REFERENCES `tutor` (`Id`);

--
-- Filtros para la tabla `profesor`
--
ALTER TABLE `profesor`
  ADD CONSTRAINT `profesor_ibfk_1` FOREIGN KEY (`Id_persona`) REFERENCES `persona` (`Id`);

--
-- Filtros para la tabla `reunion`
--
ALTER TABLE `reunion`
  ADD CONSTRAINT `reunion_ibfk_1` FOREIGN KEY (`Id_profesor`) REFERENCES `profesor` (`Id`);

--
-- Filtros para la tabla `tarea`
--
ALTER TABLE `tarea`
  ADD CONSTRAINT `tarea_ibfk_1` FOREIGN KEY (`Id_profesor`) REFERENCES `profesor` (`Id`),
  ADD CONSTRAINT `tarea_ibfk_2` FOREIGN KEY (`Id_materia`) REFERENCES `materia` (`Id`);

--
-- Filtros para la tabla `tutor`
--
ALTER TABLE `tutor`
  ADD CONSTRAINT `tutor_ibfk_1` FOREIGN KEY (`Id_usuario`) REFERENCES `usuario` (`Id`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`Id_persona`) REFERENCES `persona` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
