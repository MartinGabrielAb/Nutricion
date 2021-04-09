-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-10-2020 a las 18:09:55
-- Versión del servidor: 10.4.6-MariaDB
-- Versión de PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
  `AlimentoEstado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `alimento`
--

INSERT INTO `alimento` (`AlimentoId`, `AlimentoNombre`, `AlimentoCantidadTotal`, `UnidadMedidaId`, `AlimentoCostoTotal`, `AlimentoEstado`) VALUES
(1, 'Te', 50, 3, 75, 1),
(2, 'Azúcar', 5, 6, 401, 1),
(3, 'Pan', 5, 6, 400, 1),
(4, 'Mermelada', 0, 1, 0, 1),
(5, 'Leche', 0, 4, 0, 1);

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
(4, 1, 3, 45, 1, 1, 3.6);

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
  `AlimentoPorProveedorEstado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `alimentoporproveedor`
--

INSERT INTO `alimentoporproveedor` (`AlimentoPorProveedorId`, `ProveedorId`, `AlimentoId`, `AlimentoPorProveedorCosto`, `AlimentoPorProveedorCantidad`, `AlimentoPorProveedorVencimiento`, `AlimentoPorProveedorEstado`) VALUES
(2, 2, 1, 1.48, 25, '2021-06-30', 1),
(3, 1, 1, 1.52, 25, '2021-06-30', 1),
(4, 2, 2, 80.2, 5, '2020-12-30', 1),
(5, 1, 3, 80, 5, '2020-10-22', 1);

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
(1, 'Te con tostadas', 1, 6.7842, 1);

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
  `HistorialComidaPorTipoPacienteId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historialcomidaportipopaciente`
--

CREATE TABLE `historialcomidaportipopaciente` (
  `HistorialComidaPorTipoPacienteId` int(11) NOT NULL,
  `ComidaNombre` varchar(80) NOT NULL,
  `ComidaCostoTotal` double NOT NULL,
  `HistorialTipoPacienteId` int(11) NOT NULL,
  `TipoComidaNombre` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(4, '2014_10_12_000000_create_users_table', 1),
(5, '2014_10_12_100000_create_password_resets_table', 1),
(6, '2019_08_19_000000_create_failed_jobs_table', 1),
(7, '2020_09_16_190655_create_roles_table', 1);

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre_rol` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre_rol`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', '2020-09-23 03:00:00', '2020-09-23 03:00:00'),
(2, 'Relevador', '2020-09-23 03:00:00', '2020-09-23 03:00:00'),
(3, 'Nutricionista', '2020-09-25 03:00:00', '2020-09-23 03:00:00'),
(4, 'Cocinero', '2020-09-25 03:00:00', '2020-09-25 03:00:00'),
(5, 'Despensa', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rolesusuario`
--

CREATE TABLE `rolesusuario` (
  `RolesUsuarioId` int(11) NOT NULL,
  `UserId` bigint(20) UNSIGNED NOT NULL,
  `RolId` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rolesusuario`
--

INSERT INTO `rolesusuario` (`RolesUsuarioId`, `UserId`, `RolId`) VALUES
(5, 16, 1),
(23, 26, 1),
(25, 28, 1);

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
(16, 'Pablo Ezequiel Vega', 'pablo2443@gmail.com', NULL, '$2y$10$bYyXLXKB4iOHKljMIWhRj.bUuB3D3LiJWmJDYVkmu150aUvYZ2cnW', NULL, '2020-09-25 18:19:53', '2020-09-25 18:19:53'),
(26, 'Martin Abad', 'abad@gmail.com', NULL, '$2y$10$XfLcwkUp.r5FR/hXqhpaxeOrIMh/.ReTUvjpqfFzYW4UJunkKjdnK', NULL, '2020-09-29 00:26:58', '2020-10-14 19:21:11'),
(28, 'zalazar', 'zalazar@gmail.com', NULL, '$2y$10$Y4FJMuym8sOdc0pammZcVuVN9NbUsiPCzQgBvxNCTWnGrlk/SZi.a', NULL, '2020-10-14 22:50:44', '2020-10-14 22:50:44');

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
  ADD KEY `CamaId` (`CamaId`),
  ADD KEY `UserId` (`UserId`);

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
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rolesusuario`
--
ALTER TABLE `rolesusuario`
  ADD PRIMARY KEY (`RolesUsuarioId`),
  ADD KEY `user_id` (`UserId`),
  ADD KEY `rol_id` (`RolId`);

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
  MODIFY `AlimentoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `alimentoporcomida`
--
ALTER TABLE `alimentoporcomida`
  MODIFY `AlimentoPorComidaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `ComidaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `comidaportipopaciente`
--
ALTER TABLE `comidaportipopaciente`
  MODIFY `ComidaPorTipoPacienteId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detallehistorialcomida`
--
ALTER TABLE `detallehistorialcomida`
  MODIFY `DetalleHistorialComidaId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detallemenutipopaciente`
--
ALTER TABLE `detallemenutipopaciente`
  MODIFY `DetalleMenuTipoPacienteId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `detallerelevamiento`
--
ALTER TABLE `detallerelevamiento`
  MODIFY `DetalleRelevamientoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  MODIFY `HistorialId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `historialalimentoporcomida`
--
ALTER TABLE `historialalimentoporcomida`
  MODIFY `HistorialAlimentoPorComidaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `historialcomidaportipopaciente`
--
ALTER TABLE `historialcomidaportipopaciente`
  MODIFY `HistorialComidaPorTipoPacienteId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `historialtipopaciente`
--
ALTER TABLE `historialtipopaciente`
  MODIFY `HistorialTipoPacienteId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `MenuId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  MODIFY `RelevamientoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `rolesusuario`
--
ALTER TABLE `rolesusuario`
  MODIFY `RolesUsuarioId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
  ADD CONSTRAINT `fk_DetalleRelevamiento_TipoPaciente` FOREIGN KEY (`TipoPacienteId`) REFERENCES `tipopaciente` (`TipoPacienteId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_DetalleRelevamiento_User` FOREIGN KEY (`UserId`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

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
-- Filtros para la tabla `rolesusuario`
--
ALTER TABLE `rolesusuario`
  ADD CONSTRAINT `fk_RolesUsuario_RolId` FOREIGN KEY (`RolId`) REFERENCES `roles` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_RolesUsuario_UsuarioId` FOREIGN KEY (`UserId`) REFERENCES `users` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
