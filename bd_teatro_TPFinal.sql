-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-06-2021 a las 21:52:36
-- Versión del servidor: 10.4.19-MariaDB
-- Versión de PHP: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_teatro`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `funcion`
--

CREATE TABLE `funcion` (
  `idfuncion` bigint(20) UNSIGNED NOT NULL,
  `nombrefuncion` varchar(200) DEFAULT NULL,
  `horainicio` int(11) DEFAULT NULL,
  `duracionfuncion` int(11) DEFAULT NULL,
  `precio` int(11) DEFAULT NULL,
  `idteatro` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `funcion`
--

INSERT INTO `funcion` (`idfuncion`, `nombrefuncion`, `horainicio`, `duracionfuncion`, `precio`, `idteatro`) VALUES
(14, 'Dale que Aprobamos!!', 990, 30, 500, 19),
(15, 'Si aprobas se viene la Clandes de IPOO', 1020, 30, 350, 19),
(16, 'Musical nuevo', 1200, 60, 600, 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `funcioncine`
--

CREATE TABLE `funcioncine` (
  `idfuncion` int(11) NOT NULL,
  `genero` varchar(200) NOT NULL,
  `paisorigen` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `funcioncine`
--

INSERT INTO `funcioncine` (`idfuncion`, `genero`, `paisorigen`) VALUES
(11, 'EXITO TOTAL', 'peru');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `funcionmusical`
--

CREATE TABLE `funcionmusical` (
  `idfuncion` bigint(20) NOT NULL,
  `director` varchar(200) DEFAULT NULL,
  `personasescena` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `funcionmusical`
--

INSERT INTO `funcionmusical` (`idfuncion`, `director`, `personasescena`) VALUES
(13, 'jotaweb', 90),
(16, 'Profes', 60);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `funcionobrateatro`
--

CREATE TABLE `funcionobrateatro` (
  `idfuncion` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `funcionobrateatro`
--

INSERT INTO `funcionobrateatro` (`idfuncion`) VALUES
(14),
(15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `teatro`
--

CREATE TABLE `teatro` (
  `idteatro` int(10) UNSIGNED NOT NULL,
  `nombreteatro` varchar(200) NOT NULL,
  `direccion` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `teatro`
--

INSERT INTO `teatro` (`idteatro`, `nombreteatro`, `direccion`) VALUES
(19, 'Vorterix', 'Buenos Aires 1400');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `funcion`
--
ALTER TABLE `funcion`
  ADD PRIMARY KEY (`idfuncion`),
  ADD UNIQUE KEY `idfuncion` (`idfuncion`),
  ADD KEY `funcion_ibfk_1` (`idteatro`);

--
-- Indices de la tabla `funcioncine`
--
ALTER TABLE `funcioncine`
  ADD PRIMARY KEY (`idfuncion`);

--
-- Indices de la tabla `funcionmusical`
--
ALTER TABLE `funcionmusical`
  ADD PRIMARY KEY (`idfuncion`);

--
-- Indices de la tabla `funcionobrateatro`
--
ALTER TABLE `funcionobrateatro`
  ADD PRIMARY KEY (`idfuncion`);

--
-- Indices de la tabla `teatro`
--
ALTER TABLE `teatro`
  ADD PRIMARY KEY (`idteatro`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `funcion`
--
ALTER TABLE `funcion`
  MODIFY `idfuncion` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `teatro`
--
ALTER TABLE `teatro`
  MODIFY `idteatro` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
