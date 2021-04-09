-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-04-2021 a las 00:59:49
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
  `AlimentoCostoTotal` double NOT NULL,
  `AlimentoEstado` tinyint(1) DEFAULT NULL,
  `AlimentoEquivalenteGramos` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `alimento`
--

INSERT INTO `alimento` (`AlimentoId`, `AlimentoNombre`, `AlimentoCantidadTotal`, `UnidadMedidaId`, `AlimentoCostoTotal`, `AlimentoEstado`, `AlimentoEquivalenteGramos`) VALUES
(1, 'Te', 50, 3, 75, 1, NULL),
(2, 'Azúcar', 5, 6, 401, 1, NULL),
(3, 'Pan', 5, 6, 400, 1, NULL),
(4, 'Mermelada', 0, 1, 0, 1, NULL),
(5, 'Leche', 0, 4, 0, 1, NULL),
(6, 'pan', 0, 1, 0, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alimentoporcomida`
--

CREATE TABLE `alimentoporcomida` (
  `AlimentoPorComidaId` int(11) NOT NULL,
  `ComidaId` int(11) NOT NULL,
  `AlimentoId` int(11) NOT NULL,
  `AlimentoPorComidaCantidadNeto` int(11) NOT NULL,
  `AlimentoPorComidaEstado` tinyint(1) DEFAULT NULL,
  `UnidadMedidaId` int(11) NOT NULL,
  `AlimentoPorComidaCostoTotal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `alimentoporcomida`
--

INSERT INTO `alimentoporcomida` (`AlimentoPorComidaId`, `ComidaId`, `AlimentoId`, `AlimentoPorComidaCantidadNeto`, `AlimentoPorComidaEstado`, `UnidadMedidaId`, `AlimentoPorComidaCostoTotal`) VALUES
(1, 1, 1, 1, 1, 3, 1.5),
(2, 1, 2, 21, 1, 1, 1.6842),
(4, 1, 3, 45, 1, 1, 3.6),
(5, 2, 1, 1, 1, 3, 1.5);

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
  `AlimentoPorProveedorCantidadGramos` double DEFAULT NULL,
  `AlimentoPorProveedorCostoTotal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `alimentoporproveedor`
--

INSERT INTO `alimentoporproveedor` (`AlimentoPorProveedorId`, `ProveedorId`, `AlimentoId`, `AlimentoPorProveedorCosto`, `AlimentoPorProveedorCantidad`, `AlimentoPorProveedorVencimiento`, `AlimentoPorProveedorEstado`, `AlimentoPorProveedorCantidadGramos`, `AlimentoPorProveedorCostoTotal`) VALUES
(2, 2, 1, 1.48, 25, '2021-06-30', 1, NULL, 0),
(3, 1, 1, 1.52, 25, '2021-06-30', 1, NULL, 0),
(4, 2, 2, 80.2, 5, '2020-12-30', 1, NULL, 0),
(5, 1, 3, 80, 5, '2020-10-22', 1, NULL, 0);

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
(6, 2, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comida`
--

CREATE TABLE `comida` (
  `ComidaId` int(11) NOT NULL,
  `ComidaNombre` varchar(80) NOT NULL,
  `TipoComidaId` int(11) NOT NULL,
  `ComidaCostoTotal` double NOT NULL,
  `ComidaEstado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `comida`
--

INSERT INTO `comida` (`ComidaId`, `ComidaNombre`, `TipoComidaId`, `ComidaCostoTotal`, `ComidaEstado`) VALUES
(1, 'Te con tostadas', 1, 6.7842, 1),
(2, 'Almuerzo', 2, 1.5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comidaportipopaciente`
--

CREATE TABLE `comidaportipopaciente` (
  `ComidaPorTipoPacienteId` int(11) NOT NULL,
  `DetalleMenuTipoPacienteId` int(11) NOT NULL,
  `ComidaId` int(11) DEFAULT NULL,
  `TipoComidaId` int(11) NOT NULL,
  `ComidaPorTipoPacienteCostoTotal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `comidaportipopaciente`
--

INSERT INTO `comidaportipopaciente` (`ComidaPorTipoPacienteId`, `DetalleMenuTipoPacienteId`, `ComidaId`, `TipoComidaId`, `ComidaPorTipoPacienteCostoTotal`) VALUES
(1, 3, 1, 1, 6.7842),
(4, 4, 2, 2, 1.5),
(5, 4, 1, 1, 6.7842);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallehistorialcomida`
--

CREATE TABLE `detallehistorialcomida` (
  `DetalleHistorialComidaId` int(11) NOT NULL,
  `HistorialId` int(11) NOT NULL,
  `ComidaId` int(11) NOT NULL,
  `PacienteId` int(11) NOT NULL,
  `DetalleHistorialComidaCosto` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallemenutipopaciente`
--

CREATE TABLE `detallemenutipopaciente` (
  `DetalleMenuTipoPacienteId` int(11) NOT NULL,
  `MenuId` int(11) NOT NULL,
  `TipoPacienteId` int(11) NOT NULL,
  `DetalleMenuTipoPacienteCostoTotal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detallemenutipopaciente`
--

INSERT INTO `detallemenutipopaciente` (`DetalleMenuTipoPacienteId`, `MenuId`, `TipoPacienteId`, `DetalleMenuTipoPacienteCostoTotal`) VALUES
(3, 5, 1, 6.7842),
(4, 6, 8, 8.2842);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallerelevamiento`
--

CREATE TABLE `detallerelevamiento` (
  `DetalleRelevamientoId` int(11) NOT NULL,
  `PacienteId` int(11) NOT NULL,
  `RelevamientoId` int(11) NOT NULL,
  `DetalleRelevamientoFechora` varchar(30) NOT NULL,
  `TipoPacienteId` int(11) NOT NULL,
  `DetalleRelevamientoEstado` tinyint(1) DEFAULT NULL,
  `CamaId` int(11) NOT NULL,
  `DetalleRelevamientoObservaciones` longtext NOT NULL,
  `DetalleRelevamientoAcompaniante` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserId` bigint(20) UNSIGNED NOT NULL,
  `DetalleRelevamientoDiagnostico` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detallerelevamiento`
--

INSERT INTO `detallerelevamiento` (`DetalleRelevamientoId`, `PacienteId`, `RelevamientoId`, `DetalleRelevamientoFechora`, `TipoPacienteId`, `DetalleRelevamientoEstado`, `CamaId`, `DetalleRelevamientoObservaciones`, `DetalleRelevamientoAcompaniante`, `created_at`, `updated_at`, `UserId`, `DetalleRelevamientoDiagnostico`) VALUES
(10, 5, 3, '18:52:07', 1, 1, 5, 'asd', 1, '2021-04-08 21:52:07', '2021-04-08 21:52:07', 1, 'asd'),
(11, 5, 4, '19:45:14', 1, 1, 5, 'asd', 1, '2021-04-08 22:45:14', '2021-04-08 22:45:14', 1, 'asd'),
(12, 6, 4, '23:23:15', 8, 1, 2, 'asd', 1, '2021-04-09 02:23:15', '2021-04-09 02:23:15', 1, 'asd');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `EmpleadoId` int(11) NOT NULL,
  `EmpleadoEstado` tinyint(1) DEFAULT NULL,
  `PersonaId` int(11) NOT NULL
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
  `HistorialFecha` date NOT NULL,
  `HistorialCostoTotal` double NOT NULL DEFAULT 0,
  `HistorialCantidadPacientes` int(11) NOT NULL DEFAULT 0,
  `MenuNombre` varchar(80) NOT NULL,
  `HistorialEstado` tinyint(1) DEFAULT NULL,
  `HistorialTurno` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `historial`
--

INSERT INTO `historial` (`HistorialId`, `HistorialFecha`, `HistorialCostoTotal`, `HistorialCantidadPacientes`, `MenuNombre`, `HistorialEstado`, `HistorialTurno`) VALUES
(16, '2021-04-08', 0, 2, 'Menú 1', 0, 'Mañana'),
(17, '2021-04-08', 0, 2, 'Menú 1', 0, 'Mañana'),
(18, '2021-04-08', 0, 2, 'Menú 1', 0, 'Mañana'),
(19, '2021-04-08', 0, 2, 'Menú 1', 0, 'Mañana'),
(20, '2021-04-08', 0, 2, 'Menú 1', 0, 'Mañana'),
(21, '2021-04-08', 0, 2, 'Menú 1', 0, 'Mañana'),
(22, '2021-04-08', 0, 0, 'Menú 1', 0, 'Tarde'),
(23, '2021-04-08', 13.5684, 2, 'Menú 1', 0, 'Tarde'),
(24, '2021-04-08', 0, 2, 'Menú 1', 1, 'Mañana'),
(25, '2021-04-08', 13.56, 2, 'Menú 1', 0, 'Tarde'),
(26, '2021-04-08', 13.56, 2, 'Menú 1', 0, 'Tarde'),
(27, '2021-04-08', 13.56, 2, 'Menú 1', 0, 'Tarde'),
(28, '2021-04-08', 0, 0, 'Menú 1', 0, 'Tarde'),
(29, '2021-04-08', 0, 0, 'Menú 1', 0, 'Tarde'),
(30, '2021-04-08', 0, 0, 'Menú 1', 0, 'Tarde'),
(31, '2021-04-08', 0, 0, 'Menú 1', 0, 'Tarde'),
(32, '2021-04-08', 0, 0, 'Menú 1', 0, 'Tarde'),
(33, '2021-04-08', 13.56, 2, 'Menú 1', 0, 'Tarde'),
(34, '2021-04-08', 20.34, 4, 'Menú 1', 0, 'Tarde'),
(35, '2021-04-08', 27.12, 4, 'Menú 1', 1, 'Tarde');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historialalimentoporcomida`
--

CREATE TABLE `historialalimentoporcomida` (
  `HistorialAlimentoPorComidaId` int(11) NOT NULL,
  `AlimentoNombre` varchar(80) NOT NULL,
  `AlimentoCantidad` double NOT NULL,
  `AlimentoUnidadMedida` varchar(50) NOT NULL,
  `AlimentoCostoTotal` double NOT NULL,
  `HistorialComidaPorTipoPacienteId` int(11) NOT NULL,
  `HistorialAlimentoPorComidaEstado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `historialalimentoporcomida`
--

INSERT INTO `historialalimentoporcomida` (`HistorialAlimentoPorComidaId`, `AlimentoNombre`, `AlimentoCantidad`, `AlimentoUnidadMedida`, `AlimentoCostoTotal`, `HistorialComidaPorTipoPacienteId`, `HistorialAlimentoPorComidaEstado`) VALUES
(4, 'Te', 1, 'Unidad', 1.5, 3, 0),
(5, 'Azúcar', 21, 'Gramo', 1.6842, 3, 0),
(6, 'Pan', 45, 'Gramo', 3.6, 3, 0),
(7, 'Te', 1, 'Unidad', 1.5, 4, 0),
(8, 'Azúcar', 21, 'Gramo', 1.6842, 4, 0),
(9, 'Pan', 45, 'Gramo', 3.6, 4, 0),
(10, 'Te', 1, 'Unidad', 1.5, 5, 0),
(11, 'Azúcar', 21, 'Gramo', 1.68, 5, 0),
(12, 'Pan', 45, 'Gramo', 3.6, 5, 0),
(13, 'Te', 1, 'Unidad', 1.5, 6, 0),
(14, 'Azúcar', 21, 'Gramo', 1.68, 6, 0),
(15, 'Pan', 45, 'Gramo', 3.6, 6, 0),
(16, 'Te', 1, 'Unidad', 1.5, 7, 0),
(17, 'Azúcar', 21, 'Gramo', 1.68, 7, 0),
(18, 'Pan', 45, 'Gramo', 3.6, 7, 0),
(19, 'Te', 1, 'Unidad', 1.5, 10, 1),
(20, 'Azúcar', 21, 'Gramo', 1.68, 10, 1),
(21, 'Pan', 45, 'Gramo', 3.6, 10, 1),
(22, 'Te', 1, 'Unidad', 1.5, 11, 1),
(23, 'Azúcar', 21, 'Gramo', 1.68, 11, 1),
(24, 'Pan', 45, 'Gramo', 3.6, 11, 1),
(25, 'Te', 1, 'Unidad', 1.5, 12, 1),
(26, 'Azúcar', 21, 'Gramo', 1.68, 12, 1),
(27, 'Pan', 45, 'Gramo', 3.6, 12, 1),
(28, 'Te', 1, 'Unidad', 1.5, 13, 1),
(29, 'Azúcar', 21, 'Gramo', 1.68, 13, 1),
(30, 'Pan', 45, 'Gramo', 3.6, 13, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historialcomidaportipopaciente`
--

CREATE TABLE `historialcomidaportipopaciente` (
  `HistorialComidaPorTipoPacienteId` int(11) NOT NULL,
  `ComidaNombre` varchar(80) NOT NULL,
  `ComidaCostoTotal` double NOT NULL,
  `HistorialTipoPacienteId` int(11) NOT NULL,
  `TipoComidaNombre` varchar(80) NOT NULL,
  `HistorialComidaPorTipoPacienteEstado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `historialcomidaportipopaciente`
--

INSERT INTO `historialcomidaportipopaciente` (`HistorialComidaPorTipoPacienteId`, `ComidaNombre`, `ComidaCostoTotal`, `HistorialTipoPacienteId`, `TipoComidaNombre`, `HistorialComidaPorTipoPacienteEstado`) VALUES
(3, 'Te con tostadas', 6.7842, 13, 'Desayuno', 0),
(4, 'Te con tostadas', 6.7842, 14, 'Desayuno', 0),
(5, 'Te con tostadas', 6.78, 16, 'Desayuno', 0),
(6, 'Te con tostadas', 6.78, 17, 'Desayuno', 0),
(7, 'Te con tostadas', 6.78, 18, 'Desayuno', 0),
(8, 'Te con tostadas', 0, 22, 'Desayuno', 1),
(9, 'Te con tostadas', 0, 23, 'Desayuno', 1),
(10, 'Te con tostadas', 6.78, 24, 'Desayuno', 1),
(11, 'Te con tostadas', 6.78, 25, 'Desayuno', 1),
(12, 'Te con tostadas', 6.78, 27, 'Desayuno', 1),
(13, 'Te con tostadas', 6.78, 28, 'Desayuno', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historialtipopaciente`
--

CREATE TABLE `historialtipopaciente` (
  `HistorialTipoPacienteId` int(11) NOT NULL,
  `HistorialId` int(11) NOT NULL,
  `HistorialTipoPacienteCantidad` double NOT NULL DEFAULT 0,
  `HistorialTipoPacienteCostoTotal` double NOT NULL DEFAULT 0,
  `TipoPacienteNombre` varchar(80) NOT NULL,
  `PacienteId` int(11) DEFAULT NULL,
  `HistorialTipoPacienteEstado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `historialtipopaciente`
--

INSERT INTO `historialtipopaciente` (`HistorialTipoPacienteId`, `HistorialId`, `HistorialTipoPacienteCantidad`, `HistorialTipoPacienteCostoTotal`, `TipoPacienteNombre`, `PacienteId`, `HistorialTipoPacienteEstado`) VALUES
(7, 16, 2, 0, 'Normal', NULL, 0),
(8, 17, 2, 0, 'Normal', NULL, 0),
(9, 18, 2, 0, 'Normal', NULL, 0),
(10, 19, 2, 0, 'Normal', NULL, 0),
(11, 20, 2, 0, 'Normal', NULL, 0),
(12, 21, 2, 0, 'Normal', NULL, 0),
(13, 22, 0, 6.7842, 'Normal', NULL, 0),
(14, 23, 2, 6.7842, 'Normal', NULL, 0),
(15, 24, 2, 0, 'Normal', NULL, NULL),
(16, 25, 2, 6.78, 'Normal', NULL, 0),
(17, 26, 2, 6.78, 'Normal', NULL, 0),
(18, 27, 2, 6.78, 'Normal', NULL, 0),
(19, 28, 2, 0, 'Normal', NULL, 0),
(20, 29, 2, 0, 'Normal', NULL, 0),
(21, 30, 2, 0, 'Normal', NULL, 0),
(22, 31, 2, 0, 'Normal', NULL, 0),
(23, 32, 2, 0, 'Normal', NULL, 0),
(24, 33, 2, 6.78, 'Normal', NULL, 0),
(25, 34, 3, 6.78, 'Normal', NULL, 0),
(26, 34, 1, 0, 'Particular', 6, 0),
(27, 35, 3, 6.78, 'Normal', NULL, NULL),
(28, 35, 1, 6.78, 'Particular', 6, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `MenuId` int(11) NOT NULL,
  `MenuNombre` varchar(80) NOT NULL,
  `MenuEstado` tinyint(1) DEFAULT NULL,
  `MenuCostoTotal` double NOT NULL DEFAULT 0,
  `MenuParticular` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`MenuId`, `MenuNombre`, `MenuEstado`, `MenuCostoTotal`, `MenuParticular`) VALUES
(5, 'Menú 1', 1, 6.7842, 0),
(6, 'Particular 1', 1, 8.2842, 1);

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
(72, '2014_10_12_000000_create_users_table', 1),
(73, '2014_10_12_100000_create_password_resets_table', 1),
(74, '2019_08_19_000000_create_failed_jobs_table', 1),
(75, '2020_09_16_190655_create_roles_table', 1),
(76, '2021_04_08_121009_create_permission_tables', 1);

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
(1, 'App\\User', 1),
(2, 'App\\User', 2),
(3, 'App\\User', 3);

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
(2, 'Prótidos', 1, 1),
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
(19, 'Fósforo', 1, 2);

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
(210, 1, 1, 0, NULL),
(211, 1, 2, 0, NULL),
(212, 1, 3, 0, NULL),
(213, 1, 4, 0, NULL),
(214, 1, 5, 0, NULL),
(215, 1, 6, 0, NULL),
(216, 1, 7, 0, NULL),
(217, 1, 8, 0, NULL),
(218, 1, 9, 0, NULL),
(219, 1, 10, 0, NULL),
(220, 1, 11, 0, NULL),
(221, 1, 12, 0, NULL),
(222, 1, 13, 0, NULL),
(223, 1, 14, 0, NULL),
(224, 1, 15, 0, NULL),
(225, 1, 16, 0, NULL),
(226, 1, 17, 0, NULL),
(227, 1, 18, 0, NULL),
(228, 1, 19, 0, NULL),
(229, 2, 1, 100, NULL),
(230, 2, 2, 0, NULL),
(231, 2, 3, 0, NULL),
(232, 2, 4, 387, NULL),
(233, 2, 5, 0.1, NULL),
(234, 2, 6, 1, NULL),
(235, 2, 7, 1, NULL),
(236, 2, 8, 0, NULL),
(237, 2, 9, 0, NULL),
(238, 2, 10, 0, NULL),
(239, 2, 11, 0, NULL),
(240, 2, 12, 0, NULL),
(241, 2, 13, 0, NULL),
(242, 2, 14, 0, NULL),
(243, 2, 15, 0, NULL),
(244, 2, 16, 0, NULL),
(245, 2, 17, 0, NULL),
(246, 2, 18, 0, NULL),
(247, 2, 19, 0, NULL),
(275, 3, 1, 49, NULL),
(276, 3, 2, 0.6, NULL),
(277, 3, 3, 1, NULL),
(278, 3, 4, 13, NULL),
(279, 3, 5, 0.6, NULL),
(280, 3, 6, 0.4, NULL),
(281, 3, 7, 0.7, NULL),
(282, 3, 8, 0, NULL),
(283, 3, 9, 0, NULL),
(284, 3, 10, 0, NULL),
(285, 3, 11, 0, NULL),
(286, 3, 12, 0, NULL),
(287, 3, 13, 0, NULL),
(288, 3, 14, 0.7, NULL),
(289, 3, 15, 0.8, NULL),
(290, 3, 16, 0.8, NULL),
(291, 3, 17, 0.7, NULL),
(292, 3, 18, 1, NULL),
(293, 3, 19, 1, NULL),
(330, 4, 1, 1, NULL),
(331, 4, 2, 2, NULL),
(332, 4, 3, 3, NULL),
(333, 4, 4, 4, NULL),
(334, 4, 5, 5, NULL),
(335, 4, 6, 6, NULL),
(336, 4, 7, 7, NULL),
(337, 4, 8, 8, NULL),
(338, 4, 9, 9, NULL),
(339, 4, 10, 10, NULL),
(340, 4, 11, 11, NULL),
(341, 4, 12, 12, NULL),
(342, 4, 13, 13, NULL),
(343, 4, 14, 14, NULL),
(344, 4, 15, 15, NULL),
(345, 4, 16, 16, NULL),
(346, 4, 17, 17, NULL),
(347, 4, 18, 18, NULL),
(348, 4, 19, 19.2, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente`
--

CREATE TABLE `paciente` (
  `PacienteId` int(11) NOT NULL,
  `PersonaId` int(11) NOT NULL,
  `PacienteEstado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`PacienteId`, `PersonaId`, `PacienteEstado`) VALUES
(5, 5, 1),
(6, 6, 1),
(7, 7, 1),
(8, 8, 1);

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
(1, 'menu.store', 'web', '2021-04-08 19:29:34', '2021-04-08 19:29:34'),
(2, 'menu.index', 'web', '2021-04-08 19:29:34', '2021-04-08 19:29:34'),
(3, 'menu.create', 'web', '2021-04-08 19:29:34', '2021-04-08 19:29:34'),
(4, 'menu.update', 'web', '2021-04-08 19:29:34', '2021-04-08 19:29:34'),
(5, 'menu.show', 'web', '2021-04-08 19:29:34', '2021-04-08 19:29:34'),
(6, 'menu.destroy', 'web', '2021-04-08 19:29:34', '2021-04-08 19:29:34'),
(7, 'menu.edit', 'web', '2021-04-08 19:29:34', '2021-04-08 19:29:34'),
(8, 'salas.store', 'web', '2021-04-08 19:29:34', '2021-04-08 19:29:34'),
(9, 'salas.index', 'web', '2021-04-08 19:29:34', '2021-04-08 19:29:34'),
(10, 'salas.create', 'web', '2021-04-08 19:29:34', '2021-04-08 19:29:34'),
(11, 'salas.update', 'web', '2021-04-08 19:29:34', '2021-04-08 19:29:34'),
(12, 'salas.show', 'web', '2021-04-08 19:29:34', '2021-04-08 19:29:34'),
(13, 'salas.destroy', 'web', '2021-04-08 19:29:34', '2021-04-08 19:29:34'),
(14, 'salas.edit', 'web', '2021-04-08 19:29:34', '2021-04-08 19:29:34'),
(15, 'pacientes.store', 'web', '2021-04-08 19:29:34', '2021-04-08 19:29:34'),
(16, 'pacientes.index', 'web', '2021-04-08 19:29:34', '2021-04-08 19:29:34'),
(17, 'pacientes.create', 'web', '2021-04-08 19:29:34', '2021-04-08 19:29:34'),
(18, 'pacientes.update', 'web', '2021-04-08 19:29:34', '2021-04-08 19:29:34'),
(19, 'pacientes.show', 'web', '2021-04-08 19:29:34', '2021-04-08 19:29:34'),
(20, 'pacientes.destroy', 'web', '2021-04-08 19:29:34', '2021-04-08 19:29:34'),
(21, 'pacientes.edit', 'web', '2021-04-08 19:29:34', '2021-04-08 19:29:34'),
(22, 'piezas.store', 'web', '2021-04-08 19:29:34', '2021-04-08 19:29:34'),
(23, 'piezas.index', 'web', '2021-04-08 19:29:35', '2021-04-08 19:29:35'),
(24, 'piezas.create', 'web', '2021-04-08 19:29:35', '2021-04-08 19:29:35'),
(25, 'piezas.update', 'web', '2021-04-08 19:29:35', '2021-04-08 19:29:35'),
(26, 'piezas.show', 'web', '2021-04-08 19:29:35', '2021-04-08 19:29:35'),
(27, 'piezas.destroy', 'web', '2021-04-08 19:29:35', '2021-04-08 19:29:35'),
(28, 'piezas.edit', 'web', '2021-04-08 19:29:35', '2021-04-08 19:29:35'),
(29, 'menuportipopaciente.store', 'web', '2021-04-08 19:29:35', '2021-04-08 19:29:35'),
(30, 'menuportipopaciente.index', 'web', '2021-04-08 19:29:35', '2021-04-08 19:29:35'),
(31, 'menuportipopaciente.create', 'web', '2021-04-08 19:29:35', '2021-04-08 19:29:35'),
(32, 'menuportipopaciente.update', 'web', '2021-04-08 19:29:35', '2021-04-08 19:29:35'),
(33, 'menuportipopaciente.show', 'web', '2021-04-08 19:29:35', '2021-04-08 19:29:35'),
(34, 'menuportipopaciente.destroy', 'web', '2021-04-08 19:29:35', '2021-04-08 19:29:35'),
(35, 'menuportipopaciente.edit', 'web', '2021-04-08 19:29:35', '2021-04-08 19:29:35'),
(36, 'comidaportipopaciente.store', 'web', '2021-04-08 19:29:35', '2021-04-08 19:29:35'),
(37, 'comidaportipopaciente.index', 'web', '2021-04-08 19:29:35', '2021-04-08 19:29:35'),
(38, 'comidaportipopaciente.create', 'web', '2021-04-08 19:29:35', '2021-04-08 19:29:35'),
(39, 'comidaportipopaciente.update', 'web', '2021-04-08 19:29:35', '2021-04-08 19:29:35'),
(40, 'comidaportipopaciente.show', 'web', '2021-04-08 19:29:35', '2021-04-08 19:29:35'),
(41, 'comidaportipopaciente.destroy', 'web', '2021-04-08 19:29:35', '2021-04-08 19:29:35'),
(42, 'comidaportipopaciente.edit', 'web', '2021-04-08 19:29:35', '2021-04-08 19:29:35'),
(43, 'alimentos.store', 'web', '2021-04-08 19:29:35', '2021-04-08 19:29:35'),
(44, 'alimentos.index', 'web', '2021-04-08 19:29:35', '2021-04-08 19:29:35'),
(45, 'alimentos.create', 'web', '2021-04-08 19:29:35', '2021-04-08 19:29:35'),
(46, 'alimentos.update', 'web', '2021-04-08 19:29:35', '2021-04-08 19:29:35'),
(47, 'alimentos.show', 'web', '2021-04-08 19:29:36', '2021-04-08 19:29:36'),
(48, 'alimentos.destroy', 'web', '2021-04-08 19:29:36', '2021-04-08 19:29:36'),
(49, 'alimentos.edit', 'web', '2021-04-08 19:29:36', '2021-04-08 19:29:36'),
(50, 'alimentosporproveedor.store', 'web', '2021-04-08 19:29:36', '2021-04-08 19:29:36'),
(51, 'alimentosporproveedor.index', 'web', '2021-04-08 19:29:36', '2021-04-08 19:29:36'),
(52, 'alimentosporproveedor.create', 'web', '2021-04-08 19:29:36', '2021-04-08 19:29:36'),
(53, 'alimentosporproveedor.update', 'web', '2021-04-08 19:29:36', '2021-04-08 19:29:36'),
(54, 'alimentosporproveedor.show', 'web', '2021-04-08 19:29:36', '2021-04-08 19:29:36'),
(55, 'alimentosporproveedor.destroy', 'web', '2021-04-08 19:29:36', '2021-04-08 19:29:36'),
(56, 'alimentosporproveedor.edit', 'web', '2021-04-08 19:29:36', '2021-04-08 19:29:36'),
(57, 'comidas.store', 'web', '2021-04-08 19:29:36', '2021-04-08 19:29:36'),
(58, 'comidas.index', 'web', '2021-04-08 19:29:36', '2021-04-08 19:29:36'),
(59, 'comidas.create', 'web', '2021-04-08 19:29:36', '2021-04-08 19:29:36'),
(60, 'comidas.update', 'web', '2021-04-08 19:29:36', '2021-04-08 19:29:36'),
(61, 'comidas.show', 'web', '2021-04-08 19:29:36', '2021-04-08 19:29:36'),
(62, 'comidas.destroy', 'web', '2021-04-08 19:29:36', '2021-04-08 19:29:36'),
(63, 'comidas.edit', 'web', '2021-04-08 19:29:36', '2021-04-08 19:29:36'),
(64, 'alimentosporcomida.store', 'web', '2021-04-08 19:29:36', '2021-04-08 19:29:36'),
(65, 'alimentosporcomida.index', 'web', '2021-04-08 19:29:36', '2021-04-08 19:29:36'),
(66, 'alimentosporcomida.create', 'web', '2021-04-08 19:29:36', '2021-04-08 19:29:36'),
(67, 'alimentosporcomida.update', 'web', '2021-04-08 19:29:36', '2021-04-08 19:29:36'),
(68, 'alimentosporcomida.show', 'web', '2021-04-08 19:29:37', '2021-04-08 19:29:37'),
(69, 'alimentosporcomida.destroy', 'web', '2021-04-08 19:29:37', '2021-04-08 19:29:37'),
(70, 'alimentosporcomida.edit', 'web', '2021-04-08 19:29:37', '2021-04-08 19:29:37'),
(71, 'nutrientesporalimento.store', 'web', '2021-04-08 19:29:37', '2021-04-08 19:29:37'),
(72, 'nutrientesporalimento.index', 'web', '2021-04-08 19:29:37', '2021-04-08 19:29:37'),
(73, 'nutrientesporalimento.create', 'web', '2021-04-08 19:29:37', '2021-04-08 19:29:37'),
(74, 'nutrientesporalimento.update', 'web', '2021-04-08 19:29:37', '2021-04-08 19:29:37'),
(75, 'nutrientesporalimento.show', 'web', '2021-04-08 19:29:37', '2021-04-08 19:29:37'),
(76, 'nutrientesporalimento.destroy', 'web', '2021-04-08 19:29:37', '2021-04-08 19:29:37'),
(77, 'nutrientesporalimento.edit', 'web', '2021-04-08 19:29:37', '2021-04-08 19:29:37'),
(78, 'relevamientos.store', 'web', '2021-04-08 19:29:37', '2021-04-08 19:29:37'),
(79, 'relevamientos.index', 'web', '2021-04-08 19:29:37', '2021-04-08 19:29:37'),
(80, 'relevamientos.create', 'web', '2021-04-08 19:29:37', '2021-04-08 19:29:37'),
(81, 'relevamientos.update', 'web', '2021-04-08 19:29:38', '2021-04-08 19:29:38'),
(82, 'relevamientos.show', 'web', '2021-04-08 19:29:38', '2021-04-08 19:29:38'),
(83, 'relevamientos.destroy', 'web', '2021-04-08 19:29:38', '2021-04-08 19:29:38'),
(84, 'relevamientos.edit', 'web', '2021-04-08 19:29:38', '2021-04-08 19:29:38'),
(85, 'detallesrelevamiento.store', 'web', '2021-04-08 19:29:38', '2021-04-08 19:29:38'),
(86, 'detallesrelevamiento.index', 'web', '2021-04-08 19:29:38', '2021-04-08 19:29:38'),
(87, 'detallesrelevamiento.create', 'web', '2021-04-08 19:29:38', '2021-04-08 19:29:38'),
(88, 'detallesrelevamiento.update', 'web', '2021-04-08 19:29:38', '2021-04-08 19:29:38'),
(89, 'detallesrelevamiento.show', 'web', '2021-04-08 19:29:38', '2021-04-08 19:29:38'),
(90, 'detallesrelevamiento.destroy', 'web', '2021-04-08 19:29:38', '2021-04-08 19:29:38'),
(91, 'detallesrelevamiento.edit', 'web', '2021-04-08 19:29:38', '2021-04-08 19:29:38'),
(92, 'historial.elegirMenu', 'web', '2021-04-08 19:29:38', '2021-04-08 19:29:38'),
(93, 'historial.store', 'web', '2021-04-08 19:29:38', '2021-04-08 19:29:38'),
(94, 'historial.index', 'web', '2021-04-08 19:29:38', '2021-04-08 19:29:38'),
(95, 'historial.create', 'web', '2021-04-08 19:29:39', '2021-04-08 19:29:39'),
(96, 'historial.update', 'web', '2021-04-08 19:29:39', '2021-04-08 19:29:39'),
(97, 'historial.show', 'web', '2021-04-08 19:29:39', '2021-04-08 19:29:39'),
(98, 'historial.destroy', 'web', '2021-04-08 19:29:39', '2021-04-08 19:29:39'),
(99, 'historial.edit', 'web', '2021-04-08 19:29:39', '2021-04-08 19:29:39'),
(100, 'usuarios.store', 'web', '2021-04-08 19:29:39', '2021-04-08 19:29:39'),
(101, 'usuarios.index', 'web', '2021-04-08 19:29:39', '2021-04-08 19:29:39'),
(102, 'usuarios.create', 'web', '2021-04-08 19:29:39', '2021-04-08 19:29:39'),
(103, 'usuarios.update', 'web', '2021-04-08 19:29:39', '2021-04-08 19:29:39'),
(104, 'usuarios.show', 'web', '2021-04-08 19:29:39', '2021-04-08 19:29:39'),
(105, 'usuarios.destroy', 'web', '2021-04-08 19:29:39', '2021-04-08 19:29:39'),
(106, 'usuarios.edit', 'web', '2021-04-08 19:29:39', '2021-04-08 19:29:39'),
(107, 'proveedores.store', 'web', '2021-04-08 19:29:39', '2021-04-08 19:29:39'),
(108, 'proveedores.index', 'web', '2021-04-08 19:29:39', '2021-04-08 19:29:39'),
(109, 'proveedores.create', 'web', '2021-04-08 19:29:39', '2021-04-08 19:29:39'),
(110, 'proveedores.update', 'web', '2021-04-08 19:29:39', '2021-04-08 19:29:39'),
(111, 'proveedores.show', 'web', '2021-04-08 19:29:39', '2021-04-08 19:29:39'),
(112, 'proveedores.destroy', 'web', '2021-04-08 19:29:40', '2021-04-08 19:29:40'),
(113, 'proveedores.edit', 'web', '2021-04-08 19:29:40', '2021-04-08 19:29:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `PersonaId` int(11) NOT NULL,
  `PersonaNombre` varchar(80) NOT NULL,
  `PersonaApellido` varchar(80) NOT NULL,
  `PersonaDireccion` text DEFAULT NULL,
  `PersonaEmail` varchar(80) DEFAULT NULL,
  `PersonaTelefono` varchar(80) DEFAULT NULL,
  `PersonaCuil` bigint(20) DEFAULT NULL,
  `PersonaSexo` char(1) DEFAULT NULL,
  `PersonaEstado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`PersonaId`, `PersonaNombre`, `PersonaApellido`, `PersonaDireccion`, `PersonaEmail`, `PersonaTelefono`, `PersonaCuil`, `PersonaSexo`, `PersonaEstado`) VALUES
(5, 'Pablo', 'Vega', 'Boscariol 2443', 'pablo2443@gmail.com', '4255156', 20375084229, 'M', 1),
(6, 'Martin', 'Abad', 'Salta 123', 'abad@gmail.com', '42556357', 20393606887, 'M', 1),
(7, 'Cristian', 'Zalazar', 'Cerrillos 42', 'zalazar@gmail.com', '42556654', 2037895239, 'M', 1),
(8, 'Osvaldo', 'Daniel', 'Buenos Aires 152', 'dani.stone@gmail.com', '426335889', 20358966789, 'M', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pieza`
--

CREATE TABLE `pieza` (
  `PiezaId` int(11) NOT NULL,
  `SalaId` int(11) NOT NULL,
  `PiezaNombre` varchar(80) NOT NULL,
  `PiezaEstado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pieza`
--

INSERT INTO `pieza` (`PiezaId`, `SalaId`, `PiezaNombre`, `PiezaEstado`) VALUES
(1, 1, 'Pieza A', 1),
(2, 1, 'Pieza B', 1),
(3, 2, 'Pieza A', 1);

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
(2, 'Serenisima', 'Senerisima 123', '3587521489', 'serenisima@gmail.com', 2037865289, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relevamiento`
--

CREATE TABLE `relevamiento` (
  `RelevamientoId` int(11) NOT NULL,
  `RelevamientoFecha` varchar(80) NOT NULL,
  `RelevamientoEstado` tinyint(4) DEFAULT NULL,
  `RelevamientoTurno` varchar(80) NOT NULL,
  `RelevamientoAcompaniantes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `relevamiento`
--

INSERT INTO `relevamiento` (`RelevamientoId`, `RelevamientoFecha`, `RelevamientoEstado`, `RelevamientoTurno`, `RelevamientoAcompaniantes`) VALUES
(3, '2021-04-08', 1, 'Mañana', 0),
(4, '2021-04-08', 1, 'Tarde', 0);

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
(1, 'Admin', 'web', '2021-04-08 19:29:34', '2021-04-08 19:29:34'),
(2, 'Nutricion', 'web', '2021-04-08 19:29:34', '2021-04-08 19:29:34'),
(3, 'Relevamiento', 'web', '2021-04-08 19:29:34', '2021-04-08 19:29:34'),
(4, 'Despensa', 'web', '2021-04-08 19:29:34', '2021-04-08 19:29:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2),
(3, 1),
(3, 2),
(4, 1),
(4, 2),
(5, 1),
(5, 2),
(6, 1),
(6, 2),
(7, 1),
(7, 2),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(29, 2),
(30, 1),
(30, 2),
(31, 1),
(31, 2),
(32, 1),
(32, 2),
(33, 1),
(33, 2),
(34, 1),
(34, 2),
(35, 1),
(35, 2),
(36, 1),
(36, 2),
(37, 1),
(37, 2),
(38, 1),
(38, 2),
(39, 1),
(39, 2),
(40, 1),
(40, 2),
(41, 1),
(41, 2),
(42, 1),
(42, 2),
(43, 1),
(43, 2),
(43, 4),
(44, 1),
(44, 2),
(44, 4),
(45, 1),
(45, 2),
(45, 4),
(46, 1),
(46, 2),
(46, 4),
(47, 1),
(47, 2),
(47, 4),
(48, 1),
(48, 2),
(48, 4),
(49, 1),
(49, 2),
(49, 4),
(50, 1),
(50, 2),
(50, 4),
(51, 1),
(51, 2),
(51, 4),
(52, 1),
(52, 2),
(52, 4),
(53, 1),
(53, 2),
(53, 4),
(54, 1),
(54, 2),
(54, 4),
(55, 1),
(55, 2),
(55, 4),
(56, 1),
(56, 2),
(56, 4),
(57, 1),
(57, 2),
(58, 1),
(58, 2),
(59, 1),
(59, 2),
(60, 1),
(60, 2),
(61, 1),
(61, 2),
(62, 1),
(62, 2),
(63, 1),
(63, 2),
(64, 1),
(64, 2),
(65, 1),
(65, 2),
(66, 1),
(66, 2),
(67, 1),
(67, 2),
(68, 1),
(68, 2),
(69, 1),
(69, 2),
(70, 1),
(70, 2),
(71, 1),
(71, 4),
(72, 1),
(72, 4),
(73, 1),
(73, 4),
(74, 1),
(74, 4),
(75, 1),
(75, 4),
(76, 1),
(76, 4),
(77, 1),
(77, 4),
(78, 1),
(78, 2),
(78, 3),
(79, 1),
(79, 2),
(79, 3),
(80, 1),
(80, 2),
(80, 3),
(81, 1),
(81, 2),
(81, 3),
(82, 1),
(82, 2),
(82, 3),
(83, 1),
(83, 2),
(83, 3),
(84, 1),
(84, 2),
(84, 3),
(85, 1),
(85, 2),
(85, 3),
(86, 1),
(86, 2),
(86, 3),
(87, 1),
(87, 2),
(87, 3),
(88, 1),
(88, 2),
(88, 3),
(89, 1),
(89, 2),
(89, 3),
(90, 1),
(90, 2),
(90, 3),
(91, 1),
(91, 2),
(91, 3),
(92, 1),
(92, 2),
(93, 1),
(93, 2),
(94, 1),
(94, 2),
(95, 1),
(95, 2),
(96, 1),
(96, 2),
(97, 1),
(97, 2),
(98, 1),
(98, 2),
(99, 1),
(99, 2),
(100, 1),
(101, 1),
(102, 1),
(103, 1),
(104, 1),
(105, 1),
(106, 1),
(107, 1),
(108, 1),
(109, 1),
(110, 1),
(111, 1),
(112, 1),
(113, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sala`
--

CREATE TABLE `sala` (
  `SalaId` int(11) NOT NULL,
  `SalaNombre` varchar(80) NOT NULL,
  `SalaEstado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sala`
--

INSERT INTO `sala` (`SalaId`, `SalaNombre`, `SalaEstado`) VALUES
(1, 'Sala 1', 1),
(2, 'Sala 2', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipocomida`
--

CREATE TABLE `tipocomida` (
  `TipoComidaId` int(11) NOT NULL,
  `TipoComidaNombre` varchar(80) NOT NULL,
  `TipoComidaEstado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipocomida`
--

INSERT INTO `tipocomida` (`TipoComidaId`, `TipoComidaNombre`, `TipoComidaEstado`) VALUES
(1, 'Desayuno', 1),
(2, 'Almuerzo', 1),
(3, 'Sopa Almuerzo', 1),
(4, 'Postre Almuerzo', 1),
(5, 'Merienda', 1),
(6, 'Cena', 1),
(7, 'Sopa Cena', 1),
(8, 'Postre Cena', 1);

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
(8, 'Particular', 1),
(9, 'Pos-Operatorio-1', 1),
(10, 'Pos-Operatorio-2', 1),
(11, 'Pos-Operatorio-3', 1);

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
(7, 'U.I');

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
(1, 'Martín Abad', 'abad@gmail.com', NULL, '$2y$10$qPhS7JBEnaP5kkmzWvJP6e89kE9sRSoZA3/Fr6HDBSSgjl1.oeEtW', NULL, '2021-04-08 19:29:40', '2021-04-08 19:29:40'),
(2, 'Pablo vega', 'vega@gmail.com', NULL, '$2y$10$3.MEmwWWtdYCHCl92vz2peCuMjfXICD402L2vMfYk4lkq738e8Qfu', NULL, '2021-04-08 19:29:40', '2021-04-08 19:29:40'),
(3, 'Lautaro Martinez', 'zalazar@gmail.com', NULL, '$2y$10$i0IkA8jgiZpNeUjUrr2Vpuj10Uyr03yC45e7ncbTcjtR/jaOqF.Ua', NULL, '2021-04-08 19:29:40', '2021-04-08 19:29:40');

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
  ADD KEY `TipoComidaId` (`TipoComidaId`),
  ADD KEY `DetalleMenuTipoPacienteId` (`DetalleMenuTipoPacienteId`);

--
-- Indices de la tabla `detallehistorialcomida`
--
ALTER TABLE `detallehistorialcomida`
  ADD PRIMARY KEY (`DetalleHistorialComidaId`),
  ADD KEY `HistorialId` (`HistorialId`),
  ADD KEY `ComidaId` (`ComidaId`),
  ADD KEY `PacienteId` (`PacienteId`);

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
  ADD KEY `RelevamientoId` (`RelevamientoId`),
  ADD KEY `TipoPacienteId` (`TipoPacienteId`),
  ADD KEY `CamaId` (`CamaId`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`EmpleadoId`),
  ADD KEY `PersonaId` (`PersonaId`);

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
-- Indices de la tabla `historialalimentoporcomida`
--
ALTER TABLE `historialalimentoporcomida`
  ADD PRIMARY KEY (`HistorialAlimentoPorComidaId`),
  ADD KEY `HistorialComidaPorTipoPacienteId` (`HistorialComidaPorTipoPacienteId`);

--
-- Indices de la tabla `historialcomidaportipopaciente`
--
ALTER TABLE `historialcomidaportipopaciente`
  ADD PRIMARY KEY (`HistorialComidaPorTipoPacienteId`),
  ADD KEY `HistorialTipoPacienteId` (`HistorialTipoPacienteId`);

--
-- Indices de la tabla `historialtipopaciente`
--
ALTER TABLE `historialtipopaciente`
  ADD PRIMARY KEY (`HistorialTipoPacienteId`),
  ADD KEY `HistorialId` (`HistorialId`),
  ADD KEY `PacienteId` (`PacienteId`);

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
  ADD PRIMARY KEY (`PacienteId`),
  ADD KEY `PersonaId` (`PersonaId`);

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
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`PersonaId`);

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
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `sala`
--
ALTER TABLE `sala`
  ADD PRIMARY KEY (`SalaId`);

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
  MODIFY `AlimentoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `alimentoporcomida`
--
ALTER TABLE `alimentoporcomida`
  MODIFY `AlimentoPorComidaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `alimentoporproveedor`
--
ALTER TABLE `alimentoporproveedor`
  MODIFY `AlimentoPorProveedorId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cama`
--
ALTER TABLE `cama`
  MODIFY `CamaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `comida`
--
ALTER TABLE `comida`
  MODIFY `ComidaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `comidaportipopaciente`
--
ALTER TABLE `comidaportipopaciente`
  MODIFY `ComidaPorTipoPacienteId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `detallehistorialcomida`
--
ALTER TABLE `detallehistorialcomida`
  MODIFY `DetalleHistorialComidaId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detallemenutipopaciente`
--
ALTER TABLE `detallemenutipopaciente`
  MODIFY `DetalleMenuTipoPacienteId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `detallerelevamiento`
--
ALTER TABLE `detallerelevamiento`
  MODIFY `DetalleRelevamientoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  MODIFY `HistorialId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `historialalimentoporcomida`
--
ALTER TABLE `historialalimentoporcomida`
  MODIFY `HistorialAlimentoPorComidaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `historialcomidaportipopaciente`
--
ALTER TABLE `historialcomidaportipopaciente`
  MODIFY `HistorialComidaPorTipoPacienteId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `historialtipopaciente`
--
ALTER TABLE `historialtipopaciente`
  MODIFY `HistorialTipoPacienteId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `MenuId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT de la tabla `nutriente`
--
ALTER TABLE `nutriente`
  MODIFY `NutrienteId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `nutrienteporalimento`
--
ALTER TABLE `nutrienteporalimento`
  MODIFY `NutrientePorAlimentoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=368;

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `PacienteId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `PersonaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `pieza`
--
ALTER TABLE `pieza`
  MODIFY `PiezaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `profesional`
--
ALTER TABLE `profesional`
  MODIFY `ProfesionalId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `ProveedorId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `relevamiento`
--
ALTER TABLE `relevamiento`
  MODIFY `RelevamientoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `sala`
--
ALTER TABLE `sala`
  MODIFY `SalaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipocomida`
--
ALTER TABLE `tipocomida`
  MODIFY `TipoComidaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tipopaciente`
--
ALTER TABLE `tipopaciente`
  MODIFY `TipoPacienteId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `unidadmedida`
--
ALTER TABLE `unidadmedida`
  MODIFY `UnidadMedidaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
-- Filtros para la tabla `comida`
--
ALTER TABLE `comida`
  ADD CONSTRAINT `fk_Comida_TipoComida` FOREIGN KEY (`TipoComidaId`) REFERENCES `tipocomida` (`TipoComidaId`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `comidaportipopaciente`
--
ALTER TABLE `comidaportipopaciente`
  ADD CONSTRAINT `fk_ComidaPorTipoPaciente_Comida` FOREIGN KEY (`ComidaId`) REFERENCES `comida` (`ComidaId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ComidaPorTipoPaciente_DetalleMenuTipoPaciente` FOREIGN KEY (`DetalleMenuTipoPacienteId`) REFERENCES `detallemenutipopaciente` (`DetalleMenuTipoPacienteId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ComidaPorTipoPaciente_TipoComida` FOREIGN KEY (`TipoComidaId`) REFERENCES `tipocomida` (`TipoComidaId`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `detallehistorialcomida`
--
ALTER TABLE `detallehistorialcomida`
  ADD CONSTRAINT `fk_DetalleHistorialComida_Comida` FOREIGN KEY (`ComidaId`) REFERENCES `comida` (`ComidaId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_DetalleHistorialComida_Historial` FOREIGN KEY (`HistorialId`) REFERENCES `historial` (`HistorialId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_DetalleHistorialComida_Paciente` FOREIGN KEY (`PacienteId`) REFERENCES `paciente` (`PacienteId`) ON UPDATE CASCADE;

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
  ADD CONSTRAINT `fk_DetalleRelevamiento_Paciente` FOREIGN KEY (`PacienteId`) REFERENCES `paciente` (`PacienteId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_DetalleRelevamiento_Relevamiento` FOREIGN KEY (`RelevamientoId`) REFERENCES `relevamiento` (`RelevamientoId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_DetalleRelevamiento_TipoPaciente` FOREIGN KEY (`TipoPacienteId`) REFERENCES `tipopaciente` (`TipoPacienteId`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `fk_Empleado_Persona` FOREIGN KEY (`PersonaId`) REFERENCES `persona` (`PersonaId`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `historialalimentoporcomida`
--
ALTER TABLE `historialalimentoporcomida`
  ADD CONSTRAINT `fk_HistorialAlimentoPorComida_HistorialComidaPorTipoPaciente` FOREIGN KEY (`HistorialComidaPorTipoPacienteId`) REFERENCES `historialcomidaportipopaciente` (`HistorialComidaPorTipoPacienteId`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `historialcomidaportipopaciente`
--
ALTER TABLE `historialcomidaportipopaciente`
  ADD CONSTRAINT `fk_HistorialComidaPorTipoPaciente_HistorialTipoPaciente` FOREIGN KEY (`HistorialTipoPacienteId`) REFERENCES `historialtipopaciente` (`HistorialTipoPacienteId`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `historialtipopaciente`
--
ALTER TABLE `historialtipopaciente`
  ADD CONSTRAINT `fk_HistorialTipoPaciente_Historial` FOREIGN KEY (`HistorialId`) REFERENCES `historial` (`HistorialId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_HistorialTipoPaciente_Paciente` FOREIGN KEY (`PacienteId`) REFERENCES `paciente` (`PacienteId`) ON UPDATE CASCADE;

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
-- Filtros para la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD CONSTRAINT `fk_Paciente_Persona` FOREIGN KEY (`PersonaId`) REFERENCES `persona` (`PersonaId`) ON UPDATE CASCADE;

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
