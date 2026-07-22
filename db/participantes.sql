-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 03-08-2020 a las 01:24:58
-- Versión del servidor: 10.3.23-MariaDB-log-cll-lve
-- Versión de PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `asonacop_system`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participantes`
--

CREATE TABLE `participantes` (
  `id` int(11) NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `apellido` text COLLATE utf8_spanish_ci NOT NULL,
  `cedula` int(10) NOT NULL,
  `fecha_nacimiento` text COLLATE utf8_spanish_ci NOT NULL,
  `sexo` text COLLATE utf8_spanish_ci NOT NULL,
  `profesion` text COLLATE utf8_spanish_ci NOT NULL,
  `email` text COLLATE utf8_spanish_ci NOT NULL,
  `celular` text COLLATE utf8_spanish_ci NOT NULL,
  `ambito_laboral` text COLLATE utf8_spanish_ci NOT NULL,
  `direccion` text COLLATE utf8_spanish_ci NOT NULL,
  `pais` text COLLATE utf8_spanish_ci NOT NULL,
  `estado` text COLLATE utf8_spanish_ci NOT NULL,
  `municipio` text COLLATE utf8_spanish_ci NOT NULL,
  `nombre_taller` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha_taller` text COLLATE utf8_spanish_ci NOT NULL,
  `opinion` text COLLATE utf8_spanish_ci NOT NULL,
  `mensaje` text COLLATE utf8_spanish_ci NOT NULL,
  `volver` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estatus` int(2) NOT NULL,
  `pregunta_1` text COLLATE utf8_spanish_ci NOT NULL,
  `respuesta_1` text COLLATE utf8_spanish_ci NOT NULL,
  `pregunta_2` text COLLATE utf8_spanish_ci NOT NULL,
  `respuesta_2` text COLLATE utf8_spanish_ci NOT NULL,
  `pregunta_3` text COLLATE utf8_spanish_ci NOT NULL,
  `respuesta_3` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `participantes`
--

INSERT INTO `participantes` (`id`, `nombre`, `apellido`, `cedula`, `fecha_nacimiento`, `sexo`, `profesion`, `email`, `celular`, `ambito_laboral`, `direccion`, `pais`, `estado`, `municipio`, `nombre_taller`, `fecha_taller`, `opinion`, `mensaje`, `volver`, `fecha_registro`, `estatus`, `pregunta_1`, `respuesta_1`, `pregunta_2`, `respuesta_2`, `pregunta_3`, `respuesta_3`) VALUES
(20, 'KATIUSKA', 'BERNAL FLORES', 16877721, '17/03/85', 'Femenino', 'Abogada', 'Katyp435@gmail.com', '04121902369', 'ONG de Protección  a la Infancia', 'Cantaura Calle Carabobo casa 61', 'Venezuela', 'Anzoategui', 'Pedro María Freites', 'Jornada de Formación Comunitaria ', '30/7/2020', 'Excelente', 'Excelente ninguna recomendacion sigan con este tipo de actividades ', 'si', '2020-08-03 00:12:23', 0, '1-	¿En éste taller se abordó la temática de: ?A.	La familia \r\nB.	Protección a la mujer \r\nC.	protección a la infancia  ', 'Protección a la Infancia', '\r\n2-	¿Cuál es el principio que garantiza la participación de la sociedad en la defensa de los derechos de los niños niñas y adolescentes? A.	Corresponsabilidad.\r\nB.	Interés superior del niño \r\nC.	Prioridad absoluta. ', 'Corresponsabilidad', '\r\n3-	¿Cuál es el órgano encargado en cada municipio de garantizar los derechos de los niños niñas y adolescentes individualmente considerados? A.	Consejo Municipal de Derechos de Niños, Niñas y Adolescentes  (CMDNNA).\r\nB.	Consejo de Protección de Niños, Niñas y Adolescentes (CPNNA).\r\nC.	Defensoría de Niños, Niñas y Adolescentes (DFNNA)', 'Consejo de Protección de Niños Niñas y Adolescentes');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `participantes`
--
ALTER TABLE `participantes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `participantes`
--
ALTER TABLE `participantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
