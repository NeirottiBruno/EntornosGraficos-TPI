/*Script DB Shopping*/

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `shopping`
CREATE DATABASE shopping;

use shopping;
--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `codUsuario` int(11) NOT NULL,
  `nombreUsuario` varchar(100) NOT NULL,
  `claveUsuario` varchar(8) NOT NULL,
  `tipoUsuario` varchar(15) NOT NULL,
  `categoriaCliente` varchar(10) DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`codUsuario`, `nombreUsuario`, `claveUsuario`, `tipoUsuario`, `categoriaCliente`) VALUES
(6, 'giro@shopping.com', 'abc12345', 'dueño de local', NULL),
(7, 'samsung@shopping.com', 'def12345', 'dueño de local', NULL),
(8, 'fravega@shopping.com', 'ghi12345', 'dueño de local', NULL),
(9, 'havanna@shopping.com', 'jkl12345', 'dueño de local', NULL),
(10, 'ripcurl@shopping.com', 'mno12345', 'dueño de local', NULL),
(11, 'nespresso@shopping.com', 'pqr12345', 'dueño de local', NULL),
(12, 'cliente1@shopping.com', '123', 'cliente', 'Medium');

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE novedades (
  `codNovedad` int(11) NOT NULL,
  `textoNovedad` varchar(100) NOT NULL,
  `fechaDesdeNovedad` date NOT NULL,
  `fechaHastaNovedad` date NOT NULL,
  `tipoUsuario` varchar(15) DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `novedades`
--

INSERT INTO novedades (`codNovedad`, `textoNovedad`, `fechaDesdeNovedad`, `fechaHastaNovedad`, `tipoUsuario`) VALUES
(1, 'novedad1', '2025-06-01','2025-06-10', 'Administrador'),
(2, 'novedad2', '2025-06-01','2025-06-10', 'Dueño de local'),
(3, 'novedad3', '2025-06-01','2025-06-10', 'Cliente');



--
-- Estructura de tabla para la tabla `locales`
--

CREATE TABLE `locales` (
  `codLocal` int(11) NOT NULL,
  `nombreLocal` varchar(100) NOT NULL,
  `ubicacionLocal` varchar(50) DEFAULT NULL,
  `rubroLocal` varchar(20) DEFAULT NULL,
  `codUsuario` int(11) DEFAULT NULL,
  `logo` varchar(100) DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `locales`
--

INSERT INTO `locales` (`codLocal`, `nombreLocal`, `ubicacionLocal`, `rubroLocal`, `codUsuario`, `logo`) VALUES
(1, 'Giro Didáctico', 'Local 101', 'accesorios', 6, 'girodidactico.png'),
(2, 'Samsung', 'Local 102', 'tecnología', 7, 'samsung.png'),
(3, 'Fravega', 'Local 103', 'tecnología', 8, 'fravega.png'),
(4, 'Havanna', 'Local 104', 'comida', 9, 'havanna-h.png'),
(5, 'Ripcurl', 'Local 105', 'indumentaria', 10, 'ripcurl.png'),
(6, 'Nespresso', 'Local 106', 'comida', 11, 'nespresso.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promociones`
--

CREATE TABLE `promociones` (
  `codPromo` int(11) NOT NULL,
  `textoPromo` varchar(200) NOT NULL,
  `fechaDesdePromo` date NOT NULL,
  `fechaHastaPromo` date NOT NULL,
  `categoriaCliente` varchar(10) NOT NULL,
  `diasSemana` varchar(50) NOT NULL,
  `estadoPromo` varchar(10) NOT NULL,
  `codLocal` int(11) NOT NULL
) ;

--
-- Volcado de datos para la tabla `promociones`
--

INSERT INTO `promociones` (`codPromo`, `textoPromo`, `fechaDesdePromo`, `fechaHastaPromo`, `categoriaCliente`, `diasSemana`, `estadoPromo`, `codLocal`) VALUES
(1, '20% en Pago Contado', '2025-06-01', '2025-06-30', 'Inicial', 'Lunes,Miércoles', 'aprobada', 1),
(2, '2x1 en Accesorios', '2025-06-10', '2025-07-20', 'Medium', 'Sábado,Domingo', 'aprobada', 2),
(3, '15% en Electrónica', '2025-06-05', '2025-07-01', 'Premium', 'Martes,Viernes', 'aprobada', 3),
(4, 'Promo Café + Croissant', '2025-06-01', '2025-06-30', 'Inicial', 'Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domin', 'aprobada', 4),
(5, '30% en segunda unidad', '2025-06-12', '2025-06-25', 'Medium', 'Miércoles', 'aprobada', 5),
(6, '10% con QR', '2025-06-15', '2025-07-15', 'Premium', 'Jueves,Viernes', 'aprobada', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `uso_promociones`
--

CREATE TABLE `uso_promociones` (
  `id` int(11) NOT NULL,
  `codPromo` int(11) NOT NULL,
  `codUsuario` int(11) NOT NULL,
  `fechaSolicitud` date NOT NULL,
  `estado` varchar(15) NOT NULL DEFAULT 'pendiente',
  `codigoGenerado` varchar(20) DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `uso_promociones`
--

INSERT INTO `uso_promociones` (`id`, `codPromo`, `codUsuario`, `fechaSolicitud`, `estado`, `codigoGenerado`) VALUES
(4, 1, 12, '2025-06-19', 'aprobada', '4396091C'),
(5, 2, 12, '2025-06-19', 'pendiente', 'C7E93F71'),
(6, 5, 12, '2025-06-20', 'aprobada', 'F1161A0D'),
(7, 4, 12, '2025-06-20', 'pendiente', '5DACD9F4');

-- --------------------------------------------------------


--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `locales`
--
ALTER TABLE `locales`
  ADD PRIMARY KEY (`codLocal`);

--
-- Indices de la tabla `promociones`
--
ALTER TABLE `promociones`
  ADD PRIMARY KEY (`codPromo`),
  ADD KEY `codLocal` (`codLocal`);

--
-- Indices de la tabla `uso_promociones`
--
ALTER TABLE `uso_promociones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codPromo` (`codPromo`,`codUsuario`),
  ADD KEY `codUsuario` (`codUsuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`codUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `locales`
--
ALTER TABLE `locales`
  MODIFY `codLocal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `promociones`
--
ALTER TABLE `promociones`
  MODIFY `codPromo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `uso_promociones`
--
ALTER TABLE `uso_promociones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `codUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `promociones`
--
ALTER TABLE `promociones`
  ADD CONSTRAINT `promociones_ibfk_1` FOREIGN KEY (`codLocal`) REFERENCES `locales` (`codLocal`);

--
-- Filtros para la tabla `uso_promociones`
--
ALTER TABLE `uso_promociones`
  ADD CONSTRAINT `uso_promociones_ibfk_1` FOREIGN KEY (`codPromo`) REFERENCES `promociones` (`codPromo`),
  ADD CONSTRAINT `uso_promociones_ibfk_2` FOREIGN KEY (`codUsuario`) REFERENCES `usuarios` (`codUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
