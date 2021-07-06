--Usuario: admin@admin.com password: admin
-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-07-2021 a las 22:05:01
-- Versión del servidor: 10.4.19-MariaDB
-- Versión de PHP: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `nutricion`
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
(2, 'Azúcar', 136.48, 6, 1),
(3, 'Pan', 5, 6, 1),
(10, 'Leche', 504, 4, 1),
(13, 'Mermelada', 5000, 1, 1),
(14, 'Pollo', 97.35, 6, 1),
(15, 'Limones(jugo)', 0, 1, 1),
(16, 'Oregano', 0, 1, 1),
(17, 'Chaucha', 0, 1, 1),
(18, 'Choclo', 0, 1, 1),
(19, 'Arveja', 0, 1, 1),
(20, 'Papa', 0, 1, 1),
(21, 'Aceite', 0, 1, 1),
(22, 'Limones(gajo)', 0, 1, 1),
(23, 'Sal', 0, 1, 1),
(24, 'Caldo', 0, 1, 1),
(25, 'Arroz', 0, 1, 1),
(26, 'Dulce de batata', 0, 1, 1),
(27, 'Mate', 0, 1, 1),
(28, 'Fideos', 0, 1, 1),
(29, 'Blando Especial', 0, 1, 1),
(30, 'Tomate', 0, 1, 1),
(31, 'Cebolla', 0, 1, 1),
(32, 'Pimiento', 0, 1, 1),
(33, 'Oregano-Laurel', 0, 1, 1),
(34, 'Queso rallar', 0, 1, 1),
(35, 'Semola', 0, 1, 1),
(36, 'Manzana', 0, 1, 1),
(37, 'Jugo de limón', 0, 1, 1),
(38, 'Dulce de leche', 2000, 1, 1),
(40, 'Coso', 5, 4, 1),
(42, 'aaa', 3, 4, 1),
(43, 'Zanahoria', 200, 6, 1),
(44, 'Nuevo alimento', 0, 6, 1);

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
  `UnidadMedidaId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `alimentoporcomida`
--

INSERT INTO `alimentoporcomida` (`AlimentoPorComidaId`, `ComidaId`, `AlimentoId`, `AlimentoPorComidaCantidadNeto`, `AlimentoPorComidaEstado`, `UnidadMedidaId`) VALUES
(18, 9, 14, 200, 1, 1),
(19, 9, 15, 0, 1, 1),
(20, 9, 16, 0, 1, 1),
(21, 9, 23, 0, 1, 1),
(22, 9, 17, 30, 1, 1),
(23, 9, 18, 20, 1, 1),
(24, 9, 19, 20, 1, 1),
(25, 9, 20, 150, 1, 1),
(26, 9, 21, 20, 1, 1),
(27, 9, 22, 20, 1, 1),
(30, 9, 3, 45, 1, 1),
(45, 14, 2, 20, 1, 1),
(46, 14, 36, 60, 1, 1),
(47, 14, 37, 0, 1, 1),
(48, 14, 35, 40, 1, 1),
(49, 15, 27, 0, 1, 1),
(50, 15, 2, 21, 1, 1),
(51, 15, 3, 45, 1, 1),
(52, 15, 13, 20, 1, 1),
(53, 15, 10, 10, 1, 1),
(54, 16, 14, 150, 1, 1),
(60, 18, 2, 10, 1, 1),
(61, 13, 2, 1, 1, 1),
(62, 10, 2, 1, 1, 1),
(63, 11, 2, 1, 1, 1),
(64, 12, 2, 1, 1, 1),
(65, 9, 10, 123, 1, 7),
(66, 9, 27, 1, 1, 1);

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
(15, 1, 38, 150, 2000, '2021-05-26', 1, '0000-00-00', 0),
(17, 1, 40, 1, 2, '2021-05-11', 1, '0000-00-00', 0),
(19, 1, 40, 2, 3, '2021-04-28', 1, '0000-00-00', 0),
(20, 1, 42, 50, 2, '2021-05-20', 1, '0000-00-00', 0),
(21, 2, 42, 1, 1, '2021-05-12', 1, '2021-05-11', 0),
(26, 4, 43, 50, 50, '2021-10-28', 1, '2021-05-28', 0),
(27, 3, 43, 48, 150, '2021-10-28', 1, '2021-05-28', 0),
(29, 4, 13, 0.5, 5000, '2022-05-28', 1, '2021-05-28', 0),
(30, 4, 14, 100, 100, '2021-10-21', 1, '2021-05-28', 2.65),
(32, 2, 2, 40, 2, '2021-06-29', 1, '2021-06-29', 0.02),
(33, 2, 2, 40, 2, '2021-06-29', 1, '2021-06-29', 0),
(35, 2, 2, 10, 123, '2021-06-29', 1, '2021-06-29', 0),
(36, 1, 2, 10.5, 10.5, '2021-07-10', 1, '2021-06-29', 0);

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
(9, 'Pollo al horno con ensalada', 2, 1),
(10, 'Sopa c/arroz', 3, 1),
(11, 'Dulce de batata', 4, 1),
(12, 'Fideos entrefino con salsa', 6, 1),
(13, 'Sopa c/semola y sal', 7, 1),
(14, 'Manzana,azúcar ,limon(jugo),sémola', 8, 1),
(15, 'Mate leche, azúcar, pan sin sal, mermelada', 5, 1),
(16, 'Bife de pollo', 2, 1),
(17, 'Colación 1', 9, 1),
(18, 'Colación 2', 9, 1);

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
(20, 16, 10, 0),
(21, 16, 11, 0),
(22, 16, 12, 0),
(24, 16, 14, 0),
(25, 16, 15, 0),
(27, 20, 9, 0),
(29, 16, 13, 1),
(33, 16, 9, 1),
(35, 16, 16, 0),
(36, 18, 11, 1),
(38, 18, 9, 0);

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
(16, 13, 1),
(17, 13, 2),
(18, 13, 3),
(19, 13, 4),
(20, 17, 1);

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
  `MenuId` int(11) DEFAULT NULL,
  `DetalleRelevamientoVajillaDescartable` int(11) DEFAULT NULL,
  `DetalleRelevamientoAgregado` tinyint(4) NOT NULL,
  `DetalleRelevamientoColacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detrelevamientoporcomida`
--

CREATE TABLE `detrelevamientoporcomida` (
  `DetRelevamientoPorComidaId` bigint(20) UNSIGNED NOT NULL,
  `DetalleRelevamientoId` int(11) NOT NULL,
  `ComidaId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 1, 1),
(2, 2, 1);

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
  `CostoTotal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `historialdetallealimento`
--

INSERT INTO `historialdetallealimento` (`HistorialDetalleAlimentoId`, `HistorialDetalleComidaId`, `AlimentoNombre`, `UnidadMedida`, `Cantidad`, `CostoTotal`) VALUES
(1, 1, 'Pollo', 'Gramo', 150, 1500),
(2, 1, 'Limon', 'Gramo', 5, 1000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historialdetallecomida`
--

CREATE TABLE `historialdetallecomida` (
  `HistorialDetalleComidaId` int(11) NOT NULL,
  `HistorialId` int(11) NOT NULL,
  `ComidaNombre` varchar(120) NOT NULL,
  `Porciones` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `historialdetallecomida`
--

INSERT INTO `historialdetallecomida` (`HistorialDetalleComidaId`, `HistorialId`, `ComidaNombre`, `Porciones`) VALUES
(1, 1, 'Pollo al horno', 21),
(2, 1, 'Papa con queso', 11);

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
(13, 'Menú 1', 1),
(14, 'Menú 2', 1),
(15, 'Menú 3', 1),
(16, 'Menú 4', 1),
(17, 'Menú 5', 1);

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
(425, 2, 1, 1, NULL),
(426, 2, 2, 1, NULL),
(427, 2, 3, 1, NULL),
(428, 2, 4, 1, NULL),
(429, 2, 5, 1, NULL),
(430, 2, 6, 1, NULL),
(431, 2, 7, 1, NULL),
(432, 2, 8, 11, NULL),
(433, 2, 9, 11, NULL),
(434, 2, 10, 1, NULL),
(435, 2, 11, 1, NULL),
(436, 2, 12, 1, NULL),
(437, 2, 13, 1, NULL),
(438, 2, 14, 1, NULL),
(439, 2, 15, 1, NULL),
(440, 2, 16, 1, NULL),
(441, 2, 17, 1, NULL),
(442, 2, 18, 1, NULL),
(443, 2, 19, 1, NULL);

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
(8, 'Daniel', 'Osvaldo', 20365484, '', '', 0, 1);

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
(472, 'nutrientes.edit', 'web', '2021-06-18 22:20:11', '2021-06-18 22:20:11');

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
  `RelevamientoControlado` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `relevamiento`
--

INSERT INTO `relevamiento` (`RelevamientoId`, `RelevamientoFecha`, `RelevamientoTurno`, `RelevamientoEstado`, `RelevamientoControlado`) VALUES
(1, '2021-06-02', 'Mañana', 1, 1),
(2, '2021-07-20', 'Tarde', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relevamientocomida`
--

CREATE TABLE `relevamientocomida` (
  `RelevamientoComidaId` int(11) NOT NULL,
  `RelevamientoId` int(11) NOT NULL,
  `ComidaId` int(11) NOT NULL,
  `RelevamientoComidaCantidad` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `relevamientocomida`
--

INSERT INTO `relevamientocomida` (`RelevamientoComidaId`, `RelevamientoId`, `ComidaId`, `RelevamientoComidaCantidad`) VALUES
(1, 1, 17, 5),
(2, 1, 10, 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relevamientoporsala`
--

CREATE TABLE `relevamientoporsala` (
  `RelevamientoPorSalaId` int(11) NOT NULL,
  `RelevamientoId` int(11) NOT NULL,
  `SalaId` int(11) NOT NULL,
  `RelevamientoPorSalaAcompaniantes` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `relevamientoporsala`
--

INSERT INTO `relevamientoporsala` (`RelevamientoPorSalaId`, `RelevamientoId`, `SalaId`, `RelevamientoPorSalaAcompaniantes`) VALUES
(1, 1, 1, 10),
(2, 1, 2, 5);

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
(162, 472, 9);

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
(8, 'Postre Cena', 1),
(9, 'Colación', 1);

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
-- Indices de la tabla `relevamientocomida`
--
ALTER TABLE `relevamientocomida`
  ADD PRIMARY KEY (`RelevamientoComidaId`),
  ADD KEY `RelevamientoId` (`RelevamientoId`),
  ADD KEY `ComidaId` (`ComidaId`);

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
  MODIFY `AlimentoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `alimentoporcomida`
--
ALTER TABLE `alimentoporcomida`
  MODIFY `AlimentoPorComidaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `alimentoporproveedor`
--
ALTER TABLE `alimentoporproveedor`
  MODIFY `AlimentoPorProveedorId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `cama`
--
ALTER TABLE `cama`
  MODIFY `CamaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `comida`
--
ALTER TABLE `comida`
  MODIFY `ComidaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `comidaportipopaciente`
--
ALTER TABLE `comidaportipopaciente`
  MODIFY `ComidaPorTipoPacienteId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `detallemenutipopaciente`
--
ALTER TABLE `detallemenutipopaciente`
  MODIFY `DetalleMenuTipoPacienteId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `detallerelevamiento`
--
ALTER TABLE `detallerelevamiento`
  MODIFY `DetalleRelevamientoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=324;

--
-- AUTO_INCREMENT de la tabla `detrelevamientoporcomida`
--
ALTER TABLE `detrelevamientoporcomida`
  MODIFY `DetRelevamientoPorComidaId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `HistorialId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `historialdetallealimento`
--
ALTER TABLE `historialdetallealimento`
  MODIFY `HistorialDetalleAlimentoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `historialdetallecomida`
--
ALTER TABLE `historialdetallecomida`
  MODIFY `HistorialDetalleComidaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `MenuId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
  MODIFY `NutrientePorAlimentoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=444;

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `PacienteId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=473;

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
  MODIFY `RelevamientoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de la tabla `relevamientocomida`
--
ALTER TABLE `relevamientocomida`
  MODIFY `RelevamientoComidaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `relevamientoporsala`
--
ALTER TABLE `relevamientoporsala`
  MODIFY `RelevamientoPorSalaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT de la tabla `sala`
--
ALTER TABLE `sala`
  MODIFY `SalaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `tipocomida`
--
ALTER TABLE `tipocomida`
  MODIFY `TipoComidaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
-- Filtros para la tabla `comida`
--
ALTER TABLE `comida`
  ADD CONSTRAINT `fk_Comida_TipoComida` FOREIGN KEY (`TipoComidaId`) REFERENCES `tipocomida` (`TipoComidaId`) ON UPDATE CASCADE;

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
  ADD CONSTRAINT `detallerelevamiento_menuid_foreign` FOREIGN KEY (`MenuId`) REFERENCES `menu` (`MenuId`) ON DELETE CASCADE,
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
-- Filtros para la tabla `relevamientocomida`
--
ALTER TABLE `relevamientocomida`
  ADD CONSTRAINT `fk_Comdia_RelevamientoComida` FOREIGN KEY (`ComidaId`) REFERENCES `comida` (`ComidaId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Relevamiento_RelevamientoComida` FOREIGN KEY (`RelevamientoId`) REFERENCES `relevamiento` (`RelevamientoId`) ON DELETE CASCADE ON UPDATE CASCADE;

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
