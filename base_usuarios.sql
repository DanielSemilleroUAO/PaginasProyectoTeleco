-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-05-2019 a las 21:58:45
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `base_usuarios`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `botes`
--

CREATE TABLE `botes` (
  `ID_BOTE` varchar(20) COLLATE utf32_spanish_ci NOT NULL,
  `ID_USUARIO` varchar(20) COLLATE utf32_spanish_ci NOT NULL,
  `FECHA` varchar(20) COLLATE utf32_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_spanish_ci;

--
-- Volcado de datos para la tabla `botes`
--

INSERT INTO `botes` (`ID_BOTE`, `ID_USUARIO`, `FECHA`) VALUES
('bote0002', '5', '2019/3/21'),
('bote0001', '5', '2019/3/21'),
('bote0003', '6', '2019/4/3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
  `ID_BOTE` varchar(20) COLLATE utf32_spanish_ci NOT NULL,
  `LATITUD` varchar(20) COLLATE utf32_spanish_ci NOT NULL,
  `LONGITUD` varchar(20) COLLATE utf32_spanish_ci NOT NULL,
  `C_PLA` varchar(20) COLLATE utf32_spanish_ci NOT NULL,
  `C_ORG` varchar(20) COLLATE utf32_spanish_ci NOT NULL,
  `C_PA` varchar(20) COLLATE utf32_spanish_ci NOT NULL,
  `C_VI` varchar(20) COLLATE utf32_spanish_ci NOT NULL,
  `C_CAR` varchar(20) COLLATE utf32_spanish_ci NOT NULL,
  `C_MET` varchar(20) COLLATE utf32_spanish_ci NOT NULL,
  `C_PROM` varchar(20) COLLATE utf32_spanish_ci NOT NULL,
  `FECHA` varchar(20) COLLATE utf32_spanish_ci NOT NULL,
  `LLENO` varchar(20) COLLATE utf32_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_spanish_ci;

--
-- Volcado de datos para la tabla `historial`
--

INSERT INTO `historial` (`ID_BOTE`, `LATITUD`, `LONGITUD`, `C_PLA`, `C_ORG`, `C_PA`, `C_VI`, `C_CAR`, `C_MET`, `C_PROM`, `FECHA`, `LLENO`) VALUES
('bote0001', '3.353806', '-76.521788', '1', '2', '3', '4', '5', '6', '7', '17/03/19-17:27:00', '-'),
('bote0001', '3.353806', '-76.521788', '1', '2', '3', '4', '5', '6', '7', '2019/03/17-17:27:00', '-'),
('bote0002', '3.353531', '-76.520823', '1', '2', '3', '4', '5', '6', '7', '2019/03/17-17:27:00', '*'),
('bote0001', '3.353531', '-76.520823', '2', '2', '3', '4', '5', '6', '7', '2019/03/17-19:27:00', '*'),
('bote0001', '3.353275', '-76.521074', '1', '1', '1', '1', '1', '1', '1', '2019/03/17-20:41:05', '*'),
('bote0001', '3.353275', '-76.521074', '1', '1', '1', '1', '1', '1', '1', '2019/03/17-21:41:05', '-'),
('bote0002', '3.353531', '-76.520823', '1', '1', '1', '1', '1', '1', '1', '2019/03/17-21:41:05', '-'),
('bote0002', '3.353531', '-76.520823', '1', '1', '1', '1', '1', '1', '1', '2019/03/17-21:41:05', '-'),
('bote0002', '3.353531', '-76.520823', '1', '1', '1', '1', '1', '1', '1', '2019/03/17-21:41:05', '*'),
('bote0001', '3.353531', '-76.520823', '1', '1', '1', '1', '1', '1', '1', '2019/03/17-21:41:05', '*'),
('bote0001', '3.353275', '-76.521074', '1', '1', '1', '1', '1', '1', '1', '2019/03/17-20:41:05', '*'),
('bote0002', '3.353531', '-76.520823', '1', '1', '1', '1', '1', '1', '1', '2019/03/17-21:41:10', '*'),
('bote0001', '3.353531', '-76.520823', '1', '1', '1', '1', '1', '1', '1', '2019/03/17-22:41:05', '*');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajadores`
--

CREATE TABLE `trabajadores` (
  `ID` varchar(20) COLLATE utf32_spanish_ci NOT NULL,
  `CODIGO` varchar(20) COLLATE utf32_spanish_ci NOT NULL,
  `TIPO_RESIDUO` varchar(20) COLLATE utf32_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `ID` int(20) NOT NULL,
  `NOMBRE` varchar(40) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `IDENTIFICACION` varchar(20) COLLATE utf32_spanish_ci NOT NULL,
  `COD_USUARIO` varchar(20) COLLATE utf32_spanish_ci NOT NULL,
  `EMAIL` varchar(40) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `TELEFONO` varchar(20) COLLATE utf32_spanish_ci NOT NULL,
  `CIUDAD` varchar(20) COLLATE utf32_spanish_ci NOT NULL,
  `NICK` varchar(20) COLLATE utf32_spanish_ci NOT NULL,
  `PASSWORD` varchar(20) COLLATE utf32_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`ID`, `NOMBRE`, `IDENTIFICACION`, `COD_USUARIO`, `EMAIL`, `TELEFONO`, `CIUDAD`, `NICK`, `PASSWORD`) VALUES
(5, 'Daniel Delgado RodrÃ­guez', '1143867053', 'daniel2106', 'daniel.delgado_rod@uao.edu.co', '3043764621', 'Cali', 'dan_2106', '1234'),
(6, 'Sergio Duvan Mendoza Rojas', '1107060046', 'sergio1234', 'sergio@biiot.com', '23454', 'cali', 'sergio12', '1234'),
(7, 'Pepito Perez', '123456789', 'pepito123', 'pepito@hotmail.com', '12345', 'cali', 'pepito1', '1234'),
(8, 'Zeida Solarte', '12345345', 'zeida1', 'pepito@hotmail.com', '23454', 'cali', 'zeidaS', '1234');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
