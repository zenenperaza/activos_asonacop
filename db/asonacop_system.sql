-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 03-08-2020 a las 01:25:33
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
-- Estructura de tabla para la tabla `activos`
--

CREATE TABLE `activos` (
  `id` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `codigo` text COLLATE utf8_spanish_ci NOT NULL,
  `codigo_uf` text COLLATE utf8_spanish_ci NOT NULL,
  `nombre_activo` text COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha_adquisicion` text COLLATE utf8_spanish_ci NOT NULL,
  `fuente_financiamiento` text COLLATE utf8_spanish_ci NOT NULL,
  `origen_activo` text COLLATE utf8_spanish_ci NOT NULL,
  `situacion_contable` text COLLATE utf8_spanish_ci NOT NULL,
  `ubicacion_fisica` text COLLATE utf8_spanish_ci NOT NULL,
  `responsable` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha_entrega_res` text COLLATE utf8_spanish_ci NOT NULL,
  `estado_conservacion` text COLLATE utf8_spanish_ci NOT NULL,
  `info_garantia` text COLLATE utf8_spanish_ci NOT NULL,
  `observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `imagen` text COLLATE utf8_spanish_ci NOT NULL,
  `stock` int(11) NOT NULL,
  `precio_compra_bs` text COLLATE utf8_spanish_ci NOT NULL,
  `precio_compra_ds` text COLLATE utf8_spanish_ci NOT NULL,
  `asignaciones` int(11) NOT NULL,
  `fecha_reg` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaciones`
--

CREATE TABLE `asignaciones` (
  `id` int(11) NOT NULL,
  `codigo` text COLLATE utf8_spanish_ci NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `activos` text COLLATE utf8_spanish_ci NOT NULL,
  `total` float NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `categoria` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`, `fecha`) VALUES
(1, 'MOBILIARIOS', '2020-06-20 02:16:31'),
(2, 'COMPUTACION', '2020-06-20 02:16:43'),
(3, 'EQUIPOS DE OFICINA', '2020-07-16 14:58:53'),
(4, 'VEHICULOS', '2020-06-20 02:16:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` int(11) NOT NULL,
  `cedula` text CHARACTER SET utf8mb4 NOT NULL,
  `nombre` text CHARACTER SET utf8mb4 NOT NULL,
  `apellido` text CHARACTER SET utf8mb4 NOT NULL,
  `telefono` text CHARACTER SET utf8mb4 NOT NULL,
  `email` text CHARACTER SET utf8mb4 NOT NULL,
  `direccion` text CHARACTER SET utf8mb4 NOT NULL,
  `foto` text CHARACTER SET utf8mb4 NOT NULL,
  `estado` int(11) NOT NULL,
  `fecha_nacimiento` text CHARACTER SET utf8mb4 NOT NULL,
  `cargo` text CHARACTER SET utf8mb4 NOT NULL,
  `fecha_ingreso` text CHARACTER SET utf8mb4 NOT NULL,
  `asignaciones` int(11) NOT NULL,
  `registro` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `eliminados` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `cedula`, `nombre`, `apellido`, `telefono`, `email`, `direccion`, `foto`, `estado`, `fecha_nacimiento`, `cargo`, `fecha_ingreso`, `asignaciones`, `registro`, `eliminados`) VALUES
(12, '14695963', 'ZENEN', 'PERAZA', '(0424) 503-4999', 'peraza@outlook.com', 'Barrio el Triunfo. Carrera 12 entre 3A y 4', 'vistas/img/empleados/14695963/483.jpg', 1, '07/02/2020', 'Informatico', '01/01/2020', 0, '2020-07-25 15:27:46', 0),
(13, '27388253', 'MARCOS', 'ARTEAGA', '(0424) 518-3255', 'marcosasonacop@gmail.com', 'cabudare', 'vistas/img/empleados/default/anonymous.png', 1, '09/07/1999', 'Administrador', '01/01/2015', 0, '2020-07-25 15:24:12', 0),
(14, '8501020', 'LILY ', 'TORRES', '', '', '', 'vistas/img/empleados/default/anonymous.png', 1, '', '', '', 0, '2020-07-25 15:24:11', 0);

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `usuario` text COLLATE utf8_spanish_ci NOT NULL,
  `password` text COLLATE utf8_spanish_ci NOT NULL,
  `perfil` text COLLATE utf8_spanish_ci NOT NULL,
  `foto` text COLLATE utf8_spanish_ci NOT NULL,
  `estado` int(11) NOT NULL,
  `ultimo_login` datetime NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `password`, `perfil`, `foto`, `estado`, `ultimo_login`, `fecha`) VALUES
(60, 'ZENEN PERAZA', 'peraza@outlook.com', '$2a$07$asxx54ahjppf45sd87a5auwo7IkRZI2yO1aBLylFVooaoA0icfep2', 'Administrador', 'vistas/img/usuarios/peraza@outlook.com/753.jpg', 1, '2020-08-02 22:38:14', '2020-08-03 03:38:14'),
(63, 'MARCOS ARTEAGA', 'marcosasonacop@gmail.com', '$2a$07$asxx54ahjppf45sd87a5auwo7IkRZI2yO1aBLylFVooaoA0icfep2', 'Administrador', '', 1, '2020-07-16 09:57:07', '2020-07-16 14:57:07'),
(64, 'DEYBIS ARAUJO', 'daraujo@asonacop.com', '$2a$07$asxx54ahjppf45sd87a5auwo7IkRZI2yO1aBLylFVooaoA0icfep2', 'Administrador', 'vistas/img/usuarios/daraujo@asonacop.com/828.jpg', 1, '2020-07-17 11:22:16', '2020-08-03 03:17:49');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `activos`
--
ALTER TABLE `activos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `asignaciones`
--
ALTER TABLE `asignaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `participantes`
--
ALTER TABLE `participantes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `activos`
--
ALTER TABLE `activos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `asignaciones`
--
ALTER TABLE `asignaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `participantes`
--
ALTER TABLE `participantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
