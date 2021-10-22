-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-10-2021 a las 18:10:16
-- Versión del servidor: 10.4.19-MariaDB
-- Versión de PHP: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hsb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alimento`
--

CREATE TABLE `alimento` (
  `AlimentoId` int(11) NOT NULL,
  `AlimentoNombre` varchar(80) NOT NULL,
  `AlimentoCantidadTotal` double NOT NULL,
  `UnidadMedidaId` int(11) NOT NULL,
  `AlimentoEstado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `alimento`
--

INSERT INTO `alimento` (`AlimentoId`, `AlimentoNombre`, `AlimentoCantidadTotal`, `UnidadMedidaId`, `AlimentoEstado`) VALUES
(45, 'Pollo', 42.45, 6, 1),
(46, 'Papa', 4, 6, 1),
(47, 'Te', 99.98, 3, 1),
(48, 'Leche', 96.5, 4, 1),
(49, 'Aceite', 18, 4, 1),
(50, 'Azúcar', 2000, 6, 1),
(51, 'Pan Mignon', 5.02, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alimentoporcomida`
--

CREATE TABLE `alimentoporcomida` (
  `AlimentoPorComidaId` int(11) NOT NULL,
  `ComidaId` int(11) NOT NULL,
  `AlimentoId` int(11) NOT NULL,
  `AlimentoPorComidaCantidadBruta` double NOT NULL,
  `AlimentoPorComidaCantidadNeto` int(11) NOT NULL,
  `AlimentoPorComidaEstado` tinyint(1) DEFAULT NULL,
  `UnidadMedidaId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `alimentoporcomida`
--

INSERT INTO `alimentoporcomida` (`AlimentoPorComidaId`, `ComidaId`, `AlimentoId`, `AlimentoPorComidaCantidadBruta`, `AlimentoPorComidaCantidadNeto`, `AlimentoPorComidaEstado`, `UnidadMedidaId`) VALUES
(67, 19, 45, 0, 150, 1, 1),
(68, 19, 46, 0, 100, 1, 1),
(69, 20, 47, 0, 1, 1, 1),
(70, 20, 48, 0, 10, 1, 7),
(71, 21, 48, 0, 500, 1, 7),
(72, 22, 47, 0, 1, 1, 1),
(73, 22, 48, 0, 50, 1, 7),
(74, 23, 45, 0, 140, 1, 1),
(75, 24, 45, 0, 500, 1, 1),
(76, 25, 49, 150, 100, 1, 7),
(78, 26, 49, 12.25, 13, 1, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alimentoporproveedor`
--

CREATE TABLE `alimentoporproveedor` (
  `AlimentoPorProveedorId` int(11) NOT NULL,
  `ProveedorId` int(11) NOT NULL,
  `AlimentoId` int(11) NOT NULL,
  `AlimentoPorProveedorCosto` double NOT NULL,
  `AlimentoPorProveedorCantidad` double NOT NULL,
  `AlimentoPorProveedorVencimiento` date DEFAULT NULL,
  `AlimentoPorProveedorEstado` tinyint(1) DEFAULT NULL,
  `AlimentoPorProveedorFechaEntrada` date NOT NULL DEFAULT current_timestamp(),
  `AlimentoPorProveedorCantidadUsada` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `alimentoporproveedor`
--

INSERT INTO `alimentoporproveedor` (`AlimentoPorProveedorId`, `ProveedorId`, `AlimentoId`, `AlimentoPorProveedorCosto`, `AlimentoPorProveedorCantidad`, `AlimentoPorProveedorVencimiento`, `AlimentoPorProveedorEstado`, `AlimentoPorProveedorFechaEntrada`, `AlimentoPorProveedorCantidadUsada`) VALUES
(37, 1, 45, 100, 5, '2021-09-15', 0, '2021-09-07', 5),
(38, 2, 45, 150, 2, '2021-09-16', 1, '2021-09-07', 1.98),
(39, 1, 46, 50, 4, '2021-09-21', 1, '2021-09-07', 0),
(40, 2, 47, 5, 100, '2021-09-30', 1, '2021-09-07', 0.02),
(41, 1, 48, 100, 100, '2022-05-26', 1, '2021-09-30', 3.5),
(42, 2, 49, 120, 18, '2021-10-30', 1, '2021-10-01', 0),
(43, 1, 50, 100, 2000, '2021-10-30', 1, '2021-10-01', 0),
(44, 1, 51, 13.54, 1.52, '2021-10-20', 1, '2021-10-19', 0),
(45, 1, 51, 30.25, 1.5, '2021-10-20', 1, '2021-10-19', 0),
(46, 2, 51, 2, 2, '2021-10-27', 1, '2021-10-19', 0),
(47, 1, 45, 32.32, 42.43, '2021-10-20', 1, '2021-10-19', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cama`
--

CREATE TABLE `cama` (
  `CamaId` int(11) NOT NULL,
  `CamaNumero` int(11) NOT NULL,
  `PiezaId` int(11) NOT NULL,
  `CamaEstado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cama`
--

INSERT INTO `cama` (`CamaId`, `CamaNumero`, `PiezaId`, `CamaEstado`) VALUES
(1, 1, 1, 1),
(2, 2, 1, 1),
(3, 1, 2, 1),
(4, 2, 2, 1),
(5, 1, 3, 1),
(6, 2, 3, 1),
(7, 3, 1, 0),
(8, 4, 1, 0),
(9, 1, 5, 1),
(10, 2, 5, 1),
(11, 3, 5, 1),
(12, 1, 6, 1),
(13, 2, 6, 1),
(14, 3, 6, 1),
(15, 1, 7, 1),
(16, 2, 7, 1),
(17, 3, 7, 1),
(18, 1, 8, 1),
(19, 2, 8, 1),
(20, 3, 8, 1),
(21, 1, 9, 1),
(22, 2, 9, 1),
(23, 3, 9, 1),
(24, 1, 10, 1),
(25, 2, 10, 1),
(26, 1, 11, 1),
(27, 2, 11, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comida`
--

CREATE TABLE `comida` (
  `ComidaId` int(11) NOT NULL,
  `ComidaNombre` varchar(80) NOT NULL,
  `TipoComidaId` int(11) NOT NULL,
  `ComidaEstado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `comida`
--

INSERT INTO `comida` (`ComidaId`, `ComidaNombre`, `TipoComidaId`, `ComidaEstado`) VALUES
(19, 'Pollo al horno con papas', 2, 1),
(20, 'Té con leche', 1, 1),
(21, 'Sopa c/arroz', 7, 1),
(22, 'Té con leche / merienda', 5, 1),
(23, 'Sopa c/semola y sal', 3, 1),
(24, 'Pollo al Horno con Ensalada', 6, 1),
(25, 'Tarta de zapallitos con pan', 2, 1),
(26, 'Papa con queso', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comidaportipopaciente`
--

CREATE TABLE `comidaportipopaciente` (
  `ComidaPorTipoPacienteId` int(11) NOT NULL,
  `DetalleMenuTipoPacienteId` int(11) NOT NULL,
  `ComidaId` int(11) DEFAULT NULL,
  `ComidaPorTipoPacientePrincipal` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `comidaportipopaciente`
--

INSERT INTO `comidaportipopaciente` (`ComidaPorTipoPacienteId`, `DetalleMenuTipoPacienteId`, `ComidaId`, `ComidaPorTipoPacientePrincipal`) VALUES
(11, 28, 20, 1),
(12, 28, 19, 1),
(13, 28, 21, 1),
(14, 28, 24, 1),
(15, 28, 22, 1),
(16, 28, 23, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `congelador`
--

CREATE TABLE `congelador` (
  `CongeladorId` int(11) NOT NULL,
  `ComidaId` int(11) NOT NULL,
  `Porciones` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `congelador`
--

INSERT INTO `congelador` (`CongeladorId`, `ComidaId`, `Porciones`) VALUES
(1, 19, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallemenutipopaciente`
--

CREATE TABLE `detallemenutipopaciente` (
  `DetalleMenuTipoPacienteId` int(11) NOT NULL,
  `MenuId` int(11) NOT NULL,
  `TipoPacienteId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detallemenutipopaciente`
--

INSERT INTO `detallemenutipopaciente` (`DetalleMenuTipoPacienteId`, `MenuId`, `TipoPacienteId`) VALUES
(28, 20, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallerelevamiento`
--

CREATE TABLE `detallerelevamiento` (
  `DetalleRelevamientoId` int(11) NOT NULL,
  `PacienteId` int(11) DEFAULT NULL,
  `RelevamientoPorSalaId` int(11) NOT NULL,
  `TipoPacienteId` int(11) DEFAULT NULL,
  `DetalleRelevamientoEstado` tinyint(1) DEFAULT NULL,
  `CamaId` int(11) NOT NULL,
  `DetalleRelevamientoObservaciones` longtext DEFAULT NULL,
  `DetalleRelevamientoAcompaniante` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserId` bigint(20) UNSIGNED DEFAULT NULL,
  `DetalleRelevamientoDiagnostico` longtext DEFAULT NULL,
  `DetalleRelevamientoVajillaDescartable` int(11) DEFAULT NULL,
  `DetalleRelevamientoColacion` int(11) DEFAULT NULL,
  `MenuId` int(11) NOT NULL,
  `DetalleRelevamientoAgregado` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detallerelevamiento`
--

INSERT INTO `detallerelevamiento` (`DetalleRelevamientoId`, `PacienteId`, `RelevamientoPorSalaId`, `TipoPacienteId`, `DetalleRelevamientoEstado`, `CamaId`, `DetalleRelevamientoObservaciones`, `DetalleRelevamientoAcompaniante`, `created_at`, `updated_at`, `UserId`, `DetalleRelevamientoDiagnostico`, `DetalleRelevamientoVajillaDescartable`, `DetalleRelevamientoColacion`, `MenuId`, `DetalleRelevamientoAgregado`) VALUES
(422, 5, 32, 1, 0, 1, 'obs', 1, '2021-10-01 02:29:55', '2021-10-01 11:34:15', 8, 'dx', 0, NULL, 20, 0),
(423, 6, 32, 1, 0, 2, 'obs', 0, '2021-10-01 02:30:10', '2021-10-12 21:48:34', 8, 'dx', 0, NULL, 20, 0),
(424, 7, 32, 1, 0, 3, 'obs', 1, '2021-10-01 02:30:26', '2021-10-12 23:18:05', 8, 'dx', 0, NULL, 20, 0),
(425, 8, 32, 1, 1, 4, 'obs', 1, '2021-10-01 02:30:40', '2021-10-01 02:30:40', 8, 'dx', 0, NULL, 20, 0),
(426, 5, 33, 1, 0, 10, 'obs', 1, '2021-10-01 11:34:15', '2021-10-01 11:34:16', 8, 'dx', 0, NULL, 20, 0),
(428, 6, 35, 1, 0, 2, 'obs', 0, '2021-10-12 21:48:34', '2021-10-12 21:48:35', 8, 'dx', 0, NULL, 20, 0),
(429, 5, 35, 1, 0, 9, 'obs', 0, '2021-10-12 21:54:13', '2021-10-12 21:54:14', 8, 'dx', 0, NULL, 20, 0),
(430, 5, 35, 1, 0, 12, 'asd', 0, '2021-10-12 21:59:11', '2021-10-12 21:59:11', 8, 'as', 0, NULL, 20, 0),
(431, 5, 35, 1, 0, 13, 'pasd', 0, '2021-10-12 22:01:16', '2021-10-12 22:24:21', 8, 'dc', 0, NULL, 20, 0),
(432, 5, 35, 1, 0, 13, 'pasd', 0, '2021-10-12 22:24:21', '2021-10-12 22:24:22', 8, 'dc', 0, NULL, 20, 0),
(433, 6, 35, 1, 0, 14, 'asd', 0, '2021-10-12 22:48:15', '2021-10-12 23:09:24', 8, 'asd', 0, NULL, 20, 0),
(434, 6, 35, 1, 0, 14, 'asd', 1, '2021-10-12 23:09:24', '2021-10-12 23:16:05', 8, 'asd', 0, NULL, 20, 0),
(435, 6, 35, 1, 0, 14, 'asd', 0, '2021-10-12 23:16:05', '2021-10-12 23:17:20', 8, 'asd', 0, NULL, 20, 0),
(436, 6, 35, 1, 0, 14, 'asd', 1, '2021-10-12 23:17:20', '2021-10-12 23:19:47', 8, 'asd', 0, NULL, 20, 0),
(437, 7, 35, 1, 1, 3, 'obs', 0, '2021-10-12 23:18:05', '2021-10-12 23:18:06', 8, 'dx', 0, NULL, 20, 0),
(438, 7, 35, 1, 0, 3, 'obs', 0, '2021-10-12 23:19:05', '2021-10-12 23:19:19', 8, 'dx', 0, NULL, 20, 0),
(439, 7, 35, 1, 0, 3, 'obs', 1, '2021-10-12 23:19:19', '2021-10-12 23:19:38', 8, 'dx', 0, NULL, 20, 0),
(440, 7, 35, 1, 1, 3, 'obs', 0, '2021-10-12 23:19:38', '2021-10-12 23:19:39', 8, 'dx', 0, NULL, 20, 0),
(441, 6, 35, 1, 0, 14, 'asd', 0, '2021-10-12 23:19:47', '2021-10-12 23:24:18', 8, 'asd', 0, NULL, 20, 0),
(442, 5, 35, 1, 0, 12, 'asd', 1, '2021-10-12 23:22:20', '2021-10-12 23:22:21', 8, 'as', 0, NULL, 20, 0),
(443, 5, 35, 1, 0, 10, 'obs', 1, '2021-10-12 23:22:49', '2021-10-12 23:22:50', 8, 'dx', 0, NULL, 20, 0),
(444, 5, 35, 1, 0, 9, 'obs', 1, '2021-10-12 23:22:57', '2021-10-12 23:22:58', 8, 'dx', 0, NULL, 20, 0),
(445, 6, 35, 1, 1, 14, 'asd', 1, '2021-10-12 23:24:18', '2021-10-12 23:24:19', 8, 'asd', 0, NULL, 20, 0),
(446, 6, 35, 1, 0, 14, 'asd', 1, '2021-10-12 23:24:56', '2021-10-12 23:25:20', 8, 'asd', 0, NULL, 20, 0),
(447, 6, 35, 1, 0, 14, 'asd', 0, '2021-10-12 23:25:20', '2021-10-12 23:25:35', 8, 'asd', 0, NULL, 20, 0),
(448, 6, 35, 1, 0, 14, 'asd', 1, '2021-10-12 23:25:35', '2021-10-12 23:25:50', 8, 'asd', 0, NULL, 20, 0),
(449, 6, 35, 1, 0, 14, 'asd', 0, '2021-10-12 23:25:50', '2021-10-12 23:25:59', 8, 'asd', 0, NULL, 20, 0),
(450, 6, 35, 1, 1, 14, 'asd', 1, '2021-10-12 23:25:59', '2021-10-12 23:26:00', 8, 'asd', 0, NULL, 20, 0),
(451, 5, 35, 1, 0, 1, 'obs', 0, '2021-10-13 22:00:27', '2021-10-13 22:00:28', 8, 'dx', 0, NULL, 20, 0),
(452, 5, 35, 1, 1, 15, 'asdqwe', 0, '2021-10-13 22:06:13', '2021-10-13 22:06:13', 8, 'asdqwe', 0, NULL, 20, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detrelevamientoporcomida`
--

CREATE TABLE `detrelevamientoporcomida` (
  `DetRelevamientoPorComidaId` bigint(20) UNSIGNED NOT NULL,
  `DetalleRelevamientoId` int(11) NOT NULL,
  `ComidaId` int(11) NOT NULL,
  `para_acompaniante` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detrelevamientoporcomida`
--

INSERT INTO `detrelevamientoporcomida` (`DetRelevamientoPorComidaId`, `DetalleRelevamientoId`, `ComidaId`, `para_acompaniante`) VALUES
(241, 452, 19, 0),
(242, 452, 22, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `EmpleadoId` int(11) NOT NULL,
  `EmpleadoNombre` varchar(64) NOT NULL,
  `EmpleadoApellido` varchar(64) NOT NULL,
  `EmpleadoCuil` bigint(20) NOT NULL,
  `EmpleadoDireccion` varchar(64) DEFAULT NULL,
  `EmpleadoEmail` varchar(64) DEFAULT NULL,
  `EmpleadoTelefono` bigint(20) DEFAULT NULL,
  `EmpleadoEstado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
  `HistorialId` int(11) NOT NULL,
  `RelevamientoId` int(11) NOT NULL,
  `HistorialEstado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `historial`
--

INSERT INTO `historial` (`HistorialId`, `RelevamientoId`, `HistorialEstado`) VALUES
(42, 113, 1),
(49, 117, 1),
(51, 118, 1),
(52, 119, 1),
(53, 120, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historialdetallealimento`
--

CREATE TABLE `historialdetallealimento` (
  `HistorialDetalleAlimentoId` int(11) NOT NULL,
  `HistorialDetalleComidaId` int(11) NOT NULL,
  `AlimentoNombre` varchar(120) NOT NULL,
  `UnidadMedida` varchar(50) NOT NULL,
  `Cantidad` double NOT NULL,
  `CostoTotal` double NOT NULL,
  `AlimentoId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `historialdetallealimento`
--

INSERT INTO `historialdetallealimento` (`HistorialDetalleAlimentoId`, `HistorialDetalleComidaId`, `AlimentoNombre`, `UnidadMedida`, `Cantidad`, `CostoTotal`, `AlimentoId`) VALUES
(14, 47, 'Leche', 'cm3', 500, 0, 0),
(15, 48, 'Pollo', 'Gramo', 500, 0, 0),
(16, 49, 'Te', 'Gramo', 1, 0, 0),
(17, 50, 'Pollo', 'Gramo', 150, 0, 0),
(44, 69, 'Pollo', 'Gramo', 500, 0, 0),
(51, 76, 'Te', 'Gramo', 1, 0, 0),
(52, 79, 'Pollo', 'Gramo', 500, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historialdetallecomida`
--

CREATE TABLE `historialdetallecomida` (
  `HistorialDetalleComidaId` int(11) NOT NULL,
  `HistorialId` int(11) NOT NULL,
  `ComidaNombre` varchar(120) NOT NULL,
  `Porciones` int(11) NOT NULL,
  `Congelador` int(11) NOT NULL DEFAULT 0,
  `ComidaId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `historialdetallecomida`
--

INSERT INTO `historialdetallecomida` (`HistorialDetalleComidaId`, `HistorialId`, `ComidaNombre`, `Porciones`, `Congelador`, `ComidaId`) VALUES
(47, 42, 'Sopa c/arroz', 7, 0, 21),
(48, 42, 'Pollo al Horno con Ensalada', 7, 0, 24),
(49, 42, 'Té con leche / merienda', 7, 0, 22),
(50, 42, 'Pollo al horno con papas', 1, 0, 19),
(69, 49, 'Pollo al Horno con Ensalada', 1, 0, 24),
(76, 51, 'Té con leche', 3, 0, 20),
(79, 51, 'Pollo al Horno con Ensalada', 1, 0, 24);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `MenuId` int(11) NOT NULL,
  `MenuNombre` varchar(80) NOT NULL,
  `MenuEstado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`MenuId`, `MenuNombre`, `MenuEstado`) VALUES
(20, 'Menu 1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(474, '2014_10_12_000000_create_users_table', 1),
(475, '2014_10_12_100000_create_password_resets_table', 1),
(476, '2019_08_19_000000_create_failed_jobs_table', 1),
(477, '2021_04_08_121009_create_permission_tables', 1),
(478, '2021_04_24_005441_add_menu_to_relevamiento_table', 1),
(479, '2021_04_26_000804_drop__detalle_relevamiento_fechora_from_detallerelevamiento_table', 1),
(480, '2021_04_26_014009_add_salapseudonimo_to_sala_table', 1),
(481, '2021_04_26_021218_add_piezapseudonimo_to_pieza_table', 1),
(482, '2021_04_26_035010_add_vajilladescartable_to_detallerelevamiento_table', 1),
(483, '2021_04_29_011603_create_detrelevamientoporcomidas_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(9, 'App\\User', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nutriente`
--

CREATE TABLE `nutriente` (
  `NutrienteId` int(11) NOT NULL,
  `NutrienteNombre` varchar(80) NOT NULL,
  `NutrienteEstado` tinyint(4) DEFAULT NULL,
  `UnidadMedidaId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `nutriente`
--

INSERT INTO `nutriente` (`NutrienteId`, `NutrienteNombre`, `NutrienteEstado`, `UnidadMedidaId`) VALUES
(1, 'Hidratos', 1, 1),
(2, 'PrÃ³tidos', 1, 1),
(3, 'Grasas', 1, 1),
(4, 'KCAL', 1, 3),
(5, 'Hierro', 1, 2),
(6, 'Calcio', 1, 2),
(7, 'Sodio', 1, 2),
(8, 'Vit.A', 1, 7),
(9, 'Vit.B1', 1, 2),
(10, 'Vit.B2', 1, 2),
(11, 'Vit.C', 1, 2),
(12, 'Niacina', 1, 2),
(13, 'Fibra', 1, 1),
(14, 'Colest.', 1, 2),
(15, 'A.G.SAT.', 1, 1),
(16, 'A.G.MON.', 1, 1),
(17, 'A.G.POLI.', 1, 1),
(18, 'Potasio', 1, 2),
(19, 'FÃ³sforo', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nutrienteporalimento`
--

CREATE TABLE `nutrienteporalimento` (
  `NutrientePorAlimentoId` int(11) NOT NULL,
  `AlimentoId` int(11) NOT NULL,
  `NutrienteId` int(11) NOT NULL,
  `NutrientePorAlimentoValor` double NOT NULL,
  `NutrientePorAlimentoEstado` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `nutrienteporalimento`
--

INSERT INTO `nutrienteporalimento` (`NutrientePorAlimentoId`, `AlimentoId`, `NutrienteId`, `NutrientePorAlimentoValor`, `NutrientePorAlimentoEstado`) VALUES
(444, 45, 1, 1, NULL),
(445, 45, 2, 2, NULL),
(446, 45, 3, 3, NULL),
(447, 45, 4, 4, NULL),
(448, 45, 5, 5, NULL),
(449, 45, 6, 6, NULL),
(450, 45, 7, 7, NULL),
(451, 45, 8, 8, NULL),
(452, 45, 9, 9, NULL),
(453, 45, 10, 10, NULL),
(454, 45, 11, 11, NULL),
(455, 45, 12, 12, NULL),
(456, 45, 13, 13, NULL),
(457, 45, 14, 14, NULL),
(458, 45, 15, 15, NULL),
(459, 45, 16, 16, NULL),
(460, 45, 17, 17, NULL),
(461, 45, 18, 18, NULL),
(462, 45, 19, 19, NULL),
(482, 46, 1, 1, NULL),
(483, 46, 2, 2, NULL),
(484, 46, 3, 3, NULL),
(485, 46, 4, 4, NULL),
(486, 46, 5, 5, NULL),
(487, 46, 6, 6, NULL),
(488, 46, 7, 7, NULL),
(489, 46, 8, 8, NULL),
(490, 46, 9, 9, NULL),
(491, 46, 10, 10, NULL),
(492, 46, 11, 11, NULL),
(493, 46, 12, 12, NULL),
(494, 46, 13, 13, NULL),
(495, 46, 14, 14, NULL),
(496, 46, 15, 15, NULL),
(497, 46, 16, 16, NULL),
(498, 46, 17, 17, NULL),
(499, 46, 18, 18, NULL),
(500, 46, 19, 0, NULL),
(501, 47, 1, 1, NULL),
(502, 47, 2, 2, NULL),
(503, 47, 3, 3, NULL),
(504, 47, 4, 4, NULL),
(505, 47, 5, 5, NULL),
(506, 47, 6, 6, NULL),
(507, 47, 7, 7, NULL),
(508, 47, 8, 8, NULL),
(509, 47, 9, 9, NULL),
(510, 47, 10, 0, NULL),
(511, 47, 11, 1, NULL),
(512, 47, 12, 2, NULL),
(513, 47, 13, 3, NULL),
(514, 47, 14, 4, NULL),
(515, 47, 15, 5, NULL),
(516, 47, 16, 6, NULL),
(517, 47, 17, 7, NULL),
(518, 47, 18, 8, NULL),
(519, 47, 19, 9, NULL),
(520, 48, 1, 10, NULL),
(521, 48, 2, 10, NULL),
(522, 48, 3, 10, NULL),
(523, 48, 4, 10, NULL),
(524, 48, 5, 10, NULL),
(525, 48, 6, 10, NULL),
(526, 48, 7, 10, NULL),
(527, 48, 8, 10, NULL),
(528, 48, 9, 10, NULL),
(529, 48, 10, 10, NULL),
(530, 48, 11, 10, NULL),
(531, 48, 12, 10, NULL),
(532, 48, 13, 10, NULL),
(533, 48, 14, 10, NULL),
(534, 48, 15, 10, NULL),
(535, 48, 16, 10, NULL),
(536, 48, 17, 10, NULL),
(537, 48, 18, 10, NULL),
(538, 48, 19, 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente`
--

CREATE TABLE `paciente` (
  `PacienteId` int(11) NOT NULL,
  `PacienteNombre` varchar(64) NOT NULL,
  `PacienteApellido` varchar(64) NOT NULL,
  `PacienteCuil` bigint(20) NOT NULL,
  `PacienteDireccion` varchar(64) DEFAULT NULL,
  `PacienteEmail` varchar(64) DEFAULT NULL,
  `PacienteTelefono` bigint(20) DEFAULT NULL,
  `PacienteEstado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`PacienteId`, `PacienteNombre`, `PacienteApellido`, `PacienteCuil`, `PacienteDireccion`, `PacienteEmail`, `PacienteTelefono`, `PacienteEstado`) VALUES
(5, 'Martín', 'Abad', 39360675, NULL, NULL, NULL, 1),
(6, 'Pablo', 'Vega', 39452025, '', '', 0, 1),
(7, 'Cristian', 'Zalazar', 38254125, '', '', 0, 1),
(8, 'Daniel', 'Osvaldo', 20365484, '', '', 0, 1),
(25, 'pedro', 'diaz', 39584254, NULL, NULL, NULL, NULL),
(26, 'martin', 'perez', 396524852, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(311, 'roles.store', 'web', '2021-06-18 20:46:00', '2021-06-18 20:46:00'),
(312, 'roles.index', 'web', '2021-06-18 20:46:00', '2021-06-18 20:46:00'),
(313, 'roles.create', 'web', '2021-06-18 20:46:00', '2021-06-18 20:46:00'),
(314, 'roles.update', 'web', '2021-06-18 20:46:00', '2021-06-18 20:46:00'),
(315, 'roles.show', 'web', '2021-06-18 20:46:00', '2021-06-18 20:46:00'),
(316, 'roles.destroy', 'web', '2021-06-18 20:46:00', '2021-06-18 20:46:00'),
(317, 'roles.edit', 'web', '2021-06-18 20:46:00', '2021-06-18 20:46:00'),
(318, 'menu.store', 'web', '2021-06-18 20:46:00', '2021-06-18 20:46:00'),
(319, 'menu.index', 'web', '2021-06-18 20:46:00', '2021-06-18 20:46:00'),
(320, 'menu.create', 'web', '2021-06-18 20:46:00', '2021-06-18 20:46:00'),
(321, 'menu.update', 'web', '2021-06-18 20:46:00', '2021-06-18 20:46:00'),
(322, 'menu.show', 'web', '2021-06-18 20:46:00', '2021-06-18 20:46:00'),
(323, 'menu.destroy', 'web', '2021-06-18 20:46:00', '2021-06-18 20:46:00'),
(324, 'menu.edit', 'web', '2021-06-18 20:46:00', '2021-06-18 20:46:00'),
(325, 'salas.store', 'web', '2021-06-18 20:46:00', '2021-06-18 20:46:00'),
(326, 'salas.index', 'web', '2021-06-18 20:46:00', '2021-06-18 20:46:00'),
(327, 'salas.create', 'web', '2021-06-18 20:46:00', '2021-06-18 20:46:00'),
(328, 'salas.update', 'web', '2021-06-18 20:46:00', '2021-06-18 20:46:00'),
(329, 'salas.show', 'web', '2021-06-18 20:46:00', '2021-06-18 20:46:00'),
(330, 'salas.destroy', 'web', '2021-06-18 20:46:00', '2021-06-18 20:46:00'),
(331, 'salas.edit', 'web', '2021-06-18 20:46:01', '2021-06-18 20:46:01'),
(332, 'pacientes.store', 'web', '2021-06-18 20:46:01', '2021-06-18 20:46:01'),
(333, 'pacientes.index', 'web', '2021-06-18 20:46:01', '2021-06-18 20:46:01'),
(334, 'pacientes.create', 'web', '2021-06-18 20:46:01', '2021-06-18 20:46:01'),
(335, 'pacientes.update', 'web', '2021-06-18 20:46:01', '2021-06-18 20:46:01'),
(336, 'pacientes.show', 'web', '2021-06-18 20:46:01', '2021-06-18 20:46:01'),
(337, 'pacientes.destroy', 'web', '2021-06-18 20:46:01', '2021-06-18 20:46:01'),
(338, 'pacientes.edit', 'web', '2021-06-18 20:46:01', '2021-06-18 20:46:01'),
(339, 'empleados.store', 'web', '2021-06-18 20:46:01', '2021-06-18 20:46:01'),
(340, 'empleados.index', 'web', '2021-06-18 20:46:01', '2021-06-18 20:46:01'),
(341, 'empleados.create', 'web', '2021-06-18 20:46:01', '2021-06-18 20:46:01'),
(342, 'empleados.update', 'web', '2021-06-18 20:46:01', '2021-06-18 20:46:01'),
(343, 'empleados.show', 'web', '2021-06-18 20:46:01', '2021-06-18 20:46:01'),
(344, 'empleados.destroy', 'web', '2021-06-18 20:46:01', '2021-06-18 20:46:01'),
(345, 'empleados.edit', 'web', '2021-06-18 20:46:01', '2021-06-18 20:46:01'),
(346, 'piezas.store', 'web', '2021-06-18 20:46:01', '2021-06-18 20:46:01'),
(347, 'piezas.index', 'web', '2021-06-18 20:46:01', '2021-06-18 20:46:01'),
(348, 'piezas.create', 'web', '2021-06-18 20:46:01', '2021-06-18 20:46:01'),
(349, 'piezas.update', 'web', '2021-06-18 20:46:01', '2021-06-18 20:46:01'),
(350, 'piezas.show', 'web', '2021-06-18 20:46:01', '2021-06-18 20:46:01'),
(351, 'piezas.destroy', 'web', '2021-06-18 20:46:01', '2021-06-18 20:46:01'),
(352, 'piezas.edit', 'web', '2021-06-18 20:46:01', '2021-06-18 20:46:01'),
(353, 'camas.store', 'web', '2021-06-18 20:46:01', '2021-06-18 20:46:01'),
(354, 'camas.index', 'web', '2021-06-18 20:46:01', '2021-06-18 20:46:01'),
(355, 'camas.create', 'web', '2021-06-18 20:46:01', '2021-06-18 20:46:01'),
(356, 'camas.update', 'web', '2021-06-18 20:46:01', '2021-06-18 20:46:01'),
(357, 'camas.show', 'web', '2021-06-18 20:46:01', '2021-06-18 20:46:01'),
(358, 'camas.destroy', 'web', '2021-06-18 20:46:01', '2021-06-18 20:46:01'),
(359, 'camas.edit', 'web', '2021-06-18 20:46:01', '2021-06-18 20:46:01'),
(360, 'menuportipopaciente.store', 'web', '2021-06-18 20:46:01', '2021-06-18 20:46:01'),
(361, 'menuportipopaciente.index', 'web', '2021-06-18 20:46:01', '2021-06-18 20:46:01'),
(362, 'menuportipopaciente.create', 'web', '2021-06-18 20:46:01', '2021-06-18 20:46:01'),
(363, 'menuportipopaciente.update', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(364, 'menuportipopaciente.show', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(365, 'menuportipopaciente.destroy', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(366, 'menuportipopaciente.edit', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(367, 'comidaportipopaciente.store', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(368, 'comidaportipopaciente.index', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(369, 'comidaportipopaciente.create', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(370, 'comidaportipopaciente.update', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(371, 'comidaportipopaciente.show', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(372, 'comidaportipopaciente.destroy', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(373, 'comidaportipopaciente.edit', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(374, 'alimentos.store', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(375, 'alimentos.index', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(376, 'alimentos.create', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(377, 'alimentos.update', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(378, 'alimentos.show', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(379, 'alimentos.destroy', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(380, 'alimentos.edit', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(381, 'alimentosporproveedor.store', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(382, 'alimentosporproveedor.index', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(383, 'alimentosporproveedor.create', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(384, 'alimentosporproveedor.update', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(385, 'alimentosporproveedor.show', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(386, 'alimentosporproveedor.destroy', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(387, 'alimentosporproveedor.edit', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(388, 'comidas.store', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(389, 'comidas.index', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(390, 'comidas.create', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(391, 'comidas.update', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(392, 'comidas.show', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(393, 'comidas.destroy', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(394, 'comidas.edit', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(395, 'alimentosporcomida.store', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(396, 'alimentosporcomida.index', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(397, 'alimentosporcomida.create', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(398, 'alimentosporcomida.update', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(399, 'alimentosporcomida.show', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(400, 'alimentosporcomida.destroy', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(401, 'alimentosporcomida.edit', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(402, 'nutrientesporalimento.store', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(403, 'nutrientesporalimento.index', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(404, 'nutrientesporalimento.create', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(405, 'nutrientesporalimento.update', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(406, 'nutrientesporalimento.show', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(407, 'nutrientesporalimento.destroy', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(408, 'nutrientesporalimento.edit', 'web', '2021-06-18 20:46:02', '2021-06-18 20:46:02'),
(409, 'relevamientos.store', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(410, 'relevamientos.index', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(411, 'relevamientos.create', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(412, 'relevamientos.update', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(413, 'relevamientos.show', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(414, 'relevamientos.destroy', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(415, 'relevamientos.edit', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(416, 'detallesrelevamiento.store', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(417, 'detallesrelevamiento.index', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(418, 'detallesrelevamiento.create', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(419, 'detallesrelevamiento.update', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(420, 'detallesrelevamiento.show', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(421, 'detallesrelevamiento.destroy', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(422, 'detallesrelevamiento.edit', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(423, 'detrelevamientoporcomida.store', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(424, 'detrelevamientoporcomida.index', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(425, 'detrelevamientoporcomida.create', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(426, 'detrelevamientoporcomida.update', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(427, 'detrelevamientoporcomida.show', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(428, 'detrelevamientoporcomida.destroy', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(429, 'detrelevamientoporcomida.edit', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(430, 'historial.elegirMenu', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(431, 'historial.store', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(432, 'historial.index', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(433, 'historial.create', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(434, 'historial.update', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(435, 'historial.show', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(436, 'historial.destroy', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(437, 'historial.edit', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(438, 'usuarios.store', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(439, 'usuarios.index', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(440, 'usuarios.create', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(441, 'usuarios.update', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(442, 'usuarios.show', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(443, 'usuarios.destroy', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(444, 'usuarios.edit', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(445, 'proveedores.store', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(446, 'proveedores.index', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(447, 'proveedores.create', 'web', '2021-06-18 20:46:03', '2021-06-18 20:46:03'),
(448, 'proveedores.update', 'web', '2021-06-18 20:46:04', '2021-06-18 20:46:04'),
(449, 'proveedores.show', 'web', '2021-06-18 20:46:04', '2021-06-18 20:46:04'),
(450, 'proveedores.destroy', 'web', '2021-06-18 20:46:04', '2021-06-18 20:46:04'),
(451, 'proveedores.edit', 'web', '2021-06-18 20:46:04', '2021-06-18 20:46:04'),
(452, 'permisos.store', 'web', '2021-06-18 20:46:04', '2021-06-18 20:46:04'),
(453, 'permisos.index', 'web', '2021-06-18 20:46:04', '2021-06-18 20:46:04'),
(454, 'permisos.create', 'web', '2021-06-18 20:46:04', '2021-06-18 20:46:04'),
(455, 'permisos.update', 'web', '2021-06-18 20:46:04', '2021-06-18 20:46:04'),
(456, 'permisos.show', 'web', '2021-06-18 20:46:04', '2021-06-18 20:46:04'),
(457, 'permisos.destroy', 'web', '2021-06-18 20:46:04', '2021-06-18 20:46:04'),
(458, 'permisos.edit', 'web', '2021-06-18 20:46:04', '2021-06-18 20:46:04'),
(459, 'seleccionarMenu.store', 'web', '2021-06-18 20:46:04', '2021-06-18 20:46:04'),
(460, 'seleccionarMenu.index', 'web', '2021-06-18 20:46:04', '2021-06-18 20:46:04'),
(461, 'seleccionarMenu.create', 'web', '2021-06-18 20:46:04', '2021-06-18 20:46:04'),
(462, 'seleccionarMenu.update', 'web', '2021-06-18 20:46:04', '2021-06-18 20:46:04'),
(463, 'seleccionarMenu.show', 'web', '2021-06-18 20:46:04', '2021-06-18 20:46:04'),
(464, 'seleccionarMenu.destroy', 'web', '2021-06-18 20:46:04', '2021-06-18 20:46:04'),
(465, 'seleccionarMenu.edit', 'web', '2021-06-18 20:46:04', '2021-06-18 20:46:04'),
(466, 'nutrientes.store', 'web', '2021-06-18 22:20:11', '2021-06-18 22:20:11'),
(467, 'nutrientes.index', 'web', '2021-06-18 22:20:11', '2021-06-18 22:20:11'),
(468, 'nutrientes.create', 'web', '2021-06-18 22:20:11', '2021-06-18 22:20:11'),
(469, 'nutrientes.update', 'web', '2021-06-18 22:20:11', '2021-06-18 22:20:11'),
(470, 'nutrientes.show', 'web', '2021-06-18 22:20:11', '2021-06-18 22:20:11'),
(471, 'nutrientes.destroy', 'web', '2021-06-18 22:20:11', '2021-06-18 22:20:11'),
(472, 'nutrientes.edit', 'web', '2021-06-18 22:20:11', '2021-06-18 22:20:11'),
(473, 'relevamientoPorSalas.store', 'web', '2021-07-22 01:20:13', '2021-07-22 01:20:13'),
(474, 'relevamientoPorSalas.index', 'web', '2021-07-22 01:20:13', '2021-07-22 01:20:13'),
(475, 'relevamientoPorSalas.create', 'web', '2021-07-22 01:20:13', '2021-07-22 01:20:13'),
(476, 'relevamientoPorSalas.update', 'web', '2021-07-22 01:20:13', '2021-07-22 01:20:13'),
(477, 'relevamientoPorSalas.show', 'web', '2021-07-22 01:20:13', '2021-07-22 01:20:13'),
(478, 'relevamientoPorSalas.destroy', 'web', '2021-07-22 01:20:13', '2021-07-22 01:20:13'),
(479, 'relevamientoPorSalas.edit', 'web', '2021-07-22 01:20:13', '2021-07-22 01:20:13'),
(480, 'congelador.store', 'web', '2021-09-01 22:47:01', '2021-09-01 22:47:01'),
(481, 'congelador.index', 'web', '2021-09-01 22:47:01', '2021-09-01 22:47:01'),
(482, 'congelador.create', 'web', '2021-09-01 22:47:01', '2021-09-01 22:47:01'),
(483, 'congelador.update', 'web', '2021-09-01 22:47:01', '2021-09-01 22:47:01'),
(484, 'congelador.show', 'web', '2021-09-01 22:47:01', '2021-09-01 22:47:01'),
(485, 'congelador.destroy', 'web', '2021-09-01 22:47:01', '2021-09-01 22:47:01'),
(486, 'congelador.edit', 'web', '2021-09-01 22:47:01', '2021-09-01 22:47:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pieza`
--

CREATE TABLE `pieza` (
  `PiezaId` int(11) NOT NULL,
  `SalaId` int(11) NOT NULL,
  `PiezaNombre` varchar(80) NOT NULL,
  `PiezaEstado` tinyint(4) NOT NULL,
  `PiezaPseudonimo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pieza`
--

INSERT INTO `pieza` (`PiezaId`, `SalaId`, `PiezaNombre`, `PiezaEstado`, `PiezaPseudonimo`) VALUES
(1, 1, 'Pieza A', 1, 'PA'),
(2, 1, 'Pieza B', 1, 'PB'),
(3, 2, 'Pieza A', 1, 'PA'),
(4, 1, 'Pieza C', 0, 'PC'),
(5, 1, 'Pieza C', 1, 'PC'),
(6, 1, 'Pieza D', 1, 'PD'),
(7, 1, 'Pieza E', 1, 'PE'),
(8, 2, 'Pieza B', 1, 'PB'),
(9, 2, 'Pieza C', 1, 'PC'),
(10, 3, 'Pieza A', 1, 'PA'),
(11, 3, 'Pieza B', 1, 'PB');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesional`
--

CREATE TABLE `profesional` (
  `ProfesionalId` int(11) NOT NULL,
  `ProfesionalMatricula` bigint(20) NOT NULL,
  `EmpleadoId` int(11) NOT NULL,
  `ProfesionalEstado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `ProveedorId` int(11) NOT NULL,
  `ProveedorNombre` varchar(80) NOT NULL,
  `ProveedorDireccion` varchar(80) NOT NULL,
  `ProveedorTelefono` varchar(80) NOT NULL,
  `ProveedorEmail` varchar(80) NOT NULL,
  `ProveedorCuit` bigint(20) DEFAULT NULL,
  `ProveedorEstado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`ProveedorId`, `ProveedorNombre`, `ProveedorDireccion`, `ProveedorTelefono`, `ProveedorEmail`, `ProveedorCuit`, `ProveedorEstado`) VALUES
(1, 'Cosalta', 'Salta 123', '3884828909', 'cosalta@gmail.com', 20375084229, 1),
(2, 'Serenisima', 'Senerisima 123', '3587521489', 'serenisima@gmail.com', 2037865289, 1),
(3, 'Gómez SRL', 'san luis 345', '4245452', 'gomezsrl@gmail.com', 20354587856, 1),
(4, 'Distribuidora Pérez', 'san juan 324', '24254125', 'distribuidorapapasperez@gmail.com', 2054878521, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relevamiento`
--

CREATE TABLE `relevamiento` (
  `RelevamientoId` int(11) NOT NULL,
  `RelevamientoFecha` date NOT NULL,
  `RelevamientoTurno` varchar(64) NOT NULL,
  `RelevamientoEstado` tinyint(4) DEFAULT NULL,
  `RelevamientoControlado` tinyint(4) NOT NULL DEFAULT 0,
  `RelevamientoMenu` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `relevamiento`
--

INSERT INTO `relevamiento` (`RelevamientoId`, `RelevamientoFecha`, `RelevamientoTurno`, `RelevamientoEstado`, `RelevamientoControlado`, `RelevamientoMenu`) VALUES
(96, '0001-01-01', 'Mañana', 1, 1, 20),
(113, '2021-09-30', 'Mañana', 1, 1, 20),
(117, '2021-10-01', 'Mañana', 1, 1, 20),
(118, '2021-10-02', 'Mañana', 1, 1, 20),
(120, '2021-10-12', 'Mañana', 1, 0, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relevamientoporsala`
--

CREATE TABLE `relevamientoporsala` (
  `RelevamientoPorSalaId` int(11) NOT NULL,
  `RelevamientoId` int(11) NOT NULL,
  `SalaId` int(11) NOT NULL,
  `RelevamientoPorSalaAcompaniantes` int(11) NOT NULL DEFAULT 0,
  `RelevamientoPorSalaEstado` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `relevamientoporsala`
--

INSERT INTO `relevamientoporsala` (`RelevamientoPorSalaId`, `RelevamientoId`, `SalaId`, `RelevamientoPorSalaAcompaniantes`, `RelevamientoPorSalaEstado`) VALUES
(32, 113, 1, 0, 1),
(33, 117, 1, 0, 1),
(35, 120, 1, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(9, 'Admin', 'web', '2021-06-18 20:46:00', '2021-06-18 20:46:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `id` int(11) NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`id`, `permission_id`, `role_id`) VALUES
(1, 311, 9),
(2, 312, 9),
(3, 313, 9),
(4, 314, 9),
(5, 315, 9),
(6, 316, 9),
(7, 317, 9),
(8, 318, 9),
(9, 319, 9),
(10, 320, 9),
(11, 321, 9),
(12, 322, 9),
(13, 323, 9),
(14, 324, 9),
(15, 325, 9),
(16, 326, 9),
(17, 327, 9),
(18, 328, 9),
(19, 329, 9),
(20, 330, 9),
(21, 331, 9),
(22, 332, 9),
(23, 333, 9),
(24, 334, 9),
(25, 335, 9),
(26, 336, 9),
(27, 337, 9),
(28, 338, 9),
(29, 339, 9),
(30, 340, 9),
(31, 341, 9),
(32, 342, 9),
(33, 343, 9),
(34, 344, 9),
(35, 345, 9),
(36, 346, 9),
(37, 347, 9),
(38, 348, 9),
(39, 349, 9),
(40, 350, 9),
(41, 351, 9),
(42, 352, 9),
(43, 353, 9),
(44, 354, 9),
(45, 355, 9),
(46, 356, 9),
(47, 357, 9),
(48, 358, 9),
(49, 359, 9),
(50, 360, 9),
(51, 361, 9),
(52, 362, 9),
(53, 363, 9),
(54, 364, 9),
(55, 365, 9),
(56, 366, 9),
(57, 367, 9),
(58, 368, 9),
(59, 369, 9),
(60, 370, 9),
(61, 371, 9),
(62, 372, 9),
(63, 373, 9),
(64, 374, 9),
(65, 375, 9),
(66, 376, 9),
(67, 377, 9),
(68, 378, 9),
(69, 379, 9),
(70, 380, 9),
(71, 381, 9),
(72, 382, 9),
(73, 383, 9),
(74, 384, 9),
(75, 385, 9),
(76, 386, 9),
(77, 387, 9),
(78, 388, 9),
(79, 389, 9),
(80, 390, 9),
(81, 391, 9),
(82, 392, 9),
(83, 393, 9),
(84, 394, 9),
(85, 395, 9),
(86, 396, 9),
(87, 397, 9),
(88, 398, 9),
(89, 399, 9),
(90, 400, 9),
(91, 401, 9),
(92, 402, 9),
(93, 403, 9),
(94, 404, 9),
(95, 405, 9),
(96, 406, 9),
(97, 407, 9),
(98, 408, 9),
(99, 409, 9),
(100, 410, 9),
(101, 411, 9),
(102, 412, 9),
(103, 413, 9),
(104, 414, 9),
(105, 415, 9),
(106, 416, 9),
(107, 417, 9),
(108, 418, 9),
(109, 419, 9),
(110, 420, 9),
(111, 421, 9),
(112, 422, 9),
(113, 423, 9),
(114, 424, 9),
(115, 425, 9),
(116, 426, 9),
(117, 427, 9),
(118, 428, 9),
(119, 429, 9),
(120, 430, 9),
(121, 431, 9),
(122, 432, 9),
(123, 433, 9),
(124, 434, 9),
(125, 435, 9),
(126, 436, 9),
(127, 437, 9),
(128, 438, 9),
(129, 439, 9),
(130, 440, 9),
(131, 441, 9),
(132, 442, 9),
(133, 443, 9),
(134, 444, 9),
(135, 445, 9),
(136, 446, 9),
(137, 447, 9),
(138, 448, 9),
(139, 449, 9),
(140, 450, 9),
(141, 451, 9),
(142, 452, 9),
(143, 453, 9),
(144, 454, 9),
(145, 455, 9),
(146, 456, 9),
(147, 457, 9),
(148, 458, 9),
(149, 459, 9),
(150, 460, 9),
(151, 461, 9),
(152, 462, 9),
(153, 463, 9),
(154, 464, 9),
(155, 465, 9),
(156, 466, 9),
(157, 467, 9),
(158, 468, 9),
(159, 469, 9),
(160, 470, 9),
(161, 471, 9),
(162, 472, 9),
(163, 473, 9),
(164, 474, 9),
(165, 475, 9),
(166, 476, 9),
(167, 477, 9),
(168, 478, 9),
(169, 479, 9),
(170, 480, 9),
(171, 481, 9),
(172, 482, 9),
(173, 483, 9),
(174, 484, 9),
(175, 485, 9),
(176, 486, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sala`
--

CREATE TABLE `sala` (
  `SalaId` int(11) NOT NULL,
  `SalaNombre` varchar(80) NOT NULL,
  `SalaEstado` tinyint(1) DEFAULT NULL,
  `SalaPseudonimo` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sala`
--

INSERT INTO `sala` (`SalaId`, `SalaNombre`, `SalaEstado`, `SalaPseudonimo`) VALUES
(1, 'Cirugía Especial de Mujeres', 1, 'CEM'),
(2, 'Cirugía Especial de Varones', 1, 'CEV'),
(3, 'Cirugía General de Mujeres', 1, 'CGM'),
(4, 'Sala 4', 0, 'S4'),
(5, 'Sala 5', 0, 'S5'),
(6, 'asfsdfsdf', 0, 'a5'),
(7, 'Cirugía General de Varones', 1, 'CGV'),
(8, 'Clínica de Mujeres', 1, 'CM'),
(9, 'Clínica de Varones', 1, 'CV'),
(10, 'Terapia Intermedia', 1, 'TI'),
(11, 'UTI', 1, 'UTI'),
(12, 'CCV', 1, 'CCV'),
(13, 'Trauma Mujeres', 1, 'TM'),
(14, 'Trauma Varones', 1, 'TV'),
(15, 'BRAQUI', 1, 'BRAQUI'),
(16, 'Quemado', 1, 'Quemado'),
(17, 'Guardia', 1, 'Guardia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temp_comida`
--

CREATE TABLE `temp_comida` (
  `TempComidaId` int(11) NOT NULL,
  `TempTandaId` int(11) NOT NULL,
  `ComidaId` int(11) NOT NULL,
  `CantidadNormal` int(11) NOT NULL,
  `CantidadCongelada` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `temp_comida`
--

INSERT INTO `temp_comida` (`TempComidaId`, `TempTandaId`, `ComidaId`, `CantidadNormal`, `CantidadCongelada`) VALUES
(45, 65, 20, 1, 0),
(46, 67, 20, 1, 1),
(47, 68, 19, 1, 1),
(48, 69, 19, 1, 0),
(49, 69, 20, 1, 0),
(50, 71, 21, 7, 0),
(51, 71, 24, 7, 0),
(52, 71, 22, 7, 0),
(53, 78, 19, 1, 3),
(72, 86, 24, 1, 0),
(77, 90, 20, 3, 0),
(78, 93, 24, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temp_relevamiento`
--

CREATE TABLE `temp_relevamiento` (
  `TempRelevamientoId` int(11) NOT NULL,
  `RelevamientoId` int(11) NOT NULL,
  `MenuId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `temp_relevamiento`
--

INSERT INTO `temp_relevamiento` (`TempRelevamientoId`, `RelevamientoId`, `MenuId`) VALUES
(53, 111, 20),
(54, 112, 20),
(55, 113, 20),
(62, 117, 20),
(64, 118, 20),
(65, 119, 20),
(66, 120, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temp_tanda`
--

CREATE TABLE `temp_tanda` (
  `TempTandaId` int(11) NOT NULL,
  `TempRelevamientoId` int(11) NOT NULL DEFAULT 1,
  `TandaNumero` int(11) NOT NULL,
  `TandaObservacion` varchar(256) DEFAULT NULL,
  `TandaHora` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `temp_tanda`
--

INSERT INTO `temp_tanda` (`TempTandaId`, `TempRelevamientoId`, `TandaNumero`, `TandaObservacion`, `TandaHora`) VALUES
(88, 64, 1, NULL, '2021-10-01 11:35:54'),
(90, 64, 2, NULL, '2021-10-01 11:36:42'),
(93, 64, 3, NULL, '2021-10-01 11:37:12'),
(99, 65, 1, NULL, '2021-10-01 12:47:37'),
(100, 66, 1, NULL, '2021-10-12 21:47:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipocomida`
--

CREATE TABLE `tipocomida` (
  `TipoComidaId` int(11) NOT NULL,
  `TipoComidaNombre` varchar(80) NOT NULL,
  `TipoComidaEstado` tinyint(4) NOT NULL,
  `TipoComidaTurno` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipocomida`
--

INSERT INTO `tipocomida` (`TipoComidaId`, `TipoComidaNombre`, `TipoComidaEstado`, `TipoComidaTurno`) VALUES
(1, 'Desayuno', 1, 1),
(2, 'Almuerzo', 1, 0),
(3, 'Sopa Almuerzo', 1, 0),
(4, 'Postre Almuerzo', 1, 0),
(5, 'Merienda', 1, 0),
(6, 'Cena', 1, 1),
(7, 'Sopa Cena', 1, 1),
(8, 'Postre Cena', 1, 1),
(9, 'Colación Mañana', 1, 1),
(10, 'Colación Tarde', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipopaciente`
--

CREATE TABLE `tipopaciente` (
  `TipoPacienteId` int(11) NOT NULL,
  `TipoPacienteNombre` varchar(80) NOT NULL,
  `TipoPacienteEstado` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipopaciente`
--

INSERT INTO `tipopaciente` (`TipoPacienteId`, `TipoPacienteNombre`, `TipoPacienteEstado`) VALUES
(1, 'Normal', 1),
(2, 'Hepático', 1),
(3, 'Blando', 1),
(4, 'Renal con sal', 1),
(5, 'Renal sin sal', 1),
(6, 'Diabético con sal', 1),
(7, 'Diabético sin sal', 1),
(8, 'Individual', 1),
(9, 'Pos-Operatorio-1', 1),
(10, 'Pos-Operatorio-2', 1),
(11, 'Pos-Operatorio-3', 1),
(12, 'Semilíquido/C', 1),
(13, 'Semilíquido/C', 1),
(14, 'Líquido común', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidadmedida`
--

CREATE TABLE `unidadmedida` (
  `UnidadMedidaId` int(11) NOT NULL,
  `UnidadMedidaNombre` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `unidadmedida`
--

INSERT INTO `unidadmedida` (`UnidadMedidaId`, `UnidadMedidaNombre`) VALUES
(1, 'Gramo'),
(2, 'Miligramo'),
(3, 'Unidad'),
(4, 'Litro'),
(5, 'Mililitro'),
(6, 'Kilogramo'),
(7, 'cm3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(8, 'Administrador', 'admin@admin.com', NULL, '$2y$10$pTP8B8QW/tnv.LjeV52X1.l/bSC1czvlLg/odwFeaLid87Sm6sjuW', NULL, '2021-06-18 20:46:04', '2021-06-18 20:46:04');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alimento`
--
ALTER TABLE `alimento`
  ADD PRIMARY KEY (`AlimentoId`),
  ADD KEY `UnidadMedidaId` (`UnidadMedidaId`);

--
-- Indices de la tabla `alimentoporcomida`
--
ALTER TABLE `alimentoporcomida`
  ADD PRIMARY KEY (`AlimentoPorComidaId`),
  ADD KEY `ComidaId` (`ComidaId`),
  ADD KEY `AlimentoId` (`AlimentoId`),
  ADD KEY `UnidadMedidaId` (`UnidadMedidaId`);

--
-- Indices de la tabla `alimentoporproveedor`
--
ALTER TABLE `alimentoporproveedor`
  ADD PRIMARY KEY (`AlimentoPorProveedorId`),
  ADD KEY `ProveedorId` (`ProveedorId`),
  ADD KEY `AlimentoId` (`AlimentoId`);

--
-- Indices de la tabla `cama`
--
ALTER TABLE `cama`
  ADD PRIMARY KEY (`CamaId`),
  ADD KEY `PiezaId` (`PiezaId`);

--
-- Indices de la tabla `comida`
--
ALTER TABLE `comida`
  ADD PRIMARY KEY (`ComidaId`),
  ADD KEY `TipoComidaId` (`TipoComidaId`);

--
-- Indices de la tabla `comidaportipopaciente`
--
ALTER TABLE `comidaportipopaciente`
  ADD PRIMARY KEY (`ComidaPorTipoPacienteId`),
  ADD KEY `ComidaId` (`ComidaId`),
  ADD KEY `DetalleMenuTipoPacienteId` (`DetalleMenuTipoPacienteId`);

--
-- Indices de la tabla `congelador`
--
ALTER TABLE `congelador`
  ADD PRIMARY KEY (`CongeladorId`);

--
-- Indices de la tabla `detallemenutipopaciente`
--
ALTER TABLE `detallemenutipopaciente`
  ADD PRIMARY KEY (`DetalleMenuTipoPacienteId`),
  ADD KEY `MenuId` (`MenuId`),
  ADD KEY `TipoPacienteId` (`TipoPacienteId`);

--
-- Indices de la tabla `detallerelevamiento`
--
ALTER TABLE `detallerelevamiento`
  ADD PRIMARY KEY (`DetalleRelevamientoId`),
  ADD KEY `PacienteId` (`PacienteId`),
  ADD KEY `TipoPacienteId` (`TipoPacienteId`),
  ADD KEY `CamaId` (`CamaId`),
  ADD KEY `DetalleRelevamientoColacion` (`DetalleRelevamientoColacion`);

--
-- Indices de la tabla `detrelevamientoporcomida`
--
ALTER TABLE `detrelevamientoporcomida`
  ADD PRIMARY KEY (`DetRelevamientoPorComidaId`),
  ADD KEY `detrelevamientoporcomida_detallerelevamientoid_foreign` (`DetalleRelevamientoId`),
  ADD KEY `detrelevamientoporcomida_comidaid_foreign` (`ComidaId`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`EmpleadoId`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`HistorialId`);

--
-- Indices de la tabla `historialdetallealimento`
--
ALTER TABLE `historialdetallealimento`
  ADD PRIMARY KEY (`HistorialDetalleAlimentoId`);

--
-- Indices de la tabla `historialdetallecomida`
--
ALTER TABLE `historialdetallecomida`
  ADD PRIMARY KEY (`HistorialDetalleComidaId`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`MenuId`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `nutriente`
--
ALTER TABLE `nutriente`
  ADD PRIMARY KEY (`NutrienteId`),
  ADD KEY `UnidadMedidaId` (`UnidadMedidaId`);

--
-- Indices de la tabla `nutrienteporalimento`
--
ALTER TABLE `nutrienteporalimento`
  ADD PRIMARY KEY (`NutrientePorAlimentoId`),
  ADD KEY `AlimentoId` (`AlimentoId`),
  ADD KEY `NutrienteId` (`NutrienteId`);

--
-- Indices de la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`PacienteId`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `pieza`
--
ALTER TABLE `pieza`
  ADD PRIMARY KEY (`PiezaId`),
  ADD KEY `SalaId` (`SalaId`);

--
-- Indices de la tabla `profesional`
--
ALTER TABLE `profesional`
  ADD PRIMARY KEY (`ProfesionalId`),
  ADD KEY `EmpleadoId` (`EmpleadoId`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`ProveedorId`);

--
-- Indices de la tabla `relevamiento`
--
ALTER TABLE `relevamiento`
  ADD PRIMARY KEY (`RelevamientoId`);

--
-- Indices de la tabla `relevamientoporsala`
--
ALTER TABLE `relevamientoporsala`
  ADD PRIMARY KEY (`RelevamientoPorSalaId`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indices de la tabla `sala`
--
ALTER TABLE `sala`
  ADD PRIMARY KEY (`SalaId`);

--
-- Indices de la tabla `temp_comida`
--
ALTER TABLE `temp_comida`
  ADD PRIMARY KEY (`TempComidaId`);

--
-- Indices de la tabla `temp_relevamiento`
--
ALTER TABLE `temp_relevamiento`
  ADD PRIMARY KEY (`TempRelevamientoId`);

--
-- Indices de la tabla `temp_tanda`
--
ALTER TABLE `temp_tanda`
  ADD PRIMARY KEY (`TempTandaId`);

--
-- Indices de la tabla `tipocomida`
--
ALTER TABLE `tipocomida`
  ADD PRIMARY KEY (`TipoComidaId`);

--
-- Indices de la tabla `tipopaciente`
--
ALTER TABLE `tipopaciente`
  ADD PRIMARY KEY (`TipoPacienteId`);

--
-- Indices de la tabla `unidadmedida`
--
ALTER TABLE `unidadmedida`
  ADD PRIMARY KEY (`UnidadMedidaId`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alimento`
--
ALTER TABLE `alimento`
  MODIFY `AlimentoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `alimentoporcomida`
--
ALTER TABLE `alimentoporcomida`
  MODIFY `AlimentoPorComidaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT de la tabla `alimentoporproveedor`
--
ALTER TABLE `alimentoporproveedor`
  MODIFY `AlimentoPorProveedorId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `cama`
--
ALTER TABLE `cama`
  MODIFY `CamaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `comida`
--
ALTER TABLE `comida`
  MODIFY `ComidaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `comidaportipopaciente`
--
ALTER TABLE `comidaportipopaciente`
  MODIFY `ComidaPorTipoPacienteId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `congelador`
--
ALTER TABLE `congelador`
  MODIFY `CongeladorId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `detallemenutipopaciente`
--
ALTER TABLE `detallemenutipopaciente`
  MODIFY `DetalleMenuTipoPacienteId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `detallerelevamiento`
--
ALTER TABLE `detallerelevamiento`
  MODIFY `DetalleRelevamientoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=453;

--
-- AUTO_INCREMENT de la tabla `detrelevamientoporcomida`
--
ALTER TABLE `detrelevamientoporcomida`
  MODIFY `DetRelevamientoPorComidaId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=243;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `EmpleadoId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `HistorialId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `historialdetallealimento`
--
ALTER TABLE `historialdetallealimento`
  MODIFY `HistorialDetalleAlimentoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `historialdetallecomida`
--
ALTER TABLE `historialdetallecomida`
  MODIFY `HistorialDetalleComidaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `MenuId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=484;

--
-- AUTO_INCREMENT de la tabla `nutriente`
--
ALTER TABLE `nutriente`
  MODIFY `NutrienteId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `nutrienteporalimento`
--
ALTER TABLE `nutrienteporalimento`
  MODIFY `NutrientePorAlimentoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=539;

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `PacienteId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=487;

--
-- AUTO_INCREMENT de la tabla `pieza`
--
ALTER TABLE `pieza`
  MODIFY `PiezaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `profesional`
--
ALTER TABLE `profesional`
  MODIFY `ProfesionalId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `ProveedorId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `relevamiento`
--
ALTER TABLE `relevamiento`
  MODIFY `RelevamientoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT de la tabla `relevamientoporsala`
--
ALTER TABLE `relevamientoporsala`
  MODIFY `RelevamientoPorSalaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;

--
-- AUTO_INCREMENT de la tabla `sala`
--
ALTER TABLE `sala`
  MODIFY `SalaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `temp_comida`
--
ALTER TABLE `temp_comida`
  MODIFY `TempComidaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT de la tabla `temp_relevamiento`
--
ALTER TABLE `temp_relevamiento`
  MODIFY `TempRelevamientoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `temp_tanda`
--
ALTER TABLE `temp_tanda`
  MODIFY `TempTandaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT de la tabla `tipocomida`
--
ALTER TABLE `tipocomida`
  MODIFY `TipoComidaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tipopaciente`
--
ALTER TABLE `tipopaciente`
  MODIFY `TipoPacienteId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `unidadmedida`
--
ALTER TABLE `unidadmedida`
  MODIFY `UnidadMedidaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alimento`
--
ALTER TABLE `alimento`
  ADD CONSTRAINT `fk_Alimento_UnidadMedida` FOREIGN KEY (`UnidadMedidaId`) REFERENCES `unidadmedida` (`UnidadMedidaId`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `alimentoporcomida`
--
ALTER TABLE `alimentoporcomida`
  ADD CONSTRAINT `fk_AlimentoPorComida_Alimento` FOREIGN KEY (`AlimentoId`) REFERENCES `alimento` (`AlimentoId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_AlimentoPorComida_Comida` FOREIGN KEY (`ComidaId`) REFERENCES `comida` (`ComidaId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_AlimentoPorComida_UnidadMedida` FOREIGN KEY (`UnidadMedidaId`) REFERENCES `unidadmedida` (`UnidadMedidaId`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `alimentoporproveedor`
--
ALTER TABLE `alimentoporproveedor`
  ADD CONSTRAINT `fk_AlimentoPorProveedor_Alimento` FOREIGN KEY (`AlimentoId`) REFERENCES `alimento` (`AlimentoId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_AlimentoPorProveedor_Proveedor` FOREIGN KEY (`ProveedorId`) REFERENCES `proveedor` (`ProveedorId`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `cama`
--
ALTER TABLE `cama`
  ADD CONSTRAINT `fk_Cama_Pieza` FOREIGN KEY (`PiezaId`) REFERENCES `pieza` (`PiezaId`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `comidaportipopaciente`
--
ALTER TABLE `comidaportipopaciente`
  ADD CONSTRAINT `fk_ComidaPorTipoPaciente_Comida` FOREIGN KEY (`ComidaId`) REFERENCES `comida` (`ComidaId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ComidaPorTipoPaciente_DetalleMenuTipoPaciente` FOREIGN KEY (`DetalleMenuTipoPacienteId`) REFERENCES `detallemenutipopaciente` (`DetalleMenuTipoPacienteId`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `detallemenutipopaciente`
--
ALTER TABLE `detallemenutipopaciente`
  ADD CONSTRAINT `fk_DetalleMenuTipoPaciente_Menu` FOREIGN KEY (`MenuId`) REFERENCES `menu` (`MenuId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_DetalleMenuTipoPaciente_TipoPaciente` FOREIGN KEY (`TipoPacienteId`) REFERENCES `tipopaciente` (`TipoPacienteId`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `detallerelevamiento`
--
ALTER TABLE `detallerelevamiento`
  ADD CONSTRAINT `fk_DetalleRelevamiento_Comida` FOREIGN KEY (`DetalleRelevamientoColacion`) REFERENCES `comida` (`ComidaId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_DetalleRelevamiento_Paciente` FOREIGN KEY (`PacienteId`) REFERENCES `paciente` (`PacienteId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_DetalleRelevamiento_TipoPaciente` FOREIGN KEY (`TipoPacienteId`) REFERENCES `tipopaciente` (`TipoPacienteId`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `detrelevamientoporcomida`
--
ALTER TABLE `detrelevamientoporcomida`
  ADD CONSTRAINT `detrelevamientoporcomida_comidaid_foreign` FOREIGN KEY (`ComidaId`) REFERENCES `comida` (`ComidaId`) ON DELETE CASCADE,
  ADD CONSTRAINT `detrelevamientoporcomida_detallerelevamientoid_foreign` FOREIGN KEY (`DetalleRelevamientoId`) REFERENCES `detallerelevamiento` (`DetalleRelevamientoId`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `nutriente`
--
ALTER TABLE `nutriente`
  ADD CONSTRAINT `fk_Nutriente_UnidadMedida` FOREIGN KEY (`UnidadMedidaId`) REFERENCES `unidadmedida` (`UnidadMedidaId`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `nutrienteporalimento`
--
ALTER TABLE `nutrienteporalimento`
  ADD CONSTRAINT `fk_NutrientePorAlimento_Alimento` FOREIGN KEY (`AlimentoId`) REFERENCES `alimento` (`AlimentoId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_NutrientePorAlimento_Nutriente` FOREIGN KEY (`NutrienteId`) REFERENCES `nutriente` (`NutrienteId`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `pieza`
--
ALTER TABLE `pieza`
  ADD CONSTRAINT `fk_Pieza_Sala` FOREIGN KEY (`SalaId`) REFERENCES `sala` (`SalaId`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `profesional`
--
ALTER TABLE `profesional`
  ADD CONSTRAINT `fk_Profesional_Empleado` FOREIGN KEY (`EmpleadoId`) REFERENCES `empleado` (`EmpleadoId`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
