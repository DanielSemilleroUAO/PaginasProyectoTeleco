-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-05-2019 a las 21:58:25
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
-- Base de datos: `base_admin`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bd_botes`
--

CREATE TABLE `bd_botes` (
  `ID_BOTE` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `FECHA` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `ESTADO` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `bd_botes`
--

INSERT INTO `bd_botes` (`ID_BOTE`, `FECHA`, `ESTADO`) VALUES
('bote0001', '2019/3/16', '*'),
('bote0002', '2019/3/17', '*'),
('bote0003', '2019/3/20', '*');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bd_usuarios`
--

CREATE TABLE `bd_usuarios` (
  `ID_USUARIO` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `FECHA` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `ESTADO` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `bd_usuarios`
--

INSERT INTO `bd_usuarios` (`ID_USUARIO`, `FECHA`, `ESTADO`) VALUES
('daniel2106', '2019/3/16', '*'),
('sergio1234', '2019/3/18', '*'),
('pepito123', '2019/3/20', '*'),
('zeida1', '2019/4/3', '*');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
