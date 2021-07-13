-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-11-2020 a las 02:30:51
-- Versión del servidor: 10.4.13-MariaDB
-- Versión de PHP: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `database_animal`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adjunto`
--

CREATE TABLE `adjunto` (
  `id_adjunto` int(7) UNSIGNED ZEROFILL NOT NULL,
  `fk_reporte` int(7) UNSIGNED ZEROFILL NOT NULL,
  `fk_caso` int(7) UNSIGNED ZEROFILL NOT NULL,
  `url` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caso_maltrato`
--

CREATE TABLE `caso_maltrato` (
  `id_caso` int(7) UNSIGNED ZEROFILL NOT NULL,
  `fk_reporte` int(7) UNSIGNED ZEROFILL NOT NULL,
  `fk_estado` int(2) UNSIGNED ZEROFILL NOT NULL,
  `fk_adjunto` int(7) UNSIGNED ZEROFILL NOT NULL,
  `fk_usuario` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `fk_departamento` int(2) UNSIGNED ZEROFILL NOT NULL,
  `fk_municipio` int(4) UNSIGNED ZEROFILL NOT NULL,
  `nombre` varchar(70) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Nombre del caso',
  `anotaciones` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte`
--

CREATE TABLE `reporte` (
  `id_reporte` int(7) UNSIGNED ZEROFILL NOT NULL,
  `fecha_reporte` timestamp NOT NULL DEFAULT current_timestamp(),
  `fk_tipo_documento` int(2) UNSIGNED ZEROFILL NOT NULL,
  `fk_adjunto` int(7) UNSIGNED ZEROFILL NOT NULL,
  `nombres_denunciante` varchar(25) NOT NULL,
  `apellidos_denunciante` varchar(25) NOT NULL,
  `documento_identidad_denunciante` varchar(15) NOT NULL,
  `email_denunciante` varchar(50) NOT NULL,
  `telefono_denunciante` varchar(15) DEFAULT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `fk_departamento` int(2) UNSIGNED ZEROFILL NOT NULL,
  `fk_municipio` int(4) UNSIGNED ZEROFILL NOT NULL,
  `direccion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `hambre_sed` varchar(11) NOT NULL,
  `malestar_fisico` varchar(11) NOT NULL,
  `negligencia` varchar(11) NOT NULL,
  `miedo_estres` varchar(11) NOT NULL,
  `comportamiento_natural` varchar(11) NOT NULL,
  `agresion_fisica` varchar(11) NOT NULL,
  `agresion_verbal` varchar(11) NOT NULL,
  `bienestar_animal` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `id_departamento` int(2) UNSIGNED ZEROFILL NOT NULL,
  `descripcion` varchar(30) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`id_departamento`, `descripcion`) VALUES
(01, 'Quindío');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `id_estado` int(2) UNSIGNED ZEROFILL NOT NULL,
  `descripcion` varchar(15) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id_estado`, `descripcion`) VALUES
(01, 'Abierto'),
(02, 'Cerrado'),
(03, 'Descartado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipio`
--

CREATE TABLE `municipio` (
  `id_municipio` int(4) UNSIGNED ZEROFILL NOT NULL,
  `fk_departamento` int(2) UNSIGNED ZEROFILL NOT NULL,
  `descripcion` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `municipio`
--

INSERT INTO `municipio` (`id_municipio`, `fk_departamento`, `descripcion`) VALUES
(0001, 01, 'Armenia'),
(0002, 01, 'Buenavista'),
(0003, 01, 'Calarcá'),
(0004, 01, 'Circasia'),
(0005, 01, 'Córdoba'),
(0006, 01, 'Filandia'),
(0007, 01, 'Génova'),
(0008, 01, 'La Tebaida'),
(0009, 01, 'Montenegro'),
(0010, 01, 'Pijao'),
(0011, 01, 'Quimbaya'),
(0012, 01, 'Salento');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguimiento`
--

CREATE TABLE `seguimiento` (
  `id_seguimiento` int(7) UNSIGNED ZEROFILL NOT NULL,
  `fk_caso_maltrato` int(7) UNSIGNED ZEROFILL NOT NULL,
  `fk_tipo_seguimiento` int(2) UNSIGNED ZEROFILL NOT NULL,
  `fk_usuario` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `titulo` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(2) UNSIGNED ZEROFILL NOT NULL,
  `descripcion` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `descripcion`) VALUES
(01, 'Administrador'),
(02, 'Policia ambiental');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `id_tipo_documento` int(3) UNSIGNED ZEROFILL NOT NULL,
  `descripcion` varchar(30) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`id_tipo_documento`, `descripcion`) VALUES
(001, 'Cédula de ciudadanía'),
(002, 'Cédula de extranjería'),
(003, 'Tarjeta de identidad'),
(004, 'Otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_seguimiento`
--

CREATE TABLE `tipo_seguimiento` (
  `id_tipo_seguimiento` int(2) UNSIGNED ZEROFILL NOT NULL,
  `descripcion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `fk_tipo_documento` int(7) UNSIGNED ZEROFILL NOT NULL,
  `fk_rol` int(2) UNSIGNED ZEROFILL NOT NULL,
  `password` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `nombres` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `documento_identidad` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  `registro_ultimo_acceso` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `adjunto`
--
ALTER TABLE `adjunto`
  ADD PRIMARY KEY (`id_adjunto`),
  ADD KEY (`fk_reporte`),
  ADD KEY (`fk_caso`);

-- Indices de la tabla `caso_maltrato`
--
ALTER TABLE `caso_maltrato`
  ADD PRIMARY KEY (`id_caso`),
  ADD KEY (`fk_reporte`),
  ADD KEY (`fk_municipio`),
  ADD KEY (`fk_departamento`),
  ADD KEY (`fk_estado`),
  ADD KEY (`fk_adjunto`),
  ADD KEY (`fk_usuario`);

--
-- Indices de la tabla `reporte`
--
ALTER TABLE `reporte`
  ADD PRIMARY KEY (`id_reporte`),
  ADD KEY (`fk_tipo_documento`),
  ADD KEY (`fk_departamento`),
  ADD KEY (`fk_municipio`),
  ADD KEY (`fk_adjunto`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id_departamento`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id_estado`),
  ADD UNIQUE KEY `descripcion` (`descripcion`);

--
-- Indices de la tabla `municipio`
--
ALTER TABLE `municipio`
  ADD PRIMARY KEY (`id_municipio`),
  ADD KEY(`fk_departamento`);

--
-- Indices de la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
  ADD PRIMARY KEY (`id_seguimiento`),
  ADD KEY (`fk_caso_maltrato`) ,
  ADD KEY (`fk_tipo_seguimiento`),
  ADD KEY (`fk_usuario`);


--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`id_tipo_documento`),
  ADD UNIQUE KEY `descripcion` (`descripcion`);

--
-- Indices de la tabla `tipo_seguimiento`
--
ALTER TABLE `tipo_seguimiento`
  ADD PRIMARY KEY (`id_tipo_seguimiento`),
  ADD UNIQUE KEY `descripcion` (`descripcion`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `documento_identidad` (`documento_identidad`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`),
  ADD KEY (`fk_tipo_documento`),
  ADD KEY (`fk_rol`);
 

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `adjunto`
--
ALTER TABLE `adjunto`
  MODIFY `id_adjunto` int(7) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `caso_maltrato`
--
ALTER TABLE `caso_maltrato`
  MODIFY `id_caso` int(7) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reporte`
--
ALTER TABLE `reporte`
  MODIFY `id_reporte` int(7) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;


--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `id_departamento` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id_estado` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `municipio`
--
ALTER TABLE `municipio`
  MODIFY `id_municipio` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
  MODIFY `id_seguimiento` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `id_tipo_documento` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_seguimiento`
--
ALTER TABLE `tipo_seguimiento`
  MODIFY `id_tipo_seguimiento` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `adjunto`
--
ALTER TABLE `adjunto`
  ADD CONSTRAINT `adjunto_ibfk_1` FOREIGN KEY (`fk_reporte`) REFERENCES `reporte`(`id_reporte`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `adjunto_ibfk_2` FOREIGN KEY (`fk_caso`) REFERENCES `caso_maltrato`(`id_caso`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `caso_maltrato`
--
ALTER TABLE `caso_maltrato`
  ADD CONSTRAINT `caso_maltrato_ibfk_1` FOREIGN KEY (`fk_reporte`) REFERENCES `reporte`(`id_reporte`),
  ADD CONSTRAINT `caso_maltrato_ibfk_2` FOREIGN KEY (`fk_estado`) REFERENCES `estado`(`id_estado`),
  ADD CONSTRAINT `caso_maltrato_ibfk_3` FOREIGN KEY(`fk_departamento`) REFERENCES `departamento`(`id_departamento`),
  ADD CONSTRAINT `caso_maltrato_ibfk_4` FOREIGN KEY(`fk_municipio`) REFERENCES `municipio`(`id_municipio`),
  ADD CONSTRAINT `caso_maltrato_ibfk_5` FOREIGN KEY(`fk_adjunto`) REFERENCES `adjunto`(`id_adjunto`),
  ADD CONSTRAINT `caso_maltrato_ibfk_6` FOREIGN KEY (`fk_usuario`) REFERENCES `usuario`(`id_usuario`);

--
-- Filtros para la tabla `caso_maltrato`
--
ALTER TABLE `reporte`
  ADD CONSTRAINT `reporte_ibfk_1` FOREIGN KEY (`fk_tipo_documento`) REFERENCES `tipo_documento`(`id_tipo_documento`),
  ADD CONSTRAINT `reporte_ibfk_2` FOREIGN KEY (`fk_adjunto`) REFERENCES `adjunto`(`id_adjunto`),
  ADD CONSTRAINT `reporte_ibfk_3` FOREIGN KEY(`fk_departamento`) REFERENCES `departamento`(`id_departamento`),
  ADD CONSTRAINT `reporte_ibfk_4` FOREIGN KEY(`fk_municipio`) REFERENCES `municipio`(`id_municipio`);

--
-- Filtros para la tabla `municipio`
--
ALTER TABLE `municipio`
  ADD CONSTRAINT `municipio_ibfk_1` FOREIGN KEY (`fk_departamento`) REFERENCES `departamento` (`id_departamento`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `reporte`
--
ALTER TABLE `seguimiento`
  ADD CONSTRAINT `seguimiento_ibfk_1` FOREIGN KEY (`fk_caso_maltrato`) REFERENCES `caso_maltrato`(`id_caso`),
  ADD CONSTRAINT `seguimiento_ibfk_2` FOREIGN KEY (`fk_tipo_seguimiento`) REFERENCES `tipo_seguimiento`(`id_tipo_seguimiento`),
  ADD CONSTRAINT `seguimiento_ibfk_3` FOREIGN KEY (`fk_usuario`) REFERENCES `usuario`(`id_usuario`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`fk_tipo_documento`) REFERENCES `tipo_documento` (`id_tipo_documento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`fk_rol`) REFERENCES `rol` (`id_rol`);
COMMIT;
