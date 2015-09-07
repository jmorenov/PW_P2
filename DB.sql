SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `PW`
--
CREATE DATABASE IF NOT EXISTS `PW` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `PW`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Alumnos`
--

DROP TABLE IF EXISTS `Alumnos`;
CREATE TABLE IF NOT EXISTS `Alumnos` (
  `UsuarioID` varchar(30) NOT NULL,
  `CursoID` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `Alumnos`:
--   `CursoID`
--       `Cursos` -> `ID`
--   `UsuarioID`
--       `Usuarios` -> `ID`
--

--
-- Volcado de datos para la tabla `Alumnos`
--

INSERT INTO `Alumnos` (`UsuarioID`, `CursoID`) VALUES
('admin', 'Test');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Cursos`
--

DROP TABLE IF EXISTS `Cursos`;
CREATE TABLE IF NOT EXISTS `Cursos` (
  `ID` varchar(30) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `profesorID` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `Cursos`:
--   `profesorID`
--       `Usuarios` -> `ID`
--

--
-- Volcado de datos para la tabla `Cursos`
--

INSERT INTO `Cursos` (`ID`, `titulo`, `descripcion`, `profesorID`) VALUES
('Test', 'un curso', 'pues no se....', 'test');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Ejercicios`
--

DROP TABLE IF EXISTS `Ejercicios`;
CREATE TABLE IF NOT EXISTS `Ejercicios` (
  `ID` varchar(30) NOT NULL,
  `CursoID` varchar(30) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `Ejercicios`:
--   `CursoID`
--       `Cursos` -> `ID`
--

--
-- Volcado de datos para la tabla `Ejercicios`
--

INSERT INTO `Ejercicios` (`ID`, `CursoID`, `titulo`, `descripcion`) VALUES
('EjercicioTest', 'Test', 'Probando ejercicio', 'Un ejercicio..');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Evaluaciones`
--

DROP TABLE IF EXISTS `Evaluaciones`;
CREATE TABLE IF NOT EXISTS `Evaluaciones` (
  `AlumnoID` varchar(30) NOT NULL,
  `SolucionEjercicioID` varchar(30) NOT NULL,
  `SolucionAlumnoID` varchar(30) NOT NULL,
  `calificacion` decimal(5,0) NOT NULL,
  `lomejor` varchar(255) NOT NULL,
  `lopeor` varchar(255) NOT NULL,
  `observacion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `Evaluaciones`:
--   `AlumnoID`
--       `Usuarios` -> `ID`
--   `SolucionAlumnoID`
--       `Soluciones` -> `AlumnoID`
--   `SolucionEjercicioID`
--       `Soluciones` -> `EjercicioID`
--

--
-- Volcado de datos para la tabla `Evaluaciones`
--

INSERT INTO `Evaluaciones` (`AlumnoID`, `SolucionEjercicioID`, `SolucionAlumnoID`, `calificacion`, `lomejor`, `lopeor`, `observacion`) VALUES
('admin', 'EjercicioTest', 'test', '1', 's', 's', 's');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Soluciones`
--

DROP TABLE IF EXISTS `Soluciones`;
CREATE TABLE IF NOT EXISTS `Soluciones` (
  `EjercicioID` varchar(30) NOT NULL,
  `AlumnoID` varchar(30) NOT NULL,
  `file_video` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `Soluciones`:
--   `AlumnoID`
--       `Usuarios` -> `ID`
--   `EjercicioID`
--       `Ejercicios` -> `ID`
--

--
-- Volcado de datos para la tabla `Soluciones`
--

INSERT INTO `Soluciones` (`EjercicioID`, `AlumnoID`, `file_video`) VALUES
('EjercicioTest', 'admin', 'videos/test.mp4');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuarios`
--

DROP TABLE IF EXISTS `Usuarios`;
CREATE TABLE IF NOT EXISTS `Usuarios` (
  `ID` varchar(30) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `dni` varchar(9) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `privilegios` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `Usuarios`:
--

--
-- Volcado de datos para la tabla `Usuarios`
--

INSERT INTO `Usuarios` (`ID`, `pass`, `nombre`, `apellidos`, `dni`, `fecha_nacimiento`, `email`, `privilegios`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'istrador', '11111111N', '2015-09-01', 'admin@admin.com', 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Alumnos`
--
ALTER TABLE `Alumnos`
  ADD PRIMARY KEY (`UsuarioID`,`CursoID`);

--
-- Indices de la tabla `Cursos`
--
ALTER TABLE `Cursos`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `Ejercicios`
--
ALTER TABLE `Ejercicios`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `Evaluaciones`
--
ALTER TABLE `Evaluaciones`
  ADD PRIMARY KEY (`AlumnoID`,`SolucionEjercicioID`,`SolucionAlumnoID`);

--
-- Indices de la tabla `Soluciones`
--
ALTER TABLE `Soluciones`
  ADD PRIMARY KEY (`EjercicioID`,`AlumnoID`),
  ADD KEY `AlumnoID` (`AlumnoID`);

--
-- Indices de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`),
  ADD UNIQUE KEY `dni` (`dni`),
  ADD UNIQUE KEY `email` (`email`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
